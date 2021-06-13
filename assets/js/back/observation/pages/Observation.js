import React, { Fragment, useEffect, useReducer } from 'react';
import BreadCrumb from '../../../common/components/BreadCrumb';
import { apiClient } from '../../../common/utils/apiClient';
import queryString from 'qs';
import ObservationSearchResult from '../components/ObservationSearchResult';

const OBSERVATION_LOAD = 'OBSERVATION_LOAD';
const OBSERVATION_CHANGE_PAGE = 'OBSERVATION_CHANGE_PAGE';

const reducer = (state, action) => {
  switch (action.type) {
    case OBSERVATION_LOAD:
      return {
        ...state,
        observations: action.observations.observations,
        totalObservation: action.observations.numberOfResult,
        currentPage: action.currentPage,
        loading: false,
        loaded: true,
      };
    case OBSERVATION_CHANGE_PAGE:
      return {
        ...state,
        currentPage: parseInt(action.page),
      };
  }

  return state;
};

function loadObservation(dispatch, currentPage = 1) {
  apiClient()
    .request(
      new Request(
        `/api/observation?${queryString.stringify({
          page: currentPage,
          order: 'DESC',
          maxResult: 5,
        })}`
      )
    )
    .then((response) => response.json())
    .then((data) => {
      dispatch({
        type: OBSERVATION_LOAD,
        observations: data,
        currentPage: currentPage,
      });
    });
}

function deleteObservation(id, dispatch) {
  apiClient()
    .request(
      new Request(`/api/observation/${id}`, {
        method: 'DELETE',
      })
    )
    .then((response) => {
      loadObservation(dispatch);
    });
}

function useObservation() {
  const initialState = {
    observations: [],
    totalObservation: 0,
    currentPage: 1,
    loading: false,
    loaded: false,
  };

  const [state, dispatch] = useReducer(reducer, initialState);

  useEffect(() => {
    loadObservation(dispatch, state.currentPage);
  }, [state.currentPage]);

  return [state, dispatch];
}

export default function Observation(props) {
  const [state, dispatch] = useObservation();

  return (
    <Fragment>
      <BreadCrumb url="/admin/dashboard" page="Dashboard" text="Observation" />

      <div className="fullwidth-block padding-content">
        <div className="content col-md-8">
          <div className="post single">
            <h2 className="entry-title">Panel d'administration des observations</h2>
            <div className="featured-image">
              <img src={'/static/images/amboise.png'} alt="amboise" />
            </div>
            <div className="entry-content">
              <p>
                Panel d'administration des observations du site, accédez aux pages de
                listing, de création et de suppression des observations. Accédez
                également à toutes les autres pages d'administration du site.
              </p>
            </div>
          </div>

          <ObservationSearchResult
            observations={state.observations}
            totalObservation={state.totalObservation}
            currentPage={state.currentPage}
            onChangePage={(page) =>
              dispatch({
                type: OBSERVATION_CHANGE_PAGE,
                page: page,
              })
            }
            onDelete={(id) => deleteObservation(id, dispatch)}
          />
        </div>
      </div>
    </Fragment>
  );
}
