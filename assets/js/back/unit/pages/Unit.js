import React, { Fragment, useEffect, useReducer } from 'react';
import BreadCrumb from '../../../common/components/BreadCrumb';
import { apiClient } from '../../../common/utils/apiClient';
import queryString from 'qs';
import UnitSearchResult from '../components/UnitSearchResult';

const UNIT_LOAD = 'UNIT_LOAD';
const UNIT_CHANGE_PAGE = 'UNIT_CHANGE_PAGE';

const reducer = (state, action) => {
  switch (action.type) {
    case UNIT_LOAD:
      return {
        ...state,
        units: action.units.units,
        totalUnit: action.units.numberOfResult,
        currentPage: action.currentPage,
        loading: false,
        loaded: true,
      };
    case UNIT_CHANGE_PAGE:
      return {
        ...state,
        currentPage: parseInt(action.page),
      };
  }

  return state;
};

function loadUnit(dispatch, currentPage = 1) {
  apiClient()
    .request(
      new Request(
        `/api/unit?${queryString.stringify({
          page: currentPage,
          order: 'DESC',
          maxResult: 5,
        })}`
      )
    )
    .then((response) => response.json())
    .then((data) => {
      dispatch({
        type: UNIT_LOAD,
        units: data,
        currentPage: currentPage,
      });
    });
}

function deleteUnit(id, dispatch) {
  apiClient()
    .request(
      new Request(`/api/unit/${id}`, {
        method: 'DELETE',
      })
    )
    .then((response) => {
      loadUnit(dispatch);
    });
}

function useUnit() {
  const initialState = {
    units: [],
    totalUnit: 0,
    currentPage: 1,
    loading: false,
    loaded: false,
  };

  const [state, dispatch] = useReducer(reducer, initialState);

  useEffect(() => {
    loadUnit(dispatch, state.currentPage);
  }, [state.currentPage]);

  return [state, dispatch];
}

export default function Unit(props) {
  const [state, dispatch] = useUnit();

  return (
    <Fragment>
      <BreadCrumb url="/admin/dashboard" page="Dashboard" text="Unité" />

      <div className="fullwidth-block padding-content">
        <div className="content col-md-8">
          <div className="post single">
            <h2 className="entry-title">Panel d'administration des unités</h2>
            <div className="featured-image">
              <img src={'/static/images/amboise.png'} alt="amboise" />
            </div>
            <div className="entry-content">
              <p>
                Panel d'administration des unités du site, accédez aux pages de
                listing, de création et de suppression de messages. Accédez
                également à toutes les autres pages d'administration du site.
              </p>
            </div>
          </div>

          <UnitSearchResult
            units={state.units}
            totalUnit={state.totalUnit}
            currentPage={state.currentPage}
            onChangePage={(page) =>
              dispatch({
                type: UNIT_CHANGE_PAGE,
                page: page,
              })
            }
            onDelete={(id) => deleteUnit(id, dispatch)}
          />
        </div>
      </div>
    </Fragment>
  );
}
