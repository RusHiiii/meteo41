import React, { Fragment, useEffect, useReducer } from 'react';
import BreadCrumb from '../../../common/components/BreadCrumb';
import Menu from '../../../common/components/Menu';
import { apiClient } from '../../../common/utils/apiClient';
import queryString from 'qs';
import NewsSearchResult from '../components/NewsSearchResult';
import Input from '../../../common/components/form/Input';
import NewsForm from '../components/NewsForm';
import LoginForm from '../../../front/user/components/login/LoginForm';

const EDIT_NEWS_SENDING = 'EDIT_NEWS_SENDING';
const EDIT_NEWS_SENT = 'EDIT_NEWS_SENT';
const EDIT_NEWS_ERRORS = 'EDIT_NEWS_ERRORS';
const EDIT_NEWS_LOAD = 'EDIT_NEWS_LOAD';

const getInitialValues = (news) => {
  return {
    name: news.name,
    description: news.description,
  };
};

const reducer = (state, action) => {
  switch (action.type) {
    case EDIT_NEWS_SENDING:
      return {
        ...state,
        sending: true,
      };
    case EDIT_NEWS_LOAD:
      return {
        ...state,
        news: action.news,
        loaded: true,
      };
    case EDIT_NEWS_SENT:
      return {
        ...state,
        sending: false,
        sent: true,
        errors: [],
      };
    case EDIT_NEWS_ERRORS:
      return {
        ...state,
        errors: action.errors,
        sending: false,
      };
  }

  return state;
};

function updateNews(data, id, dispatch) {
  dispatch({
    type: EDIT_NEWS_SENDING,
  });

  apiClient()
    .request(
      new Request(`/api/post/${id}`, {
        method: 'PUT',
        body: JSON.stringify({
          description: data.description,
          name: data.name,
        }),
      })
    )
    .then((response) => {
      if (response.ok) {
        dispatch({
          type: EDIT_NEWS_SENT,
        });

        return;
      }

      return response.json().then((errors) => {
        dispatch({
          type: EDIT_NEWS_ERRORS,
          errors: errors,
        });
      });
    });
}

function loadNews(dispatch, id) {
  apiClient()
    .request(new Request(`/api/post/${id}`))
    .then((response) => response.json())
    .then((data) => {
      dispatch({
        type: EDIT_NEWS_LOAD,
        news: data,
      });
    });
}

function useEditNews(id) {
  const initialState = {
    errors: [],
    news: null,
    sending: false,
    sent: false,
    loaded: false,
    loading: false,
  };

  const [state, dispatch] = useReducer(reducer, initialState);

  useEffect(() => {
    loadNews(dispatch, id);
  }, []);

  return [state, dispatch];
}

export default function EditNews(props) {
  const [state, dispatch] = useEditNews(props.match.params.id);

  return (
    <Fragment>
      <Menu dashboard />

      <BreadCrumb url="/admin/dashboard" page="Dashboard" text="News" />

      <div className="fullwidth-block padding-content">
        <div className="content col-md-8">
          <div className="post single">
            <h2 className="entry-title">Edition d'une news</h2>
            <div className="featured-image">
              <img src={'/static/images/amboise.png'} alt="amboise" />
            </div>
          </div>

          <div className="entry-content">
            {state.sent && (
              <div className="success-alert">La news a été modifié !</div>
            )}

            {state.loaded && (
              <NewsForm
                errors={state.errors}
                sending={state.sending}
                onSubmit={(data) => updateNews(data, state.news.id, dispatch)}
                initialValues={getInitialValues(state.news)}
              />
            )}
          </div>
        </div>
      </div>
    </Fragment>
  );
}
