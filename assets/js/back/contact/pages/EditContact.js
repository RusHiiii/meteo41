import React, { Fragment, useEffect, useReducer } from 'react';
import BreadCrumb from '../../../common/components/BreadCrumb';
import { apiClient } from '../../../common/utils/apiClient';
import ContactForm from '../components/ContactForm';

const EDIT_CONTACT_SENDING = 'EDIT_CONTACT_SENDING';
const EDIT_CONTACT_SENT = 'EDIT_CONTACT_SENT';
const EDIT_CONTACT_ERRORS = 'EDIT_CONTACT_ERRORS';
const EDIT_CONTACT_LOAD = 'EDIT_CONTACT_LOAD';

const getInitialValues = (contact) => {
  return {
    name: contact.name,
    email: contact.email,
    subject: contact.subject,
    message: contact.message,
  };
};

const reducer = (state, action) => {
  switch (action.type) {
    case EDIT_CONTACT_SENDING:
      return {
        ...state,
        sending: true,
      };
    case EDIT_CONTACT_LOAD:
      return {
        ...state,
        contact: action.contact,
        loaded: true,
      };
    case EDIT_CONTACT_SENT:
      return {
        ...state,
        sending: false,
        sent: true,
        errors: [],
      };
    case EDIT_CONTACT_ERRORS:
      return {
        ...state,
        errors: action.errors,
        sending: false,
      };
  }

  return state;
};

function updateContact(data, id, dispatch) {
  dispatch({
    type: EDIT_CONTACT_SENDING,
  });

  apiClient()
    .request(
      new Request(`/api/contact/${id}`, {
        method: 'PUT',
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
          type: EDIT_CONTACT_SENT,
        });

        return;
      }

      return response.json().then((errors) => {
        dispatch({
          type: EDIT_CONTACT_ERRORS,
          errors: errors,
        });
      });
    });
}

function loadContact(dispatch, id) {
  apiClient()
    .request(new Request(`/api/contact/${id}`))
    .then((response) => response.json())
    .then((data) => {
      dispatch({
        type: EDIT_CONTACT_LOAD,
        contact: data,
      });
    });
}

function useEditContact(id) {
  const initialState = {
    errors: [],
    contact: null,
    sending: false,
    sent: false,
    loaded: false,
    loading: false,
  };

  const [state, dispatch] = useReducer(reducer, initialState);

  useEffect(() => {
    loadContact(dispatch, id);
  }, []);

  return [state, dispatch];
}

export default function EditContact(props) {
  const [state, dispatch] = useEditContact(props.match.params.id);

  return (
    <Fragment>
      <BreadCrumb url="/admin/dashboard" page="Dashboard" text="Message" />

      <div className="fullwidth-block padding-content">
        <div className="content col-md-8">
          <div className="post single">
            <h2 className="entry-title">Edition d'un message</h2>
            <div className="featured-image">
              <img src={'/static/images/amboise.png'} alt="amboise" />
            </div>
          </div>

          <div className="entry-content min-height-entry">
            {state.sent && (
              <div className="success-alert">Le message a été modifié !</div>
            )}

            {state.loaded && (
              <ContactForm
                errors={state.errors}
                sending={state.sending}
                onSubmit={(data) =>
                  updateContact(data, state.contact.id, dispatch)
                }
                initialValues={getInitialValues(state.contact)}
              />
            )}
          </div>
        </div>
      </div>
    </Fragment>
  );
}
