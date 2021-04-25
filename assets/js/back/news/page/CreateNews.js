import React, { Fragment, useEffect, useReducer } from 'react';
import BreadCrumb from '../../../common/components/BreadCrumb';
import Menu from '../../../common/components/Menu';
import { apiClient } from '../../../common/utils/apiClient';
import queryString from 'qs';
import NewsSearchResult from '../components/NewsSearchResult';
import Input from '../../../common/components/form/Input';
import NewsForm from '../components/NewsForm';
import LoginForm from '../../../front/user/components/login/LoginForm';

const CREATE_NEWS_SENDING = 'CREATE_NEWS_SENDING';
const CREATE_NEWS_SENT = 'CREATE_NEWS_SENT';
const CREATE_NEWS_ERRORS = 'CREATE_NEWS_ERRORS';

const reducer = (state, action) => {
  switch (action.type) {
    case CREATE_NEWS_SENDING:
      return {
        ...state,
        sending: true,
      };
    case CREATE_NEWS_SENT:
      return {
        ...state,
        sending: false,
        sent: true,
        errors: [],
      };
    case CREATE_NEWS_ERRORS:
      return {
        ...state,
        errors: action.errors,
        sending: false,
      };
  }

  return state;
};

function sendNews(data, dispatch) {
  dispatch({
    type: CREATE_NEWS_SENDING,
  });

  apiClient()
    .request(
      new Request(`/api/post`, {
        method: 'POST',
        body: JSON.stringify({
          description: data.description,
          name: data.name,
        }),
      })
    )
    .then((response) => {
      if (response.ok) {
        dispatch({
          type: CREATE_NEWS_SENT,
        });

        return;
      }

      return response.json().then((errors) => {
        dispatch({
          type: CREATE_NEWS_ERRORS,
          errors: errors,
        });
      });
    });
}

function useCreateNews() {
  const initialState = {
    errors: [],
    sending: false,
    sent: false,
  };

  return useReducer(reducer, initialState);
}

export default function CreateNews(props) {
  const [state, dispatch] = useCreateNews();

  return (
    <Fragment>
      <Menu dashboard />

      <BreadCrumb url="/admin/dashboard" page="Dashboard" text="News" />

      <div className="fullwidth-block padding-content">
        <div className="content col-md-8">
          <div className="post single">
            <h2 className="entry-title">Ajout d'une news</h2>
            <div className="featured-image">
              <img src={'/static/images/amboise.png'} alt="amboise" />
            </div>
          </div>

          <div className="entry-content">
            {state.sent && (
              <div className="success-alert">La news a été ajouté !</div>
            )}

            <NewsForm
              errors={state.errors}
              sending={state.sending}
              onSubmit={(data) => sendNews(data, dispatch)}
              initialValues={{ name: '', description: '' }}
            />
          </div>
        </div>
      </div>
    </Fragment>
  );
}
