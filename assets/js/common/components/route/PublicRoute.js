import React, { Fragment, useEffect, useReducer } from 'react';
import { Link, Redirect, Route } from 'react-router-dom';
import { useSelector } from 'react-redux';

export default function PublicRoute({ component: Component, ...rest }) {
  const isConnected = useSelector((state) => state.user.connected);

  if (
    isConnected &&
    rest.path === '/login' &&
    rest.location.pathname !== '/login'
  ) {
    return <Redirect to="/" />;
  }

  return <Route exact {...rest} render={(props) => <Component {...props} />} />;
}
