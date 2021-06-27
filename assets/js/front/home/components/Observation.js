import React, { Fragment, useEffect, useReducer, useState } from 'react';
import { Date as DateComponent } from '../../../common/components/Date';
import { degToCompass } from '../../weatherData/utils/degreesToCompass';
import { getSunrise, getSunset } from 'sunrise-sunset-js';
import { getMoonTimes } from 'suncalc';

export default function Observation(props) {
  const { weatherData } = props;

  return (
    <div className="forecast-home col-md-7">
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
                      <h3>
                        {weatherData?.temperature}
                        <small className="celsius">
                          {weatherData?.unit.temperatureUnit}
                        </small>
                      </h3>
                      <div className="windchill">
                        Windchill
                        <strong className="windchill-value">
                          {weatherData?.windChill}
                          {weatherData?.unit.temperatureUnit}
                        </strong>
                      </div>
                      <div>
                        Point de rosée
                        <strong className="dewpoint-value">
                          {weatherData?.dewPoint}
                          {weatherData?.unit.temperatureUnit}
                        </strong>
                      </div>
                      <div>
                        Humidex
                        <strong className="humidex-value">
                          {weatherData?.humidex}
                          {weatherData?.unit.temperatureUnit}
                        </strong>
                      </div>
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
                              <span>
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
                            <td className="td-value-obs">
                              <strong>{weatherData?.relativePressure}</strong>
                            </td>
                            <td>
                              <small>{weatherData?.unit.pressureUnit}</small>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span>
                                <i
                                  className="wi wi-barometer"
                                  title="Humidité"
                                ></i>
                              </span>
                            </td>
                            <td className="td-value-obs">
                              <strong>{weatherData?.humidity}</strong>
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
                            <td className="td-value-obs">
                              <strong>{weatherData?.pm25}</strong>
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
                            <td className="td-value-obs">
                              <strong>{weatherData?.cloudBase}</strong>
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
                                  true
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
                                  true
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
            {!weatherData && <p className="loading" />}
          </div>
        </div>
      </div>
    </div>
  );
}
