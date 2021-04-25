import React, { Fragment, useEffect, useReducer } from 'react';
import BreadCrumb from '../../../common/components/BreadCrumb';
import Menu from '../../../common/components/Menu';
import SummaryWeatherData from '../../../common/components/weather/SummaryWeatherData';
import { Link } from 'react-router-dom';

export default function DashBoard(props) {
  return (
    <Fragment>
      <Menu dashboard />

      <BreadCrumb text="Dashboard" />

      <div className="fullwidth-block">
        <div className="container">
          <div className="row">
            <div className="content col-md-8">
              <div className="post single">
                <h2 className="entry-title">Panel d'administration du site</h2>
                <div className="featured-image">
                  <img src={'/static/images/amboise.png'} alt="amboise" />
                </div>
                <div className="entry-content">
                  <p>
                    Page d'administration du site météo41, accédez aux pages de
                    gestions des utilisateurs, des messages, des news, des
                    stations météo, des observations et des unités. Il est
                    possible d'ajouter, supprimer, et lister chacun des
                    éléments.
                  </p>
                </div>
              </div>
              <div className="col-md-6 no-padding-left">
                <div className="photo">
                  <div className="photo-details">
                    <h3 className="photo-title">
                      <a>Utilisateurs</a>
                    </h3>
                    <p className="photo-text">
                      Gestion des utilisateurs du site
                    </p>
                    <div className="photo-access">
                      <a href="" className="button">
                        Accéder
                      </a>
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
                      <Link to="/admin/news" className="button">
                        Accéder
                      </Link>
                    </div>
                  </div>
                </div>
                <div className="photo">
                  <div className="photo-details">
                    <h3 className="photo-title">
                      <a>Observations</a>
                    </h3>
                    <p className="photo-text">
                      Gestion des observations du site
                    </p>
                    <div className="photo-access">
                      <a href="#" className="button">
                        Accéder
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <div className="col-md-6 no-padding-right">
                <div className="photo">
                  <div className="photo-details">
                    <h3 className="photo-title">
                      <a>Contacts</a>
                    </h3>
                    <p className="photo-text">Gestion des messages du site</p>
                    <div className="photo-access">
                      <a href="#" className="button">
                        Accéder
                      </a>
                    </div>
                  </div>
                </div>
                <div className="photo">
                  <div className="photo-details">
                    <h3 className="photo-title">
                      <a>Stations météo</a>
                    </h3>
                    <p className="photo-text">
                      Gestion des stations météo du site
                    </p>
                    <div className="photo-access">
                      <a href="#" className="button">
                        Accéder
                      </a>
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
                      <a href="#" className="button">
                        Accéder
                      </a>
                    </div>
                  </div>
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
