@comparer
Feature: Adding a product to comparer
  In order to compare products
  As a visitor
  I want to add a product to the comparer

  Background:
    Given the store operates on a single channel in "United States"
    And all store products appear under a main taxonomy

  @ui
  Scenario: Adding a product to comparer
    Given the store has a product "Wookie toy" priced at "$5.00"
    When I add this product to comparer
    Then I should be on comparer page
    And I should be notified that the product has been successfully added to comparer
    And I should have this product in my comparer

  @ui
  Scenario: Adding products to a full comparer
    Given the store has "Laser", "Hologram", "Jet-pack" and "Sword" products
#    And comparer has maximum capacity of 3 items
    And I add "Laser", "Hologram", "Jet-pack" products to comparer
    When I add the "Sword" product to comparer
    Then I should be on comparer page
    And I should be notified that product cannot be added to comparer due to full comparer
    And I should not have "Sword" product in my comparer

  @ui
  Scenario: Adding already added product to comparer
    Given the store has a product "R2-D2" priced at "$100.00"
    And I add this product to comparer
    Then I should be on comparer page
    And I should be on comparer page
    And I should be notified that the product has been successfully added to comparer
    And I should have this product in my comparer
    And I add this product to comparer
    Then I should be on comparer page
    And I should be notified that product cannot be added to comparer because Its already in comparer
    And I should have this product in my comparer