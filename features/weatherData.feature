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
  Scenario: Register weather data n°5 without PM 2.5 sensor data
    Given I load the fixture "weatherStation"
    When I request the url "/api/weatherData" with http verb "POST" and with the payload
    """
    PASSKEY=5C909136C44BE31AB4F58FA0A5A54D68&stationtype=EasyWeatherV1.4.6&dateutc=2020-07-17+20:05:30&tempinf=75.6&humidityin=52&baromrelin=30.142&baromabsin=29.667&tempf=70.3&humidity=61&winddir=211&winddir_avg10m=211&windspeedmph=0.0&windspdmph_avg10m=0.0&windgustmph=0.0&maxdailygust=2.2&rainratein=0.000&eventrainin=0.000&hourlyrainin=0.000&dailyrainin=0.063&weeklyrainin=0.063&monthlyrainin=0.063&yearlyrainin=0.063&solarradiation=0.00&uv=0&wh65batt=0&wh25batt=0&pm25batt1=5&freq=868M&model=HP1000SE-PRO_Pro_V1.6.0
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
      | humidex           | 24.4         |
      | dewPoint          | 13.5         |
      | windChill         | 21.3         |
      | cloudBase         | 970          |
      | beaufortScale     | 0            |
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
  Scenario: Register weather data n°4
    Given I load the fixture "weatherStation"
    When I request the url "/api/weatherData" with http verb "POST" and with the payload
    """
    PASSKEY=5C909136C44BE31AB4F58FA0A5A54D68&stationtype=EasyWeatherV1.4.6&dateutc=2020-07-17+20:05:30&tempinf=69.8&humidityin=41&baromrelin=30.36&baromabsin=29.93&tempf=48.0&humidity=55&winddir=18&winddir_avg10m=18&windspeedmph=6.0&windspdmph_avg10m=6.0&windgustmph=13.6&maxdailygust=20.6&rainratein=0.000&eventrainin=0.00&hourlyrainin=0.00&dailyrainin=0.00&weeklyrainin=0.24&monthlyrainin=0.89&yearlyrainin=6.93&solarradiation=468.1&uv=4&pm25_ch1=13.0&pm25_avg_24h_ch1=13.0&wh65batt=0&wh25batt=0&pm25batt1=5&tf_ch1=56.5&leafwetness_ch1=0&tf_batt1=1.72&leaf_batt1=1.72&freq=868M&model=HP1000SE-PRO_Pro_V1.6.0
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
      | soilTemperature   | 13.6         |
      | leafWetness       | 0            |

  @database
  Scenario: Show summary weather data
    Given I load the fixture "weatherData"
    When I request the url "/api/weatherData/AAA/currentData/summary" with http verb "GET"
    Then the status code should be 400
    And the response should have the following content
    """
     [
        {
            "type":"NoWeatherDataFoundException",
            "message":"Aucune données météo disponible actuellement :("
        }
    ]
    """

  @database
  Scenario: Show detail weather data
    Given I load the fixture "weatherData"
    When I request the url "/api/weatherData/AAA/currentData/detail" with http verb "GET"
    Then the status code should be 400
    And the response should have the following content
    """
    [
        {
            "type":"NoWeatherDataFoundException",
            "message":"Aucune données météo disponible actuellement :("
        }
    ]
    """

  @database
  Scenario: Show history weather data
    Given I load the fixture "weatherData"
    When I request the url "/api/weatherData/EEE/history/yearly" with http verb "GET"
    Then the status code should be 200

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