import React, { Fragment, useEffect, useReducer } from 'react';
import { Link, Redirect, Route } from 'react-router-dom';
import { useSelector } from 'react-redux';
import { useHistoryManager } from '../../utils/hooks/useHistoryManager';

export default function PrivateRoute({ component: Component, ...rest }) {
  const isConnected = useSelector((state) => state.user.connected);
  useHistoryManager({ ...rest });

  return (
    <Route
      {...rest}
      render={(props) => {
        return isConnected ? <Component {...props} /> : <Redirect to="/" />;
      }}
    />
  );
}
