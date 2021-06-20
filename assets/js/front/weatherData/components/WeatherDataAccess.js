import React, { Fragment, useEffect, useReducer } from 'react';
import { Link, useHistory } from 'react-router-dom';

export default function WeatherDataAccess(props) {
  return (
    <div className="widget">
      <h3 className="widget-title">Données météo</h3>
      <ul className="arrow-list">
        <li>
          <Link to="/weather/current">Données actuelles</Link>
        </li>
        <li>
          <Link to="/weather/history/daily">Données du jour</Link>
        </li>
        <li>
          <Link to="/weather/history/weekly">Données de la semaine</Link>
        </li>
        <li>
          <Link to="/weather/history/monthly">Données du mois</Link>
        </li>
        <li>
          <Link to="/weather/history/yearly">Données de l'année</Link>
        </li>
        <li>
          <Link to="/weather/history/record">Record</Link>
        </li>
      </ul>
    </div>
  );
}
