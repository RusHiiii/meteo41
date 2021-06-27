import React, { Fragment, useEffect, useReducer, useState } from 'react';
import TextArea from '../../../common/components/form/TextArea';
import { useForm } from '../../../common/utils/hooks/useForm';
import Input from '../../../common/components/form/Input';

export default function Forecast(props) {
  return (
    <div className="forecast-container">
      <div className="today forecast">
        <div className="forecast-header">
          <div className="day">Lundi</div>
          <div className="date">6 Oct</div>
        </div>
        <div className="forecast-content">
          <div className="location">Blois</div>
          <div className="degree">
            <div className="num">
              23<sup>o</sup>C
            </div>
            <div className="forecast-icon">
              <img src="/static/images/icons/icon-1.svg" alt="" width="48" />
            </div>
          </div>
          <span>
            <img src="/static/images/icon-umberella.png" alt="" />
            20%
          </span>
          <span>
            <img src="/static/images/icon-wind.png" alt="" />
            18km/h
          </span>
          <span>
            <img src="/static/images/icon-compass.png" alt="" />
            Est
          </span>
        </div>
      </div>
      <div className="forecast">
        <div className="forecast-header">
          <div className="day day-name">Mardi</div>
        </div>
        <div className="forecast-content city">
          <div className="forecast-icon">
            <img src="/static/images/icons/icon-3.svg" alt="" width="48" />
          </div>
          <div className="degree">
            23<sup>o</sup>C
          </div>
          <small>
            18<sup>o</sup>
          </small>
        </div>
      </div>
      <div className="forecast">
        <div className="forecast-header">
          <div className="day day-name">Mercredi</div>
        </div>
        <div className="forecast-content city">
          <div className="forecast-icon">
            <img src="/static/images/icons/icon-5.svg" alt="" width="48" />
          </div>
          <div className="degree">
            23<sup>o</sup>C
          </div>
          <small>
            18<sup>o</sup>
          </small>
        </div>
      </div>
      <div className="forecast">
        <div className="forecast-header">
          <div className="day day-name">Jeudi</div>
        </div>
        <div className="forecast-content city">
          <div className="forecast-icon">
            <img src="/static/images/icons/icon-7.svg" alt="" width="48" />
          </div>
          <div className="degree">
            23<sup>o</sup>C
          </div>
          <small>
            18<sup>o</sup>
          </small>
        </div>
      </div>
      <div className="forecast">
        <div className="forecast-header">
          <div className="day day-name">Vendredi</div>
        </div>
        <div className="forecast-content city">
          <div className="forecast-icon">
            <img src="/static/images/icons/icon-12.svg" alt="" width="48" />
          </div>
          <div className="degree">
            23<sup>o</sup>C
          </div>
          <small>
            18<sup>o</sup>
          </small>
        </div>
      </div>
      <div className="forecast">
        <div className="forecast-header">
          <div className="day day-name">Samedi</div>
        </div>
        <div className="forecast-content city">
          <div className="forecast-icon">
            <img src="/static/images/icons/icon-13.svg" alt="" width="48" />
          </div>
          <div className="degree">
            23<sup>o</sup>C
          </div>
          <small>
            18<sup>o</sup>
          </small>
        </div>
      </div>
    </div>
  );
}
