import React, { Fragment, useEffect, useReducer } from 'react';
import { Link, Redirect, Route } from 'react-router-dom';
import { useSelector } from 'react-redux';
import { useHistoryManager } from '../../utils/hooks/useHistoryManager';

export default function PublicRoute({ component: Component, ...rest }) {
  const isConnected = useSelector((state) => state.user.connected);
  useHistoryManager({ ...rest });

  if (
    isConnected &&
    rest.path === '/login' &&
    rest.location.pathname === '/login'
  ) {
    return <Redirect to="/" />;
  }

  return <Route {...rest} render={(props) => <Component {...props} />} />;
}
