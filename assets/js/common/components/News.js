import React, { Fragment, useEffect, useReducer } from 'react';
import apiClient from '../utils/apiClient';
import queryString from 'qs';
import { Date } from './Date';

const NEWS_LOAD = 'NEWS_LOAD';

const reducer = (state, action) => {
  switch (action.type) {
    case NEWS_LOAD:
      return {
        ...state,
        news: action.news,
        loading: false,
        loaded: true,
      };
  }

  return state;
};

function loadNews(dispatch) {
  apiClient
    .request(
      new Request(
        `/api/post?${queryString.stringify({
          maxResult: 3,
        })}`
      )
    )
    .then((response) => response.json())
    .then((data) => {
      dispatch({
        type: NEWS_LOAD,
        news: data.posts,
      });
    });
}

function useNewsQuery() {
  const initialState = {
    news: [],
    loading: false,
    loaded: false,
  };

  const [state, dispatch] = useReducer(reducer, initialState);

  useEffect(() => {
    loadNews(dispatch);
  }, []);

  return [state, dispatch];
}

export default function News(props) {
  const [state, dispatch] = useNewsQuery();

  return (
    <div className="fullwidth-block news" data-bg-color="#262936">
      <div className="container">
        <div className="row">
          {state.news.map((post, index) => (
            <div key={index} className="col-md-4">
              <div className="news">
                <div className="date">
                  <Date date={post.createdAt} format="MM/YYYY" />
                </div>
                <h3>
                  <a>{post.name}</a>
                </h3>
                <p>{post.description}</p>
              </div>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
}
