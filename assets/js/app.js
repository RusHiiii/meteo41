import React from 'react';
import ReactDOM from 'react-dom';

import { Provider } from 'react-redux';
import {
  BrowserRouter as Router,
  Redirect,
  Route,
  Switch,
} from 'react-router-dom';
import createStore from './common/createStore';
import Login from './back/user/page/Login';
import NotFound from './front/error/page/NotFound';
import history from './common/utils/history';
import PrivateRoute from './common/components/route/PrivateRoute';
import PublicRoute from './common/components/route/PublicRoute';
import DashBoard from './back/dashboard/page/DashBoard';
import Home from './front/home/page/Home';

export const store = createStore();

ReactDOM.render(
  <Provider store={store}>
    <Router history={history}>
      <Switch>
        <PublicRoute exact path="/" component={Home} />

        <PrivateRoute exact path="/admin/dashboard" component={DashBoard} />

        <PublicRoute exact path="/login" component={Login} />
        <PublicRoute component={NotFound} />
      </Switch>
    </Router>
  </Provider>,
  document.getElementById('root')
);
