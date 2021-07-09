import React, { Fragment, useEffect, useReducer, useRef } from 'react';
import Map from '../../../common/components/Map';
import Forecast from '../components/Forecast';
import ForecastSearchForm from '../components/ForecastSearchForm';
import Observation from '../components/Observation';
import { useSelector } from 'react-redux';
import { apiClient } from '../../../common/utils/apiClient';
import ReactTooltip from 'react-tooltip';
import RainRate from '../components/gauge/RainRate';
import WindSpeed from '../components/gauge/WindSpeed';
import queryString from 'qs';
import WindDirection from '../components/gauge/WindDirection';
import Uv from '../components/gauge/Uv';
import SolarRadiation from '../components/gauge/SolarRadiation';
import Aqi from '../components/gauge/Aqi';
import {
  DEFAULT_CITY_LAT,
  DEFAULT_CITY_LNG,
  DEFAULT_CITY_TEXT,
} from '../../../common/constant';
import RainDaily from '../components/gauge/RainDaily';
import RainMonthly from '../components/gauge/RainMonthly';
import WindGust from '../components/gauge/WindGust';
import WindMaxGust from '../components/gauge/WindMaxGust';
import RainYearly from '../components/gauge/RainYearly';

const WEATHER_DATA_LOAD = 'WEATHER_DATA_LOAD';
const WEATHER_DATA_PERIOD_LOAD = 'WEATHER_DATA_PERIOD_LOAD';
const WEATHER_DATA_PERIOD_ERRORS = 'WEATHER_DATA_PERIOD_ERRORS';
const WEATHER_DATA_ERRORS = 'WEATHER_DATA_ERRORS';
const GEOCODING_LOAD = 'GEOCODING_LOAD';
const GEOCODING_ERRORS = 'GEOCODING_ERRORS';

const reducer = (state, action) => {
  switch (action.type) {
    case WEATHER_DATA_LOAD:
      return {
        ...state,
        weatherData: action.weatherData,
        errors: [],
        loading: false,
        loaded: true,
      };
    case WEATHER_DATA_PERIOD_LOAD:
      return {
        ...state,
        weatherDataDaily: action.weatherData,
        errorsDaily: [],
        loading: false,
        loaded: true,
      };
    case WEATHER_DATA_ERRORS:
      return {
        ...state,
        errors: action.errors,
        loading: false,
        loaded: false,
      };
    case WEATHER_DATA_PERIOD_ERRORS:
      return {
        ...state,
        errorsDaily: action.errors,
        loading: false,
        loaded: false,
      };
    case GEOCODING_LOAD:
      return {
        ...state,
        forecast: {
          ...state.forecast,
          geocoding: {
            lat: action.geocoding.results[0]?.geometry.location.lat || null,
            lng: action.geocoding.results[0]?.geometry.location.lng || null,
            status: action.geocoding.status,
          },
          errors: [],
          city:
            action.geocoding.results[0]?.formatted_address ||
            state.forecast.city,
        },
      };
    case GEOCODING_ERRORS:
      return {
        ...state,
        forecast: {
          ...state.forecast,
          errors: action.errors,
        },
      };
  }

  return state;
};

function loadWeatherData(weatherStation, dispatch) {
  apiClient()
    .request(
      new Request(
        `/api/weatherData/${weatherStation.reference}/currentData/detail`
      )
    )
    .then((response) => {
      if (response.ok) {
        return response.json();
      }

      return response.json().then((errors) => {
        throw errors;
      });
    })
    .then((data) => {
      dispatch({
        type: WEATHER_DATA_LOAD,
        weatherData: data,
      });
    })
    .catch((errors) => {
      dispatch({
        type: WEATHER_DATA_ERRORS,
        errors: errors,
      });
    });
}

function loadWeatherDataDaily(weatherStation, dispatch) {
  apiClient()
    .request(
      new Request(`/api/weatherData/${weatherStation.reference}/history/daily`)
    )
    .then((response) => {
      if (response.ok) {
        return response.json();
      }

      return response.json().then((errors) => {
        throw errors;
      });
    })
    .then((data) => {
      dispatch({
        type: WEATHER_DATA_PERIOD_LOAD,
        weatherData: data,
      });
    })
    .catch((errors) => {
      dispatch({
        type: WEATHER_DATA_PERIOD_ERRORS,
        errors: errors,
      });
    });
}

function loadForecastAddress(text, dispatch) {
  apiClient()
    .request(
      new Request(
        `/api/geocoding?${queryString.stringify({
          address: text,
        })}`
      )
    )
    .then((response) => {
      if (response.ok) {
        return response.json();
      }

      return response.json().then((errors) => {
        throw errors;
      });
    })
    .then((data) => {
      dispatch({
        type: GEOCODING_LOAD,
        geocoding: data,
      });
    })
    .catch((errors) => {
      dispatch({
        type: GEOCODING_ERRORS,
        errors: errors,
      });
    });
}

