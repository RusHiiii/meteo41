import React, { Fragment, useEffect, useReducer, useState } from 'react';
import { Date as DateComponent } from '../../../common/components/Date';
import { degToCompass } from '../../weatherData/utils/degreesToCompass';
import { getSunrise, getSunset } from 'sunrise-sunset-js';
import { getMoonTimes } from 'suncalc';
import ReactTooltip from 'react-tooltip';
import Tooltip from './Tooltip';
import { showFixedValue } from '../utils/showFixedValue';

export default function Observation(props) {
  const { weatherData, weatherDataDaily } = props;

  return (
    <div className="forecast-home col-md-7 col-xs-12">
      <div className="forecast-table">
        <div className="forecast-container">
          <div className="today forecast">
            <div className="forecast-header">
              <div className="day">
                Observations à{' '}
                <DateComponent date={weatherData?.receivedAt} format={'LT'} />,
                le{' '}
                <DateComponent date={weatherData?.receivedAt} format={'LL'} />
              </div>
            </div>
            {weatherData && (
              <div className="forecast-content obs-content">
                <div className="text-center home-temp">
                  <div className="temp">
                    <div className="current-temp">
                      <h3 data-tip data-for="temperature">
                        {showFixedValue(weatherData?.temperature)}
                        <small className="celsius">
                          {weatherData?.unit.temperatureUnit}
                        </small>
                      </h3>
                      {weatherDataDaily && (
                        <Tooltip
                          id="temperature"
                          min={showFixedValue(weatherDataDaily.minTemperature)}
                          max={showFixedValue(weatherDataDaily.maxTemperature)}
                          minReceivedAt={
                            weatherDataDaily.minTemperatureReceivedAt
                          }
                          maxReceivedAt={
                            weatherDataDaily.maxTemperatureReceivedAt
                          }
                          unit={weatherDataDaily.unit.temperatureUnit}
                        />
                      )}
                      <div className="windchill">
                        Windchill
                        <strong
                          className="windchill-value"
                          data-tip
                          data-for="windChill"
                        >
                          {showFixedValue(weatherData?.windChill)}
                          {weatherData?.unit.temperatureUnit}
                        </strong>
                      </div>
                      {weatherDataDaily && (
                        <Tooltip
                          id="windChill"
                          min={showFixedValue(weatherDataDaily.minWindChill)}
                          max={showFixedValue(weatherDataDaily.maxWindChill)}
                          minReceivedAt={
                            weatherDataDaily.minWindChillReceivedAt
                          }
                          maxReceivedAt={
                            weatherDataDaily.maxWindChillReceivedAt
                          }
                          unit={weatherDataDaily.unit.temperatureUnit}
                        />
                      )}
                      <div>
                        Point de rosée
                        <strong
                          className="dewpoint-value"
                          data-tip
                          data-for="dewpoint"
                        >
                          {showFixedValue(weatherData?.dewPoint)}
                          {weatherData?.unit.temperatureUnit}
                        </strong>
                      </div>
                      {weatherDataDaily && (
                        <Tooltip
                          id="dewpoint"
                          min={showFixedValue(weatherDataDaily.minDewPoint)}
                          max={showFixedValue(weatherDataDaily.maxDewPoint)}
                          minReceivedAt={weatherDataDaily.minDewPointReceivedAt}
                          maxReceivedAt={weatherDataDaily.maxDewPointReceivedAt}
                          unit={weatherDataDaily.unit.temperatureUnit}
                        />
                      )}
                      <div>
                        Humidex
                        <strong
                          className="humidex-value"
                          data-tip
                          data-for="humidex"
                        >
                          {showFixedValue(weatherData?.humidex)}
                          {weatherData?.unit.temperatureUnit}
                        </strong>
                      </div>
                      {weatherDataDaily && (
                        <Tooltip
                          id="humidex"
                          min={showFixedValue(weatherDataDaily.minHumidex)}
                          max={showFixedValue(weatherDataDaily.maxHumidex)}
                          minReceivedAt={weatherDataDaily.minHumidexReceivedAt}
                          maxReceivedAt={weatherDataDaily.maxHumidexReceivedAt}
                          unit={weatherDataDaily.unit.temperatureUnit}
                        />
                      )}
                      <div>
                        Heat Index
                        <strong
                          className="heatindex-value"
                          data-tip
                          data-for="heatindex"
                        >
                          {showFixedValue(weatherData?.heatIndex)}
                          {weatherData?.unit.temperatureUnit}
                        </strong>
                      </div>
                      {weatherDataDaily && (
                        <Tooltip
                          id="heatindex"
                          min={showFixedValue(weatherDataDaily.minHeatIndex)}
                          max={showFixedValue(weatherDataDaily.maxHeatIndex)}
                          minReceivedAt={
                            weatherDataDaily.minHeatIndexReceivedAt
                          }
                          maxReceivedAt={
                            weatherDataDaily.maxHeatIndexReceivedAt
                          }
                          unit={weatherDataDaily.unit.temperatureUnit}
                        />
                      )}
                    </div>
                  </div>
                </div>
                <div className="text-center other-value">
                  <div>
                    <div className="container-value">
                      <table className="table-obs-home">
                        <tbody>
                          <tr className="tr-home">
                            <td>
                              <span className="wind-span">
                                <i
                                  className={`wi wi-wind towards-${weatherData?.windDirection}-deg`}
                                  title={degToCompass(
                                    weatherData?.windDirection
                                  )}
                                ></i>
                              </span>
                            </td>
                            <td className="td-value-obs">
                              <strong className="wind-value">
                                {weatherData?.windSpeed}
                              </strong>
                            </td>
                            <td>
                              <small className="wind-unit">
                                {weatherData?.unit.speedUnit}
                              </small>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span>
                                <i
                                  className="fa fa-tachometer"
                                  title="Pression"
                                ></i>
                              </span>
                            </td>
                            <td
                              className="td-value-obs"
                              data-tip
                              data-for="pressure"
                            >
                              <strong>
                                {showFixedValue(weatherData?.relativePressure)}
                              </strong>
                              {weatherDataDaily && (
                                <Tooltip
                                  id="pressure"
                                  min={showFixedValue(
                                    weatherDataDaily.minRelativePressure
                                  )}
                                  max={showFixedValue(
                                    weatherDataDaily.maxRelativePressure
                                  )}
                                  minReceivedAt={
                                    weatherDataDaily.minRelativePressureReceivedAt
                                  }
                                  maxReceivedAt={
                                    weatherDataDaily.maxRelativePressureReceivedAt
                                  }
                                  unit={weatherDataDaily.unit.pressureUnit}
                                />
                              )}
                            </td>
                            <td>
                              <small>{weatherData?.unit.pressureUnit}</small>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span>
                                <i
                                  className="wi wi-humidity"
                                  title="Humidité"
                                ></i>
                              </span>
                            </td>
                            <td
                              className="td-value-obs"
                              data-tip
                              data-for="humidity"
                            >
                              <strong>{weatherData?.humidity}</strong>
                              {weatherDataDaily && (
                                <Tooltip
                                  id="humidity"
                                  min={weatherDataDaily.minHumidity}
                                  max={weatherDataDaily.maxHumidity}
                                  minReceivedAt={
                                    weatherDataDaily.minHumidityReceivedAt
                                  }
                                  maxReceivedAt={
                                    weatherDataDaily.maxHumidityReceivedAt
                                  }
                                  unit={weatherDataDaily.unit.humidityUnit}
                                />
                              )}
                            </td>
                            <td>
                              <small>{weatherData?.unit.humidityUnit}</small>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span>
                                <i
                                  className="wi wi-dust"
                                  title="Particules fines"
                                ></i>
                              </span>
                            </td>
                            <td
                              className="td-value-obs"
                              data-tip
                              data-for="pm25"
                            >
                              <strong>{weatherData?.pm25}</strong>
                              {weatherDataDaily && (
                                <Tooltip
                                  id="pm25"
                                  min={weatherDataDaily.minPm25}
                                  max={weatherDataDaily.maxPm25}
                                  minReceivedAt={
                                    weatherDataDaily.maxPm25ReceivedAt
                                  }
                                  maxReceivedAt={
                                    weatherDataDaily.minPm25ReceivedAt
                                  }
                                  unit={weatherDataDaily.unit.pmUnit}
                                />
                              )}
                            </td>
                            <td>
                              <small>{weatherData?.unit.pmUnit}</small>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span>
                                <i
                                  className="fa fa-cloud"
                                  title="Base des nuages"
                                ></i>
                              </span>
                            </td>
                            <td
                              className="td-value-obs"
                              data-tip
                              data-for="cloud"
                            >
                              <strong>{weatherData?.cloudBase}</strong>
                              {weatherDataDaily && (
                                <Tooltip
                                  id="cloud"
                                  min={weatherDataDaily.minCloudBase}
                                  max={weatherDataDaily.maxCloudBase}
                                  minReceivedAt={
                                    weatherDataDaily.minCloudBaseReceivedAt
                                  }
                                  maxReceivedAt={
                                    weatherDataDaily.maxCloudBaseReceivedAt
                                  }
                                  unit={weatherDataDaily.unit.cloudBaseUnit}
                                />
                              )}
                            </td>
                            <td>
                              <small>{weatherData?.unit.cloudBaseUnit}</small>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div className="text-center ephemeride">
                  <div className="sun-moon">
                    <table>
                      <tbody>
                        <tr>
                          <td className="ephemeride-logo-moon" rowSpan="2">
                            <i className="wi wi-moon-alt-waxing-crescent-5"></i>
                          </td>
                          <td>
                            <span>
                              <i className="wi wi-moonset"></i>
                            </span>
                            &nbsp;{' '}
                            <DateComponent
                              date={
                                getMoonTimes(
                                  new Date(),
                                  weatherData?.weatherStation.lat,
                                  weatherData?.weatherStation.lng,
                                  false
                                ).rise
                              }
                              format={'LT'}
                            />
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span>
                              <i className="wi wi-moonrise"></i>
                            </span>
                            &nbsp;{' '}
                            <DateComponent
                              date={
                                getMoonTimes(
                                  new Date(),
                                  weatherData?.weatherStation.lat,
                                  weatherData?.weatherStation.lng,
                                  false
                                ).set
                              }
                              format={'LT'}
                            />
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div className="text-center ephemeride">
                  <table>
                    <tbody>
                      <tr>
                        <td className="ephemeride-logo-sun" rowSpan="2">
                          <i className="wi wi-day-sunny"></i>
                        </td>
                        <td>
                          <span>
                            <i className="wi wi-sunset"></i>
                          </span>
                          &nbsp;{' '}
                          <DateComponent
                            date={getSunrise(
                              weatherData?.weatherStation.lat,
                              weatherData?.weatherStation.lng
                            )}
                            format={'LT'}
                          />
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <span>
                            <i className="wi wi-sunrise"></i>
                          </span>
                          &nbsp;{' '}
                          <DateComponent
                            date={getSunset(
                              weatherData?.weatherStation.lat,
                              weatherData?.weatherStation.lng
                            )}
                            format={'LT'}
                          />
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            )}
            {!weatherData && (
              <p className="loading">
                Aucune données actuellement
              </p>
            )}
          </div>
        </div>
      </div>
    </div>
  );
}
