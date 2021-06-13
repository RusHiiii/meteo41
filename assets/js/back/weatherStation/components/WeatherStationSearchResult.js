import React, { Fragment, useEffect, useReducer, useState } from 'react';
import { Date } from '../../../common/components/Date';
import Paginator from '../../../common/components/Paginator';
import { Link } from 'react-router-dom';
import ConfirmButton from '../../../common/components/ConfirmButton';

export default function WeatherStationSearchResult(props) {
  const { totalWeatherStation, currentPage, weatherStations } = props;

  return (
    <Fragment>
      <Paginator
        totalItems={totalWeatherStation}
        currentPage={currentPage}
        itemsPerPage={5}
        onChange={props.onChangePage}
      />

      {weatherStations.map((weatherStation, index) => (
        <div key={index} className="photo list">
          <div className="photo-details">
            <h3 className="photo-title">
              <strong>{weatherStation.name}</strong>
            </h3>
            <p>
              <strong>Description courte:</strong>{' '}
              {weatherStation.shortDescription}
            </p>
            <p>
              <strong>Adresse:</strong> {weatherStation.address},{' '}
              {weatherStation.city}, {weatherStation.country}
            </p>
            <p>
              <strong>Modèle:</strong> {weatherStation.model}
            </p>
            <p>
              <strong>Référence:</strong> {weatherStation.reference}
            </p>
            <p>
              <strong>Date de création:</strong>{' '}
              <Date date={weatherStation.createdAt} format="LLLL" />
            </p>
            <p>
              <strong>Date d'édition:</strong>{' '}
              <Date date={weatherStation.updatedAt} format="LLLL" />
            </p>
            <div className="photo-access">
              <Link
                to={`/admin/weatherStation/edit/${weatherStation.reference}`}
                className="button btn-edit"
              >
                Editer
              </Link>
              <ConfirmButton
                id={weatherStation.id}
                onClick={() => props.onDelete(weatherStation.id)}
              />
            </div>
          </div>
        </div>
      ))}
    </Fragment>
  );
}
