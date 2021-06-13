import React, { Fragment, useEffect, useReducer } from 'react';
import BreadCrumb from '../../../common/components/BreadCrumb';
import { apiClient } from '../../../common/utils/apiClient';
import WeatherStationForm from '../components/WeatherStationForm';

const CREATE_WEATHER_STATION_SENDING = 'CREATE_WEATHER_STATION_SENDING';
const CREATE_WEATHER_STATION_SENT = 'CREATE_WEATHER_STATION_SENT';
const CREATE_WEATHER_STATION_ERRORS = 'CREATE_WEATHER_STATION_ERRORS';

const reducer = (state, action) => {
  switch (action.type) {
    case CREATE_WEATHER_STATION_SENDING:
      return {
        ...state,
        sending: true,
      };
    case CREATE_WEATHER_STATION_SENT:
      return {
        ...state,
        sending: false,
        sent: true,
        errors: [],
      };
    case CREATE_WEATHER_STATION_ERRORS:
      return {
        ...state,
        errors: action.errors,
        sending: false,
      };
  }

  return state;
};

function sendWeatherStation(data, dispatch) {
  dispatch({
    type: CREATE_WEATHER_STATION_SENDING,
  });

  apiClient()
    .request(
      new Request(`/api/weatherStation`, {
        method: 'POST',
        body: JSON.stringify({
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
        }),
      })
    )
    .then((response) => {
      if (response.ok) {
        dispatch({
          type: CREATE_WEATHER_STATION_SENT,
        });

        return;
      }

      return response.json().then((errors) => {
        dispatch({
          type: CREATE_WEATHER_STATION_ERRORS,
          errors: errors,
        });
      });
    });
}

function useCreateWeatherStation() {
  const initialState = {
    errors: [],
    sending: false,
    sent: false,
  };

  return useReducer(reducer, initialState);
}

export default function CreateWeatherStation(props) {
  const [state, dispatch] = useCreateWeatherStation();

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
            <h2 className="entry-title">Ajout d'une station météo</h2>
            <div className="featured-image">
              <img src={'/static/images/amboise.png'} alt="amboise" />
            </div>
          </div>

          <div className="entry-content">
            {state.sent && (
              <div className="success-alert">
                La station météo a été ajouté !
              </div>
            )}
            {state.errors
              .filter((error) => !error.propertyPath)
              .map((error, index) => (
                <div className="error-alert">{error.message}</div>
              ))}

            <WeatherStationForm
              errors={state.errors}
              sending={state.sending}
              onSubmit={(data) => sendWeatherStation(data, dispatch)}
              initialValues={{
                name: '',
                description: '',
                shortDescription: '',
                country: 'FR',
                address: '',
                city: '',
                lat: 45.78,
                lng: 3.08,
                apiToken: '',
                model: '',
                elevation: '',
                preferedUnit: 'Metric',
                reference: '',
              }}
            />
          </div>
        </div>
      </div>
    </Fragment>
  );
}
