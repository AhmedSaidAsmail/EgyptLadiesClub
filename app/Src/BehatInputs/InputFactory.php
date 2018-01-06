<?php

namespace App\Src\BehatInputs;

use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Mink\Element\NodeElement;
use Exception;

class InputFactory {

    private $context;

    public function __construct(RawMinkContext $context) {
        $this->context = $context;
    }

    public function fillItemFeilds(TableNode $table) {
        foreach ($table->getHash() as $row) {
            switch ($row['type'])
            {
                case "text":
                    $this->FillTextInput($row['name'], $row['data']);
                    break;
                case "multitext":
                    $this->fillMultiTextInput($row['name'], $row['data']);
                    break;
                case "textarea":
                    $this->fillTextarea($row['name'], $row['data']);
                    break;
                case "select":
                    $this->fillSelectOption($row['name'], $row['data']);
                    break;
                case "datepicker":
                    $this->fillDatePicker($row['name']);
                    break;
                case "file":
                    $this->fillFileInput($row['name']);
                    break;
                case "multiselect":
                    $this->fillMultiSelect($row['name'], $row['data']);
                    break;
                case "multidatepicker":
                    $this->fillMultiDatePicker($row['name']);
                    break;
                case "multifile":
                    $this->fillMultiFileInput($row['name']);
                    break;
            }
        }
    }

    protected function FillTextInput($locator, $value) {
        $field = $this->context->getSession()->getPage()->findField($locator);
        if (is_null($field)) {
            throw new Exception($locator . " this field is not exists");
        }
        $field->setValue($value);
    }

    protected function fillMultiTextInput($locator, $value) {
        $fields = $this->context->getSession()->getPage()->findAll('named',['id_or_name',$locator]);
        foreach ($fields as $key=>$field) {
            if ($field->isVisible()) {
                $field->setValue($this->setValue($key, $value));
            }
        }
    }
    private function valueIsArray($value){
        $return= explode(',', $value);
        if(count($return)>1){
            return $return;
        }
        return false;
    }
    private function setValue($key,$value){
        if(!$this->valueIsArray($value)){
            return $value;
        }
        return $this->valueIsArray($value)[$key];
    }

    protected function fillTextarea($locator, $value) {
        $this->remove_wysihtml5();
        $field = $this->context->getSession()->getPage()->findField($locator);
        if (is_null($field)) {
            throw new Exception($locator . " this field is not exists");
        }
        $field->setValue($value);
    }

    private function remove_wysihtml5() {
        $this->context->getSession()->executeScript('document.getElementById("remove_wysihtml5").click();');
    }

    protected function fillSelectOption($locator, $option) {
        $field = $this->context->getSession()->getPage()->findField($locator);
        if (is_null($field)) {
            throw new Exception($locator . " this field is not exists");
        }
        $field->selectOption($option);
    }

    protected function fillDatePicker($locator) {
        $field = $this->context->getSession()->getPage()->findField($locator);
        if (is_null($field)) {
            throw new Exception($locator . " this field is not exists");
        }
        $field->setValue(date('m/d/Y'));
    }

    protected function fillMultiDatePicker($locator) {
        $fields = $this->context->getSession()->getPage()->findAll('css', "." . $locator);
        foreach ($fields as $field) {
            if ($field->isVisible()) {
                $field->setValue(date('m/d/Y'));
            }
        }
    }

    protected function fillMultiFileInput($locator) {
        $fields = $this->context->getSession()->getPage()->findAll('css', "." . $locator);
        foreach ($fields as $field) {
            if ($field->isVisible()) {
                $this->fillFileInput(null, $field);
            }
        }
    }

    protected function fillFileInput($locator, NodeElement $getField = null) {
        if (is_null($getField)) {
            $field = $this->context->getSession()->getPage()->findField($locator);
            if (is_null($field)) {
                throw new Exception($locator . " this field is not exists");
            }
        }
        else {
            $field = $getField;
        }

        $field->attachFile(dirname(dirname(dirname(__DIR__))) . '\public\images\testProduct.png');
    }

    protected function getSelectOptions(NodeElement $field, array $opetions) {
        $html = $field->getHtml();
        preg_match_all('/value="(\d)"/', $html, $matches);
        if (isset($matches[1]) && !empty($matches[1])) {
            $returnedOpetions = [];
            foreach ($opetions as $opetion) {
                if (!is_null(array_search($opetion, $matches[1]))) {
                    $returnedOpetions[] = $opetion;
                }
                else {
                    throw new Exception($opetion . ' this value not exists');
                }
            }
            return (count($returnedOpetions) > 0) ? $returnedOpetions : null;
        }
//        throw new Exception('this field has no oetions');
    }

    protected function fillMultiSelect($locator, $options) {
        $fixOpetions = explode(',', $options);
        if (count($fixOpetions) > 0) {
            $field = $this->context->getSession()->getPage()->findField($locator);
            $opetionsArray = $this->getSelectOptions($field, $fixOpetions);
            if (is_null($field) || is_null($opetionsArray)) {
                throw new Exception($locator . " this field is not exists or not have opetions");
            }

            $field->setValue($opetionsArray);
        }
    }

}
