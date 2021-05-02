import React, { Fragment, useEffect, useReducer } from 'react';
import SummaryWeatherData from '../weather/SummaryWeatherData';
import AdminAccess from '../AdminAccess';

export default function AdminPageLayout(props) {
  return (
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
  );
}
