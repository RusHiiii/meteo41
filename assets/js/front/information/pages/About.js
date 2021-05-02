import React, { Fragment, useEffect, useReducer } from 'react';
import BreadCrumb from '../../../common/components/BreadCrumb';
import { apiClient } from '../../../common/utils/apiClient';
import { useSelector } from 'react-redux';
import { Date } from '../../../common/components/Date';

const ABOUT_LOAD = 'ABOUT_LOAD';

const reducer = (state, action) => {
  switch (action.type) {
    case ABOUT_LOAD:
      return {
        ...state,
        weatherStation: action.weatherStation,
        loading: false,
        loaded: true,
      };
  }

  return state;
};

function loadAbout(weatherStation, dispatch) {
  apiClient()
    .request(new Request(`/api/weatherStation/${weatherStation.reference}`))
    .then((response) => response.json())
    .then((data) => {
      dispatch({
        type: ABOUT_LOAD,
        weatherStation: data,
      });
    });
}

function useAboutQuery(weatherStation) {
  const initialState = {
    weatherStation: null,
    loading: false,
    loaded: false,
  };

  const [state, dispatch] = useReducer(reducer, initialState);

  useEffect(() => {
    loadAbout(weatherStation, dispatch);
  }, [weatherStation.reference]);

  return [state, dispatch];
}

export default function About(props) {
  const weatherStation = useSelector((state) => state.weatherStation);
  const [state, dispatch] = useAboutQuery(weatherStation);

  return (
    <Fragment>
      <BreadCrumb text="A propos" />

      <div className="fullwidth-block no-padding-top">
        <div className="container">
          <div className="row">
            <div className="fullwidth-block padding-content">
              <div className="content col-md-8">
                <div className="post single">
                  <h2 className="entry-title">
                    Informations sur la station de {state.weatherStation?.city}
                  </h2>
                  <div className="featured-image">
                    <img src={'/static/images/chambord.png'} alt="Chambord" />
                  </div>

                  <div className="entry-content">
                    <p className="description-about">
                      {state.weatherStation?.description}
                    </p>
                  </div>

                  <div className="col-md-6">
                    <h3 className="about-title-content">
                      La localisation de la station
                    </h3>
                    <div className="entry-content">
                      <ul>
                        <li>Ville: {state.weatherStation?.city}</li>
                        <li>Pays: {state.weatherStation?.country}</li>
                        <li>Altitude: {state.weatherStation?.elevation}</li>
                        <li>Latitude: {state.weatherStation?.lat}</li>
                        <li>Longitude: {state.weatherStation?.lng}</li>
                      </ul>
                    </div>
                  </div>

                  <div className="col-md-6">
                    <h3 className="about-title-content">Autre informations</h3>
                    <div className="entry-content">
                      <ul>
                        <li>Modèle: {state.weatherStation?.model}</li>
                        <li>Référence: {state.weatherStation?.reference}</li>
                        <li>
                          Date de création:{' '}
                          <Date
                            format="L"
                            date={state.weatherStation?.createdAt}
                          />
                        </li>
                        <li>
                          Date de mise à jour:{' '}
                          <Date
                            format="L"
                            date={state.weatherStation?.updatedAt}
                          />
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div className="sidebar col-md-3 col-md-offset-1">
              <div className="widget">
                <h3 className="widget-title">Les autres stations</h3>
                <ul className="arrow-list">
                  <li>
                    <a
                      target="_blank"
                      href="https://www.wunderground.com/dashboard/pws/ICHAIL9"
                    >
                      Chailles
                    </a>
                  </li>
                  <li>
                    <a
                      target="_blank"
                      href="https://www.wunderground.com/dashboard/pws/ICELLETT3"
                    >
                      Cellettes
                    </a>
                  </li>
                  <li>
                    <a
                      target="_blank"
                      href="https://www.wunderground.com/dashboard/pws/ITOURENS3"
                    >
                      Tour-en-Sologne
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </Fragment>
  );
}
