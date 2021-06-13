import React, { Fragment, useEffect, useReducer } from 'react';
import BreadCrumb from '../../../common/components/BreadCrumb';
import { apiClient } from '../../../common/utils/apiClient';
import ObservationForm from "../components/ObservationForm";
import {DEFAULT_WEATHER_STATION_REFERENCE} from "../../../common/constant";

const CREATE_OBSERVATION_SENDING = 'CREATE_OBSERVATION_SENDING';
const CREATE_OBSERVATION_SENT = 'CREATE_OBSERVATION_SENT';
const CREATE_OBSERVATION_ERRORS = 'CREATE_UNIT_ERRORS';

const reducer = (state, action) => {
  switch (action.type) {
    case CREATE_OBSERVATION_SENDING:
      return {
        ...state,
        sending: true,
      };
    case CREATE_OBSERVATION_SENT:
      return {
        ...state,
        sending: false,
        sent: true,
        errors: [],
      };
    case CREATE_OBSERVATION_ERRORS:
      return {
        ...state,
        errors: action.errors,
        sending: false,
      };
  }

  return state;
};

function sendObservation(data, dispatch) {
  dispatch({
    type: CREATE_OBSERVATION_SENDING,
  });

  apiClient()
    .request(
      new Request(`/api/observation`, {
        method: 'POST',
        body: JSON.stringify({
          message: data.message,
          weatherStation: data.weatherStation
        }),
      })
    )
    .then((response) => {
      if (response.ok) {
        dispatch({
          type: CREATE_OBSERVATION_SENT,
        });

        return;
      }

      return response.json().then((errors) => {
        dispatch({
          type: CREATE_OBSERVATION_ERRORS,
          errors: errors,
        });
      });
    });
}

function useCreateObservation() {
  const initialState = {
    errors: [],
    sending: false,
    sent: false,
  };

  return useReducer(reducer, initialState);
}

export default function CreateObservation(props) {
  const [state, dispatch] = useCreateObservation();

  return (
    <Fragment>
      <BreadCrumb url="/admin/dashboard" page="Dashboard" text="Observation" />

      <div className="fullwidth-block padding-content">
        <div className="content col-md-8">
          <div className="post single">
            <h2 className="entry-title">Ajout d'une observation</h2>
            <div className="featured-image">
              <img src={'/static/images/amboise.png'} alt="amboise" />
            </div>
          </div>

          <div className="entry-content">
            {state.sent && (
              <div className="success-alert">L'observation a été ajouté !</div>
            )}

            <ObservationForm
              errors={state.errors}
              sending={state.sending}
              onSubmit={(data) => sendObservation(data, dispatch)}
              initialValues={{
                message: '',
                weatherStation: DEFAULT_WEATHER_STATION_REFERENCE
              }}
            />
          </div>
        </div>
      </div>
    </Fragment>
  );
}
