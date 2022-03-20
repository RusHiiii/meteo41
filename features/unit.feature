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
      "cloudBaseUnit": "m",
      "windDirUnit": "°",
      "pmUnit": "µg/m3",
      "humidityUnit": "%",
      "pressureUnit": "hPa",
      "type": "Imperial"
    }
    """
    Then the status code should be 201
    And Object "Unit" in namespace "WebApp" with the following data should exist in database
      | attribute           | value     |
      | temperatureUnit     | °C        |
      | speedUnit           | km/h      |
      | rainUnit            | mm        |
      | solarRadiationUnit  | w/m²      |
      | pressureUnit        | hPa       |
      | pmUnit              | µg/m3     |
      | humidityUnit        | %         |
      | windDirUnit         | °         |
      | cloudBaseUnit       | m         |
      | type                | Imperial  |

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
      "cloudBaseUnit": "m",
      "windDirUnit": "°",
      "pressureUnit": "hPa",
      "humidityUnit": "%",
      "type": "Metric"
    }
    """
    Then the status code should be 400
    And the response should have the following content
    """
     [{
        "type": "UnitAlreadyExistException",
        "message": "Unité dupliquée !"
     }]
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
      "pressureUnit": "hPa",
      "pmUnit": "µg/m3",
      "humidityUnit": "%",
      "type": "Metric"
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
      "pressureUnit": "hPa",
      "humidityUnit": "%",
      "type": "metric"
    }
    """
    Then the status code should be 401

  @database
  Scenario: Check unit edit
    Given I load the fixture "unit"
    And I am logged with the email "admin@orange.fr"
    When I request the url "/api/unit/1" with http verb "PUT" and with the payload
    """
    {
      "temperatureUnit": "aa",
      "speedUnit": "aa",
      "rainUnit": "a",
      "solarRadiationUnit": "wa/m²",
      "pmUnit": "wm3",
      "cloudBaseUnit": "ma",
      "windDirUnit": "po",
      "pressureUnit": "hPa",
      "humidityUnit": "wa",
      "type": "metrics"
    }
    """
    Then the status code should be 201
    And Object "Unit" in namespace "WebApp" with the following data should exist in database
      | attribute           | value     |
      | temperatureUnit     | aa        |
      | speedUnit           | aa        |
      | rainUnit            | a         |
      | solarRadiationUnit  | wa/m²     |
      | pmUnit              | wm3       |
      | cloudBaseUnit       | ma        |
      | windDirUnit         | po        |
      | pressureUnit        | hPa       |
      | humidityUnit        | wa        |
      | type                | metrics   |

  @database
  Scenario: Check unit edit with bad data
    Given I load the fixture "unit"
    And I am logged with the email "admin@orange.fr"
    When I request the url "/api/unit/1" with http verb "PUT" and with the payload
    """
    {
      "temperatureUnit": "aa",
      "speedUnit": "",
      "rainUnit": "a",
      "solarRadiationUnit": "wa/m²",
      "pmUnit": "wm3",
      "humidityUnit": "wa",
      "pressureUnit": "hPa",
      "type": "metrics",
      "cloudBaseUnit": "ma",
      "windDirUnit": "po"
    }
    """
    Then the status code should be 400
    And the response should have the following content
    """
     [
       {
          "message": "Cette valeur ne doit pas être vide.",
          "messageTemplate": "This value should not be blank.",
          "propertyPath": "speedUnit"
       }
     ]
    """

  @database
  Scenario: Check delete unit
    Given I load the fixture "unit"
    And I am logged with the email "admin@orange.fr"
    When I request the url "/api/unit/1" with http verb "DELETE"
    Then the status code should be 204
    And Object "Unit" in namespace "WebApp" with the following data shouldn't exist in database
      | attribute | value     |
      | id        | 1         |

  @database
  Scenario: Check delete unit without user
    Given I load the fixture "unit"
    When I request the url "/api/unit/1" with http verb "DELETE"
    Then the status code should be 401

  @database
  Scenario: Get unit with user logged
    Given I load the fixture "unit"
    And I am logged with the email "admin@orange.fr"
    When I request the url "/api/unit/1" with http verb "GET"
    Then the status code should be 200
    And the response should have the following content
    """
     {
       "id":1,
       "temperatureUnit":"°C",
       "speedUnit":"m\/s",
       "rainUnit":"mm",
       "solarRadiationUnit":"lux",
       "pmUnit":"um\/m",
       "cloudBaseUnit":"m",
       "pressureUnit": "hPa",
       "windDirUnit":"°",
       "humidityUnit":"%",
       "type":"Metric",
       "createdAt":"2020-12-10T00:12:12+01:00",
       "updatedAt":"2020-12-10T00:12:12+01:00"
    }
    """

  @database
  Scenario: Get unit without user logged
    Given I load the fixture "unit"
    When I request the url "/api/unit/1" with http verb "GET"
    Then the status code should be 401

  @database
  Scenario: Show unit list with user logged
    Given I load the fixture "unit"
    And I am logged with the email "admin@orange.fr"
    When I request the url "/api/unit" with http verb "GET"
    Then the status code should be 200
    And the response should have the following content
    """
     {
       "numberOfResult":1,
       "units":[
          {
             "id":1,
             "temperatureUnit":"°C",
             "speedUnit":"m/s",
             "rainUnit":"mm",
             "solarRadiationUnit":"lux",
             "pmUnit":"um/m",
             "humidityUnit":"%",
             "pressureUnit":"hPa",
             "type":"Metric",
             "cloudBaseUnit":"m",
             "windDirUnit":"°",
             "createdAt":"2020-12-10T00:12:12+01:00",
             "updatedAt":"2020-12-10T00:12:12+01:00"
          }
       ]
    }
    """