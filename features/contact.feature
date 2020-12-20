Feature: Contact

  @database
  Scenario: Check contact register
    Given I load the fixture "user"
    And I am logged with the email "damiens.florent@orange.fr"
    When I request the url "/api/contact" with http verb "POST" and with the payload
    """
    {
      "email": "test@test.fr",
      "name": "name",
      "subject": "sujet",
      "message": "message"
    }
    """
    Then the status code should be 201
    And Object "Contact" in namespace "WebApp" with the following data should exist in database
      | attribute   | value        |
      | name        | name         |
      | subject     | sujet        |
      | message     | message      |

  @database
  Scenario: Check contact register with bad data with user logged
    Given I load the fixture "user"
    And I am logged with the email "damiens.florent@orange.fr"
    When I request the url "/api/contact" with http verb "POST" and with the payload
    """
    {
      "email": "test@test.fr",
      "name": "name",
      "subject": "sazsazs",
      "message": ""
    }
    """
    Then the status code should be 400
    And the response should have the following content
    """
     [
       {
          "message": "Cette valeur ne doit pas être vide.",
          "messageTemplate": "This value should not be blank.",
          "propertyPath": "message"
       }
     ]
    """

  @database
  Scenario: Check contact register with bad data without user logged
    Given I load the fixture "user"
    When I request the url "/api/contact" with http verb "POST" and with the payload
    """
    {
      "email": "test@test.fr",
      "name": "name",
      "subject": "sazsazs",
      "message": ""
    }
    """
    Then the status code should be 400
    And the response should have the following content
    """
     [
       {
          "message": "Cette valeur ne doit pas être vide.",
          "messageTemplate": "This value should not be blank.",
          "propertyPath": "message"
       }
     ]
    """

  @database
  Scenario: Check contact register with bad email
    Given I load the fixture "user"
    When I request the url "/api/contact" with http verb "POST" and with the payload
    """
    {
      "email": "testtest.fr",
      "name": "name",
      "subject": "sazsazs",
      "message": "ezfezf"
    }
    """
    Then the status code should be 400
    And the response should have the following content
    """
     [
       {
          "message": "Cette valeur n'est pas une adresse email valide.",
          "messageTemplate": "This value is not a valid email address.",
          "propertyPath": "email"
       }
     ]
    """

  @database
  Scenario: Check contact register for bot spamming
    Given I load the fixture "contact"
    When I request the url "/api/contact" with http verb "POST" and with the payload
    """
    {
      "email": "etst@orange.fr",
      "name": "name",
      "subject": "sazsazs",
      "message": "ezfezf"
    }
    """
    Then the status code should be 400
    And the response should have the following content
    """
     {
        "type": "ContactLimitException",
        "content": "ContactLimitException"
     }
    """

  @database
  Scenario: Delete contact without user logged
    Given I load the fixture "contact"
    When I request the url "/api/contact/2" with http verb "DELETE"
    Then the status code should be 401

  @database
  Scenario: Delete contact with bad user role
    Given I load the fixture "contact"
    And I am logged with the email "editor@test.fr"
    When I request the url "/api/contact/2" with http verb "DELETE"
    Then the status code should be 403

  @database
  Scenario: Delete contact
    Given I load the fixture "contact"
    And I am logged with the email "admin@test.fr"
    When I request the url "/api/contact/2" with http verb "DELETE"
    Then the status code should be 204
    And Object "Contact" in namespace "WebApp" with the following data shouldn't exist in database
      | attribute   | value        |
      | id          | 2            |

  @database
  Scenario: Check contact edit
    Given I load the fixture "contact"
    And I am logged with the email "admin@test.fr"
    When I request the url "/api/contact/2" with http verb "PUT" and with the payload
    """
    {
      "email": "edit@test.fr",
      "name": "name edited",
      "subject": "sazsazs edited",
      "message": "ezfezf dezd"
    }
    """
    Then the status code should be 204
    And Object "Contact" in namespace "WebApp" with the following data should exist in database
      | attribute   | value          |
      | id          | 2              |
      | name        | name edited    |
      | subject     | sazsazs edited |
      | message     | ezfezf dezd    |
      | email       | edit@test.fr   |

  @database
  Scenario: Check contact edit without user logged
    Given I load the fixture "contact"
    When I request the url "/api/contact/2" with http verb "PUT" and with the payload
    """
    {
      "email": "edit@test.fr",
      "name": "name edited",
      "subject": "sazsazs edited",
      "message": "ezfezf dezd"
    }
    """
    Then the status code should be 401

  @database
  Scenario: Check contact edit with bad user role
    Given I load the fixture "contact"
    And I am logged with the email "editor@test.fr"
    When I request the url "/api/contact/2" with http verb "PUT" and with the payload
    """
    {
      "email": "edit@test.fr",
      "name": "name edited",
      "subject": "sazsazs edited",
      "message": "ezfezf dezd"
    }
    """
    Then the status code should be 403

  @database
  Scenario: Show contact without user logged
    Given I load the fixture "contact"
    When I request the url "/api/contact/2" with http verb "GET"
    Then the status code should be 401

  @database
  Scenario: Show contact with user logged
    Given I load the fixture "contact"
    And I am logged with the email "editor@test.fr"
    When I request the url "/api/contact/2" with http verb "GET"
    Then the status code should be 200
    And the response should have the following content
    """
     {
      "id": "2",
      "email": "etst@orange.fr",
      "name": "nom",
      "subject": "subject",
      "message": "message",
      "createdAt": "2020-12-12T00:12:12+01:00",
      "updatedAt": "2020-12-12T00:12:12+01:00"
    }
    """

  @database
  Scenario: Show contact with user logged
    Given I load the fixture "contact"
    And I am logged with the email "admin@test.fr"
    When I request the url "/api/contact/2" with http verb "GET"
    Then the status code should be 200
    And the response should have the following content
    """
     {
      "id": "2",
      "email": "etst@orange.fr",
      "name": "nom",
      "subject": "subject",
      "message": "message",
      "createdAt": "2020-12-12T00:12:12+01:00",
      "updatedAt": "2020-12-12T00:12:12+01:00"
    }
    """