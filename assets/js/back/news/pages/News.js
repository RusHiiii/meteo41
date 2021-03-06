import React, { Fragment, useEffect, useReducer } from 'react';
import BreadCrumb from '../../../common/components/BreadCrumb';
import Menu from '../../../common/components/Menu';
import { apiClient } from '../../../common/utils/apiClient';
import queryString from 'qs';
import NewsSearchResult from '../components/NewsSearchResult';

const NEWS_LOAD = 'NEWS_LOAD';
const NEWS_CHANGE_PAGE = 'NEWS_CHANGE_PAGE';

const reducer = (state, action) => {
  switch (action.type) {
    case NEWS_LOAD:
      return {
        ...state,
        news: action.news.posts,
        totalNews: action.news.numberOfResult,
        currentPage: action.currentPage,
        loading: false,
        loaded: true,
      };
    case NEWS_CHANGE_PAGE:
      return {
        ...state,
        currentPage: parseInt(action.page),
      };
  }

  return state;
};

function loadNews(dispatch, currentPage = 1) {
  apiClient()
    .request(
      new Request(
        `/api/post?${queryString.stringify({
          page: currentPage,
          order: 'DESC',
          maxResult: 5,
        })}`
      )
    )
    .then((response) => response.json())
    .then((data) => {
      dispatch({
        type: NEWS_LOAD,
        news: data,
        currentPage: currentPage,
      });
    });
}

function deleteNews(id, dispatch) {
  apiClient()
    .request(
      new Request(`/api/post/${id}`, {
        method: 'DELETE',
      })
    )
    .then((response) => {
      loadNews(dispatch);
    });
}

function useNews() {
  const initialState = {
    news: [],
    totalNews: 0,
    currentPage: 1,
    loading: false,
    loaded: false,
  };

  const [state, dispatch] = useReducer(reducer, initialState);

  useEffect(() => {
    loadNews(dispatch, state.currentPage);
  }, [state.currentPage]);

  return [state, dispatch];
}

export default function News(props) {
  const [state, dispatch] = useNews();

  return (
    <Fragment>
      <BreadCrumb url="/admin/dashboard" page="Dashboard" text="News" />

      <div className="fullwidth-block padding-content">
        <div className="content col-md-8">
          <div className="post single">
            <h2 className="entry-title">Panel d'administration des news</h2>
            <div className="featured-image">
              <img src={'/static/images/amboise.png'} alt="amboise" />
            </div>
            <div className="entry-content">
              <p>
                Panel d'administration des news du site, accédez aux pages de
                listing, de création et de suppression de news. Accédez
                également à toutes les autres pages d'administration du site.
              </p>
            </div>
          </div>

          <NewsSearchResult
            news={state.news}
            totalNews={state.totalNews}
            currentPage={state.currentPage}
            onChangePage={(page) =>
              dispatch({
                type: NEWS_CHANGE_PAGE,
                page: page,
              })
            }
            onDelete={(id) => deleteNews(id, dispatch)}
          />
        </div>
      </div>
    </Fragment>
  );
}
