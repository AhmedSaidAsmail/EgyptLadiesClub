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
            |email         |supplier@supplier.com    |
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
    When I fill email with "supplier@supplier.com"
    And I Fill password with "supplier"
    And I click "Sign In"
    Then I should See "supllier@supplier.com"
@createItem
    Scenario:
    Given I am in supplier welcome page
    When I click the Product Link
    And I click the Add New Product link
    And I Fill General Fields:
        |type          |name                |data                 |
        |select        |category_id         |usb connector        |
        |text          |model               |testModel            |
        |select        |brand_id            |HP                   |
        |file          |img                 |null                 |
        |text          |quantity            |25                   |
        |text          |min_quantity        |10                   |
        |text          |price               |2500                 |
        |radio         |shipping            |1                    |
        |datepicker    |date_available      |null                 |
    And I click Data link
    And I Fill Data Fields:
        |type          |name                |data                 |
        |text          |en_name             |English name         |
        |textarea      |en_text             |English Description  |
        |text          |en_title            |English Title        |
        |text          |en_keywords         |English Keywords     |
        |text          |en_description      |English Description  |
    And I click DataArabic link
    And I Fill arabic Data Fields:
        |type          |name                |data                 |
        |text          |ar_name             |Arabic name          |
        |textarea      |ar_text             |Arabic Description   |
        |text          |ar_title            |Arabic Title         |
        |text          |ar_keywords         |Arabic Keywords      |
        |text          |ar_description      |Arabic Description   |
    And I click Discounts link
    And I click discounts add row Link twice
    And I Fill discount Fields:
        |type               |name                |data                 |
        |multitext          |dis_price           |2300                 |
        |multitext          |dis_quantity        |10                   |
        |multidatepicker    |date_start          |null                 |
        |multidatepicker    |date_end            |null                 |
    And I click the Links link
    And I Fill Links Fields:
        |type          |name                |data                 |
        |multiselect   |filters_item_id[]   |3,4,5                |
        |multiselect2   |related[]           |                     |
    And I click the Images link
    And I Fill Images Fields:
        |type          |name                |data                      |
        |multifile          |item_image          |null                 |
        |multitext          |image_sort_order    |1                    |
    And I press button with  id "create_item_done"
    Then I should see "The product has been inserted" in the alert div


 