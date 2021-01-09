Feature: Unit

  @database
  Scenario: Check unit register
    Given I load the fixture "unit"
    And I am logged with the email "admin@orange.fr"
    When I request the url "/api/unit" with http verb "POST" and with the payload
    """
    {
      "temperatureUnit": "°C",
      "speedUnit": "km/h",
      "rainUnit": "mm",
      "solarRadiationUnit": "w/m²",
      "pmUnit": "µg/m3",
      "humidityUnit": "%",
      "type": "imperial"
    }
    """
    Then the status code should be 201
    And Object "Unit" in namespace "WebApp" with the following data should exist in database
      | attribute           | value     |
      | temperatureUnit     | °C        |
      | speedUnit           | km/h      |
      | rainUnit            | mm        |
      | solarRadiationUnit  | w/m²      |
      | pmUnit              | µg/m3     |
      | humidityUnit        | %         |
      | type                | imperial  |

  @database
  Scenario: Check unit register with existing type
    Given I load the fixture "unit"
    And I am logged with the email "admin@orange.fr"
    When I request the url "/api/unit" with http verb "POST" and with the payload
    """
    {
      "temperatureUnit": "°C",
      "speedUnit": "km/h",
      "rainUnit": "mm",
      "solarRadiationUnit": "w/m²",
      "pmUnit": "µg/m3",
      "humidityUnit": "%",
      "type": "metric"
    }
    """
    Then the status code should be 400
    And the response should have the following content
    """
     {
        "type": "UnitAlreadyExistException",
        "content": "UnitAlreadyExistException"
     }
    """

  @database
  Scenario: Check unit register with bad role
    Given I load the fixture "unit"
    And I am logged with the email "editor@orange.fr"
    When I request the url "/api/unit" with http verb "POST" and with the payload
    """
    {
      "temperatureUnit": "°C",
      "speedUnit": "km/h",
      "rainUnit": "mm",
      "solarRadiationUnit": "w/m²",
      "pmUnit": "µg/m3",
      "humidityUnit": "%",
      "type": "metric"
    }
    """
    Then the status code should be 403

  @database
  Scenario: Check unit register without user
    Given I load the fixture "unit"
    When I request the url "/api/unit" with http verb "POST" and with the payload
    """
    {
      "temperatureUnit": "°C",
      "speedUnit": "km/h",
      "rainUnit": "mm",
      "solarRadiationUnit": "w/m²",
      "pmUnit": "µg/m3",
      "humidityUnit": "%",
      "type": "metric"
    }
    """
    Then the status code should be 401