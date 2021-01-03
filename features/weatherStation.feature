Feature: Weather station

  @database
  Scenario: Delete weather station without user logged
    Given I load the fixture "weatherStation"
    When I request the url "/api/weatherStation/1" with http verb "DELETE"
    Then the status code should be 401

  @database
  Scenario: Delete weather station with bad user role
    Given I load the fixture "weatherStation"
    And I am logged with the email "editor@test.fr"
    When I request the url "/api/weatherStation/1" with http verb "DELETE"
    Then the status code should be 403

  @database
  Scenario: Delete weather station
    Given I load the fixture "weatherStation"
    And I am logged with the email "admin@test.fr"
    When I request the url "/api/weatherStation/1" with http verb "DELETE"
    Then the status code should be 204
    And Object "WeatherStation" in namespace "WebApp" with the following data shouldn't exist in database
      | attribute   | value        |
      | id          | 1            |
    And Object "Observation" in namespace "WebApp" with the following data shouldn't exist in database
      | attribute   | value        |
      | id          | 1            |

  @database
  Scenario: Check weather station register
    Given I load the fixture "user"
    And I am logged with the email "damiens.florent@orange.fr"
    When I request the url "/api/weatherStation" with http verb "POST" and with the payload
    """
    {
      "name": "station 1",
      "description": "ma description",
      "shortDescription": "ma short description",
      "country": "FR",
      "address": "rue du moulin",
      "city": "Blois",
      "lat": 4.5632,
      "lng": 4.1236,
      "apiToken": "XYXYXXYX",
      "model": "HP 2551",
      "elevation": "250m"
    }
    """
    Then the status code should be 201
    And Object "WeatherStation" in namespace "WebApp" with the following data should exist in database
      | attribute         | value                 |
      | name              | station 1             |
      | description       | ma description        |
      | shortDescription  | ma short description  |
      | country           | FR                    |
      | address           | rue du moulin         |
      | city              | Blois                 |
      | lat               | 4.5632                |
      | lng               | 4.1236                |
      | apiToken          | XYXYXXYX              |
      | model             | HP 2551               |
      | elevation         | 250m                  |

  @database
  Scenario: Check weather station register with bad data
    Given I load the fixture "user"
    And I am logged with the email "damiens.florent@orange.fr"
    When I request the url "/api/weatherStation" with http verb "POST" and with the payload
    """
    {
      "name": "station 1",
      "description": "ma description",
      "shortDescription": "ma short description",
      "country": "France",
      "address": "rue du moulin",
      "city": "Blois",
      "lat": 4.5632,
      "lng": 4.1236,
      "apiToken": "",
      "model": "HP 2551",
      "elevation": "250m"
    }
    """
    Then the status code should be 400
    And the response should have the following content
    """
     [
       {
          "message": "Ce pays n'est pas valide.",
          "messageTemplate": "This value is not a valid country.",
          "propertyPath": "country"
       },
       {
          "message": "Cette valeur ne doit pas être vide.",
          "messageTemplate": "This value should not be blank.",
          "propertyPath": "apiToken"
       }
     ]
    """

  @database
  Scenario: Check weather station register with duplicated weather station
    Given I load the fixture "weatherStation"
    And I am logged with the email "admin@test.fr"
    When I request the url "/api/weatherStation" with http verb "POST" and with the payload
    """
    {
      "name": "station 1",
      "description": "ma description",
      "shortDescription": "ma short description",
      "country": "FR",
      "address": "46 rue des moulins",
      "city": "Blois",
      "lat": 4.5632,
      "lng": 4.1236,
      "apiToken": "XXXXXXX",
      "model": "HP 2551",
      "elevation": "250m"
    }
    """
    Then the status code should be 400
    And the response should have the following content
    """
     {
      "type": "DuplicateWeatherStationFoundException",
      "content": "DuplicateWeatherStationFoundException"
     }
    """

  @database
  Scenario: Check weather station edition
    Given I load the fixture "weatherStation"
    And I am logged with the email "admin@test.fr"
    When I request the url "/api/weatherStation/1" with http verb "POST" and with the payload
    """
    {
      "name": "station 1",
      "description": "ma description",
      "shortDescription": "ma short description",
      "country": "FR",
      "address": "rue du moulin",
      "city": "Blois",
      "lat": 4.5632,
      "lng": 4.1236,
      "apiToken": "XYXYXXYX",
      "model": "HP 2551",
      "elevation": "250m"
    }
    """
    Then the status code should be 204
    And Object "WeatherStation" in namespace "WebApp" with the following data should exist in database
      | attribute         | value                 |
      | name              | station 1             |
      | description       | ma description        |
      | shortDescription  | ma short description  |
      | country           | FR                    |
      | address           | rue du moulin         |
      | city              | Blois                 |
      | lat               | 4.5632                |
      | lng               | 4.1236                |
      | apiToken          | XYXYXXYX              |
      | model             | HP 2551               |
      | elevation         | 250m                  |

  @database
  Scenario: Check weather station edition with bad data
    Given I load the fixture "weatherStation"
    And I am logged with the email "admin@test.fr"
    When I request the url "/api/weatherStation/1" with http verb "POST" and with the payload
    """
    {
      "name": "station 1",
      "description": "ma description",
      "shortDescription": "ma short description",
      "country": "FRA",
      "address": "rue du moulin",
      "city": "Blois",
      "lat": 4.5632,
      "lng": 4.1236,
      "apiToken": "",
      "model": "HP 2551",
      "elevation": ""
    }
    """
    Then the status code should be 400
    And the response should have the following content
    """
     [
       {
          "message": "Ce pays n'est pas valide.",
          "messageTemplate": "This value is not a valid country.",
          "propertyPath": "country"
       },
       {
          "message": "Cette valeur ne doit pas être vide.",
          "messageTemplate": "This value should not be blank.",
          "propertyPath": "apiToken"
       },
       {
          "message": "Cette valeur ne doit pas être vide.",
          "messageTemplate": "This value should not be blank.",
          "propertyPath": "elevation"
       }
     ]
    """

  @database
  Scenario: Get weather station without user logged
    Given I load the fixture "weatherStation"
    When I request the url "/api/weatherStation/1" with http verb "GET"
    Then the status code should be 200
    And the response should have the following content
    """
     {
       "id":1,
       "name":"Station de Blois",
       "description":"ma longue description",
       "shortDescription":"courte descrition",
       "country":"FR",
       "address":"46 rue des moulins",
       "city":"Blois",
       "lat":4.5956,
       "lng":4.2356,
       "model":"HP 2551",
       "elevation":"200m",
       "createdAt":"2020-12-11T00:12:12+01:00",
       "updatedAt":"2020-12-11T00:12:12+01:00"
    }
    """

  @database
  Scenario: Get weather station with user logged
    Given I load the fixture "weatherStation"
    And I am logged with the email "admin@test.fr"
    When I request the url "/api/weatherStation/1" with http verb "GET"
    Then the status code should be 200
    And the response should have the following content
    """
     {
       "id":1,
       "name":"Station de Blois",
       "description":"ma longue description",
       "shortDescription":"courte descrition",
       "country":"FR",
       "address":"46 rue des moulins",
       "city":"Blois",
       "lat":4.5956,
       "lng":4.2356,
       "model":"HP 2551",
       "elevation":"200m",
       "createdAt":"2020-12-11T00:12:12+01:00",
       "updatedAt":"2020-12-11T00:12:12+01:00"
    }
    """

  @database
  Scenario: Show list of weather station with user logged with bad params order
    Given I load the fixture "weatherStation"
    And I am logged with the email "admin@test.fr"
    When I request the url "/api/weatherStation?searchBy[name]=bad&order=DESCAS&maxResult=1&page=2" with http verb "GET"
    Then the status code should be 400
    And the response should have the following content
    """
     {
        "type": "InvalidArgumentException",
        "content": "Order not valid"
     }
    """

  @database
  Scenario: Show list of weather station with good parameter
    Given I load the fixture "weatherStation"
    When I request the url "/api/weatherStation?searchBy[name]=Blois&order=DESC&maxResult=10&page=1" with http verb "GET"
    Then the status code should be 200
    And the response should have the following content
    """
     {
       "numberOfResult":2,
       "weatherStations":[
          {
             "id":2,
             "name":"Station de Blois",
             "description":"ma longue description",
             "shortDescription":"courte descrition",
             "country":"FR",
             "address":"46 rue des moulins",
             "city":"Blois",
             "lat":4.5956,
             "lng":4.2356,
             "model":"HP 2551",
             "elevation":"200m",
             "createdAt":"2020-12-11T00:12:12+01:00",
             "updatedAt":"2020-12-11T00:12:12+01:00"
          },
          {
             "id":1,
             "name":"Station de Blois",
             "description":"ma longue description",
             "shortDescription":"courte descrition",
             "country":"FR",
             "address":"46 rue des moulins",
             "city":"Blois",
             "lat":4.5956,
             "lng":4.2356,
             "model":"HP 2551",
             "elevation":"200m",
             "createdAt":"2020-12-11T00:12:12+01:00",
             "updatedAt":"2020-12-11T00:12:12+01:00"
          }
       ]
    }
    """

  @database
  Scenario: Show list of weather station with good parameter
    Given I load the fixture "weatherStation"
    When I request the url "/api/weatherStation?searchBy[name]=Blois&searchBy[country]=DE&order=DESC&maxResult=10&page=1" with http verb "GET"
    Then the status code should be 200
    And the response should have the following content
    """
     {
       "numberOfResult":0,
       "weatherStations":[]
      }
    """

  @database
  Scenario: Show list of weather station with good parameter
    Given I load the fixture "weatherStation"
    When I request the url "/api/weatherStation?searchBy[name]=Blois&order=ASC&maxResult=1&page=2" with http verb "GET"
    Then the status code should be 200
    And the response should have the following content
    """
     {
      "numberOfResult":2,
       "weatherStations":[
          {
             "id":2,
             "name":"Station de Blois",
             "description":"ma longue description",
             "shortDescription":"courte descrition",
             "country":"FR",
             "address":"46 rue des moulins",
             "city":"Blois",
             "lat":4.5956,
             "lng":4.2356,
             "model":"HP 2551",
             "elevation":"200m",
             "createdAt":"2020-12-11T00:12:12+01:00",
             "updatedAt":"2020-12-11T00:12:12+01:00"
          }
       ]
    }
    """