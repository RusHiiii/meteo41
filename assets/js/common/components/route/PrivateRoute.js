import React, { Fragment, useEffect, useReducer } from 'react';
import { Link, Redirect, Route } from 'react-router-dom';
import { useSelector } from 'react-redux';

export default function PrivateRoute({ component: Component, ...rest }) {
  const isConnected = useSelector((state) => state.user.connected);

  return (
    <Route
      {...rest}
      render={(props) => {
        return isConnected ? (
          <Component {...props} />
        ) : (
          <Redirect to="/login" />
        );
      }}
    />
  );
}
