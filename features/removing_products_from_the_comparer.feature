@comparer
Feature: Removing products that are in the comparer
  In order to stop comparing specific product
  As a customer
  I want to remove a product that is in the comparer

  Background:
    Given the store operates on a single channel in "United States"
    And all store products appear under a main taxonomy

  @ui
  Scenario: Removing a product to comparer
    Given the store has a product "Darth Vader toy" priced at "$5.00"
    And I add this product to comparer
    And I remove this product from comparer
    Then I should be on comparer page
    And I should be notified that the product has been successfully removed from comparer
    And I should not have this product in my comparer