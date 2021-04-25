import React, { Fragment, useEffect, useReducer } from 'react';
import Footer from '../Footer';
import News from '../News';
import Informations from '../Informations';
import SummaryWeatherData from '../weather/SummaryWeatherData';
import AdminAccess from '../AdminAccess';

export default function AdminPageLayout(props) {
  return (
    <div className="site-content">
      <div className="fullwidth-block no-padding-top">
        <div className="container">
          <div className="row">
            {props.children}

            <SummaryWeatherData />

            <div className="sidebar col-md-3 col-md-offset-1">
              <AdminAccess />
            </div>
          </div>
        </div>
      </div>

      <News />

      <Informations />

      <Footer />
    </div>
  );
}
