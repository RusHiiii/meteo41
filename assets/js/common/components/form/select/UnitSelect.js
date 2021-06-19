import React, { Fragment, useEffect, useReducer } from 'react';
import { apiClient } from '../../../utils/apiClient';

const UNIT_LOAD = 'UNIT_LOAD';

const reducer = (state, action) => {
  switch (action.type) {
    case UNIT_LOAD:
      return {
        ...state,
        units: action.units,
        loading: false,
        loaded: true,
      };
  }

  return state;
};

function loadUnits(dispatch) {
  apiClient()
    .request(new Request(`/api/unit`))
    .then((response) => response.json())
    .then((data) => {
      dispatch({
        type: UNIT_LOAD,
        units: data.units,
      });
    });
}

function useUnitSelectQuery() {
  const initialState = {
    units: [],
    loading: false,
    loaded: false,
  };

  const [state, dispatch] = useReducer(reducer, initialState);

  useEffect(() => {
    loadUnits(dispatch);
  }, []);

  return [state, dispatch];
}

export default function UnitSelect(props) {
  const [state, dispatch] = useUnitSelectQuery();

  const handleInputChange = (evt) => {
    props.onChange(evt.target.value, evt.target.name);
  };

  return (
    <select
      className={props.className}
      value={props.value}
      name={props.name}
      onChange={handleInputChange}
    >
      {state.units.map((unit) => (
        <option key={unit.id} value={unit.type}>
          {unit.type}
        </option>
      ))}
    </select>
  );
}
