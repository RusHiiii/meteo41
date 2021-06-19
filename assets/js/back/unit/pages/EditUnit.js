import React, { Fragment, useEffect, useReducer } from 'react';
import BreadCrumb from '../../../common/components/BreadCrumb';
import { apiClient } from '../../../common/utils/apiClient';
import UnitForm from '../components/UnitForm';

const EDIT_UNIT_SENDING = 'EDIT_UNIT_SENDING';
const EDIT_UNIT_SENT = 'EDIT_UNIT_SENT';
const EDIT_UNIT_ERRORS = 'EDIT_UNIT_ERRORS';
const EDIT_UNIT_LOAD = 'EDIT_UNIT_LOAD';

const getInitialValues = (unit) => {
  return {
    type: unit.type,
    temperatureUnit: unit.temperatureUnit,
    speedUnit: unit.speedUnit,
    rainUnit: unit.rainUnit,
    solarRadiationUnit: unit.solarRadiationUnit,
    pmUnit: unit.pmUnit,
    humidityUnit: unit.humidityUnit,
    cloudBaseUnit: unit.cloudBaseUnit,
    windDirUnit: unit.windDirUnit,
    pressureUnit: unit.pressureUnit,
  };
};

const reducer = (state, action) => {
  switch (action.type) {
    case EDIT_UNIT_SENDING:
      return {
        ...state,
        sending: true,
      };
    case EDIT_UNIT_LOAD:
      return {
        ...state,
        unit: action.unit,
        loaded: true,
      };
    case EDIT_UNIT_SENT:
      return {
        ...state,
        sending: false,
        sent: true,
        errors: [],
      };
    case EDIT_UNIT_ERRORS:
      return {
        ...state,
        errors: action.errors,
        sending: false,
      };
  }

  return state;
};

function updateUnit(data, id, dispatch) {
  dispatch({
    type: EDIT_UNIT_SENDING,
  });

  apiClient()
    .request(
      new Request(`/api/unit/${id}`, {
        method: 'PUT',
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
          type: EDIT_UNIT_SENT,
        });

        return;
      }

      return response.json().then((errors) => {
        dispatch({
          type: EDIT_UNIT_ERRORS,
          errors: errors,
        });
      });
    });
}

function loadUnit(dispatch, id) {
  apiClient()
    .request(new Request(`/api/unit/${id}`))
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
        type: EDIT_UNIT_LOAD,
        unit: data,
      });
    })
    .catch((errors) => {
      dispatch({
        type: EDIT_UNIT_ERRORS,
        errors: errors,
      });
    });
}

function useEditUnit(id) {
  const initialState = {
    errors: [],
    unit: null,
    sending: false,
    sent: false,
    loaded: false,
    loading: false,
  };

  const [state, dispatch] = useReducer(reducer, initialState);

  useEffect(() => {
    loadUnit(dispatch, id);
  }, []);

  return [state, dispatch];
}

export default function EditUnit(props) {
  const [state, dispatch] = useEditUnit(props.match.params.id);

  return (
    <Fragment>
      <BreadCrumb url="/admin/dashboard" page="Dashboard" text="Unité" />

      <div className="fullwidth-block padding-content">
        <div className="content col-md-8">
          <div className="post single">
            <h2 className="entry-title">Edition d'une unité</h2>
            <div className="featured-image">
              <img src={'/static/images/amboise.png'} alt="amboise" />
            </div>
          </div>

          <div className="entry-content min-height-entry">
            {state.sent && (
              <div className="success-alert">L'unité a été modifié !</div>
            )}

            {state.errors
              .filter((error) => !error.propertyPath)
              .map((error, index) => (
                <div key={index} className="error-alert">
                  {error.message}
                </div>
              ))}

            {state.loaded && (
              <UnitForm
                errors={state.errors}
                sending={state.sending}
                onSubmit={(data) => updateUnit(data, state.unit.id, dispatch)}
                initialValues={getInitialValues(state.unit)}
              />
            )}
          </div>
        </div>
      </div>
    </Fragment>
  );
}
