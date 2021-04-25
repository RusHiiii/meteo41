import React, { Fragment, useEffect, useReducer } from 'react';
import { Link } from 'react-router-dom';

export default function NewsAccessMenu(props) {
  return (
    <div className="widget">
      <h3 className="widget-title">News</h3>
      <ul className="arrow-list">
        <li>
          <Link to="/admin/news">Lister les news</Link>
        </li>
        <li>
          <a href="">Ajouter une news</a>
        </li>
      </ul>
    </div>
  );
}
