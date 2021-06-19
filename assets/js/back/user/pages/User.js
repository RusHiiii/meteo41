import React, { Fragment, useEffect, useReducer } from 'react';
import BreadCrumb from '../../../common/components/BreadCrumb';
import { apiClient } from '../../../common/utils/apiClient';
import queryString from 'qs';
import UserSearchResult from '../components/UserSearchResult';

const USER_LOAD = 'USER_LOAD';
const USER_CHANGE_PAGE = 'USER_CHANGE_PAGE';

const reducer = (state, action) => {
  switch (action.type) {
    case USER_LOAD:
      return {
        ...state,
        users: action.users.users,
        totalUser: action.users.numberOfResult,
        currentPage: action.currentPage,
        loading: false,
        loaded: true,
      };
    case USER_CHANGE_PAGE:
      return {
        ...state,
        currentPage: parseInt(action.page),
      };
  }

  return state;
};

function loadUser(dispatch, currentPage = 1) {
  apiClient()
    .request(
      new Request(
        `/api/user?${queryString.stringify({
          page: currentPage,
          order: 'DESC',
          maxResult: 5,
        })}`
      )
    )
    .then((response) => response.json())
    .then((data) => {
      dispatch({
        type: USER_LOAD,
        users: data,
        currentPage: currentPage,
      });
    });
}

function deleteUser(id, dispatch) {
  apiClient()
    .request(
      new Request(`/api/user/${id}`, {
        method: 'DELETE',
      })
    )
    .then((response) => {
      loadUser(dispatch);
    });
}

function useUser() {
  const initialState = {
    users: [],
    totalUser: 0,
    currentPage: 1,
    loading: false,
    loaded: false,
  };

  const [state, dispatch] = useReducer(reducer, initialState);

  useEffect(() => {
    loadUser(dispatch, state.currentPage);
  }, [state.currentPage]);

  return [state, dispatch];
}

export default function User(props) {
  const [state, dispatch] = useUser();

  return (
    <Fragment>
      <BreadCrumb url="/admin/dashboard" page="Dashboard" text="Utilisateur" />

      <div className="fullwidth-block padding-content">
        <div className="content col-md-8">
          <div className="post single">
            <h2 className="entry-title">
              Panel d'administration des utilisateurs
            </h2>
            <div className="featured-image">
              <img src={'/static/images/amboise.png'} alt="amboise" />
            </div>
            <div className="entry-content">
              <p>
                Panel d'administration des utilisateurs du site, accédez aux
                pages de listing, de création et de suppression des
                utilisateurs. Accédez également à toutes les autres pages
                d'administration du site.
              </p>
            </div>
          </div>

          <UserSearchResult
            users={state.users}
            totalUser={state.totalUser}
            currentPage={state.currentPage}
            onChangePage={(page) =>
              dispatch({
                type: USER_CHANGE_PAGE,
                page: page,
              })
            }
            onDelete={(id) => deleteUser(id, dispatch)}
          />
        </div>
      </div>
    </Fragment>
  );
}
