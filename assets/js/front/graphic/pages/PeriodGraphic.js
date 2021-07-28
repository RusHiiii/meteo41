import React, { Fragment, useEffect, useReducer } from 'react';
import BreadCrumb from '../../../common/components/BreadCrumb';
import SummaryWeatherData from '../../../common/components/weather/SummaryWeatherData';
import Select from '../../../common/components/form/Select';
import {
  PERIOD_DAILY,
  PERIOD_MONTHLY,
  PERIOD_WEEKLY,
  PERIOD_YEALY,
} from '../../../common/constant';
import { apiClient } from '../../../common/utils/apiClient';
import { useSelector } from 'react-redux';
import HumidityPeriodGraphic from '../components/HumidityPeriodGraphic';
import SolarRadiationPeriodGraphic from '../components/SolarRadiationPeriodGraphic';
import UVPeriodGraphic from '../components/UVPeriodGraphic';
import PressurePeriodGraphic from '../components/PressurePeriodGraphic';
import WindDirectionPeriodGraphic from '../components/WindDirectionPeriodGraphic';
import TemperaturePeriodGraphic from '../components/TemperaturePeriodGraphic';
import RainPeriodGraphic from '../components/RainPeriodGraphic';
import PMPeriodGraphic from '../components/PMPeriodGraphic';
import WindPeriodGraphic from '../components/WindPeriodGraphic';

const choices = [
  {
    value: PERIOD_DAILY,
    text: 'Jour',
  },
  {
    value: PERIOD_WEEKLY,
    text: 'Semaine',
  },
  {
    value: PERIOD_MONTHLY,
    text: 'Mois',
  },
  {
    value: PERIOD_YEALY,
    text: 'Année',
  },
];

const WEATHER_DATA_GRAPH_LOAD = 'WEATHER_DATA_GRAPH_LOAD';
const WEATHER_DATA_HISTORY_LOAD = 'WEATHER_DATA_HISTORY_LOAD';
const WEATHER_DATA_ERRORS = 'WEATHER_DATA_ERRORS';
const WEATHER_DATA_PERIOD_CHANGE = 'WEATHER_DATA_PERIOD_CHANGE';

const periodToText = (period) => {
  switch (period) {
    case PERIOD_DAILY:
      return 'Graphique de la journée';
    case PERIOD_WEEKLY:
      return 'Graphique de la semaine';
    case PERIOD_MONTHLY:
      return 'Graphique du mois';
    case PERIOD_YEALY:
      return "Graphique de l'année";
  }
};

const formatData = (weatherData) => {
  let formatedGraphicData = {
    humidity: [],
    solarRadiation: [],
    uv: [],
    pressure: [],
    windDirection: [],
    temperature: [],
    dewpoint: [],
    windchill: [],
    rainRate: [],
    rainDaily: [],
    pm25: [],
    aqi: [],
    aqiAvg: [],
    windGust: [],
    windSpeed: [],
  };

  weatherData.datas.map((data) => {
    formatedGraphicData.humidity.push([
      new Date(data.receivedAt).getTime(),
      data.humidity,
    ]);
    formatedGraphicData.solarRadiation.push([
      new Date(data.receivedAt).getTime(),
      data.solarRadiation,
    ]);
    formatedGraphicData.uv.push([new Date(data.receivedAt).getTime(), data.uv]);
    formatedGraphicData.pressure.push([
      new Date(data.receivedAt).getTime(),
      data.relativePressure,
    ]);
    formatedGraphicData.windDirection.push([
      new Date(data.receivedAt).getTime(),
      data.windDirection,
    ]);
    formatedGraphicData.temperature.push([
      new Date(data.receivedAt).getTime(),
      data.temperature,
    ]);
    formatedGraphicData.dewpoint.push([
      new Date(data.receivedAt).getTime(),
      data.dewPoint,
    ]);
    formatedGraphicData.windchill.push([
      new Date(data.receivedAt).getTime(),
      data.windChill,
    ]);
    formatedGraphicData.rainDaily.push([
      new Date(data.receivedAt).getTime(),
      data.rainDaily,
    ]);
    formatedGraphicData.rainRate.push([
      new Date(data.receivedAt).getTime(),
      data.rainRate,
    ]);
    formatedGraphicData.aqi.push([
      new Date(data.receivedAt).getTime(),
      data.aqi,
    ]);
    formatedGraphicData.aqiAvg.push([
      new Date(data.receivedAt).getTime(),
      data.aqiAvg,
    ]);
    formatedGraphicData.pm25.push([
      new Date(data.receivedAt).getTime(),
      data.pm25,
    ]);
    formatedGraphicData.windGust.push([
      new Date(data.receivedAt).getTime(),
      data.windGust,
    ]);
    formatedGraphicData.windSpeed.push([
      new Date(data.receivedAt).getTime(),
      data.windSpeed,
    ]);
  });

  return formatedGraphicData;
};

const reducer = (state, action) => {
  switch (action.type) {
    case WEATHER_DATA_GRAPH_LOAD:
      return {
        ...state,
        weatherGraphic: action.weatherGraphic,
        formatedGraphicData: formatData(action.weatherGraphic),
        errors: [],
        loading: false,
        loaded: true,
      };
    case WEATHER_DATA_HISTORY_LOAD:
      return {
        ...state,
        weatherHistory: action.weatherHistory,
        errors: [],
      };
    case WEATHER_DATA_ERRORS:
      return {
        ...state,
        errors: action.errors,
        loading: false,
        loaded: false,
      };
    case WEATHER_DATA_PERIOD_CHANGE:
      return {
        ...state,
        period: action.period,
        loading: true,
        loaded: false,
      };
  }

  return state;
};

