import React, { Fragment, useEffect, useReducer } from 'react';
import BreadCrumb from '../../../common/components/BreadCrumb';
import { apiClient } from '../../../common/utils/apiClient';
import UnitForm from '../components/UnitForm';

const CREATE_UNIT_SENDING = 'CREATE_UNIT_SENDING';
const CREATE_UNIT_SENT = 'CREATE_UNIT_SENT';
const CREATE_UNIT_ERRORS = 'CREATE_UNIT_ERRORS';

const reducer = (state, action) => {
  switch (action.type) {
    case CREATE_UNIT_SENDING:
      return {
        ...state,
        sending: true,
      };
    case CREATE_UNIT_SENT:
      return {
        ...state,
        sending: false,
        sent: true,
        errors: [],
      };
    case CREATE_UNIT_ERRORS:
      return {
        ...state,
        errors: action.errors,
        sending: false,
      };
  }

  return state;
};

function sendUnit(data, dispatch) {
  dispatch({
    type: CREATE_UNIT_SENDING,
  });

  apiClient()
    .request(
      new Request(`/api/unit`, {
        method: 'POST',
        body: JSON.stringify({
          type: data.type,
          temperatureUnit: data.temperatureUnit,
          speedUnit: data.speedUnit,
          rainUnit: data.rainUnit,
          solarRadiationUnit: data.solarRadiationUnit,
          pmUnit: data.pmUnit,
          humidityUnit: data.humidityUnit,
          cloudBaseUnit: data.cloudBaseUnit,
          windDirUnit: data.windDirUnit,
          pressureUnit: data.pressureUnit,
        }),
      })
    )
    .then((response) => {
      if (response.ok) {
        dispatch({
          type: CREATE_UNIT_SENT,
        });

        return;
      }

      return response.json().then((errors) => {
        dispatch({
          type: CREATE_UNIT_ERRORS,
          errors: errors,
        });
      });
    });
}

function useCreateUnit() {
  const initialState = {
    errors: [],
    sending: false,
    sent: false,
  };

  return useReducer(reducer, initialState);
}

export default function CreateUnit(props) {
  const [state, dispatch] = useCreateUnit();

  return (
    <Fragment>
      <BreadCrumb url="/admin/dashboard" page="Dashboard" text="Unité" />

      <div className="fullwidth-block padding-content">
        <div className="content col-md-8">
          <div className="post single">
            <h2 className="entry-title">Ajout d'une unité</h2>
            <div className="featured-image">
              <img src={'/static/images/amboise.png'} alt="amboise" />
            </div>
          </div>

          <div className="entry-content">
            {state.sent && (
              <div className="success-alert">L'unité a été ajouté !</div>
            )}

            <UnitForm
              errors={state.errors}
              sending={state.sending}
              onSubmit={(data) => sendUnit(data, dispatch)}
              initialValues={{
                type: 'metric',
                temperatureUnit: '',
                speedUnit: '',
                rainUnit: '',
                solarRadiationUnit: '',
                pmUnit: '',
                humidityUnit: '',
                cloudBaseUnit: '',
                windDirUnit: '',
                pressureUnit: '',
              }}
            />
          </div>
        </div>
      </div>
    </Fragment>
  );
}
