<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Element\NodeElement;
use Behat\MinkExtension\Context\RawMinkContext;
use Exception;

/**
 * Defines application features from the specific context.
 */
class SupplierContext extends RawMinkContext implements Context {

    protected function login() {
        $this->iFillEmailWith("supplier@supplier.com");
        $this->iFillPasswordWith("supplier");
        $this->iClick("Sign In");
    }

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct() {
        
    }

    /**
     * @Given I am in Welcome panel
     */
    public function iAmIn() {
        $this->visitPath('/supplier/welcome/home');
    }

    /**
     * @When I click the register link
     */
    public function iClickTheLink() {
        $this->getSession()->getPage()->findById("reigister")->click();
    }

    /**
     * @Then I should see :firstHeading in h1
     */
    public function iShouldSeeInH($firstHeading) {
        $firstHeader = $this->getSession()->getPage()->find('css', 'h1:first-of-type');
        expect($firstHeader->getText())->toBe($firstHeading);
    }

    /**
     * @When I go back
     */
    public function iGoBack() {
        $this->getSession()->back();
    }

    /**
     * @When I click the login link
     */
    public function iClickTheLoginLink() {
        $this->getSession()->getPage()->findLink("Login")->click();
    }

    /**
     * @Then I should see :firstHeading in first heading
     */
    public function iShouldSeeInFirstHeading($firstHeading) {
        $firstHeader = $this->getSession()->getPage()->find('css', '.login-logo > a');
        expect($firstHeader->getText())->toBe($firstHeading);
    }

    /**
     * @Given I am in the Register section
     */
    public function iAmInTheRegitserSection() {
        $this->visitPath('/register/supplier');
    }

    /**
     * @When I fill Register Form fields:
     */
    public function iFillRegisterFormFileds(TableNode $fields) {
        foreach ($fields->getRowsHash() as $field => $value) {
            $this->getSession()->getPage()->fillField($field, $value);
        }
    }

    /**
     * @When I check option :agree
     */
    public function iCheckOpetion($agree) {
        $this->getSession()->getPage()->checkField($agree);
    }

    /**
     * @When I click :button button
     */
    public function iClickButton($button) {
        $this->getSession()->getPage()->pressButton($button);
    }

    /**
     * @Then I should see :alertsString in alert div
     */
    public function iShouldSee($alertsString) {
        $alertDiv = $this->getSession()->getPage()->find('css', '.alert-danger >ul');
        expect($alertDiv->getText())->toBe($alertsString);
    }

    /**
     * @Given I am in login area
     */
    public function iAmInLoginArae() {
        $this->visitPath('/login/supplier');
    }

    /**
     * @When I fill email with :email
     */
    public function iFillEmailWith($email) {
        $this->getSession()->getPage()->fillField('email', $email);
    }

    /**
     * @When I Fill password with :password
     */
    public function iFillPasswordWith($passord) {
        $this->getSession()->getPage()->fillField('password', $passord);
    }

    /**
     * @When I click :sighin
     */
    public function iClick($sighin) {
        $this->getSession()->getPage()->pressButton($sighin);
    }

    /**
     * @Then I should See :email
     */
    public function iShouldSee2($email) {
        $location = $this->getSession()->getPage()->find('css', '.user-menu > a > span');
        expect($location->getText())->toBe($email);
    }

    /**
     * @Given I am in supplier welcome page
     */
    public function iAmInSupplierWelcomePage() {
        $this->visitPath('/supplier');
        if ($this->getSession()->getPage()->findField("email")) {
            $this->login();
        }
    }

    /**
     * @When I click the Product Link
     */
    public function iClickThePrductsLink() {
        $this->getSession()->getPage()->clickLink("Product");
    }

    /**
     * @When I click the Add New Product link
     */
    public function iClickTheAddNewProductLink() {
        $this->getSession()->getPage()->clickLink("Add New Product");
    }

    protected function remove_wysihtml5() {
        $this->getSession()->executeScript('document.getElementById("remove_wysihtml5").click();');
    }

    protected function FillTextInput($locator, $value) {
        $field = $this->getSession()->getPage()->findField($locator);
        if (is_null($field)) {
            throw new Exception($locator . " this field is not exists");
        }
        $field->setValue($value);
    }

    protected function fillMultiTextInput($locator, $value) {
        $fields = $this->getSession()->getPage()->findAll('css', "." . $locator);
        foreach ($fields as $field) {
            if ($field->isVisible()) {
                $field->setValue($value);
            }
        }
    }

    protected function fillTextarea($locator, $value) {
        $this->remove_wysihtml5();
        $field = $this->getSession()->getPage()->findField($locator);
        if (is_null($field)) {
            throw new Exception($locator . " this field is not exists");
        }
        $field->setValue($value);
    }

