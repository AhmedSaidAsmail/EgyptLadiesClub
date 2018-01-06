Feature: 
In order to login as an admin to admin panel
@adminLogin
  Scenario: 
    Given I am in login area
    And I fill username with "admin@admin.com"
    And I fill password with "admin"
    When I press <button>
    Then the result should be "admin@admin.com" on the screen

