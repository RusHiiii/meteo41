import React, { Fragment, useEffect, useReducer } from 'react';
import { Date } from '../../../common/components/Date';
import Paginator from '../../../common/components/Paginator';

export default function NewsSearchResult(props) {
  const { totalNews, currentPage, news } = props;

  return (
    <div className="col-md-12">
      <Paginator
        totalItems={totalNews}
        itemsPerPage={5}
        onChange={props.onChangePage}
      />

      {news.map((post, index) => (
        <div key={index} className="photo list">
          <div className="photo-preview photo-detail edit-btn">
            <div className="btn-info">
              <div className="row btn-height">
                <a href="#" className="button btn-edit">
                  Editer
                </a>
              </div>
              <div className="row btn-height">
                <a href="#" className="button btn-delete">
                  Supprimer
                </a>
              </div>
            </div>
          </div>
          <div className="photo-details">
            <h3 className="photo-title">
              <strong>{post.name}</strong>
            </h3>
            <p className="admin-paragraph">
              <strong>Description:</strong> {post.description}
            </p>
            <p className="admin-paragraph">
              <strong>Date de création:</strong>{' '}
              <Date date={post.createdAt} format="LLLL" />
            </p>
            <p className="admin-paragraph">
              <strong>Date d'édition:</strong>{' '}
              <Date date={post.updatedAt} format="LLLL" />
            </p>
          </div>
        </div>
      ))}
    </div>
  );
}
