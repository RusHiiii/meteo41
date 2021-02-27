Feature: Weather Data

  @database
  Scenario: Register weather data
    Given I load the fixture "weatherStation"
    When I request the url "/api/weatherData?PASSKEY=5C909136C44BE31AB4F58FA0A5A54D68&stationtype=EasyWeatherV1.4.6&dateutc=2020-07-17+20:05:30&tempinf=75.6&humidityin=52&baromrelin=30.142&baromabsin=29.667&tempf=70.3&humidity=61&winddir=211&winddir_avg10m=211&windspeedmph=0.0&windspdmph_avg10m=0.0&windgustmph=0.0&maxdailygust=2.2&rainratein=0.000&eventrainin=0.000&hourlyrainin=0.000&dailyrainin=0.063&weeklyrainin=0.063&monthlyrainin=0.063&yearlyrainin=0.063&solarradiation=0.00&uv=0&pm25_ch1=7.0&pm25_avg_24h_ch1=6.5&wh65batt=0&wh25batt=0&pm25batt1=5&freq=868M&model=HP1000SE-PRO_Pro_V1.6.0" with http verb "GET"
