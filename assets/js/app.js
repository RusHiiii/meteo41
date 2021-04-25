import React from 'react';
import ReactDOM from 'react-dom';

import { Provider } from 'react-redux';
import { BrowserRouter as Router, Switch } from 'react-router-dom';
import createStore from './common/createStore';
import Login from './back/user/page/Login';
import NotFound from './front/error/page/NotFound';
import PrivateRoute from './common/components/route/PrivateRoute';
import PublicRoute from './common/components/route/PublicRoute';
import DashBoard from './back/dashboard/page/DashBoard';
import Home from './front/home/page/Home';
import PageLayout from './common/components/layout/PageLayout';
import News from './back/news/page/News';

export const store = createStore();

// https://dev.to/xavivzla/react-router-v5-multiple-layouts-4fo4

ReactDOM.render(
  <Provider store={store}>
    <Router>
      <PageLayout>
        <Switch>
          <PrivateRoute exact path="/admin/dashboard" component={DashBoard} />
          <PrivateRoute exact path="/admin/news" component={News} />

          <PublicRoute exact path="/login" component={Login} />
          <PublicRoute exact path="/" component={Home} />
          <PublicRoute component={NotFound} />
        </Switch>
      </PageLayout>
    </Router>
  </Provider>,
  document.getElementById('root')
);
