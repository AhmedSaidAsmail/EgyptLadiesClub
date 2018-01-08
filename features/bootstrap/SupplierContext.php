<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Element\NodeElement;
use Behat\MinkExtension\Context\RawMinkContext;
use App\Src\BehatInputs\InputFactory;
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
     * @Then I should see success div appearing
     */
    public function iShouldSeeSuccessDivAppearing()
    {
        $successDiv = $this->getSession()->getPage()->find('css', '.alert-success');
        if(is_null($successDiv)){
            throw new Exception('unsuccessfully');
        }
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

    /**
     * @When I Fill General Fields:
     */
    public function iFillGenralFields(TableNode $table) {
        $inputFactory = new InputFactory($this);
        $inputFactory->fillItemFeilds($table);
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
        $inputFactory = new InputFactory($this);
        $inputFactory->fillItemFeilds($table);
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
        $inputFactory = new InputFactory($this);
        $inputFactory->fillItemFeilds($table);
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
        $inputFactory = new InputFactory($this);
        $inputFactory->fillItemFeilds($table);
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
        $inputFactory = new InputFactory($this);
        $inputFactory->fillItemFeilds($table);
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
        $inputFactory = new InputFactory($this);
        $inputFactory->fillItemFeilds($table);
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
        $heading = $this->getSession()->getPage()->find('css', 'p.success');
        if (is_null($heading)) {
            throw new Exception('oops something went wrong ');
        }
        expect($heading->getText())->toBe($message);
    }

}
