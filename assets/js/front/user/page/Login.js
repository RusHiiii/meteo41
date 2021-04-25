import React, { Fragment, useEffect, useReducer } from 'react';
import BreadCrumb from '../../../common/components/BreadCrumb';
import LoginForm from '../components/login/LoginForm';
import Menu from '../../../common/components/Menu';

export default function Login(props) {
  return (
    <Fragment>
      <Menu />

      <BreadCrumb text="Connexion" />

      <div className="fullwidth-block">
        <div className="container">
          <div className="row">
            <div className="col-lg-7 col-xs-12 margin-auto">
              <h2 className="section-title title-center">Identifiez-Vous</h2>

              <div className="entry-content">
                <LoginForm />
              </div>
            </div>
          </div>
        </div>
      </div>
    </Fragment>
  );
}
