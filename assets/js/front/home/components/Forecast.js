import React, { Fragment, useEffect, useReducer, useState } from 'react';
import { apiClient } from '../../../common/utils/apiClient';
import queryString from 'qs';
import { Date as DateMoment } from '../../../common/components/Date';
import { degToCompass } from '../../weatherData/utils/degreesToCompass';
import { iconIdToSvg } from '../utils/iconIdToSvg';
import { showFixedValue } from '../utils/showFixedValue';
import { showSpeedValue } from '../utils/showSpeedValue';
import { showRoundValue } from '../utils/showRoundValue';
import moment from 'moment';

const FORECAST_LOAD = 'FORECAST_LOAD';

const reducer = (state, action) => {
  switch (action.type) {
    case FORECAST_LOAD:
      return {
        ...state,
        forecast: action.forecast,
        loading: false,
        loaded: true,
      };
  }

  return state;
};

function loadForecast(lat, lng, dispatch) {
  apiClient()
    .request(
      new Request(
        `/api/openWeather?${queryString.stringify({
          lat: lat,
          lng: lng,
        })}`
      )
    )
    .then((response) => response.json())
    .then((data) => {
      dispatch({
        type: FORECAST_LOAD,
        forecast: data,
      });
    });
}

function useForecast(lat, lng) {
  const initialState = {
    forecast: null,
    loading: false,
    loaded: false,
  };

  const [state, dispatch] = useReducer(reducer, initialState);

  useEffect(() => {
    if (!lat || !lng) {
      return;
    }

    loadForecast(lat, lng, dispatch);
  }, [lat, lng]);

  return [state, dispatch];
}

export default function Forecast(props) {
  const { forecast } = props;
  const [state, dispatch] = useForecast(
    forecast.geocoding.lat,
    forecast.geocoding.lng
  );

  return (
    <div className="forecast-container">
      <div className="today forecast">
        <div className="forecast-header">
          <div className="day cap">
            <DateMoment format="dddd" date={new Date()} />
          </div>
          <div className="date">
            <DateMoment format="D MMM" date={new Date()} />
          </div>
        </div>
        <div className="forecast-content">
          <div className="location">{forecast.city}</div>
          <div className="degree">
            <div className="num">
              {showFixedValue(state.forecast?.current.temp)}
              <sup>o</sup>C
            </div>
            <div className="forecast-icon">
              <img
                src={`/static/images/icons/${iconIdToSvg(
                  state.forecast?.current.weather[0].icon
                )}`}
                title={state.forecast?.current.weather[0].description}
                alt="forecast"
                width="48"
              />
            </div>
          </div>
          <span>
            <img src="/static/images/icon-umberella.png" alt="humidity" />
            {showFixedValue(state.forecast?.current.humidity)}%
          </span>
          <span>
            <img src="/static/images/icon-wind.png" alt="speed" />
            {showSpeedValue(state.forecast?.current.wind_speed)}km/h
          </span>
          <span>
            <img src="/static/images/icon-compass.png" alt="wind" />
            {degToCompass(state.forecast?.current.wind_deg)}
          </span>
        </div>
      </div>
      {[...Array(7).keys()].slice(1, 6).map((value) => (
        <div key={value} className="forecast">
          <div className="forecast-header">
            <div className="day day-name cap">
              <DateMoment format="dddd" date={moment().add(value, 'days')} />
            </div>
          </div>
          <div className="forecast-content city">
            <div className="forecast-icon">
              <img
                src={`/static/images/icons/${iconIdToSvg(
                  state.forecast?.daily[value].weather[0].icon
                )}`}
                title={state.forecast?.daily[value].weather[0].description}
                alt="forecast"
                width="48"
              />
            </div>
            <div className="degree">
              {showRoundValue(state.forecast?.daily[value].temp.max)}
              <sup>o</sup>C
            </div>
            <small>
              {showRoundValue(state.forecast?.daily[value].temp.min)}
              <sup>o</sup>C
            </small>
          </div>
        </div>
      ))}
    </div>
  );
}
