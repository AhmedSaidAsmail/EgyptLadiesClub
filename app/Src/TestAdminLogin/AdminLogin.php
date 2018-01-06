<?php

namespace App\Src\TestAdminLogin;

use Behat\MinkExtension\Context\RawMinkContext;
use Exception;

class AdminLogin {

    private $conText;

    public function __construct(RawMinkContext $conText) {
        $this->conText = $conText;
    }

    private function fillUserName() {
        $field = $this->conText->getSession()->getPage()->findField('email');
        if (is_null($field)) {
            throw new Exception('Username input not exists');
        }
        $field->setValue("admin@admin.com");
        return $this;
    }

    private function fillPassword() {
        $field = $this->conText->getSession()->getPage()->findField('password');
        if (is_null($field)) {
            throw new Exception('Password input not exists');
        }
        $field->setValue("admin");
        return $this;
    }

    private function submitForm() {
        $this->conText->getSession()->getPage()->findButton('Sign In')->click();
        return $this;
    }
    public function login(){
        $this->fillUserName()->fillPassword()->submitForm();
    }

}
