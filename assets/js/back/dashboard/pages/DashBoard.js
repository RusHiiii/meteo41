import React, { Fragment, useEffect, useReducer } from 'react';
import BreadCrumb from '../../../common/components/BreadCrumb';
import { Link } from 'react-router-dom';

export default function DashBoard(props) {
  return (
    <Fragment>
      <BreadCrumb text="Dashboard" />

      <div className="fullwidth-block padding-content">
        <div className="content col-md-8">
          <div className="post single">
            <h2 className="entry-title">Panel d'administration du site</h2>
            <div className="featured-image">
              <img src={'/static/images/amboise.png'} alt="amboise" />
            </div>
            <div className="entry-content">
              <p>
                Page d'administration du site, accédez aux pages de gestions des
                utilisateurs, des messages, des news, des stations météo, des
                observations et des unités. Il est possible d'ajouter,
                supprimer, et lister chacun des éléments.
              </p>
            </div>
          </div>
          <div className="col-md-6">
            <div className="photo">
              <div className="photo-details">
                <h3 className="photo-title">
                  <a>Utilisateurs</a>
                </h3>
                <p className="photo-text">Gestion des utilisateurs du site</p>
                <div className="photo-access">
                  <button className="button margin-right">Accéder</button>
                  <button className="button margin-left">Ajouter</button>
                </div>
              </div>
            </div>
            <div className="photo">
              <div className="photo-details">
                <h3 className="photo-title">
                  <a>News</a>
                </h3>
                <p className="photo-text">Gestion des news du site</p>
                <div className="photo-access">
                  <Link to="/admin/news" className="button margin-right">
                    Accéder
                  </Link>
                  <Link to="/admin/news/create" className="button margin-left">
                    Ajouter
                  </Link>
                </div>
              </div>
            </div>
            <div className="photo">
              <div className="photo-details">
                <h3 className="photo-title">
                  <a>Observations</a>
                </h3>
                <p className="photo-text">Gestion des observations du site</p>
                <div className="photo-access">
                  <Link to="/admin/observation" className="button margin-right">
                    Accéder
                  </Link>
                  <Link
                    to="/admin/observation/create"
                    className="button margin-right"
                  >
                    Ajouter
                  </Link>
                </div>
              </div>
            </div>
          </div>
          <div className="col-md-6">
            <div className="photo">
              <div className="photo-details">
                <h3 className="photo-title">
                  <a>Messages</a>
                </h3>
                <p className="photo-text">Gestion des messages du site</p>
                <div className="photo-access">
                  <Link to="/admin/contact" className="button margin-right">
                    Accéder
                  </Link>
                  <Link
                    to="/admin/contact/create"
                    className="button margin-right"
                  >
                    Ajouter
                  </Link>
                </div>
              </div>
            </div>
            <div className="photo">
              <div className="photo-details">
                <h3 className="photo-title">
                  <a>Stations météo</a>
                </h3>
                <p className="photo-text">Gestion des stations météo du site</p>
                <div className="photo-access">
                  <button className="button margin-right">Accéder</button>
                  <button className="button margin-left">Ajouter</button>
                </div>
              </div>
            </div>
            <div className="photo">
              <div className="photo-details">
                <h3 className="photo-title">
                  <a>Unités</a>
                </h3>
                <p className="photo-text">Gestion des unités du site</p>
                <div className="photo-access">
                  <Link to="/admin/unit" className="button margin-right">
                    Accéder
                  </Link>
                  <Link to="/admin/unit/create" className="button margin-right">
                    Ajouter
                  </Link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </Fragment>
  );
}
