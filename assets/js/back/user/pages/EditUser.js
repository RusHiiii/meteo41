import React, { Fragment, useEffect, useReducer } from 'react';
import BreadCrumb from '../../../common/components/BreadCrumb';
import { apiClient } from '../../../common/utils/apiClient';
import UserForm from '../components/UserForm';

const EDIT_USER_SENDING = 'EDIT_USER_SENDING';
const EDIT_USER_SENT = 'EDIT_USER_SENT';
const EDIT_USER_ERRORS = 'EDIT_USER_ERRORS';
const EDIT_USER_LOAD = 'EDIT_USER_LOAD';

const getInitialValues = (user) => {
  return {
    firstname: user.firstname,
    lastname: user.lastname,
    email: user.email,
    password: '',
    passwordConfirmation: '',
    roles: user.roles[0],
  };
};

const reducer = (state, action) => {
  switch (action.type) {
    case EDIT_USER_SENDING:
      return {
        ...state,
        sending: true,
      };
    case EDIT_USER_LOAD:
      return {
        ...state,
        user: action.user,
        loaded: true,
      };
    case EDIT_USER_SENT:
      return {
        ...state,
        sending: false,
        sent: true,
        errors: [],
      };
    case EDIT_USER_ERRORS:
      return {
        ...state,
        errors: action.errors,
        sending: false,
      };
  }

  return state;
};

function updateUser(data, id, dispatch) {
  dispatch({
    type: EDIT_USER_SENDING,
  });

  apiClient()
    .request(
      new Request(`/api/user/${id}`, {
        method: 'PUT',
        body: JSON.stringify({
          firstname: data.firstname,
          lastname: data.lastname,
          email: data.email,
          password: data.password,
          passwordConfirmation: data.passwordConfirmation,
          roles: [data.roles],
        }),
      })
    )
    .then((response) => {
      if (response.ok) {
        dispatch({
          type: EDIT_USER_SENT,
        });

        return;
      }

      return response.json().then((errors) => {
        dispatch({
          type: EDIT_USER_ERRORS,
          errors: errors,
        });
      });
    });
}

function loadUser(dispatch, id) {
  apiClient()
    .request(new Request(`/api/user/${id}`))
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
        type: EDIT_USER_LOAD,
        user: data,
      });
    })
    .catch((errors) => {
      dispatch({
        type: EDIT_USER_ERRORS,
        errors: errors,
      });
    });
}

function useEditUser(id) {
  const initialState = {
    errors: [],
    user: null,
    sending: false,
    sent: false,
    loaded: false,
    loading: false,
  };

  const [state, dispatch] = useReducer(reducer, initialState);

  useEffect(() => {
    loadUser(dispatch, id);
  }, []);

  return [state, dispatch];
}

export default function EditUser(props) {
  const [state, dispatch] = useEditUser(props.match.params.id);

  return (
    <Fragment>
      <BreadCrumb url="/admin/dashboard" page="Dashboard" text="Utilisateur" />

      <div className="fullwidth-block padding-content">
        <div className="content col-md-8">
          <div className="post single">
            <h2 className="entry-title">Edition d'un utilisateur</h2>
            <div className="featured-image">
              <img src={'/static/images/amboise.png'} alt="amboise" />
            </div>
          </div>

          <div className="entry-content min-height-entry">
            {state.sent && (
              <div className="success-alert">L'utilisateur a été modifié !</div>
            )}

            {state.errors
              .filter((error) => !error.propertyPath)
              .map((error, index) => (
                <div key={index} className="error-alert">
                  {error.message}
                </div>
              ))}

            {state.loaded && (
              <UserForm
                errors={state.errors}
                sending={state.sending}
                onSubmit={(data) => updateUser(data, state.user.id, dispatch)}
                initialValues={getInitialValues(state.user)}
              />
            )}
          </div>
        </div>
      </div>
    </Fragment>
  );
}
