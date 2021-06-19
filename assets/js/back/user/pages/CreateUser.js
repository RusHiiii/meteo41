import React, { Fragment, useEffect, useReducer } from 'react';
import BreadCrumb from '../../../common/components/BreadCrumb';
import { apiClient } from '../../../common/utils/apiClient';
import UserForm from '../components/UserForm';
import { ROLE_EDITOR } from '../../../common/constant';

const CREATE_USER_SENDING = 'CREATE_USER_SENDING';
const CREATE_USER_SENT = 'CREATE_USER_SENT';
const CREATE_USER_ERRORS = 'CREATE_USER_ERRORS';

const reducer = (state, action) => {
  switch (action.type) {
    case CREATE_USER_SENDING:
      return {
        ...state,
        sending: true,
      };
    case CREATE_USER_SENT:
      return {
        ...state,
        sending: false,
        sent: true,
        errors: [],
      };
    case CREATE_USER_ERRORS:
      return {
        ...state,
        errors: action.errors,
        sending: false,
      };
  }

  return state;
};

function sendUser(data, dispatch) {
  dispatch({
    type: CREATE_USER_SENDING,
  });

  apiClient()
    .request(
      new Request(`/api/user`, {
        method: 'POST',
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
          type: CREATE_USER_SENT,
        });

        return;
      }

      return response.json().then((errors) => {
        dispatch({
          type: CREATE_USER_ERRORS,
          errors: errors,
        });
      });
    });
}

function useCreateUser() {
  const initialState = {
    errors: [],
    sending: false,
    sent: false,
  };

  return useReducer(reducer, initialState);
}

export default function CreateUser(props) {
  const [state, dispatch] = useCreateUser();

  return (
    <Fragment>
      <BreadCrumb url="/admin/dashboard" page="Dashboard" text="Utilisateur" />

      <div className="fullwidth-block padding-content">
        <div className="content col-md-8">
          <div className="post single">
            <h2 className="entry-title">Ajout d'un utilisateur</h2>
            <div className="featured-image">
              <img src={'/static/images/amboise.png'} alt="amboise" />
            </div>
          </div>

          <div className="entry-content">
            {state.sent && (
              <div className="success-alert">L'utilisateur a été ajouté !</div>
            )}

            {state.errors
              .filter((error) => !error.propertyPath)
              .map((error, index) => (
                <div key={index} className="error-alert">
                  {error.message}
                </div>
              ))}

            <UserForm
              errors={state.errors}
              sending={state.sending}
              onSubmit={(data) => sendUser(data, dispatch)}
              initialValues={{
                firstname: '',
                lastname: '',
                email: '',
                password: '',
                passwordConfirmation: '',
                roles: ROLE_EDITOR,
              }}
            />
          </div>
        </div>
      </div>
    </Fragment>
  );
}
