import React, { Fragment, useEffect, useReducer, useState } from 'react';
import { Date } from '../../../common/components/Date';
import Paginator from '../../../common/components/Paginator';
import { Link } from 'react-router-dom';
import ConfirmButton from '../../../common/components/ConfirmButton';

export default function UnitSearchResult(props) {
  const { totalUnit, currentPage, units } = props;

  return (
    <Fragment>
      <Paginator
        totalItems={totalUnit}
        currentPage={currentPage}
        itemsPerPage={5}
        onChange={props.onChangePage}
      />

      {units.map((unit, index) => (
        <div key={index} className="photo list">
          <div className="photo-details">
            <h3 className="photo-title">
              <strong>{unit.type}</strong>
            </h3>
            <p>
              <strong>Température:</strong> {unit.temperatureUnit}
            </p>
            <p>
              <strong>Vitesse:</strong> {unit.speedUnit}
            </p>
            <p>
              <strong>Pluie:</strong> {unit.rainUnit}
            </p>
            <p>
              <strong>Pression:</strong> {unit.pressureUnit}
            </p>
            <p>
              <strong>Date de création:</strong>{' '}
              <Date date={unit.createdAt} format="LLLL" />
            </p>
            <p>
              <strong>Date d'édition:</strong>{' '}
              <Date date={unit.updatedAt} format="LLLL" />
            </p>
            <div className="photo-access">
              <Link
                to={`/admin/unit/edit/${unit.id}`}
                className="button btn-edit"
              >
                Editer
              </Link>
              <ConfirmButton
                id={unit.id}
                onClick={() => props.onDelete(unit.id)}
              />
            </div>
          </div>
        </div>
      ))}
    </Fragment>
  );
}
