import React, { Fragment, useEffect, useReducer } from 'react';
import BreadCrumb from '../../../common/components/BreadCrumb';
import SummaryWeatherData from '../../../common/components/weather/SummaryWeatherData';
import WeatherDataAccess from '../components/WeatherDataAccess';
import { useSelector } from 'react-redux';
import { apiClient } from '../../../common/utils/apiClient';
import CurrentWeatherDataTable from '../components/CurrentWeatherDataTable';

const WEATHER_DATA_LOAD = 'WEATHER_DATA_LOAD';
const OBSERVATION_DATA_LOAD = 'OBSERVATION_DATA_LOAD';
const WEATHER_DATA_ERRORS = 'WEATHER_DATA_ERRORS';

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
    case WEATHER_DATA_ERRORS:
      return {
        ...state,
        errors: action.errors,
        loading: false,
        loaded: false,
      };
    case OBSERVATION_DATA_LOAD:
      return {
        ...state,
        observation: action.observation,
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

function loadObservation(weatherStation, dispatch) {
  apiClient()
    .request(new Request(`/api/weatherStation/observation/last/${weatherStation.reference}`))
    .then((response) => {
      if (response.ok) {
        return response.json();
      }
    })
    .then((data) => {
      dispatch({
        type: OBSERVATION_DATA_LOAD,
        observation: data,
      });
    });
}

function useCurrentWeatherData(weatherStation) {
  const initialState = {
    weatherData: null,
    observation: null,
    errors: [],
    loading: false,
    loaded: false,
  };

  const [state, dispatch] = useReducer(reducer, initialState);

  useEffect(() => {
    loadWeatherData(weatherStation, dispatch);
    loadObservation(weatherStation, dispatch);

    const intervalId = setInterval(() => {
      loadWeatherData(weatherStation, dispatch);
    }, 60000);

    return () => clearInterval(intervalId);
  }, [weatherStation.reference]);

  return [state, dispatch];
}

export default function CurrentWeatherData(props) {
  const weatherStation = useSelector((state) => state.weatherStation);
  const [state, dispatch] = useCurrentWeatherData(weatherStation);

  return (
    <Fragment>
      <BreadCrumb
        url="/weather/current"
        page="Données"
        text="Données courante"
      />

      <div className="fullwidth-block no-padding-top">
        <div className="container">
          <div className="row">
            <div className="fullwidth-block padding-content">
              <div className="content col-md-8">
                <div className="post single">
                  <h2 className="entry-title">
                    Données de la station en temps réel
                  </h2>
                  <div className="featured-image">
                    <img
                      src={'/static/images/chenonceau.png'}
                      alt="Chenonceau"
                    />
                  </div>

                  <div className="entry-content min-height-entry">
                    {state.errors.map((error, index) => (
                      <div key={index} className="primary-alert">
                        {error.message}
                      </div>
                    ))}

                    {state.loaded && (
                      <Fragment>
                        <p>
                          {state.weatherData.weatherStation.shortDescription}
                        </p>

                        <CurrentWeatherDataTable
                          weatherData={state.weatherData}
                          observation={state.observation}
                        />
                      </Fragment>
                    )}
                  </div>
                </div>
              </div>
            </div>

            <SummaryWeatherData />

            <div className="sidebar col-md-3 col-md-offset-1">
              <WeatherDataAccess />
            </div>
          </div>
        </div>
      </div>
    </Fragment>
  );
}
