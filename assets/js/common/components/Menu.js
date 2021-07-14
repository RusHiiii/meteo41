import React, { Fragment, useEffect, useReducer } from 'react';
import { Link, useHistory, useLocation, useParams } from 'react-router-dom';
import { useDispatch, useSelector } from 'react-redux';
import { WEATHER_STATION_CHANGE_LOCATION } from '../reducers/weatherStation';
import WeatherStationSelect from './form/select/WeatherStationSelect';
import {
  ROUTE_ABOUT,
  ROUTE_ADMIN_CONTACT,
  ROUTE_ADMIN_CONTACT_CREATE,
  ROUTE_ADMIN_CONTACT_EDIT,
  ROUTE_ADMIN_DASHBOARD,
  ROUTE_HOME,
  ROUTE_ADMIN_NEWS,
  ROUTE_ADMIN_NEWS_CREATE,
  ROUTE_ADMIN_NEWS_EDIT,
  ROUTE_ADMIN_UNIT,
  ROUTE_ADMIN_UNIT_CREATE,
  ROUTE_ADMIN_UNIT_EDIT,
  ROUTE_CONTACT,
  ROUTE_ADMIN_OBSERVATION,
  ROUTE_ADMIN_OBSERVATION_CREATE,
  ROUTE_ADMIN_WEATHER_STATION,
  ROUTE_ADMIN_WEATHER_STATION_CREATE,
  ROUTE_ADMIN_WEATHER_STATION_EDIT,
  ROUTE_ADMIN_USER,
  ROUTE_ADMIN_USER_CREATE,
  ROUTE_ADMIN_USER_EDIT,
  ROUTE_CURRENT_WEATHER_DATA,
  ROUTE_PERIOD_WEATHER_DATA, ROUTE_PERIOD_GRAPHIC,
} from '../constant';

const routeNameToActiveItem = (routeName) => {
  switch (routeName) {
    case ROUTE_HOME:
      return 'home';
    case ROUTE_CURRENT_WEATHER_DATA:
    case ROUTE_PERIOD_WEATHER_DATA:
      return 'weatherData';
    case ROUTE_PERIOD_GRAPHIC:
      return 'graphic';
    case ROUTE_CONTACT:
      return 'contact';
    case ROUTE_ADMIN_NEWS:
    case ROUTE_ADMIN_CONTACT:
    case ROUTE_ADMIN_UNIT:
    case ROUTE_ADMIN_CONTACT_EDIT:
    case ROUTE_ADMIN_CONTACT_CREATE:
    case ROUTE_ADMIN_NEWS_EDIT:
    case ROUTE_ADMIN_NEWS_CREATE:
    case ROUTE_ADMIN_UNIT_CREATE:
    case ROUTE_ADMIN_UNIT_EDIT:
    case ROUTE_ADMIN_DASHBOARD:
    case ROUTE_ADMIN_OBSERVATION:
    case ROUTE_ADMIN_OBSERVATION_CREATE:
    case ROUTE_ADMIN_WEATHER_STATION_CREATE:
    case ROUTE_ADMIN_WEATHER_STATION_EDIT:
    case ROUTE_ADMIN_WEATHER_STATION:
    case ROUTE_ADMIN_USER_CREATE:
    case ROUTE_ADMIN_USER_EDIT:
    case ROUTE_ADMIN_USER:
      return 'administration';
    case ROUTE_ABOUT:
      return 'about';
    default:
      return null;
  }
};

export default function Menu(props) {
  const dispatch = useDispatch();
  const isConnected = useSelector((state) => state.user.connected);
  const routeName = useSelector((state) => state.router.name);
  const reference = useSelector((state) => state.weatherStation.reference);

  const activeItemName = routeNameToActiveItem(routeName);

  return (
    <div className="site-header">
      <div className="container">
        <div className="branding">
          <Link to="/">
            <img src={'/static/images/logo.png'} alt="" className="logo" />
          </Link>
          <div className="logo-type">
            <WeatherStationSelect
              className="site-title select-weatherstation"
              onChange={(ref) =>
                dispatch({
                  type: WEATHER_STATION_CHANGE_LOCATION,
                  reference: ref,
                })
              }
              value={reference}
            />
            <small className="site-description">La météo du voisinage</small>
          </div>
        </div>

        <div className="main-navigation">
          <button type="button" className="menu-toggle">
            <i className="fa fa-bars" />
          </button>
        </div>

        <div id="custom-menu" className="main-navigation main-navigation-menu">
          <ul className="menu">
            <li
              className={`menu-item ${
                activeItemName === 'home' ? 'current-menu-item' : ''
              }`}
            >
              <Link to="/">Accueil</Link>
            </li>
            <li
              className={`menu-item ${
                activeItemName === 'weatherData' ? 'current-menu-item' : ''
              }`}
            >
              <Link to="/weather/current">Données</Link>
            </li>
            <li
              className={`menu-item ${
                activeItemName === 'graphic' ? 'current-menu-item' : ''
              }`}
            >
              <Link to="/graphic/history/daily">Graphiques</Link>
            </li>
            <li
              className={`menu-item ${
                activeItemName === 'about' ? 'current-menu-item' : ''
              }`}
            >
              <Link to="/about">A propos</Link>
            </li>
            <li
              className={`menu-item ${
                activeItemName === 'contact' ? 'current-menu-item' : ''
              }`}
            >
              <Link to="/contact">Contact</Link>
            </li>
            {isConnected && (
              <Fragment>
                <li
                  className={`menu-item ${
                    activeItemName === 'administration'
                      ? 'current-menu-item'
                      : ''
                  }`}
                >
                  <Link to="/admin/dashboard">Administration</Link>
                </li>
              </Fragment>
            )}
          </ul>
        </div>

        <div className="mobile-navigation" />
      </div>
    </div>
  );
}
