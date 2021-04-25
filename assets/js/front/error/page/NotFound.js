import React, { Fragment, useEffect, useReducer } from 'react';
import Menu from '../../../common/components/Menu';
import BreadCrumb from '../../../common/components/BreadCrumb';
import SummaryWeatherData from '../../../common/components/weather/SummaryWeatherData';

export default function NotFound(props) {
  return (
    <Fragment>
      <Menu home />

      <BreadCrumb text="Erreur" />

      <div className="fullwidth-block">
        <div className="container">
          <div className="row">
            <div className="content col-md-8">
              <div className="post single">
                <h2 className="entry-title">Oops - Page non trouvée :(</h2>
                <div className="entry-content">
                  <p>
                    La page que vous demandez n'existe pas. Elle a peut-être été
                    déplacée. Revenez vers l'accueil pour accéder aux données.
                  </p>
                </div>
              </div>
            </div>

            <SummaryWeatherData />
          </div>
        </div>
      </div>
    </Fragment>
  );
}
