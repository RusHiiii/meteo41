import React, { Fragment, useEffect, useReducer } from 'react';
import BreadCrumb from '../../../common/components/BreadCrumb';
import { apiClient } from '../../../common/utils/apiClient';
import WeatherStationForm from '../components/WeatherStationForm';

const EDIT_WEATHER_STATION_SENDING = 'EDIT_WEATHER_STATION_SENDING';
const EDIT_WEATHER_STATION_SENT = 'EDIT_WEATHER_STATION_SENT';
const EDIT_WEATHER_STATION_ERRORS = 'EDIT_WEATHER_STATION_ERRORS';
const EDIT_WEATHER_STATION_LOAD = 'EDIT_WEATHER_STATION_LOAD';

const getInitialValues = (data) => {
  return {
    name: data.name,
    description: data.description,
    shortDescription: data.shortDescription,
    country: data.country,
    address: data.address,
    city: data.city,
    lat: data.lat,
    lng: data.lng,
    apiToken: data.apiToken,
    model: data.model,
    elevation: data.elevation,
    preferedUnit: data.preferedUnit,
    reference: data.reference,
  };
};

const reducer = (state, action) => {
  switch (action.type) {
    case EDIT_WEATHER_STATION_SENDING:
      return {
        ...state,
        sending: true,
      };
    case EDIT_WEATHER_STATION_LOAD:
      return {
        ...state,
        weatherStation: action.weatherStation,
        loaded: true,
      };
    case EDIT_WEATHER_STATION_SENT:
      return {
        ...state,
        sending: false,
        sent: true,
        errors: [],
      };
    case EDIT_WEATHER_STATION_ERRORS:
      return {
        ...state,
        errors: action.errors,
        sending: false,
      };
  }

  return state;
};

function updateWeatherStation(data, id, dispatch) {
  dispatch({
    type: EDIT_WEATHER_STATION_SENDING,
  });

  apiClient()
    .request(
      new Request(`/api/weatherStation/${id}`, {
        method: 'PUT',
        body: JSON.stringify({
          name: data.name,
          description: data.description,
          shortDescription: data.shortDescription,
          country: data.country,
          address: data.address,
          city: data.city,
          lat: parseFloat(data.lat),
          lng: parseFloat(data.lng),
          apiToken: data.apiToken,
          model: data.model,
          elevation: data.elevation,
          preferedUnit: data.preferedUnit,
          reference: data.reference,
        }),
      })
    )
    .then((response) => {
      if (response.ok) {
        dispatch({
          type: EDIT_WEATHER_STATION_SENT,
        });

        return;
      }

      return response.json().then((errors) => {
        dispatch({
          type: EDIT_WEATHER_STATION_ERRORS,
          errors: errors,
        });
      });
    });
}

function loadWeatherStation(dispatch, reference) {
  apiClient()
    .request(new Request(`/api/weatherStation/${reference}`))
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
        type: EDIT_WEATHER_STATION_LOAD,
        weatherStation: data,
      });
    })
    .catch((errors) => {
      dispatch({
        type: EDIT_WEATHER_STATION_ERRORS,
        errors: errors,
      });
    });
}

function useEditWeatherStation(id) {
  const initialState = {
    errors: [],
    weatherStation: null,
    sending: false,
    sent: false,
    loaded: false,
    loading: false,
  };

  const [state, dispatch] = useReducer(reducer, initialState);

  useEffect(() => {
    loadWeatherStation(dispatch, id);
  }, []);

  return [state, dispatch];
}

export default function EditWeatherStation(props) {
  const [state, dispatch] = useEditWeatherStation(props.match.params.reference);

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
            <h2 className="entry-title">Edition d'une station météo</h2>
            <div className="featured-image">
              <img src={'/static/images/amboise.png'} alt="amboise" />
            </div>
          </div>

          <div className="entry-content min-height-entry">
            {state.sent && (
              <div className="success-alert">
                La station météo a été modifié !
              </div>
            )}

            {state.errors
              .filter((error) => !error.propertyPath)
              .map((error, index) => (
                <div className="error-alert">{error.message}</div>
              ))}

            {state.loaded && state.weatherStation && (
              <WeatherStationForm
                errors={state.errors}
                sending={state.sending}
                onSubmit={(data) =>
                  updateWeatherStation(data, state.weatherStation.id, dispatch)
                }
                initialValues={getInitialValues(state.weatherStation)}
              />
            )}
          </div>
        </div>
      </div>
    </Fragment>
  );
}
