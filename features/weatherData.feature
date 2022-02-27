Feature: Weather Data

  @database
  Scenario: Register weather data n°1
    Given I load the fixture "weatherStation"
    When I request the url "/api/weatherData" with http verb "POST" and with the payload
    """
    PASSKEY=5C909136C44BE31AB4F58FA0A5A54D68&stationtype=EasyWeatherV1.4.6&dateutc=2020-07-17+20:05:30&tempinf=75.6&humidityin=52&baromrelin=30.142&baromabsin=29.667&tempf=70.3&humidity=61&winddir=211&winddir_avg10m=211&windspeedmph=0.0&windspdmph_avg10m=0.0&windgustmph=0.0&maxdailygust=2.2&rainratein=0.000&eventrainin=0.000&hourlyrainin=0.000&dailyrainin=0.063&weeklyrainin=0.063&monthlyrainin=0.063&yearlyrainin=0.063&solarradiation=0.00&uv=0&pm25_ch1=7.0&pm25_avg_24h_ch1=6.5&wh65batt=0&wh25batt=0&pm25batt1=5&freq=868M&model=HP1000SE-PRO_Pro_V1.6.0
    """
    Then the status code should be 201
    And Object "WeatherData" in namespace "WebApp" with the following data should exist in database
      | attribute         | value        |
      | unit              | 1            |
      | weatherStation    | 1            |
      | temperature       | 21.3         |
      | humidity          | 61           |
      | relativePressure  | 1020.7       |
      | absolutePressure  | 1004.6       |
      | windDirection     | 211          |
      | windDirectionAvg  | 211          |
      | windSpeed         | 0            |
      | windSpeedAvg      | 0            |
      | windGust          | 0            |
      | windMaxDailyGust  | 3.5          |
      | rainRate          | 0            |
      | rainEvent         | 0            |
      | rainHourly        | 0            |
      | rainDaily         | 1.6          |
      | rainWeekly        | 1.6          |
      | rainMonthly       | 1.6          |
      | rainYearly        | 1.6          |
      | solarRadiation    | 0            |
      | uv                | 0            |
      | pm25              | 7            |
      | pm25Avg           | 6.5          |
      | humidex           | 24.4         |
      | dewPoint          | 13.5         |
      | windChill         | 21.3         |
      | cloudBase         | 970          |
      | beaufortScale     | 0            |
      | aqi               | 29           |
      | aqiAvg            | 27           |
      | heatIndex         | 21.1         |

  @database
  Scenario: Register weather data n°2
    Given I load the fixture "weatherStation"
    When I request the url "/api/weatherData" with http verb "POST" and with the payload
    """
    PASSKEY=5C909136C44BE31AB4F58FA0A5A54D68&stationtype=EasyWeatherV1.4.6&dateutc=2020-07-17+20:05:30&tempinf=69.8&humidityin=41&baromrelin=30.15&baromabsin=29.72&tempf=49.3&humidity=67&winddir=332&winddir_avg10m=332&windspeedmph=2.5&windspdmph_avg10m=8.1&windgustmph=8.1&maxdailygust=17.2&rainratein=0.000&eventrainin=0.36&hourlyrainin=0.00&dailyrainin=0.00&weeklyrainin=0.00&monthlyrainin=0.65&yearlyrainin=6.69&solarradiation=272.3&uv=2&pm25_ch1=9.0&pm25_avg_24h_ch1=9.0&wh65batt=0&wh25batt=0&pm25batt1=5&freq=868M&model=HP1000SE-PRO_Pro_V1.6.0
    """
    Then the status code should be 201
    And Object "WeatherData" in namespace "WebApp" with the following data should exist in database
      | attribute         | value        |
      | unit              | 1            |
      | weatherStation    | 1            |
      | temperature       | 9.6          |
      | humidity          | 67           |
      | relativePressure  | 1021         |
      | absolutePressure  | 1006.4       |
      | windDirection     | 332          |
      | windDirectionAvg  | 332          |
      | windSpeed         | 4            |
      | windSpeedAvg      | 13           |
      | windGust          | 13           |
      | windMaxDailyGust  | 27.7         |
      | rainRate          | 0            |
      | rainEvent         | 9.1          |
      | rainHourly        | 0            |
      | rainDaily         | 0            |
      | rainWeekly        | 0            |
      | rainMonthly       | 16.5         |
      | rainYearly        | 169.9        |
      | solarRadiation    | 272.3        |
      | uv                | 2            |
      | pm25              | 9            |
      | pm25Avg           | 9            |
      | humidex           | 9.6          |
      | dewPoint          | 3.8          |
      | windChill         | 9.6          |
      | cloudBase         | 727          |
      | beaufortScale     | 1            |
      | aqi               | 38           |
      | aqiAvg            | 38           |
      | heatIndex         | 8.4          |

  @database
  Scenario: Register weather data n°3
    Given I load the fixture "weatherStation"
    When I request the url "/api/weatherData" with http verb "POST" and with the payload
    """
    PASSKEY=5C909136C44BE31AB4F58FA0A5A54D68&stationtype=EasyWeatherV1.4.6&dateutc=2020-07-17+20:05:30&tempinf=69.8&humidityin=41&baromrelin=30.36&baromabsin=29.93&tempf=48.0&humidity=55&winddir=18&winddir_avg10m=18&windspeedmph=6.0&windspdmph_avg10m=6.0&windgustmph=13.6&maxdailygust=20.6&rainratein=0.000&eventrainin=0.00&hourlyrainin=0.00&dailyrainin=0.00&weeklyrainin=0.24&monthlyrainin=0.89&yearlyrainin=6.93&solarradiation=468.1&uv=4&pm25_ch1=13.0&pm25_avg_24h_ch1=13.0&wh65batt=0&wh25batt=0&pm25batt1=5&freq=868M&model=HP1000SE-PRO_Pro_V1.6.0
    """
    Then the status code should be 201
    And Object "WeatherData" in namespace "WebApp" with the following data should exist in database
      | attribute         | value        |
      | unit              | 1            |
      | weatherStation    | 1            |
      | temperature       | 8.9          |
      | humidity          | 55           |
      | relativePressure  | 1028.1       |
      | absolutePressure  | 1013.5       |
      | windDirection     | 18           |
      | windDirectionAvg  | 18           |
      | windSpeed         | 9.7          |
      | windSpeedAvg      | 9.7          |
      | windGust          | 21.9         |
      | windMaxDailyGust  | 33.1         |
      | rainRate          | 0            |
      | rainEvent         | 0            |
      | rainHourly        | 0            |
      | rainDaily         | 0            |
      | rainWeekly        | 6.1          |
      | rainMonthly       | 22.6         |
      | rainYearly        | 176          |
      | solarRadiation    | 468.1        |
      | uv                | 4            |
      | pm25              | 13           |
      | pm25Avg           | 13           |
      | humidex           | 8.9          |
      | dewPoint          | 0.3          |
      | windChill         | 7.4          |
      | cloudBase         | 1067         |
      | beaufortScale     | 2            |
      | aqi               | 53           |
      | aqiAvg            | 53           |
      | heatIndex         | 7.3          |

  @database
  Scenario: Show summary weather data
    Given I load the fixture "weatherData"
    When I request the url "/api/weatherData/AAA/currentData/summary" with http verb "GET"
    Then the status code should be 200
    And the response should have the following content
    """
     {
       "id":6,
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
          "updatedAt":"2020-12-11T00:12:12+01:00",
          "reference":"AAA"
       },
       "unit":{
          "id":1,
          "temperatureUnit":"\u00b0C",
          "speedUnit":"m\/s",
          "rainUnit":"mm",
          "solarRadiationUnit":"lux",
          "pmUnit":"um\/m",
          "pressureUnit":"hPa",
          "humidityUnit":"%",
          "type":"Metric",
          "createdAt":"2020-12-10T00:12:12+01:00",
          "updatedAt":"2020-12-10T00:12:12+01:00",
          "cloudBaseUnit":"m",
          "windDirUnit":"\u00b0"
       },
       "temperature":8.7,
       "relativePressure":1026.6,
       "windSpeedAvg":10.7,
       "windDirectionAvg":19,
       "humidity":56,
       "receivedAt":"2022-01-01T00:13:12+01:00"
    }
    """

  @database
  Scenario: Show detail weather data
    Given I load the fixture "weatherData"
    When I request the url "/api/weatherData/AAA/currentData/detail" with http verb "GET"
    Then the status code should be 200
    And the response should have the following content
    """
    {
       "id":6,
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
          "updatedAt":"2020-12-11T00:12:12+01:00",
          "reference":"AAA"
       },
       "unit":{
          "id":1,
          "temperatureUnit":"\u00b0C",
          "speedUnit":"m\/s",
          "rainUnit":"mm",
          "solarRadiationUnit":"lux",
          "pmUnit":"um\/m",
          "humidityUnit":"%",
          "pressureUnit":"hPa",
          "type":"Metric",
          "createdAt":"2020-12-10T00:12:12+01:00",
          "updatedAt":"2020-12-10T00:12:12+01:00",
          "cloudBaseUnit":"m",
          "windDirUnit":"\u00b0"
       },
       "temperature":8.7,
       "temperatureVariation":null,
       "humidity":56,
       "relativePressure":1026.6,
       "relativePressureVariation":null,
       "absolutePressure":1013.6,
       "windDirection":19,
       "windDirectionAvg":19,
       "windSpeed":3,
       "windSpeedAvg":10.7,
       "windGust":22,
       "windMaxDailyGust":35,
       "rainRate":3,
       "rainEvent":5,
       "rainHourly":6,
       "rainDaily":1,
       "rainWeekly":6.1,
       "rainMonthly":11,
       "rainYearly":176,
       "solarRadiation":412,
       "solarRadiationVariation":null,
       "uv":5,
       "pm25":6,
       "pm25Avg":13,
       "humidex":9.9,
       "humidexVariation":null,
       "dewPoint":1.3,
       "windChill":8.4,
       "cloudBase":1024,
       "beaufortScale":3,
       "aqi":54,
       "aqiAvg":54,
       "heatIndex":8.3,
       "receivedAt":"2022-01-01T00:13:12+01:00"
    }
    """

  @database
  Scenario: Show history weather data
    Given I load the fixture "weatherData"
    When I request the url "/api/weatherData/AAA/history/yearly" with http verb "GET"
    Then the status code should be 200
    And the response should have the following content
    """
    {
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
          "updatedAt":"2020-12-11T00:12:12+01:00",
          "reference":"AAA"
       },
       "unit":{
          "id":1,
          "temperatureUnit":"\u00b0C",
          "speedUnit":"m\/s",
          "rainUnit":"mm",
          "solarRadiationUnit":"lux",
          "pmUnit":"um\/m",
          "humidityUnit":"%",
          "type":"Metric",
          "createdAt":"2020-12-10T00:12:12+01:00",
          "updatedAt":"2020-12-10T00:12:12+01:00",
          "cloudBaseUnit":"m",
          "windDirUnit":"\u00b0",
          "pressureUnit":"hPa"
       },
       "maxTemperature":8.7,
       "maxTemperatureReceivedAt":"2022-01-01T00:13:12+01:00",
       "minTemperature":8.6,
       "minTemperatureReceivedAt":"2022-01-01T00:12:12+01:00",
       "maxHumidex":9.9,
       "maxHumidexReceivedAt":"2022-01-01T00:13:12+01:00",
       "minHumidex":8.9,
       "minHumidexReceivedAt":"2022-01-01T00:12:12+01:00",
       "maxDewPoint":1.3,
       "maxDewPointReceivedAt":"2022-01-01T00:13:12+01:00",
       "minDewPoint":0.3,
       "minDewPointReceivedAt":"2022-01-01T00:12:12+01:00",
       "maxWindChill":8.4,
       "maxWindChillReceivedAt":"2022-01-01T00:13:12+01:00",
       "minWindChill":7.4,
       "minWindChillReceivedAt":"2022-01-01T00:12:12+01:00",
       "maxHumidity":56,
       "maxHumidityReceivedAt":"2022-01-01T00:13:12+01:00",
       "minHumidity":55,
       "minHumidityReceivedAt":"2022-01-01T00:12:12+01:00",
       "maxRelativePressure":1026.6,
       "maxRelativePressureReceivedAt":"2022-01-01T00:13:12+01:00",
       "minRelativePressure":1025.6,
       "minRelativePressureReceivedAt":"2022-01-01T00:12:12+01:00",
       "maxRainRate":3,
       "maxRainRateReceivedAt":"2022-01-01T00:13:12+01:00",
       "maxRainEvent":5,
       "maxRainEventReceivedAt":"2022-01-01T00:13:12+01:00",
       "rainPeriod":176,
       "maxWindGust":22,
       "maxWindGustReceivedAt":"2022-01-01T00:13:12+01:00",
       "maxBeaufortScale":3,
       "maxBeaufortScaleReceivedAt":"2022-01-01T00:13:12+01:00",
       "avgWindSpeed":10.2,
       "avgPm25":13,
       "avgAqi":54,
       "maxPm25":6,
       "maxPm25ReceivedAt":"2022-01-01T00:13:12+01:00",
       "maxAqi":54,
       "maxAqiReceivedAt":"2022-01-01T00:13:12+01:00",
       "maxSolarRadiation":412,
       "maxSolarRadiationReceivedAt":"2022-01-01T00:12:12+01:00",
       "maxUv":5,
       "maxUvReceivedAt":"2022-01-01T00:13:12+01:00",
       "minPm25":5,
       "minPm25ReceivedAt":"2022-01-01T00:12:12+01:00",
       "minAqi":53,
       "minAqiReceivedAt":"2022-01-01T00:12:12+01:00",
       "minCloudBase":1024,
       "minCloudBaseReceivedAt":"2022-01-01T00:12:12+01:00",
       "maxCloudBase":1024,
       "maxCloudBaseReceivedAt":"2022-01-01T00:12:12+01:00",
       "maxHeatIndex":8.3,
       "maxHeatIndexReceivedAt":"2022-01-01T00:13:12+01:00",
       "minHeatIndex":7.3,
       "minHeatIndexReceivedAt":"2022-01-01T00:12:12+01:00"
    }
    """

  @database
  Scenario: Show history weather data with bad period
    Given I load the fixture "weatherData"
    When I request the url "/api/weatherData/AAA/history/daily" with http verb "GET"
    Then the status code should be 400
    And the response should have the following content
    """
     [{
         "type":"NoWeatherDataReportFoundException",
         "message":"Aucune données météo disponible actuellement :("
      }]
    """

  @database
  Scenario: Show graph weather data
    Given I load the fixture "weatherData"
    When I request the url "/api/weatherData/CCC/graph/daily" with http verb "GET"
    Then the status code should be 200
    Then the response should contains "4" number of result