    protected function fillSelectOption($locator, $option) {
        $field = $this->getSession()->getPage()->findField($locator);
        if (is_null($field)) {
            throw new Exception($locator . " this field is not exists");
        }
        $field->selectOption($option);
    }

    protected function fillDatePicker($locator) {
        $field = $this->getSession()->getPage()->findField($locator);
        if (is_null($field)) {
            throw new Exception($locator . " this field is not exists");
        }
        $field->setValue(date('m/d/Y'));
    }

    protected function fillMultiDatePicker($locator) {
        $fields = $this->getSession()->getPage()->findAll('css', "." . $locator);
        foreach ($fields as $field) {
            if ($field->isVisible()) {
                $field->setValue(date('m/d/Y'));
            }
        }
    }

    protected function fillMultiFileInput($locator) {
        $fields = $this->getSession()->getPage()->findAll('css', "." . $locator);
        foreach ($fields as $field) {
            if ($field->isVisible()) {
                $this->fillFileInput(null, $field);
            }
        }
    }

    protected function fillFileInput($locator, NodeElement $getField = null) {
        if (is_null($getField)) {
            $field = $this->getSession()->getPage()->findField($locator);
            if (is_null($field)) {
                throw new Exception($locator . " this field is not exists");
            }
        }
        else {
            $field = $getField;
        }

        $field->attachFile(dirname(dirname(__DIR__)) . '\public\images\testProduct.png');
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
            $field = $this->getSession()->getPage()->findField($locator);
            $opetionsArray = $this->getSelectOptions($field, $fixOpetions);
            if (is_null($field) || is_null($opetionsArray)) {
                throw new Exception($locator . " this field is not exists or not have opetions");
            }

            $field->setValue($opetionsArray);
        }
    }

    protected function fillItemFeilds(TableNode $table) {
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

    /**
     * @When I Fill General Fields:
     */
    public function iFillGenralFields(TableNode $table) {
        $this->fillItemFeilds($table);
    }

    /**
     * @When I click Data link
     */
    public function iClickDataLink() {
        $this->getSession()->getPage()->clickLink('Data');
        $this->getSession()->wait(100);
    }

    /**
     * @When I Fill Data Fields:
     */
    public function iFillDataFields(TableNode $table) {
        $this->fillItemFeilds($table);
    }

    /**
     * @When I click DataArabic link
     */
    public function iClickDataarabicLink() {

        $this->getSession()->wait(100, $this->getSession()->getPage()->clickLink('Arabic'));
    }

    /**
     * @When I Fill arabic Data Fields:
     */
    public function iFillArabicDataFields(TableNode $table) {
        $this->fillItemFeilds($table);
    }

    /**
     * @When I click Discounts link
     */
    public function iClickDiscountsLink() {
        $this->getSession()->wait(100, $this->getSession()->getPage()->clickLink('Discounts'));
    }

    /**
     * @When I click discounts add row Link twice
     */
    public function iClickDiscountsAddRowLinkTwice() {
        for ($i = 0; $i < 2; $i++) {
            $this->getSession()->getPage()->findLink('insertRow')->click();
        }
    }

    /**
     * @When I Fill discount Fields:
     */
    public function iFillDiscountFields(TableNode $table) {
        $this->fillItemFeilds($table);
    }

    /**
     * @When I click the Links link
     */
    public function iClickTheLinksLink() {
        $this->getSession()->getPage()->clickLink('Links');
    }

    /**
     * @When I Fill Links Fields:
     */
    public function iFillLinksFields(TableNode $table) {
        $this->fillItemFeilds($table);
    }

    /**
     * @When I click the Images link
     */
    public function iClickTheImagesLink() {
        $this->getSession()->getPage()->clickLink('Images');
        $this->getSession()->wait(100);
        for ($i = 0; $i < 2; $i++) {
            $this->getSession()->getPage()->find('css', '.second-insert')->click();
        }
    }

    /**
     * @When I Fill Images Fields:
     */
    public function iFillImagesFields(TableNode $table) {
        $this->fillItemFeilds($table);
    }

    /**
     * @When I press button with  id :linkId
     */
    public function iPressButtonWithId($linkId) {
        $this->getSession()->getPage()->findById($linkId)->click();
    }

    /**
     * @Then I should see :message in the alert div
     */
    public function iShouldSeeInTheAlertDiv($message) {
        $heading = $this->getSession()->getPage()->find('css', 'h4:first-of-type');
        if (is_null($heading)) {
            throw new Exception('oops something went wrong ');
        }
        expect($heading->getText())->toBe($message);
    }

}
