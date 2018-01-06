Feature:
  In order to check Admin filters
  @addFilter
  Scenario:
    Given I be in the admin page
    When I click "Filters" link
    And I press link "add_new"
    And Fill filter details
             |type          |name                       |data                 |
             |text          |ar_name                    |arabic name filter   |
             |text          |en_name                    |english name filter  |
             |text          |sort_order                 |1                    |
    And I click "add-row" link "2" times to add to filter items
    And I fill filter items data
             |type               |name                       |data                                           |
             |multitext          |filter_ar_name[]             |filter item arabic 1,filter item arabic 2    |
             |multitext          |filter_en_name[]             |filter item english 1,filter item english 2  |
             |multitext          |filter_sort_order[]          |1,2                                          |
    And I press button
    Then I should see "Filter has been inserted" on the screen
  @updateFilter
  Scenario:
    Given I be in the admin page
    When I click "Filters" link
    And I press update link "fa-pencil"
    And I press button
    Then I should see "Filter has been updated" on the screen
