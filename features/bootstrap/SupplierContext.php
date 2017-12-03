<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;

/**
 * Defines application features from the specific context.
 */
class SupplierContext extends RawMinkContext implements Context {

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
     * @Given I am in the Regitser section
     */
    public function iAmInTheRegitserSection() {
        $this->visitPath('/register/supplier');
    }

    /**
     * @When I fill Register Form Fileds:
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
       $alertDiv= $this->getSession()->getPage()->find('css', '.alert-danger >ul');
       expect($alertDiv->getText())->toBe($alertsString);
    }


    /**
     * @Given I am in login arae
     */
    public function iAmInLoginArae()
    {
        $this->visitPath('/login/supplier');
    }

    /**
     * @When I fill email with :email
     */
    public function iFillEmailWith($email)
    {
        $this->getSession()->getPage()->fillField('email', $email);
    }

    /**
     * @When I Fill password with :password
     */
    public function iFillPasswordWith($passord)
    {
        $this->getSession()->getPage()->fillField('password', $passord);
    }

    /**
     * @When I click :sighin
     */
    public function iClick($sighin)
    {
        $this->getSession()->getPage()->pressButton($sighin);
    }

    /**
     * @Then I should See :email
     */
    public function iShouldSee2($email)
    {
        $location= $this->getSession()->getPage()->find('css', '.user-menu > a > span');
        expect($location->getText())->toBe($email);
    }
}
