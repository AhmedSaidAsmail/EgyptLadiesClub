<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use App\Src\TestAdminLogin\AdminLogin;
use App\Src\BehatInputs\InputFactory;

/**
 * Defines application features from the specific context.
 */
class AdminFilters extends RawMinkContext implements Context {

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct() {
        
    }

    public function login() {
        $adminLogin = new AdminLogin($this);
        $adminLogin->Login();
    }

    /**
     * @Given I be in the admin page
     */
    public function iBeInTheAdminPage() {
        $this->visitPath('/admin');
        if ($this->getSession()->getPage()->findField("email")) {
            $this->login();
        }
    }

    /**
     * @When I click :filter link
     */
    public function iClickLink($locator) {
        $this->getSession()->getPage()->clickLink($locator);
    }

    /**
     * @When I press link :link_id
     */
    public function iPressLink($link_id) {
        $this->getSession()->getPage()->clickLink($link_id);
    }

    /**
     * @When Fill filter details
     */
    public function fillFilterDetails(TableNode $table) {
        $inputFactory = new InputFactory($this);
        $inputFactory->fillItemFeilds($table);
    }

    /**
     * @When I click :link_id link :times times to add to filter items
     */
    public function iClickLinkTimesToAddToFilterItems($link_id, $times) {
        for ($i = 0; $i < $times; $i++) {
            $this->getSession()->getPage()->clickLink($link_id);
        }
    }

    /**
     * @When I fill filter items data
     */
    public function iFillFilterItemsData(TableNode $table) {
        $inputFactory = new InputFactory($this);
        $inputFactory->fillItemFeilds($table);
    }

    /**
     * @When I press button
     */
    public function iPressButton2() {
        $this->getSession()->getPage()->find('css','.fa-floppy-o')->click();
    }

    /**
     * @Then I should see :successMsg on the screen
     */
    public function iShouldSeeOnTheScreen($successMsg) {
        $sucess_div=$this->getSession()->getPage()->find('css','.alert-success');
        expect($sucess_div->getText())->toBe($successMsg);
    }
        /**
     * @When I press update link :edit_link
     */
    public function iPressUpdateLink($edit_link)
    {
        $this->getSession()->getPage()->find('css','.'.$edit_link)->click();
    }


}
