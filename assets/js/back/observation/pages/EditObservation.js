import React, { Fragment, useEffect, useReducer } from 'react';
import BreadCrumb from '../../../common/components/BreadCrumb';
import { apiClient } from '../../../common/utils/apiClient';
import UnitForm from '../../unit/components/UnitForm';
import ObservationForm from '../components/ObservationForm';

const EDIT_OBSERVATION_SENDING = 'EDIT_OBSERVATION_SENDING';
const EDIT_OBSERVATION_SENT = 'EDIT_OBSERVATION_SENT';
const EDIT_OBSERVATION_ERRORS = 'EDIT_OBSERVATION_ERRORS';
const EDIT_OBSERVATION_LOAD = 'EDIT_OBSERVATION_LOAD';

const getInitialValues = (observation) => {
  return {
    weatherStation: observation.weatherStation?.reference,
    message: observation.message,
  };
};

const reducer = (state, action) => {
  switch (action.type) {
    case EDIT_OBSERVATION_SENDING:
      return {
        ...state,
        sending: true,
      };
    case EDIT_OBSERVATION_LOAD:
      return {
        ...state,
        observation: action.observation,
        loaded: true,
      };
    case EDIT_OBSERVATION_SENT:
      return {
        ...state,
        sending: false,
        sent: true,
        errors: [],
      };
    case EDIT_OBSERVATION_ERRORS:
      return {
        ...state,
        errors: action.errors,
        sending: false,
      };
  }

  return state;
};

function updateObservation(data, id, dispatch) {
  dispatch({
    type: EDIT_OBSERVATION_SENDING,
  });

  apiClient()
    .request(
      new Request(`/api/observation/${id}`, {
        method: 'PUT',
        body: JSON.stringify({
          weatherStation: data.weatherStation,
          message: data.message,
        }),
      })
    )
    .then((response) => {
      if (response.ok) {
        dispatch({
          type: EDIT_OBSERVATION_SENT,
        });

        return;
      }

      return response.json().then((errors) => {
        dispatch({
          type: EDIT_OBSERVATION_ERRORS,
          errors: errors,
        });
      });
    });
}

function loadObservation(dispatch, id) {
  apiClient()
    .request(new Request(`/api/observation/${id}`))
    .then((response) => response.json())
    .then((data) => {
      dispatch({
        type: EDIT_OBSERVATION_LOAD,
        observation: data,
      });
    });
}

function useEditObservation(id) {
  const initialState = {
    errors: [],
    observation: null,
    sending: false,
    sent: false,
    loaded: false,
    loading: false,
  };

  const [state, dispatch] = useReducer(reducer, initialState);

  useEffect(() => {
    loadObservation(dispatch, id);
  }, []);

  return [state, dispatch];
}

export default function EditObservation(props) {
  const [state, dispatch] = useEditObservation(props.match.params.id);

  return (
    <Fragment>
      <BreadCrumb url="/admin/dashboard" page="Dashboard" text="Observation" />

      <div className="fullwidth-block padding-content">
        <div className="content col-md-8">
          <div className="post single">
            <h2 className="entry-title">Edition d'une observation</h2>
            <div className="featured-image">
              <img src={'/static/images/amboise.png'} alt="amboise" />
            </div>
          </div>

          <div className="entry-content min-height-entry">
            {state.sent && (
              <div className="success-alert">L'observation a été modifié !</div>
            )}

            {state.loaded && (
              <ObservationForm
                errors={state.errors}
                sending={state.sending}
                onSubmit={(data) =>
                  updateObservation(data, state.observation.id, dispatch)
                }
                initialValues={getInitialValues(state.observation)}
              />
            )}
          </div>
        </div>
      </div>
    </Fragment>
  );
}
