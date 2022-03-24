# This file contains a user story for demonstration only.
# Learn how to get started with Behat and BDD on Behat's website:
# http://behat.org/en/latest/quick_start.html

Feature:
    Product feature

    Scenario: It retreive products
        Given the api url "/products"
        When make the request
        Then should return the products
