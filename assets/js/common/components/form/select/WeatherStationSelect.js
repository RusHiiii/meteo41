import React, { Fragment, useEffect, useReducer } from 'react';
import { apiClient } from '../../../utils/apiClient';

const WEATHER_STATION_LOAD = 'WEATHER_STATION_LOAD';

const reducer = (state, action) => {
  switch (action.type) {
    case WEATHER_STATION_LOAD:
      return {
        ...state,
        weatherStations: action.weatherStations,
        loading: false,
        loaded: true,
      };
  }

  return state;
};

function loadWeatherStations(dispatch) {
  apiClient()
    .request(new Request(`/api/weatherStation`))
    .then((response) => response.json())
    .then((data) => {
      dispatch({
        type: WEATHER_STATION_LOAD,
        weatherStations: data.weatherStations,
      });
    });
}

function useWeatherStationSelectQuery() {
  const initialState = {
    weatherStations: [],
    loading: false,
    loaded: false,
  };

  const [state, dispatch] = useReducer(reducer, initialState);

  useEffect(() => {
    loadWeatherStations(dispatch);
  }, []);

  return [state, dispatch];
}

export default function WeatherStationSelect(props) {
  const [state, dispatch] = useWeatherStationSelectQuery();

  const handleInputChange = (evt) => {
    props.onChange(evt.target.value, evt.target.name);
  };

  return (
    <select
      className={props.className}
      value={props.value}
      name={props.name}
      onChange={handleInputChange}
    >
      {state.weatherStations.map((weatherStation) => (
        <option key={weatherStation.id} value={weatherStation.reference}>
          {weatherStation.city}
        </option>
      ))}
    </select>
  );
}
