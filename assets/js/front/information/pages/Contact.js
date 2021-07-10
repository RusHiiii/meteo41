import React, { Fragment, useEffect, useReducer } from 'react';
import BreadCrumb from '../../../common/components/BreadCrumb';
import { apiClient } from '../../../common/utils/apiClient';
import { DEFAULT_WEATHER_STATION_REFERENCE } from '../../../common/constant';
import Map from '../../../common/components/Map';
import ContactForm from '../components/ContactForm';
import NewsForm from '../../../back/news/components/NewsForm';

const CONTACT_LOAD = 'CONTACT_LOAD';
const CREATE_CONTACT_SENDING = 'CREATE_CONTACT_SENDING';
const CREATE_CONTACT_SENT = 'CREATE_CONTACT_SENT';
const CREATE_CONTACT_ERRORS = 'CREATE_CONTACT_ERRORS';

const reducer = (state, action) => {
  switch (action.type) {
    case CONTACT_LOAD:
      return {
        ...state,
        weatherStation: action.weatherStation,
        loading: false,
        loaded: true,
      };
    case CREATE_CONTACT_SENDING:
      return {
        ...state,
        sending: true,
      };
    case CREATE_CONTACT_SENT:
      return {
        ...state,
        sending: false,
        sent: true,
        errors: [],
      };
    case CREATE_CONTACT_ERRORS:
      return {
        ...state,
        errors: action.errors,
        sending: false,
      };
  }

  return state;
};

function loadWeatherStation(dispatch) {
  apiClient()
    .request(
      new Request(`/api/weatherStation/${DEFAULT_WEATHER_STATION_REFERENCE}`)
    )
    .then((response) => response.json())
    .then((data) => {
      dispatch({
        type: CONTACT_LOAD,
        weatherStation: data,
      });
    });
}

function sendContact(data, dispatch) {
  dispatch({
    type: CREATE_CONTACT_SENDING,
  });

  apiClient()
    .request(
      new Request(`/api/contact`, {
        method: 'POST',
        body: JSON.stringify({
          name: data.name,
          subject: data.subject,
          email: data.email,
          message: data.message,
        }),
      })
    )
    .then((response) => {
      if (response.ok) {
        dispatch({
          type: CREATE_CONTACT_SENT,
        });

        return;
      }

      return response.json().then((errors) => {
        dispatch({
          type: CREATE_CONTACT_ERRORS,
          errors: errors,
        });
      });
    });
}

function useContact() {
  const initialState = {
    weatherStation: null,
    loading: false,
    loaded: false,
    errors: [],
    sending: false,
    sent: false,
  };

  const [state, dispatch] = useReducer(reducer, initialState);

  useEffect(() => {
    loadWeatherStation(dispatch);
  }, []);

  return [state, dispatch];
}

export default function Contact(props) {
  const [state, dispatch] = useContact();

  return (
    <Fragment>
      <BreadCrumb text="Contact" />

      <div className="fullwidth-block">
        <div className="container">
          <div className="col-md-5">
            <div className="contact-details about-map">
              <div className="map">
                <Map
                  lat={state.weatherStation?.lat}
                  lng={state.weatherStation?.lng}
                />
              </div>
              <div className="contact-info">
                <address>
                  <img src={'/static/images/icon-marker.png'} alt="marker" />
                  <p>
                    Damiens Florent
                    <br />
                    Royat, 63130, France
                  </p>
                </address>

                <a>
                  <img
                    src={'/static/images/icon-envelope.png'}
                    alt="enveloppe"
                  />
                  damiens.florent[at]orange.fr
                </a>
              </div>
            </div>
          </div>
          <div className="col-md-6 col-md-offset-1 contact">
            <h2 className="section-title">Formulaire de contact</h2>
            <p>
              Vous avez une question sur l'utilisation de nos données ? Vous
              souhaitez intégrer notre réseau de stations météo ? Ou vous
              souhaitez juste contacter le développeur en charge du site ?
              Répondez au formulaire ci-dessous votre demande sera traitée
              rapidement !
            </p>

            {state.sent && (
              <div className="success-alert">Votre demande a été envoyée !</div>
            )}
            <ContactForm
              errors={state.errors}
              sending={state.sending}
              onSubmit={(data) => sendContact(data, dispatch)}
              initialValues={{ name: '', message: '', email: '', subject: '' }}
            />
          </div>
        </div>
      </div>
    </Fragment>
  );
}
