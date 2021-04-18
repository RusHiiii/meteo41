import React, { Fragment, useEffect, useReducer } from 'react';
import { Link } from 'react-router-dom';

export default function BreadCrumb(props) {
  return (
    <div className="container">
      <div className="breadcrumb">
        <Link to="/">Accueil</Link>
        {props.url && <Link to={props.url}>{props.page}</Link>}
        {props.text && <span>{props.text}</span>}
      </div>
    </div>
  );
}
