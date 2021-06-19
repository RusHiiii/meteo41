import React, { Fragment, useEffect, useReducer } from 'react';
import BreadCrumb from '../../../common/components/BreadCrumb';
import { apiClient } from '../../../common/utils/apiClient';
import queryString from 'qs';
import WeatherStationSearchResult from '../components/WeatherStationSearchResult';

const WEATHER_STATION_LOAD = 'WEATHER_STATION_LOAD';
const WEATHER_STATION_CHANGE_PAGE = 'WEATHER_STATION_CHANGE_PAGE';

const reducer = (state, action) => {
  switch (action.type) {
    case WEATHER_STATION_LOAD:
      return {
        ...state,
        weatherStations: action.weatherStations.weatherStations,
        totalWeatherStation: action.weatherStations.numberOfResult,
        currentPage: action.currentPage,
        loading: false,
        loaded: true,
      };
    case WEATHER_STATION_CHANGE_PAGE:
      return {
        ...state,
        currentPage: parseInt(action.page),
      };
  }

  return state;
};

function loadWeatherStation(dispatch, currentPage = 1) {
  apiClient()
    .request(
      new Request(
        `/api/weatherStation?${queryString.stringify({
          page: currentPage,
          order: 'DESC',
          maxResult: 5,
        })}`
      )
    )
    .then((response) => response.json())
    .then((data) => {
      dispatch({
        type: WEATHER_STATION_LOAD,
        weatherStations: data,
        currentPage: currentPage,
      });
    });
}

function deleteWeatherStation(id, dispatch) {
  apiClient()
    .request(
      new Request(`/api/weatherStation/${id}`, {
        method: 'DELETE',
      })
    )
    .then((response) => {
      loadWeatherStation(dispatch);
    });
}

function useWeatherStation() {
  const initialState = {
    weatherStations: [],
    totalWeatherStation: 0,
    currentPage: 1,
    loading: false,
    loaded: false,
  };

  const [state, dispatch] = useReducer(reducer, initialState);

  useEffect(() => {
    loadWeatherStation(dispatch, state.currentPage);
  }, [state.currentPage]);

  return [state, dispatch];
}

export default function WeatherStation(props) {
  const [state, dispatch] = useWeatherStation();

  return (
    <Fragment>
      <BreadCrumb
        url="/admin/dashboard"
        page="Dashboard"
        text="Station météo"
      />

      <div className="fullwidth-block padding-content">
        <div className="content col-md-8">
          <div className="post single">
            <h2 className="entry-title">
              Panel d'administration des stations météo
            </h2>
            <div className="featured-image">
              <img src={'/static/images/amboise.png'} alt="amboise" />
            </div>
            <div className="entry-content">
              <p>
                Panel d'administration des stations météo du site, accédez aux
                pages de listing, de création et de suppression des unités.
                Accédez également à toutes les autres pages d'administration du
                site.
              </p>
            </div>
          </div>

          <WeatherStationSearchResult
            weatherStations={state.weatherStations}
            totalWeatherStation={state.totalWeatherStation}
            currentPage={state.currentPage}
            onChangePage={(page) =>
              dispatch({
                type: WEATHER_STATION_CHANGE_PAGE,
                page: page,
              })
            }
            onDelete={(id) => deleteWeatherStation(id, dispatch)}
          />
        </div>
      </div>
    </Fragment>
  );
}
