import React, { Fragment, useEffect, useReducer } from 'react';
import { Link, useHistory } from 'react-router-dom';
import { USER_LOGOUT } from '../reducers/user';
import { cookieManager } from '../utils/cookieManager';
import { useDispatch } from 'react-redux';

function logout(history, dispatch) {
  cookieManager().remove('token');

  dispatch({
    type: USER_LOGOUT,
  });
}

export default function AdminAccess(props) {
  const dispatch = useDispatch();
  const history = useHistory();

  return (
    <div className="widget">
      <h3 className="widget-title">Accès rapide</h3>
      <ul className="arrow-list">
        <li>
          <Link to="/admin/user">Gestion des utilisateurs</Link>
        </li>
        <li>
          <Link to="/admin/contact">Gestion des messages</Link>
        </li>
        <li>
          <Link to="/admin/news">Gestion des news</Link>
        </li>
        <li>
          <Link to="/admin/weatherStation">Gestion des stations météo</Link>
        </li>
        <li>
          <Link to="/admin/unit">Gestion des unités</Link>
        </li>
        <li>
          <Link to="/admin/observation">Gestion des observations</Link>
        </li>
        <li>
          <a className="pointer" onClick={() => logout(history, dispatch)}>
            Se déconnecter
          </a>
        </li>
      </ul>
    </div>
  );
}
