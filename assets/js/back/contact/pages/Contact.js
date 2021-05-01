import React, { Fragment, useEffect, useReducer } from 'react';
import BreadCrumb from '../../../common/components/BreadCrumb';
import { apiClient } from '../../../common/utils/apiClient';
import queryString from 'qs';
import ContactSearchResult from '../components/ContactSearchResult';

const CONTACT_LOAD = 'CONTACT_LOAD';
const CONTACT_CHANGE_PAGE = 'CONTACT_CHANGE_PAGE';

const reducer = (state, action) => {
  switch (action.type) {
    case CONTACT_LOAD:
      return {
        ...state,
        contacts: action.contacts.contacts,
        totalContact: action.contacts.numberOfResult,
        currentPage: action.currentPage,
        loading: false,
        loaded: true,
      };
    case CONTACT_CHANGE_PAGE:
      return {
        ...state,
        currentPage: parseInt(action.page),
      };
  }

  return state;
};

function loadContact(dispatch, currentPage = 1) {
  apiClient()
    .request(
      new Request(
        `/api/contact?${queryString.stringify({
          page: currentPage,
          order: 'DESC',
          maxResult: 5,
        })}`
      )
    )
    .then((response) => response.json())
    .then((data) => {
      dispatch({
        type: CONTACT_LOAD,
        contacts: data,
        currentPage: currentPage,
      });
    });
}

function deleteContact(id, dispatch) {
  apiClient()
    .request(
      new Request(`/api/contact/${id}`, {
        method: 'DELETE',
      })
    )
    .then((response) => {
      loadContact(dispatch);
    });
}

function useContact() {
  const initialState = {
    contacts: [],
    totalContact: 0,
    currentPage: 1,
    loading: false,
    loaded: false,
  };

  const [state, dispatch] = useReducer(reducer, initialState);

  useEffect(() => {
    loadContact(dispatch, state.currentPage);
  }, [state.currentPage]);

  return [state, dispatch];
}

export default function Contact(props) {
  const [state, dispatch] = useContact();

  return (
    <Fragment>
      <BreadCrumb url="/admin/dashboard" page="Dashboard" text="Message" />

      <div className="fullwidth-block padding-content">
        <div className="content col-md-8">
          <div className="post single">
            <h2 className="entry-title">Panel d'administration des messages</h2>
            <div className="featured-image">
              <img src={'/static/images/amboise.png'} alt="amboise" />
            </div>
            <div className="entry-content">
              <p>
                Panel d'administration des messages du site, accédez aux pages
                de listing, de création et de suppression de messages. Accédez
                également à toutes les autres pages d'administration du site.
              </p>
            </div>
          </div>

          <ContactSearchResult
            contacts={state.contacts}
            totalContact={state.totalContact}
            currentPage={state.currentPage}
            onChangePage={(page) =>
              dispatch({
                type: CONTACT_CHANGE_PAGE,
                page: page,
              })
            }
            onDelete={(id) => deleteContact(id, dispatch)}
          />
        </div>
      </div>
    </Fragment>
  );
}
