import React, { Fragment, useEffect, useReducer, useState } from 'react';
import { Date } from '../../../common/components/Date';
import Paginator from '../../../common/components/Paginator';
import { Link } from 'react-router-dom';
import ConfirmButton from '../../../common/components/ConfirmButton';

export default function ObservationSearchResult(props) {
  const { totalObservation, currentPage, observations } = props;

  return (
    <Fragment>
      <Paginator
        totalItems={totalObservation}
        currentPage={currentPage}
        itemsPerPage={5}
        onChange={props.onChangePage}
      />

      {observations.map((observation, index) => (
        <div key={index} className="photo list">
          <div className="photo-details">
            <h3 className="photo-title">
              <strong>{observation.weatherStation.city}</strong>
            </h3>
            <p>
              <strong>Auteur:</strong> {observation.user.email}
            </p>
            <p>
              <strong>Message:</strong> {observation.message}
            </p>
            <p>
              <strong>Date de création:</strong>{' '}
              <Date date={observation.createdAt} format="LLLL" />
            </p>
            <p>
              <strong>Date d'édition:</strong>{' '}
              <Date date={observation.updatedAt} format="LLLL" />
            </p>
            <div className="photo-access">
              <Link
                to={`/admin/observation/edit/${observation.id}`}
                className="button btn-edit"
              >
                Editer
              </Link>
              <ConfirmButton
                key={observation.id}
                onClick={() => props.onDelete(observation.id)}
              />
            </div>
          </div>
        </div>
      ))}
    </Fragment>
  );
}
