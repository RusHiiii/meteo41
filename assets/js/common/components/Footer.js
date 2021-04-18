import React, { Fragment, useEffect, useReducer } from 'react';
import { Link } from 'react-router-dom';

export default function Footer(props) {
  return (
    <footer className="site-footer">
      <div className="container">
        <div className="row">
          <div className="col-md-8">
            <p className="colophon">
              Copyright © 2020 - Tous droits réservés. Florent Damiens - Themezy
            </p>
          </div>
          <div className="col-md-3 col-md-offset-1">
            <div className="social-links">
              <a href="https://twitter.com/RusHiiiiiiii">
                <i className="fa fa-twitter"></i>
              </a>
              <a href="https://github.com/RusHiiii">
                <i className="fa fa-github"></i>
              </a>
              <a href="https://www.linkedin.com/in/florent-damiens-939a49164/">
                <i className="fa fa-linkedin"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </footer>
  );
}
