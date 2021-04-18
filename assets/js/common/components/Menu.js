import React, { Fragment, useEffect, useReducer } from 'react';
import { Link, useHistory } from 'react-router-dom';
import { useDispatch, useSelector } from 'react-redux';
import apiClient from '../utils/apiClient';
import tokenRepository from '../utils/tokenRepository';
import { USER_LOGOUT } from '../reducers/user';

function logout(history, dispatch) {
  apiClient.request(new Request(`/api/logout`)).then(() => {
    tokenRepository.removeToken();
    dispatch({
      type: USER_LOGOUT,
    });
    history.push('/login');
  });
}

export default function Menu(props) {
  const history = useHistory();
  const dispatch = useDispatch();
  const isConnected = useSelector((state) => state.user.connected);

  return (
    <div className="site-header">
      <div className="container">
        <Link to="/" className="branding">
          <img src="/static/images/logo.png" alt="" className="logo" />
          <div className="logo-type">
            <h1 className="site-title">Saint Sulpice</h1>
            <small className="site-description">La météo du voisinage</small>
          </div>
        </Link>

        <div className="main-navigation">
          <button type="button" className="menu-toggle">
            <i className="fa fa-bars"></i>
          </button>
          <ul className="menu">
            <li
              className={`menu-item ${props.home ? 'current-menu-item' : ''}`}
            >
              <Link to="/">Accueil</Link>
            </li>
            <li className="menu-item">
              <a href="obs.html">Données</a>
            </li>
            <li className="menu-item">
              <a href="live-cameras.html">Graphiques</a>
            </li>
            <li className="menu-item">
              <a href="a-propos.html">A propos</a>
            </li>
            <li className="menu-item">
              <a href="contact.html">Contact</a>
            </li>
            {isConnected && (
              <Fragment>
                <li className={`menu-item ${props.dashboard ? 'current-menu-item' : ''}`}>
                  <Link to="/admin/dashboard">Administration</Link>
                </li>
              </Fragment>
            )}
          </ul>
        </div>

        <div className="mobile-navigation"></div>
      </div>
    </div>
  );
}
