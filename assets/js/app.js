import React from 'react';
import ReactDOM from 'react-dom';

import { Provider } from 'react-redux';
import { BrowserRouter as Router, Route, Switch } from 'react-router-dom';
import createStore from './common/createStore';
import Login from './front/user/page/Login';
import PrivateRoute from './common/components/route/PrivateRoute';
import PublicRoute from './common/components/route/PublicRoute';
import DashBoard from './back/dashboard/page/DashBoard';
import Home from './front/home/page/Home';
import PageLayout from './common/components/layout/PageLayout';
import News from './back/news/page/News';
import AdminPageLayout from './common/components/layout/AdminPageLayout';
import NotFoundAdmin from './back/error/page/NotFound';
import NotFound from './front/error/page/NotFound';
import CreateNews from './back/news/page/CreateNews';
import EditNews from './back/news/page/EditNews';
import ScrollToTop from "./common/ScrollToTop";

export const store = createStore();

// https://dev.to/xavivzla/react-router-v5-multiple-layouts-4fo4

ReactDOM.render(
  <Provider store={store}>
    <Router>
      <ScrollToTop />
      <Switch>
        <Route path="/admin/:path">
          <AdminPageLayout>
            <Switch>
              <PrivateRoute
                exact
                path="/admin/dashboard"
                component={DashBoard}
              />

              <PrivateRoute
                exact
                path="/admin/news/create"
                component={CreateNews}
              />
              <PrivateRoute
                exact
                path="/admin/news/edit/:id"
                component={EditNews}
              />
              <PrivateRoute exact path="/admin/news" component={News} />

              <PrivateRoute component={NotFoundAdmin} />
            </Switch>
          </AdminPageLayout>
        </Route>

        <Route>
          <PageLayout>
            <Switch>
              <PublicRoute exact path="/login" component={Login} />
              <PublicRoute exact path="/" component={Home} />

              <PublicRoute component={NotFound} />
            </Switch>
          </PageLayout>
        </Route>
      </Switch>
    </Router>
  </Provider>,
  document.getElementById('root')
);
