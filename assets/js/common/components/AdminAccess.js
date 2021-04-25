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
          <a href="">Gestion des utilisateurs</a>
        </li>
        <li>
          <a href="">Gestion des contacts</a>
        </li>
        <li>
          <Link to="/admin/news">Gestion des news</Link>
        </li>
        <li>
          <a href="">Gestion des stations météo</a>
        </li>
        <li>
          <a href="">Gestion des unités</a>
        </li>
        <li>
          <a href="">Gestion des observations</a>
        </li>
        <li>
          <a href="" onClick={() => logout(history, dispatch)}>
            Se déconnecter
          </a>
        </li>
      </ul>
    </div>
  );
}
