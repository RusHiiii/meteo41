import React, { Fragment, useEffect, useReducer } from 'react';
import BreadCrumb from '../../../common/components/BreadCrumb';
import PageLayout from '../../../common/components/layout/PageLayout';

export default function DashBoard(props) {
  return (
    <PageLayout dashboard>
      <BreadCrumb text="Dashboard" />

      <div className="fullwidth-block">
        <div className="container">
          <div className="row">
            <div className="content col-md-8">
              <div className="post single">
                <h2 className="entry-title">Panel d'administration du site</h2>
                <div className="featured-image">
                  <img src="/static/images/amboise.png" alt="" />
                </div>
                <div className="entry-content">
                  <p>
                    La station météo utilisée est une La Crosse Technology
                    (WS2357), et ces pages sont mises à jour aux 10 minutes. Je
                    possède cette station depuis Mars 2012. Toutes les données
                    sont transmises sur d'autres sites. Les données météo de
                    cette station débute à minuit.
                  </p>
                </div>
              </div>
              <div className="col-md-6 no-padding-left">
                <div className="photo">
                  <div className="photo-details">
                    <h3 className="photo-title">
                      <a href="#">Utilisateurs</a>
                    </h3>
                    <p className="photo-text">
                      Gestion des utilisateurs du site
                    </p>
                    <div className="photo-access">
                      <a href="admin-user.html" className="button">
                        Accéder
                      </a>
                    </div>
                  </div>
                </div>
                <div className="photo">
                  <div className="photo-details">
                    <h3 className="photo-title">
                      <a href="#">News</a>
                    </h3>
                    <p className="photo-text">Gestion des news du site</p>
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
                      <a href="#">Observations</a>
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
                      <a href="#">Contacts</a>
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
                      <a href="#">Stations météo</a>
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
                      <a href="#">Unités</a>
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
            <div className="sidebar col-md-3 col-md-offset-1">
              <div className="widget current-weather-data">
                <h3 className="widget-title">Données actuelle</h3>
                <ul>
                  <li>
                    <h3 className="entry-title">
                      <a href="#">Température</a>
                    </h3>
                    <div className="current">
                      <span>
                        <i className="wi wi-thermometer-exterior"></i>
                      </span>
                      <strong>23.5</strong>°C
                    </div>
                  </li>
                  <li>
                    <h3 className="entry-title">
                      <a href="#">Pression atmosphérique</a>
                    </h3>
                    <div className="current">
                      <span>
                        <i className="fa fa-tachometer"></i>
                      </span>
                      <strong>1025</strong>hPa
                    </div>
                  </li>
                  <li>
                    <h3 className="entry-title">
                      <a href="#">Vent moyen</a>
                    </h3>
                    <div className="current">
                      <span>
                        <i className="wi wi-wind towards-121-deg"></i>
                      </span>
                      <strong>12.5</strong>km/h
                    </div>
                  </li>
                  <li>
                    <h3 className="entry-title">
                      <a href="#">Humidité</a>
                    </h3>
                    <div className="current">
                      <span>
                        <i className="wi wi-barometer"></i>
                      </span>
                      <strong>75</strong>%
                    </div>
                  </li>
                  <li className="text-align-right">Mise à jour à 13h31</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </PageLayout>
  );
}
