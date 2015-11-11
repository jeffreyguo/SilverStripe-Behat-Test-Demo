Feature: View site links
  As a SS visitor
  I can visit the homepage
  So I can view SS products and services

  @jira:MEMS-123 @smoke @sanity
  Scenario: Visit homepage
    Given I am on homepage
	And I put a breakpoint
    Then I should see "Welcome to SilverStripe! This is the default homepage."
    When I go to "/about-us/"
    Then I should see "About Us You can fill this page out with your own content, or delete it and create your own pages"
