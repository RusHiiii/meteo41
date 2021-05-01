import React, { Fragment, useEffect, useReducer } from 'react';
import BreadCrumb from '../../../common/components/BreadCrumb';
import { apiClient } from '../../../common/utils/apiClient';
import ContactForm from '../components/ContactForm';

const CREATE_MESSAGE_SENDING = 'CREATE_MESSAGE_SENDING';
const CREATE_MESSAGE_SENT = 'CREATE_MESSAGE_SENT';
const CREATE_MESSAGE_ERRORS = 'CREATE_MESSAGE_ERRORS';

const reducer = (state, action) => {
  switch (action.type) {
    case CREATE_MESSAGE_SENDING:
      return {
        ...state,
        sending: true,
      };
    case CREATE_MESSAGE_SENT:
      return {
        ...state,
        sending: false,
        sent: true,
        errors: [],
      };
    case CREATE_MESSAGE_ERRORS:
      return {
        ...state,
        errors: action.errors,
        sending: false,
      };
  }

  return state;
};

function sendMessage(data, dispatch) {
  dispatch({
    type: CREATE_MESSAGE_SENDING,
  });

  apiClient()
    .request(
      new Request(`/api/contact`, {
        method: 'POST',
        body: JSON.stringify({
          name: data.name,
          email: data.email,
          subject: data.subject,
          message: data.message,
        }),
      })
    )
    .then((response) => {
      if (response.ok) {
        dispatch({
          type: CREATE_MESSAGE_SENT,
        });

        return;
      }

      return response.json().then((errors) => {
        dispatch({
          type: CREATE_MESSAGE_ERRORS,
          errors: errors,
        });
      });
    });
}

function useMessage() {
  const initialState = {
    errors: [],
    sending: false,
    sent: false,
  };

  return useReducer(reducer, initialState);
}

export default function CreateContact(props) {
  const [state, dispatch] = useMessage();

  return (
    <Fragment>
      <BreadCrumb url="/admin/dashboard" page="Dashboard" text="Message" />

      <div className="fullwidth-block padding-content">
        <div className="content col-md-8">
          <div className="post single">
            <h2 className="entry-title">Ajout d'un message</h2>
            <div className="featured-image">
              <img src={'/static/images/amboise.png'} alt="amboise" />
            </div>
          </div>

          <div className="entry-content">
            {state.sent && (
              <div className="success-alert">Le message a été ajouté !</div>
            )}

            <ContactForm
              errors={state.errors}
              sending={state.sending}
              onSubmit={(data) => sendMessage(data, dispatch)}
              initialValues={{ name: '', email: '', subject: '', message: '' }}
            />
          </div>
        </div>
      </div>
    </Fragment>
  );
}
