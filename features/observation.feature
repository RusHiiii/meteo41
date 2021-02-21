Feature: Observation

  @database
  Scenario: Check observation register
    Given I load the fixture "observation"
    And I am logged with the email "admin@test.fr"
    When I request the url "/api/observation" with http verb "POST" and with the payload
    """
    {
      "message": "je suis un mesage",
      "weatherStationId": 1
    }
    """
    Then the status code should be 201
    And Object "Observation" in namespace "WebApp" with the following data should exist in database
      | attribute       | value             |
      | user            | 1                 |
      | message         | je suis un mesage |
      | weatherStation  | 1                 |

  @database
  Scenario: Check observation register with bad message
    Given I load the fixture "observation"
    And I am logged with the email "admin@test.fr"
    When I request the url "/api/observation" with http verb "POST" and with the payload
    """
    {
      "message": "",
      "weatherStationId": 1
    }
    """
    Then the status code should be 400
    And the response should have the following content
    """
     [
       {
          "message":"Cette valeur ne doit pas \u00eatre vide.",
          "messageTemplate":"This value should not be blank.",
          "propertyPath":"message"
       },
       {
          "message":"Cette cha\u00eene est trop courte. Elle doit avoir au minimum 5 caract\u00e8res.",
          "messageTemplate":"This value is too short. It should have {{ limit }} character or more.|This value is too short. It should have {{ limit }} characters or more.",
          "propertyPath":"message"
       }
    ]
    """

  @database
  Scenario: Check observation register with bad weather station
    Given I load the fixture "observation"
    And I am logged with the email "admin@test.fr"
    When I request the url "/api/observation" with http verb "POST" and with the payload
    """
    {
      "message": "sasasa",
      "weatherStationId": 10
    }
    """
    Then the status code should be 400
    And the response should have the following content
    """
     {
      "type": "WeatherStationNotFoundException",
      "content": "WeatherStationNotFoundException"
     }
    """

  @database
  Scenario: Edit observation
    Given I load the fixture "observation"
    And I am logged with the email "admin@test.fr"
    When I request the url "/api/observation/1" with http verb "PUT" and with the payload
    """
    {
      "message": "je suis un mesage de test",
      "weatherStationId": 1
    }
    """
    Then the status code should be 204
    And Object "Observation" in namespace "WebApp" with the following data should exist in database
      | attribute       | value                     |
      | user            | 1                         |
      | message         | je suis un mesage de test |
      | weatherStation  | 1                         |

  @database
  Scenario: Edit observation without user
    Given I load the fixture "observation"
    When I request the url "/api/observation/1" with http verb "PUT" and with the payload
    """
    {
      "message": "je suis un mesage de test",
      "weatherStationId": 1
    }
    """
    Then the status code should be 401

  @database
  Scenario: Delete observation
    Given I load the fixture "observation"
    And I am logged with the email "admin@test.fr"
    When I request the url "/api/observation/1" with http verb "DELETE"
    Then the status code should be 204
    And Object "Observation" in namespace "WebApp" with the following data shouldn't exist in database
      | attribute | value |
      | id        | 1     |

  @database
  Scenario: Delete observation without existing
    Given I load the fixture "observation"
    And I am logged with the email "admin@test.fr"
    When I request the url "/api/observation/10" with http verb "DELETE"
    Then the status code should be 404

  @database
  Scenario: Show observation with logged user
    Given I load the fixture "observation"
    And I am logged with the email "admin@test.fr"
    When I request the url "/api/observation/1" with http verb "GET"
    Then the status code should be 200
    And the response should have the following content
    """
     {
       "id":1,
       "message":"test de message",
       "createdAt":"2020-12-11T00:12:12+01:00",
       "updatedAt":"2020-12-11T00:12:12+01:00",
       "user":{
          "firstname":"florent",
          "lastname":"damiens",
          "email":"admin@test.fr",
          "roles":[
             "ROLE_ADMIN"
          ],
          "createdAt":"2020-12-11T00:12:12+01:00",
          "updatedAt":"2020-12-11T00:12:12+01:00",
          "id":1
       },
       "weatherStation":{
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
    }
    """

  @database
  Scenario: Show observation without logged user
    Given I load the fixture "observation"
    When I request the url "/api/observation/1" with http verb "GET"
    Then the status code should be 200
    And the response should have the following content
    """
     {
       "id":1,
       "message":"test de message",
       "createdAt":"2020-12-11T00:12:12+01:00",
       "updatedAt":"2020-12-11T00:12:12+01:00",
       "user":{
          "firstname":"florent",
          "lastname":"damiens",
          "email":null,
          "roles":null,
          "createdAt":"2020-12-11T00:12:12+01:00",
          "updatedAt":"2020-12-11T00:12:12+01:00",
          "id":1
       },
       "weatherStation":{
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
    }
    """

  @database
  Scenario: List observation without parameter
    Given I load the fixture "observation"
    When I request the url "/api/observation" with http verb "GET"
    Then the status code should be 200
    And the response should have the following content
    """
     {
       "numberOfResult":3,
       "observations":[
          {
             "id":3,
             "message":"test de message2",
             "createdAt":"2020-12-11T00:12:12+01:00",
             "updatedAt":"2020-12-11T00:12:12+01:00",
             "user":{
                "firstname":"florent",
                "lastname":"damiens",
                "email":null,
                "roles":null,
                "createdAt":"2020-12-11T00:12:12+01:00",
                "updatedAt":"2020-12-11T00:12:12+01:00",
                "id":1
             },
             "weatherStation":{
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
          },
          {
             "id":2,
             "message":"meteo",
             "createdAt":"2020-12-11T00:12:12+01:00",
             "updatedAt":"2020-12-11T00:12:12+01:00",
             "user":{
                "firstname":"florent",
                "lastname":"damiens",
                "email":null,
                "roles":null,
                "createdAt":"2020-12-11T00:12:12+01:00",
                "updatedAt":"2020-12-11T00:12:12+01:00",
                "id":1
             },
             "weatherStation":{
                "id":2,
                "name":"Station de Romo",
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
          },
          {
             "id":1,
             "message":"test de message",
             "createdAt":"2020-12-11T00:12:12+01:00",
             "updatedAt":"2020-12-11T00:12:12+01:00",
             "user":{
                "firstname":"florent",
                "lastname":"damiens",
                "email":null,
                "roles":null,
                "createdAt":"2020-12-11T00:12:12+01:00",
                "updatedAt":"2020-12-11T00:12:12+01:00",
                "id":1
             },
             "weatherStation":{
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
          }
       ]
    }
    """

  @database
  Scenario: List observation with parameter
    Given I load the fixture "observation"
    When I request the url "/api/observation?searchBy[weatherStation]=2" with http verb "GET"
    Then the status code should be 200
    And the response should have the following content
    """
     {
       "numberOfResult":1,
       "observations":[
          {
             "id":2,
             "message":"meteo",
             "createdAt":"2020-12-11T00:12:12+01:00",
             "updatedAt":"2020-12-11T00:12:12+01:00",
             "user":{
                "firstname":"florent",
                "lastname":"damiens",
                "email":null,
                "roles":null,
                "createdAt":"2020-12-11T00:12:12+01:00",
                "updatedAt":"2020-12-11T00:12:12+01:00",
                "id":1
             },
             "weatherStation":{
                "id":2,
                "name":"Station de Romo",
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
          }
       ]
    }
    """

  @database
  Scenario: List observation with message parameter
    Given I load the fixture "observation"
    When I request the url "/api/observation?searchBy[message]=meteo" with http verb "GET"
    Then the status code should be 200
    And the response should have the following content
    """
     {
       "numberOfResult":1,
       "observations":[
          {
             "id":2,
             "message":"meteo",
             "createdAt":"2020-12-11T00:12:12+01:00",
             "updatedAt":"2020-12-11T00:12:12+01:00",
             "user":{
                "firstname":"florent",
                "lastname":"damiens",
                "email":null,
                "roles":null,
                "createdAt":"2020-12-11T00:12:12+01:00",
                "updatedAt":"2020-12-11T00:12:12+01:00",
                "id":1
             },
             "weatherStation":{
                "id":2,
                "name":"Station de Romo",
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
          }
       ]
    }
    """