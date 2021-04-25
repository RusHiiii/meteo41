import React, { Fragment, useEffect, useReducer } from 'react';
import { apiClient } from '../../utils/apiClient';
import { DEFAULT_WEATHER_STATION_REFERENCE } from '../../constant';
import { Date } from '../Date';

const WEATHER_DATA_LOAD = 'WEATHER_DATA_LOAD';

const reducer = (state, action) => {
  switch (action.type) {
    case WEATHER_DATA_LOAD:
      return {
        ...state,
        weatherData: action.weatherData,
        loading: false,
        loaded: true,
      };
  }

  return state;
};

function loadWeatherData(dispatch) {
  apiClient()
    .request(
      new Request(
        `/api/weatherData/${DEFAULT_WEATHER_STATION_REFERENCE}/currentData/summary`
      )
    )
    .then((response) => response.json())
    .then((data) => {
      dispatch({
        type: WEATHER_DATA_LOAD,
        weatherData: data,
      });
    });
}

function useSummaryWeatherData() {
  const initialState = {
    weatherData: null,
    loading: false,
    loaded: false,
  };

  const [state, dispatch] = useReducer(reducer, initialState);

  useEffect(() => {
    loadWeatherData(dispatch);

    const intervalId = setInterval(() => {
      loadWeatherData(dispatch);
    }, 60000);

    return () => clearInterval(intervalId);
  }, []);

  return [state, dispatch];
}

export default function SummaryWeatherData(props) {
  const [state, dispatch] = useSummaryWeatherData();

  return (
    <div className="sidebar col-md-3 col-md-offset-1">
      <div className="widget current-weather-data">
        <h3 className="widget-title">Données actuelle</h3>
        <ul>
          <li>
            <h3 className="entry-title">Température</h3>
            <div className="current">
              <span>
                <i className="wi wi-thermometer-exterior" />
              </span>
              <strong>{state.weatherData?.temperature}</strong>
              {state.weatherData?.unit.temperatureUnit}
            </div>
          </li>
          <li>
            <h3 className="entry-title">Pression atmosphérique</h3>
            <div className="current">
              <span>
                <i className="fa fa-tachometer" />
              </span>
              <strong>{state.weatherData?.relativePressure}</strong>
              {state.weatherData?.unit.pressureUnit}
            </div>
          </li>
          <li>
            <h3 className="entry-title">Vent moyen</h3>
            <div className="current">
              <span>
                <i className="wi wi-wind towards-121-deg" />
              </span>
              <strong>{state.weatherData?.windSpeedAvg}</strong>
              {state.weatherData?.unit.speedUnit}
            </div>
          </li>
          <li>
            <h3 className="entry-title">Humidité</h3>
            <div className="current">
              <span>
                <i className="wi wi-barometer" />
              </span>
              <strong>{state.weatherData?.humidity}</strong>
              {state.weatherData?.unit.humidityUnit}
            </div>
          </li>
          <li className="text-align-right">
            Mise à jour à{' '}
            <Date date={state.weatherData?.receivedAt} format="LT" />
          </li>
        </ul>
      </div>
    </div>
  );
}
