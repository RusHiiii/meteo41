Feature: Login

  @database
  Scenario: Check user login with bad email
    Given I load the fixture "user"
    When I request the url "/api/login" with http verb "POST" and with the payload
        """
        {
          "email": "bad@gmail.com",
          "password": "pass"
        }
        """
    Then the status code should be 403

  @database
  Scenario: Check user login with good email
    Given I load the fixture "user"
    When I request the url "/api/login" with http verb "POST" and with the payload
        """
        {
          "email": "damiens.florent@orange.fr",
          "password": "pass"
        }
        """
    Then the status code should be 200

  @database
  Scenario: Check user login with bad password
    Given I load the fixture "user"
    When I request the url "/api/login" with http verb "POST" and with the payload
        """
        {
          "email": "damiens.florent@orange.fr",
          "password": "bad"
        }
        """
    Then the status code should be 403