import React, { Fragment, useEffect, useReducer, useState } from 'react';
import { Link } from 'react-router-dom';

export default function ConfirmButton(props) {
  const [confirm, setConfirm] = useState(false);

  return (
    <Fragment>
      {!confirm && (
        <button
          className="button btn-delete margin-left"
          onClick={() => setConfirm(true)}
        >
          Supprimer
        </button>
      )}
      {confirm && (
        <Fragment>
          <button
            className="button btn-delete margin-left"
            onClick={props.onClick}
          >
            Confirmer ?
          </button>
          <button
            className="button btn-edit margin-left"
            onClick={() => setConfirm(false)}
          >
            Annuler
          </button>
        </Fragment>
      )}
    </Fragment>
  );
}
