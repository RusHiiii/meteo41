import React, { Fragment, useEffect, useReducer } from 'react';
import Menu from '../../../common/components/Menu';
import BreadCrumb from '../../../common/components/BreadCrumb';

export default function NotFound(props) {
  return (
    <Fragment>
      <BreadCrumb url="/admin/dashboard" page="Dashboard" text="Erreur" />

      <div className="fullwidth-block padding-content">
        <div className="content col-md-8">
          <div className="post single">
            <h2 className="entry-title">Oops - Page non trouvée :(</h2>
            <div className="entry-content min-height-entry">
              <p>
                La page que vous demandez n'existe pas. Elle a peut-être été
                déplacée. Revenez vers l'accueil du dashboard pour accéder aux
                données.
              </p>
            </div>
          </div>
        </div>
      </div>
    </Fragment>
  );
}
