<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;

/**
 * Defines application features from the specific context.
 */
class AdminLogin extends RawMinkContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given I am in login area
     */
    public function iAmInLoginArea()
    {
        $this->visitPath('/admin');
    }

    /**
     * @Given I fill username with :user
     */
    public function iFillUsernameWith($user)
    {
        $field=$this->getSession()->getPage()->findField('email');
        if(!is_null($field)){
            $field->setValue($user);
        }
    }

    /**
     * @Given I fill password with :password
     */
    public function iFillPasswordWith($password)
    {
        $field=$this->getSession()->getPage()->findField('password');
        if(!is_null($field)){
            $field->setValue($password);
        }
    }

    /**
     * @When I press <button>
     */
    public function iPressButton()
    {
        $this->getSession()->getPage()->findButton('Sign In')->click();
    }

    /**
     * @Then the result should be :username on the screen
     */
    public function theResultShouldBeOnTheScreen($username)
    {
        $locator= $this->getSession()->getPage()->find('css', '#welcome_user');
        expect($locator->getText())->toBe($username);
    }


    
}