function useHome(weatherStation) {
  const initialState = {
    weatherData: null,
    weatherDataDaily: null,
    errors: [],
    errorsDaily: [],
    forecast: {
      city: DEFAULT_CITY_TEXT,
      geocoding: {
        lat: DEFAULT_CITY_LAT,
        lng: DEFAULT_CITY_LNG,
        status: 'OK',
      },
      errors: [],
      weather: null,
    },
    loading: false,
    loaded: false,
  };

  const [state, dispatch] = useReducer(reducer, initialState);

  useEffect(() => {
    loadWeatherData(weatherStation, dispatch);
    loadWeatherDataDaily(weatherStation, dispatch);

    const intervalId = setInterval(() => {
      loadWeatherData(weatherStation, dispatch);
      loadWeatherDataDaily(weatherStation, dispatch);
    }, 60000);

    return () => clearInterval(intervalId);
  }, [weatherStation.reference]);

  return [state, dispatch];
}

export default function Home(props) {
  const weatherStation = useSelector((state) => state.weatherStation);
  const [state, dispatch] = useHome(weatherStation);

  return (
    <Fragment>
      <main className="main-content">
        <div className="hero" data-bg-image="/static/images/sologne-v1.png">
          <div className="container">
            <ForecastSearchForm
              initialValues={{ text: DEFAULT_CITY_TEXT }}
              onSubmit={(data) => loadForecastAddress(data.text, dispatch)}
            />
            {state.forecast.errors.map((error, index) => (
              <div key={index} className="error-alert margin-top-10">
                {error.message}
              </div>
            ))}
            {state.forecast.geocoding.status !== 'OK' && (
              <p className="primary-alert margin-top-10">Aucun résultat :(</p>
            )}
          </div>
        </div>
        <div className="forecast-table">
          <div className="container">
            <Forecast forecast={state.forecast} />
          </div>
        </div>
        <main className="main-content current-obs">
          <div className="fullwidth-block">
            <div className="container">
              <Observation
                weatherData={state.weatherData}
                weatherDataDaily={state.weatherDataDaily}
              />
              <div className="home-map col-md-5 col-xs-12">
                <div className="contact-details">
                  <Map
                    lat={state.weatherData?.weatherStation?.lat}
                    lng={state.weatherData?.weatherStation?.lng}
                  />
                </div>
              </div>
            </div>
          </div>

          <div className="fullwidth-block">
            <div className="container">
              <h2 className="section-title">Précipitation</h2>
              <div className="gauge col-md-3 col-sm-6">
                <RainRate
                  value={state.weatherData?.rainRate}
                  unit={`${state.weatherData?.unit.rainUnit}/h`}
                />
                <h3>Averse</h3>
              </div>
              <div className="gauge col-md-3 col-sm-6">
                <RainDaily
                  value={state.weatherData?.rainDaily}
                  unit={state.weatherData?.unit.rainUnit}
                />
                <h3>Précipitation (jour)</h3>
              </div>
              <div className="gauge col-md-3 col-sm-6">
                <RainMonthly
                  value={state.weatherData?.rainMonthly}
                  unit={state.weatherData?.unit.rainUnit}
                />
                <h3>Précipitation (mois)</h3>
              </div>
              <div className="gauge col-md-3 col-sm-6">
                <RainYearly
                  value={state.weatherData?.rainYearly}
                  unit={state.weatherData?.unit.rainUnit}
                />
                <h3>Précipitation (année)</h3>
              </div>
            </div>
          </div>

          <div className="fullwidth-block">
            <div className="container">
              <h2 className="section-title">Vent</h2>
              <div className="gauge col-md-3 col-sm-6">
                <WindSpeed
                  value={state.weatherData?.windSpeedAvg}
                  unit={state.weatherData?.unit.speedUnit}
                />
                <h3>Vent (moy/10 min)</h3>
              </div>
              <div className="gauge col-md-3 col-sm-6">
                <WindDirection value={state.weatherData?.windDirectionAvg} />
                <h3>Direction (moy/10 min)</h3>
              </div>
              <div className="gauge col-md-3 col-sm-6">
                <WindGust
                  value={state.weatherData?.windGust}
                  unit={state.weatherData?.unit.speedUnit}
                />
                <h3>Vent (rafale)</h3>
              </div>
              <div className="gauge col-md-3 col-sm-6">
                <WindMaxGust
                  value={state.weatherData?.windMaxDailyGust}
                  unit={state.weatherData?.unit.speedUnit}
                />
                <h3>Vent (rafale max)</h3>
              </div>
            </div>
          </div>

          <div className="fullwidth-block other-sensor">
            <div className="container">
              <h2 className="section-title">Autres capteurs</h2>
              <div className="gauge col-md-3 col-sm-6">
                <Uv value={state.weatherData?.uv} />
                <h3>UV</h3>
              </div>
              <div className="gauge col-md-3 col-sm-6">
                <SolarRadiation
                  value={state.weatherData?.solarRadiation}
                  unit={state.weatherData?.unit.solarRadiationUnit}
                />
                <h3>Radiation solaire</h3>
              </div>
              <div className="gauge col-md-3 col-sm-6">
                <Aqi value={state.weatherData?.aqi} />
                <h3>Qualité de l'air</h3>
              </div>
            </div>
          </div>
        </main>
      </main>
    </Fragment>
  );
}
