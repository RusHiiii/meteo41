import React, { Fragment, useEffect, useReducer } from 'react';
import BreadCrumb from '../../../common/components/BreadCrumb';
import SummaryWeatherData from '../../../common/components/weather/SummaryWeatherData';
import WeatherDataAccess from '../components/WeatherDataAccess';
import { useSelector } from 'react-redux';
import { apiClient } from '../../../common/utils/apiClient';
import {
  PERIOD_DAILY,
  PERIOD_MONTHLY,
  PERIOD_RECORD,
  PERIOD_WEEKLY,
  PERIOD_YEALY,
} from '../../../common/constant';
import PeriodWeatherDataTable from '../components/PeriodWeatherDataTable';

const WEATHER_DATA_PERIOD_LOAD = 'WEATHER_DATA_PERIOD_LOAD';
const WEATHER_DATA_PERIOD_ERRORS = 'WEATHER_DATA_ERRORS';

const periodToText = (period) => {
  switch (period) {
    case PERIOD_DAILY:
      return 'Données de la journée';
    case PERIOD_WEEKLY:
      return 'Données de la semaine';
    case PERIOD_MONTHLY:
      return 'Données du mois';
    case PERIOD_YEALY:
      return "Données de l'année";
    case PERIOD_RECORD:
      return 'Record de la station';
  }
};

const reducer = (state, action) => {
  switch (action.type) {
    case WEATHER_DATA_PERIOD_LOAD:
      return {
        ...state,
        weatherData: action.weatherData,
        errors: [],
        loading: false,
        loaded: true,
      };
    case WEATHER_DATA_PERIOD_ERRORS:
      return {
        ...state,
        errors: action.errors,
        loading: false,
        loaded: false,
      };
  }

  return state;
};

function loadWeatherData(weatherStation, period, dispatch) {
  apiClient()
    .request(
      new Request(
        `/api/weatherData/${weatherStation.reference}/history/${period}`
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

function usePeriodWeatherData(weatherStation, period) {
  const initialState = {
    weatherData: null,
    errors: [],
    loading: false,
    loaded: false,
  };

  const [state, dispatch] = useReducer(reducer, initialState);

  useEffect(() => {
    loadWeatherData(weatherStation, period, dispatch);
  }, [weatherStation.reference, period]);

  return [state, dispatch];
}

export default function PeriodWeatherData(props) {
  const weatherStation = useSelector((state) => state.weatherStation);
  const [state, dispatch] = usePeriodWeatherData(
    weatherStation,
    props.match.params.period
  );

  return (
    <Fragment>
      <BreadCrumb
        url="/weather/current"
        page="Données"
        text={periodToText(props.match.params.period)}
      />

      <div className="fullwidth-block no-padding-top">
        <div className="container">
          <div className="row">
            <div className="fullwidth-block padding-content">
              <div className="content col-md-8">
                <div className="post single">
                  <h2 className="entry-title">
                    {periodToText(props.match.params.period)}
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

                        <PeriodWeatherDataTable
                          weatherData={state.weatherData}
                          period={props.match.params.period}
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
