import React, { Fragment, useEffect, useReducer, useRef } from 'react';
import Map from '../../../common/components/Map';
import Forecast from '../components/Forecast';
import ForecastSearchForm from '../components/ForecastSearchForm';
import Observation from '../components/Observation';
import { useSelector } from 'react-redux';
import { apiClient } from '../../../common/utils/apiClient';
import Rain from '../components/gauge/Rain';
import RainRate from '../components/gauge/RainRate';
import WindSpeed from '../components/gauge/WindSpeed';
import WindDirection from '../components/gauge/WindDirection';
import Uv from '../components/gauge/Uv';
import SolarRadiation from '../components/gauge/SolarRadiation';
import Aqi from '../components/gauge/Aqi';

const WEATHER_DATA_LOAD = 'WEATHER_DATA_LOAD';
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

function useHome(weatherStation) {
  const initialState = {
    weatherData: null,
    errors: [],
    forecast: {
      city: 'Blois',
      weather: null,
    },
    loading: false,
    loaded: false,
  };

  const [state, dispatch] = useReducer(reducer, initialState);

  useEffect(() => {
    loadWeatherData(weatherStation, dispatch);

    const intervalId = setInterval(() => {
      loadWeatherData(weatherStation, dispatch);
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
              initialValues={{ text: '' }}
              onSubmit={(text) => console.log(text)}
            />
          </div>
        </div>
        <div className="forecast-table">
          <div className="container">
            <Forecast />
          </div>
        </div>
        <main className="main-content current-obs">
          <div className="fullwidth-block">
            <div className="container">
              <Observation weatherData={state.weatherData} />
              <div className="home-map col-md-5">
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
              <h2 className="section-title">Capteurs secondaires</h2>
              <div className="gauge col-md-3 col-sm-6">
                <Rain
                  value={state.weatherData?.rainWeekly}
                  unit={state.weatherData?.unit.rainUnit}
                />
                <h3>Précipitation</h3>
              </div>
              <div className="gauge col-md-3 col-sm-6">
                <RainRate
                  value={state.weatherData?.rainRate}
                  unit={`${state.weatherData?.unit.rainUnit}/h`}
                />
                <h3>Averse</h3>
              </div>
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
