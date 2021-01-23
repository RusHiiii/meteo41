Feature: User

  @database
  Scenario: Check user register
    Given I load the fixture "user"
    And I am logged with the email "damiens.florent@orange.fr"
    When I request the url "/api/user" with http verb "POST" and with the payload
    """
    {
      "firstname": "patrick",
      "lastname": "dupond",
      "email": "patrick@orange.fr",
      "password": "jeSuis5*mDp",
      "passwordConfirmation": "jeSuis5*mDp",
      "roles": ["ROLE_USER", "ROLE_EDITOR"]
    }
    """
    Then the status code should be 201
    And Object "User" in namespace "WebApp" with the following data should exist in database
      | attribute   | value             |
      | firstname   | patrick           |
      | lastname    | dupond            |
      | email       | patrick@orange.fr |
    And User with mail "patrick@orange.fr" has role "ROLE_USER"
    And User with mail "patrick@orange.fr" has role "ROLE_EDITOR"
    And User with mail "patrick@orange.fr" has password "jeSuis5*mDp"

  @database
  Scenario: Check user register with bad confirmation password
    Given I load the fixture "user"
    And I am logged with the email "damiens.florent@orange.fr"
    When I request the url "/api/user" with http verb "POST" and with the payload
    """
    {
      "firstname": "patrick",
      "lastname": "dupond",
      "email": "patrick@orange.fr",
      "password": "jeSuis5*mDp",
      "passwordConfirmation": "jeSuis5*mDpp",
      "roles": ["ROLE_USER", "ROLE_EDITOR"]
    }
    """
    Then the status code should be 400
    And the response should have the following content
    """
     {
         "type":"BadPasswordConfirmationException",
         "content":"BadPasswordConfirmationException"
      }
    """

  @database
  Scenario: Check user register with bad password security
    Given I load the fixture "user"
    And I am logged with the email "damiens.florent@orange.fr"
    When I request the url "/api/user" with http verb "POST" and with the payload
    """
    {
      "firstname": "patrick",
      "lastname": "dupond",
      "email": "patrick@orange.fr",
      "password": "jeSuis",
      "passwordConfirmation": "jeSuis",
      "roles": ["ROLE_USER", "ROLE_EDITOR"]
    }
    """
    Then the status code should be 400
    And the response should have the following content
    """
     [
       {
          "message":"Cette valeur n'est pas valide.",
          "messageTemplate":"This value is not valid.",
          "propertyPath":"password"
       },
       {
          "message":"Cette valeur n'est pas valide.",
          "messageTemplate":"This value is not valid.",
          "propertyPath":"passwordConfirmation"
       }
    ]
    """

  @database
  Scenario: Check user register with user already exist
    Given I load the fixture "user"
    And I am logged with the email "damiens.florent@orange.fr"
    When I request the url "/api/user" with http verb "POST" and with the payload
    """
    {
      "firstname": "patrick",
      "lastname": "dupond",
      "email": "damiens.florent@orange.fr",
      "password": "jeSuis5*mDp",
      "passwordConfirmation": "jeSuis5*mDpp",
      "roles": ["ROLE_USER", "ROLE_EDITOR"]
    }
    """
    Then the status code should be 400
    And the response should have the following content
    """
     {
         "type":"UserAlreadyExistException",
         "content":"UserAlreadyExistException"
      }
    """

  @database
  Scenario: Check user register with bad role
    Given I load the fixture "user"
    And I am logged with the email "damiens.florent@orange.fr"
    When I request the url "/api/user" with http verb "POST" and with the payload
    """
    {
      "firstname": "patrick",
      "lastname": "dupond",
      "email": "damiens.florent@orange.fr",
      "password": "jeSuis5*mDp",
      "passwordConfirmation": "jeSuis5*mDpp",
      "roles": ["ROLE_USER", "ROLE_F1AUX"]
    }
    """
    Then the status code should be 400
    And the response should have the following content
    """
     [
       {
          "message":"Une ou plusieurs des valeurs soumises sont invalides.",
          "messageTemplate":"One or more of the given values is invalid.",
          "propertyPath":"roles"
       }
    ]
    """

  @database
  Scenario: Delete user
    Given I load the fixture "user"
    And I am logged with the email "damiens.florent@orange.fr"
    When I request the url "/api/user/1" with http verb "DELETE" and with the payload
    """
    {
      "firstname": "patrick",
      "lastname": "dupond",
      "email": "damiens.florent@orange.fr",
      "password": "jeSuis5*mDp",
      "passwordConfirmation": "jeSuis5*mDpp",
      "roles": ["ROLE_USER", "ROLE_F1AUX"]
    }
    """
    Then the status code should be 204
    And Object "User" in namespace "WebApp" with the following data shouldn't exist in database
      | attribute   | value        |
      | id          | 1            |

  @database
  Scenario: Check user update
    Given I load the fixture "user"
    And I am logged with the email "damiens.florent@orange.fr"
    When I request the url "/api/user/1" with http verb "PUT" and with the payload
    """
    {
      "firstname": "patrick",
      "lastname": "dupond",
      "email": "damiens.florent@orange.fr",
      "password": "jeSuis5*mDp",
      "passwordConfirmation": "jeSuis5*mDp",
      "roles": ["ROLE_USER", "ROLE_EDITOR"]
    }
    """
    Then the status code should be 204
    And Object "User" in namespace "WebApp" with the following data should exist in database
      | attribute   | value                     |
      | firstname   | patrick                   |
      | lastname    | dupond                    |
      | email       | damiens.florent@orange.fr |
    And User with mail "damiens.florent@orange.fr" has role "ROLE_USER"
    And User with mail "damiens.florent@orange.fr" has role "ROLE_EDITOR"
    And User with mail "damiens.florent@orange.fr" has password "jeSuis5*mDp"

  @database
  Scenario: Check user update with other mail
    Given I load the fixture "user"
    And I am logged with the email "damiens.florent@orange.fr"
    When I request the url "/api/user/1" with http verb "PUT" and with the payload
    """
    {
      "firstname": "patrick",
      "lastname": "dupond",
      "email": "florent@orange.fr",
      "password": "jeSuis5*mDp",
      "passwordConfirmation": "jeSuis5*mDp",
      "roles": ["ROLE_USER", "ROLE_EDITOR"]
    }
    """
    Then the status code should be 400
    And the response should have the following content
    """
     {
         "type":"CannotEditMailException",
         "content":"CannotEditMailException"
      }
    """