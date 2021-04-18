import React, { Fragment, useEffect, useReducer, useRef } from 'react';
import BreadCrumb from '../../../common/components/BreadCrumb';
import PageLayout from '../../../common/components/layout/PageLayout';
import HomeLayout from '../../../common/components/layout/HomeLayout';
import { RainGauge } from '../../../../../public/static/js/raingauge';
function initGauge(canvas) {
  var grain = new RainGauge(canvas, {
    units: ' mm',
    minValue: 0,
    maxValue: 50,
    majorTicks: ['0', '10', '20', '30', '40', '50'],
    highlights: [
      { from: 0, to: 10, color: '#DBEFF5' },
      { from: 10, to: 20, color: '#B6DFEB' },
      { from: 20, to: 30, color: '#92CFE1' },
      { from: 30, to: 40, color: '#6DBFD7' },
      { from: 40, to: 50, color: '#49AFCD' },
    ],
  });
  grain.draw();
  grain.setValue(35);
}
export default function Home(props) {
  const canvasRef = useRef(null);

  useEffect(() => {
    const canvas = canvasRef.current;
    initGauge(canvas);
  }, []);

  //initGauge(canvas);

  return (
    <HomeLayout home>
      <div className="hero" data-bg-image="/static/images/sologne-v1.png">
        <div className="container">
          <form action="#" className="find-location">
            <input type="text" placeholder="Rechercher..." />
            <input type="submit" value="Valider" />
          </form>
        </div>
      </div>
      <div className="forecast-table">
        <div className="container">
          <div className="forecast-container">
            <div className="today forecast">
              <div className="forecast-header">
                <div className="day">Lundi</div>
                <div className="date">6 Oct</div>
              </div>
              <div className="forecast-content">
                <div className="location">Blois</div>
                <div className="degree">
                  <div className="num">
                    23<sup>o</sup>C
                  </div>
                  <div className="forecast-icon">
                    <img
                      src="/static/images/icons/icon-1.svg"
                      alt=""
                      width="48"
                    />
                  </div>
                </div>
                <span>
                  <img src="/static/images/icon-umberella.png" alt="" />
                  20%
                </span>
                <span>
                  <img src="/static/images/icon-wind.png" alt="" />
                  18km/h
                </span>
                <span>
                  <img src="/static/images/icon-compass.png" alt="" />
                  Est
                </span>
              </div>
            </div>
            <div className="forecast">
              <div className="forecast-header">
                <div className="day day-name">Mardi</div>
              </div>
              <div className="forecast-content city">
                <div className="forecast-icon">
                  <img
                    src="/static/images/icons/icon-3.svg"
                    alt=""
                    width="48"
                  />
                </div>
                <div className="degree">
                  23<sup>o</sup>C
                </div>
                <small>
                  18<sup>o</sup>
                </small>
              </div>
            </div>
            <div className="forecast">
              <div className="forecast-header">
                <div className="day day-name">Mercredi</div>
              </div>
              <div className="forecast-content city">
                <div className="forecast-icon">
                  <img
                    src="/static/images/icons/icon-5.svg"
                    alt=""
                    width="48"
                  />
                </div>
                <div className="degree">
                  23<sup>o</sup>C
                </div>
                <small>
                  18<sup>o</sup>
                </small>
              </div>
            </div>
            <div className="forecast">
              <div className="forecast-header">
                <div className="day day-name">Jeudi</div>
              </div>
              <div className="forecast-content city">
                <div className="forecast-icon">
                  <img
                    src="/static/images/icons/icon-7.svg"
                    alt=""
                    width="48"
                  />
                </div>
                <div className="degree">
                  23<sup>o</sup>C
                </div>
                <small>
                  18<sup>o</sup>
                </small>
              </div>
            </div>
            <div className="forecast">
              <div className="forecast-header">
                <div className="day day-name">Vendredi</div>
              </div>
              <div className="forecast-content city">
                <div className="forecast-icon">
                  <img
                    src="/static/images/icons/icon-12.svg"
                    alt=""
                    width="48"
                  />
                </div>
                <div className="degree">
                  23<sup>o</sup>C
                </div>
                <small>
                  18<sup>o</sup>
                </small>
              </div>
            </div>
            <div className="forecast">
              <div className="forecast-header">
                <div className="day day-name">Samedi</div>
              </div>
              <div className="forecast-content city">
                <div className="forecast-icon">
                  <img
                    src="/staticimages/icons/icon-13.svg"
                    alt=""
                    width="48"
                  />
                </div>
                <div className="degree">
                  23<sup>o</sup>C
                </div>
                <small>
                  18<sup>o</sup>
                </small>
              </div>
            </div>
          </div>
        </div>
      </div>
      <main className="main-content current-obs">
        <div className="fullwidth-block">
          <div className="container">
            <div className="forecast-home col-md-7">
              <div className="forecast-table">
                <div className="forecast-container">
                  <div className="today forecast">
                    <div className="forecast-header">
                      <div className="day">
                        Observations à 13:00, le 11 juillet 2020
                      </div>
                    </div>
                    <div className="forecast-content obs-content">
                      <div className="text-center home-temp">
                        <div className="temp">
                          <div className="current-temp">
                            <h3>
                              23.3
                              <small className="celsius">°C</small>
                            </h3>
                            <div className="windchill">
                              Windchill{' '}
                              <strong className="windchill-value">
                                23.2°C
                              </strong>
                            </div>
                            <div>
                              Point de rosée{' '}
                              <strong className="dewpoint-value">23.3°C</strong>
                            </div>
                            <div>
                              Humidex{' '}
                              <strong className="humidex-value">23.3°C</strong>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div className="text-center other-value">
                        <div>
                          <div className="container-value">
                            <ul className="unstyled">
                              <li>
                                <span>
                                  <i className="wi wi-wind towards-23-deg"></i>
                                </span>
                                <strong className="wind-value">2</strong>
                                <small className="wind-unit">km/h</small>
                                <strong className="wind-dir">NNW</strong>
                              </li>
                              <li>
                                <span>
                                  <i className="fa fa-tachometer"></i>
                                </span>
                                <strong>
                                  <span id="bar_cur">1023</span>
                                </strong>
                                <small>hPa</small>
                              </li>
                              <li>
                                <span>
                                  <i className="wi wi-barometer"></i>
                                </span>
                                &nbsp;
                                <strong>
                                  <span id="bar_cur_a">38</span>
                                </strong>
                                <small>%</small>
                              </li>
                              <li>
                                <span>
                                  <i className="wi wi-dust"></i>
                                </span>
                                <strong>
                                  <span id="clouds">23</span>
                                </strong>
                                <small>
                                  µg/m<sup>3</sup>
                                </small>
                              </li>
                              <li>
                                <span>
                                  <i className="fa fa-cloud"></i>
                                </span>
                                <strong>
                                  <span id="clouds">2307</span>
                                </strong>
                                <small>m</small>
                              </li>
                            </ul>
                          </div>
                        </div>
                      </div>
                      <div className="text-center ephemeride">
                        <div className="sun-moon">
                          <table>
                            <tr>
                              <td className="ephemeride-logo-moon" rowSpan="2">
                                <i className="wi wi-moon-alt-waxing-crescent-5"></i>
                              </td>
                              <td>
                                <span>
                                  <i className="wi wi-moonset"></i>
                                </span>
                                &nbsp; 06h32
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <span>
                                  <i className="wi wi-moonrise"></i>
                                </span>
                                &nbsp; 21h26
                              </td>
                            </tr>
                          </table>
                        </div>
                      </div>
                      <div className="text-center ephemeride">
                        <table>
                          <tr>
                            <td className="ephemeride-logo-sun" rowSpan="2">
                              <i className="wi wi-day-sunny"></i>
                            </td>
                            <td>
                              <span>
                                <i className="wi wi-sunset"></i>
                              </span>
                              &nbsp; 05h32
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <span>
                                <i className="wi wi-sunrise"></i>
                              </span>
                              &nbsp; 22h26
                            </td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div className="home-map col-md-5">
              <div className="contact-details">
                <div
                  className="map"
                  data-latitude="47.610"
                  data-longitude="1.272"
                ></div>
              </div>
            </div>
          </div>
        </div>

        <div className="fullwidth-block">
          <div className="container">
            <h2 className="section-title">Capteurs secondaires</h2>
            <div className="gauge col-md-3 col-sm-6">
              <canvas id="rain" ref={canvasRef}></canvas>
              <h3>Précipitation</h3>
            </div>
            <div className="gauge col-md-3 col-sm-6">
              <canvas id="rainrate"></canvas>
              <h3>Averse</h3>
            </div>
            <div className="gauge col-md-3 col-sm-6">
              <canvas id="wspd"></canvas>
              <h3>Vent (moy/10 min)</h3>
            </div>
            <div className="gauge col-md-3 col-sm-6">
              <canvas id="wdir"></canvas>
              <h3>Direction (moy/10 min)</h3>
            </div>
          </div>
        </div>

        <div className="fullwidth-block other-sensor">
          <div className="container">
            <h2 className="section-title">Autres capteurs</h2>
            <div className="gauge col-md-3 col-sm-6">
              <canvas id="uvi"></canvas>
              <h3>UV</h3>
            </div>
            <div className="gauge col-md-3 col-sm-6">
              <canvas id="sol"></canvas>
              <h3>Radiation solaire</h3>
            </div>
            <div className="gauge col-md-3 col-sm-6">
              <canvas id="iqa"></canvas>
              <h3>Qualité de l'air</h3>
            </div>
          </div>
        </div>
      </main>
    </HomeLayout>
  );
}
