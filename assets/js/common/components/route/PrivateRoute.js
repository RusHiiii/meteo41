import React, { Fragment, useEffect, useReducer } from 'react';
import { Link, Redirect, Route } from 'react-router-dom';
import { useSelector } from 'react-redux';
import { useHistoryManager } from '../../utils/hooks/useHistoryManager';
import { userIsAdmin } from '../../utils/hooks/security/userIsAdmin';

export default function PrivateRoute({ component: Component, ...rest }) {
  useHistoryManager({ ...rest });
  const isAdmin = userIsAdmin();
  const isConnected = useSelector((state) => state.user.connected);

  if (!isConnected) {
    return <Redirect to="/login" />;
  }

  const isAuthorized = rest.adminOnly ? isAdmin : true;

  if (!isAuthorized) {
    return <Redirect to="/admin/dashboard" />;
  }

  return <Route {...rest} render={(props) => <Component {...props} />} />;
}
