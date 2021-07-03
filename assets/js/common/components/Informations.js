import React, { Fragment, useEffect, useReducer } from 'react';
import { apiClient } from '../utils/apiClient';
import { useSelector } from 'react-redux';
import { Link } from 'react-router-dom';

const INFORMATION_LOAD = 'INFORMATION_LOAD';

const reducer = (state, action) => {
  switch (action.type) {
    case INFORMATION_LOAD:
      return {
        ...state,
        weatherStation: action.weatherStation,
        loading: false,
        loaded: true,
      };
  }

  return state;
};

function loadInformation(weatherStation, dispatch) {
  apiClient()
    .request(new Request(`/api/weatherStation/${weatherStation.reference}`))
    .then((response) => response.json())
    .then((data) => {
      dispatch({
        type: INFORMATION_LOAD,
        weatherStation: data,
      });
    });
}

function useInformationQuery(weatherStation) {
  const initialState = {
    weatherStation: null,
    loading: false,
    loaded: false,
  };

  const [state, dispatch] = useReducer(reducer, initialState);

  useEffect(() => {
    loadInformation(weatherStation, dispatch);
  }, [weatherStation.reference]);

  return [state, dispatch];
}

export default function Informations(props) {
  const weatherStation = useSelector((state) => state.weatherStation);
  const [state, dispatch] = useInformationQuery(weatherStation);

  return (
    <div className="fullwidth-block information">
      <div className="container">
        <div className="row">
          <div className="col-md-4">
            <h2 className="section-title">Informations</h2>
            <ul className="arrow-feature">
              <li>
                <h3>Ma station météo</h3>
                {state.weatherStation && (
                  <p>{state.weatherStation.shortDescription}</p>
                )}
              </li>
              <li>
                <h3>Utilisation des données</h3>
                <p>
                  Les données météo du site ne peuvent en aucun cas servir pour
                  la protection des biens et des personnes.
                </p>
              </li>
              <li>
                <h3>Développeur Web</h3>
                <p>Florent Damiens, Royat, 63130</p>
              </li>
            </ul>
          </div>
          <div className="col-md-4">
            <h2 className="section-title weather-data">Les données météo</h2>
            <ul className="arrow-list">
              <li>
                <Link to="/weather/current">Les données de la journée</Link>
              </li>
              <li>
                <Link to="/weather/history/weekly">
                  Les données de la semaine
                </Link>
              </li>
              <li>
                <Link to="/weather/history/monthly">Les données du mois</Link>
              </li>
              <li>
                <Link to="/weather/history/yearly">Les données de l'année</Link>
              </li>
              <li>
                <Link to="/weather/history/record">
                  Les records de la station
                </Link>
              </li>
            </ul>
          </div>
          <div className="col-md-4">
            <h2 className="section-title my-network">Mes autres réseaux</h2>
            <div className="photo-grid">
              <a
                target="_blank"
                href="https://app.weathercloud.net/d0599727380#profile"
              >
                <img
                  src={'/static/images/weathercloud.png'}
                  alt="weathercloud"
                />
              </a>
              <a
                target="_blank"
                href="https://www.wunderground.com/dashboard/pws/ISAINT1035"
              >
                <img src={'/static/images/wu.png'} alt="wunderground" />
              </a>
              <a target="_blank" href="https://www.ecowitt.net/">
                <img src={'/static/images/ecowitt.png'} alt="ecowitt" />
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