function loadWeatherDataGraphic(weatherStation, period, dispatch) {
  apiClient()
    .request(
      new Request(
        `/api/weatherData/${weatherStation.reference}/graph/${period}`
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
        type: WEATHER_DATA_GRAPH_LOAD,
        weatherGraphic: data,
      });
    })
    .catch((errors) => {
      dispatch({
        type: WEATHER_DATA_ERRORS,
        errors: errors,
      });
    });
}

function loadWeatherDataHistory(weatherStation, period, dispatch) {
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
        type: WEATHER_DATA_HISTORY_LOAD,
        weatherHistory: data,
      });
    })
    .catch((errors) => {
      dispatch({
        type: WEATHER_DATA_ERRORS,
        errors: errors,
      });
    });
}

function useGraphicWeatherData(weatherStation) {
  const initialState = {
    weatherGraphic: null,
    weatherHistory: null,
    formatedGraphicData: {
      humidity: null,
      solarRadiation: null,
      uv: null,
      pressure: null,
      windDirection: null,
      temperature: null,
      dewpoint: null,
      windchill: null,
      rainRate: null,
      rainDaily: null,
      pm25: null,
      aqi: null,
      aqiAvg: null,
      windGust: null,
      windSpeed: null,
    },
    errors: [],
    period: PERIOD_DAILY,
    loading: false,
    loaded: false,
  };

  const [state, dispatch] = useReducer(reducer, initialState);

  useEffect(() => {
    loadWeatherDataHistory(weatherStation, state.period, dispatch);
    loadWeatherDataGraphic(weatherStation, state.period, dispatch);
  }, [weatherStation.reference, state.period]);

  return [state, dispatch];
}

export default function PeriodGraphic(props) {
  const weatherStation = useSelector((state) => state.weatherStation);
  const [state, dispatch] = useGraphicWeatherData(weatherStation);

  return (
    <Fragment>
      <BreadCrumb
        url="/weather/current"
        page="Graphiques"
        text={periodToText(state.period)}
      />

      <div className="fullwidth-block no-padding-top">
        <div className="container">
          <div className="row">
            <div className="fullwidth-block padding-content">
              <div className="content col-md-12">
                <div className="post single">
                  <h2 className="entry-title">{periodToText(state.period)}</h2>
                </div>
              </div>
              <div className="content col-md-8">
                <div className="post single">
                  <div className="featured-image">
                    <img
                      src={'/static/images/chenonceau.png'}
                      alt="Chenonceau"
                    />
                  </div>

                  <div className="entry-content">
                    {state.errors.map((error, index) => (
                      <div key={index} className="primary-alert">
                        {error.message}
                      </div>
                    ))}

                    <Fragment>
                      <p>
                        {state.weatherGraphic?.weatherStation.shortDescription}
                      </p>
                    </Fragment>

                    <div className="pagination">
                      <div className="filter">
                        <div className="count filter-control filter-right">
                          <label htmlFor="">Période</label>
                          <Select
                            name="roles"
                            value={state.period}
                            choices={choices}
                            onChange={(period) =>
                              dispatch({
                                type: WEATHER_DATA_PERIOD_CHANGE,
                                period: period,
                              })
                            }
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <SummaryWeatherData />
              <div className="content col-md-12">
                <TemperaturePeriodGraphic
                  dataTemp={state.formatedGraphicData.temperature}
                  dataWindchill={state.formatedGraphicData.windchill}
                  dataDewpoint={state.formatedGraphicData.dewpoint}
                  history={state.weatherHistory}
                  period={state.period}
                  unit={state.weatherGraphic?.unit.temperatureUnit}
                />
                <HumidityPeriodGraphic
                  data={state.formatedGraphicData.humidity}
                  history={state.weatherHistory}
                  period={state.period}
                  unit={state.weatherGraphic?.unit.humidityUnit}
                />
                <SolarRadiationPeriodGraphic
                  data={state.formatedGraphicData.solarRadiation}
                  history={state.weatherHistory}
                  period={state.period}
                  unit={state.weatherGraphic?.unit.solarRadiationUnit}
                />
                <UVPeriodGraphic
                  data={state.formatedGraphicData.uv}
                  history={state.weatherHistory}
                  period={state.period}
                />
                <RainPeriodGraphic
                  dataRainRate={state.formatedGraphicData.rainRate}
                  dataRainDaily={state.formatedGraphicData.rainDaily}
                  history={state.weatherHistory}
                  period={state.period}
                  unit={state.weatherGraphic?.unit.rainUnit}
                />
                <WindPeriodGraphic
                  dataWindSpeed={state.formatedGraphicData.windSpeed}
                  dataWindGust={state.formatedGraphicData.windGust}
                  history={state.weatherHistory}
                  period={state.period}
                  unit={state.weatherGraphic?.unit.speedUnit}
                />
                <WindDirectionPeriodGraphic
                  data={state.formatedGraphicData.windDirection}
                  unit={state.weatherGraphic?.unit.windDirUnit}
                  period={state.period}
                />
                <PressurePeriodGraphic
                  data={state.formatedGraphicData.pressure}
                  history={state.weatherHistory}
                  period={state.period}
                  unit={state.weatherGraphic?.unit.pressureUnit}
                />
                <PMPeriodGraphic
                  dataAqi={state.formatedGraphicData.aqi}
                  dataAqiAvg={state.formatedGraphicData.aqiAvg}
                  dataPm25={state.formatedGraphicData.pm25}
                  history={state.weatherHistory}
                  period={state.period}
                  unit={state.weatherGraphic?.unit.pmUnit}
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </Fragment>
  );
}
