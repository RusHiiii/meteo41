import React from 'react';
import ReactDOM from 'react-dom';

import { Provider } from 'react-redux';
import { BrowserRouter as Router, Route, Switch } from 'react-router-dom';
import createStore from './common/createStore';
import Login from './front/user/pages/Login';
import PrivateRoute from './common/components/route/PrivateRoute';
import PublicRoute from './common/components/route/PublicRoute';
import DashBoard from './back/dashboard/pages/DashBoard';
import Home from './front/home/pages/Home';
import PageLayout from './common/components/layout/PageLayout';
import News from './back/news/pages/News';
import AdminPageLayout from './common/components/layout/AdminPageLayout';
import NotFoundAdmin from './back/error/pages/NotFound';
import NotFound from './front/error/pages/NotFound';
import CreateNews from './back/news/pages/CreateNews';
import EditNews from './back/news/pages/EditNews';
import {
  ROUTE_ABOUT,
  ROUTE_ADMIN_CONTACT,
  ROUTE_ADMIN_CONTACT_CREATE,
  ROUTE_ADMIN_CONTACT_EDIT,
  ROUTE_ADMIN_DASHBOARD,
  ROUTE_HOME,
  ROUTE_LOGIN,
  ROUTE_ADMIN_NEWS,
  ROUTE_ADMIN_NEWS_CREATE,
  ROUTE_ADMIN_NEWS_EDIT,
  ROUTE_NOT_FOUND,
  ROUTE_ADMIN_UNIT,
  ROUTE_ADMIN_UNIT_CREATE,
  ROUTE_ADMIN_UNIT_EDIT,
  ROUTE_CONTACT,
  ROUTE_ADMIN_OBSERVATION,
  ROUTE_ADMIN_OBSERVATION_CREATE,
  ROUTE_ADMIN_OBSERVATION_EDIT,
  ROUTE_ADMIN_WEATHER_STATION,
  ROUTE_ADMIN_WEATHER_STATION_CREATE,
  ROUTE_ADMIN_WEATHER_STATION_EDIT,
  ROUTE_ADMIN_USER,
  ROUTE_ADMIN_USER_CREATE,
  ROUTE_ADMIN_USER_EDIT,
  ROUTE_CURRENT_WEATHER_DATA,
  ROUTE_PERIOD_WEATHER_DATA, ROUTE_PERIOD_GRAPHIC,
} from './common/constant';
import About from './front/information/pages/About';
import ContactAdmin from './back/contact/pages/Contact';
import CreateContact from './back/contact/pages/CreateContact';
import EditContact from './back/contact/pages/EditContact';
import Unit from './back/unit/pages/Unit';
import CreateUnit from './back/unit/pages/CreateUnit';
import EditUnit from './back/unit/pages/EditUnit';
import Contact from './front/information/pages/Contact';
import Observation from './back/observation/pages/Observation';
import ObservationSearchResult from './back/observation/components/ObservationSearchResult';
import CreateObservation from './back/observation/pages/CreateObservation';
import EditObservation from './back/observation/pages/EditObservation';
import WeatherStation from './back/weatherStation/pages/WeatherStation';
import CreateWeatherStation from './back/weatherStation/pages/CreateWeatherStation';
import EditWeatherStation from './back/weatherStation/pages/EditWeatherStation';
import User from './back/user/pages/User';
import CreateUser from './back/user/pages/CreateUser';
import EditUser from './back/user/pages/EditUser';
import CurrentWeatherData from './front/weatherData/pages/CurrentWeatherData';
import PeriodWeatherData from './front/weatherData/pages/PeriodWeatherData';
import ScrollToTop from "./common/components/ScrollToTop";
import PeriodGraphic from "./front/graphic/pages/PeriodGraphic";

export const store = createStore();

// https://dev.to/xavivzla/react-router-v5-multiple-layouts-4fo4

