import { useEffect, useState } from 'react';
import { useLocation } from 'react-router-dom';
import { useDispatch } from 'react-redux';
import { ROUTER_CHANGE } from '../../reducers/router';

export const useHistoryManager = (props) => {
  const location = useLocation();
  const dispatch = useDispatch();

  useEffect(() => {
    dispatch({
      type: ROUTER_CHANGE,
      location: location,
      name: props.name,
    });
  }, [location]);
};
