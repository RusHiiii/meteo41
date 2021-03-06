Feature: Post

  @database
  Scenario: Check post register
    Given I load the fixture "user"
    And I am logged with the email "admin@orange.fr"
    When I request the url "/api/post" with http verb "POST" and with the payload
    """
    {
      "name": "je suis un name",
      "description": "description"
    }
    """
    Then the status code should be 201
    And Object "Post" in namespace "WebApp" with the following data should exist in database
      | attribute   | value           |
      | user        | 2               |
      | name        | je suis un name |
      | description | description     |

  @database
  Scenario: Check post register without name
    Given I load the fixture "user"
    And I am logged with the email "admin@orange.fr"
    When I request the url "/api/post" with http verb "POST" and with the payload
    """
    {
      "name": "",
      "description": "description"
    }
    """
    Then the status code should be 400
    And the response should have the following content
    """
     [
       {
          "message":"Cette valeur ne doit pas \u00eatre vide.",
          "messageTemplate":"This value should not be blank.",
          "propertyPath":"name"
       },
       {
          "message":"Cette cha\u00eene est trop courte. Elle doit avoir au minimum 5 caract\u00e8res.",
          "messageTemplate":"This value is too short. It should have {{ limit }} character or more.|This value is too short. It should have {{ limit }} characters or more.",
          "propertyPath":"name"
       }
    ]
    """

  @database
  Scenario: Delete post
    Given I load the fixture "post"
    And I am logged with the email "admin@test.fr"
    When I request the url "/api/post/1" with http verb "DELETE"
    Then the status code should be 204
    And Object "Post" in namespace "WebApp" with the following data shouldn't exist in database
      | attribute   | value        |
      | id          | 1            |

  @database
  Scenario: Check post update
    Given I load the fixture "post"
    And I am logged with the email "admin@test.fr"
    When I request the url "/api/post/1" with http verb "PUT" and with the payload
    """
    {
      "name": "name2",
      "description": "desc2"
    }
    """
    Then the status code should be 204
    And Object "Post" in namespace "WebApp" with the following data should exist in database
      | attribute   | value   |
      | id          | 1       |
      | name        | name2   |
      | description | desc2   |

  @database
  Scenario: Check post update
    Given I load the fixture "post"
    And I am logged with the email "admin@test.fr"
    When I request the url "/api/post/10" with http verb "PUT" and with the payload
    """
    {
      "name": "name2",
      "description": "desc2"
    }
    """
    Then the status code should be 404

  @database
  Scenario: Show post without user
    Given I load the fixture "post"
    When I request the url "/api/post/1" with http verb "GET"
    Then the status code should be 200
    And the response should have the following content
    """
     {
       "id":1,
       "name":"nale",
       "createdAt":"2020-12-11T00:12:12+01:00",
       "updatedAt":"2020-12-11T00:12:12+01:00",
       "description":"subject",
       "user":{
          "firstname":"florent",
          "lastname":"damiens",
          "email":null,
          "roles":null,
          "createdAt":"2020-12-11T00:12:12+01:00",
          "updatedAt":"2020-12-11T00:12:12+01:00",
          "id":1
       }
    }
    """

  @database
  Scenario: Show post with user
    Given I load the fixture "post"
    And I am logged with the email "admin@test.fr"
    When I request the url "/api/post/1" with http verb "GET"
    Then the status code should be 200
    And the response should have the following content
    """
     {
       "id":1,
       "name":"nale",
       "createdAt":"2020-12-11T00:12:12+01:00",
       "updatedAt":"2020-12-11T00:12:12+01:00",
       "description":"subject",
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
       }
    }
    """

  @database
  Scenario: Show list post with user
    Given I load the fixture "post"
    And I am logged with the email "admin@test.fr"
    When I request the url "/api/post" with http verb "GET"
    Then the status code should be 200
    And the response should have the following content
    """
     {
       "numberOfResult":1,
       "posts":[
          {
             "id":1,
             "name":"nale",
             "createdAt":"2020-12-11T00:12:12+01:00",
             "updatedAt":"2020-12-11T00:12:12+01:00",
             "description":"subject",
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
             }
          }
       ]
    }
    """

  @database
  Scenario: Show list post without user
    Given I load the fixture "post"
    When I request the url "/api/post" with http verb "GET"
    Then the status code should be 200
    And the response should have the following content
    """
     {
       "numberOfResult":1,
       "posts":[
          {
             "id":1,
             "name":"nale",
             "createdAt":"2020-12-11T00:12:12+01:00",
             "updatedAt":"2020-12-11T00:12:12+01:00",
             "description":"subject",
             "user":{
                "firstname":"florent",
                "lastname":"damiens",
                "email":null,
                "roles":null,
                "createdAt":"2020-12-11T00:12:12+01:00",
                "updatedAt":"2020-12-11T00:12:12+01:00",
                "id":1
             }
          }
       ]
    }
    """

  @database
  Scenario: Show list post without user with search params
    Given I load the fixture "post"
    When I request the url "/api/post?searchBy[user]=1" with http verb "GET"
    Then the status code should be 200
    And the response should have the following content
    """
     {
       "numberOfResult":1,
       "posts":[
          {
             "id":1,
             "name":"nale",
             "createdAt":"2020-12-11T00:12:12+01:00",
             "updatedAt":"2020-12-11T00:12:12+01:00",
             "description":"subject",
             "user":{
                "firstname":"florent",
                "lastname":"damiens",
                "email":null,
                "roles":null,
                "createdAt":"2020-12-11T00:12:12+01:00",
                "updatedAt":"2020-12-11T00:12:12+01:00",
                "id":1
             }
          }
       ]
    }
    """

  @database
  Scenario: Show list post without user with search params
    Given I load the fixture "post"
    When I request the url "/api/post?searchBy[user]=1&searchBy[name]=na" with http verb "GET"
    Then the status code should be 200
    And the response should have the following content
    """
     {
       "numberOfResult":1,
       "posts":[
          {
             "id":1,
             "name":"nale",
             "createdAt":"2020-12-11T00:12:12+01:00",
             "updatedAt":"2020-12-11T00:12:12+01:00",
             "description":"subject",
             "user":{
                "firstname":"florent",
                "lastname":"damiens",
                "email":null,
                "roles":null,
                "createdAt":"2020-12-11T00:12:12+01:00",
                "updatedAt":"2020-12-11T00:12:12+01:00",
                "id":1
             }
          }
       ]
    }
    """