ReactDOM.render(
  <Provider store={store}>
    <Router>
      <ScrollToTop />
      <PageLayout>
        <Switch>
          <Route path="/admin/:path">
            <AdminPageLayout>
              <Switch>
                <PrivateRoute
                  exact
                  name={ROUTE_ADMIN_DASHBOARD}
                  path="/admin/dashboard"
                  component={DashBoard}
                />
                <PrivateRoute
                  exact
                  adminOnly
                  name={ROUTE_ADMIN_USER_EDIT}
                  path="/admin/user/edit/:id"
                  component={EditUser}
                />
                <PrivateRoute
                  exact
                  adminOnly
                  name={ROUTE_ADMIN_USER_CREATE}
                  path="/admin/user/create"
                  component={CreateUser}
                />
                <PrivateRoute
                  exact
                  name={ROUTE_ADMIN_USER}
                  path="/admin/user"
                  component={User}
                />
                <PrivateRoute
                  exact
                  adminOnly
                  name={ROUTE_ADMIN_WEATHER_STATION_EDIT}
                  path="/admin/weatherStation/edit/:reference"
                  component={EditWeatherStation}
                />
                <PrivateRoute
                  exact
                  adminOnly
                  name={ROUTE_ADMIN_WEATHER_STATION_CREATE}
                  path="/admin/weatherStation/create"
                  component={CreateWeatherStation}
                />
                <PrivateRoute
                  exact
                  name={ROUTE_ADMIN_WEATHER_STATION}
                  path="/admin/weatherStation"
                  component={WeatherStation}
                />
                <PrivateRoute
                  exact
                  name={ROUTE_ADMIN_OBSERVATION_CREATE}
                  path="/admin/observation/create"
                  component={CreateObservation}
                />
                <PrivateRoute
                  exact
                  name={ROUTE_ADMIN_OBSERVATION_EDIT}
                  path="/admin/observation/edit/:id"
                  component={EditObservation}
                />
                <PrivateRoute
                  exact
                  name={ROUTE_ADMIN_OBSERVATION}
                  path="/admin/observation"
                  component={Observation}
                />
                <PrivateRoute
                  exact
                  adminOnly
                  name={ROUTE_ADMIN_UNIT_CREATE}
                  path="/admin/unit/create"
                  component={CreateUnit}
                />
                <PrivateRoute
                  exact
                  adminOnly
                  name={ROUTE_ADMIN_UNIT_EDIT}
                  path="/admin/unit/edit/:id"
                  component={EditUnit}
                />
                <PrivateRoute
                  exact
                  name={ROUTE_ADMIN_UNIT}
                  path="/admin/unit"
                  component={Unit}
                />
                <PrivateRoute
                  exact
                  name={ROUTE_ADMIN_NEWS_CREATE}
                  path="/admin/news/create"
                  component={CreateNews}
                />
                <PrivateRoute
                  exact
                  name={ROUTE_ADMIN_NEWS_EDIT}
                  path="/admin/news/edit/:id"
                  component={EditNews}
                />
                <PrivateRoute
                  exact
                  name={ROUTE_ADMIN_NEWS}
                  path="/admin/news"
                  component={News}
                />
                <PrivateRoute
                  exact
                  name={ROUTE_ADMIN_CONTACT_EDIT}
                  path="/admin/contact/edit/:id"
                  component={EditContact}
                />
                <PrivateRoute
                  exact
                  name={ROUTE_ADMIN_CONTACT_CREATE}
                  path="/admin/contact/create"
                  component={CreateContact}
                />
                <PrivateRoute
                  exact
                  name={ROUTE_ADMIN_CONTACT}
                  path="/admin/contact"
                  component={ContactAdmin}
                />
                <PrivateRoute
                  name={ROUTE_NOT_FOUND}
                  component={NotFoundAdmin}
                />
              </Switch>
            </AdminPageLayout>
          </Route>

          <Route>
            <Switch>
              <PublicRoute
                exact
                name={ROUTE_PERIOD_WEATHER_DATA}
                path="/weather/history/:period(daily|weekly|monthly|yearly|record)"
                component={PeriodWeatherData}
              />
              <PublicRoute
                exact
                name={ROUTE_PERIOD_GRAPHIC}
                path="/graphic/history/:period(daily|weekly|monthly|yearly)"
                component={PeriodGraphic}
              />
              <PublicRoute
                exact
                name={ROUTE_CURRENT_WEATHER_DATA}
                path="/weather/current"
                component={CurrentWeatherData}
              />
              <PublicRoute
                exact
                name={ROUTE_ABOUT}
                path="/about"
                component={About}
              />
              <PublicRoute
                exact
                name={ROUTE_CONTACT}
                path="/contact"
                component={Contact}
              />
              <PublicRoute
                exact
                name={ROUTE_LOGIN}
                path="/login"
                component={Login}
              />
              <PublicRoute exact name={ROUTE_HOME} path="/" component={Home} />
              <PublicRoute name={ROUTE_NOT_FOUND} component={NotFound} />
            </Switch>
          </Route>
        </Switch>
      </PageLayout>
    </Router>
  </Provider>,
  document.getElementById('root')
);
