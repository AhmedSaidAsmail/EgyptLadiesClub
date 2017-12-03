Feature:
    test Supplier area
@WelcomePanel
    Scenario:
     Given I am in Welcome panel
     When I click the Register Link
     Then I should see "Shop Details" in h1
     When I go back
     And I click the login link 
     Then I should see "SupplierC-Panel" in first heading
@makeRegisteration
    Scenario:
    Given I am in the Regitser section
    When I fill Register Form Fileds:
            |f_name        |TsetFirstName            |
            |l_name        |TestLastName             |
            |email         |supllier@supplier.com    |
            |mobile        |00201009340001           |
            |company       |testCompany              |
            |store_name    |testStroeName            |
            |address       |testAddress              |
            |city          |testCity                 |
            |postal_code   |testPostalCode           |
    And I check option "agree"
    And I click "Submit Form" button
    Then I should see "The email has already been taken." in alert div
@loginSupplier
    Scenario:
    Given I am in login arae
    When I fill email with "supllier@supplier.com"
    And I Fill password with "supplier"
    And I click "Sign In"
    Then I should See "supllier@supplier.com"
@items
    Scenario:
    Given I am in supplier welcome page
    When I Click the "Prducts" Link
    
 