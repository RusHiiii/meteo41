import React, { Fragment, useEffect, useReducer } from 'react';
import { Link } from 'react-router-dom';

export default function Footer(props) {
  return (
    <footer className="site-footer">
      <div className="container">
        <div className="row">
          <div className="col-md-8">
            <p className="colophon">
              Copyright © {new Date().getFullYear()} - Tous droits réservés.
              Florent Damiens
            </p>
          </div>
          <div className="col-md-3 col-md-offset-1">
            <div className="social-links">
              <a target="_blank" href="https://twitter.com/RusHiiiiiiii">
                <i className="fa fa-twitter" />
              </a>
              <a target="_blank" href="https://github.com/RusHiiii">
                <i className="fa fa-github" />
              </a>
              <a target="_blank" href="https://www.linkedin.com/in/florent-damiens-939a49164/">
                <i className="fa fa-linkedin" />
              </a>
            </div>
          </div>
        </div>
      </div>
    </footer>
  );
}
