import React, { Fragment, useEffect, useReducer } from 'react';
import { Date } from '../../../common/components/Date';
import Paginator from '../../../common/components/Paginator';
import { useHistory } from 'react-router';
import { Link } from 'react-router-dom';

export default function NewsSearchResult(props) {
  const { totalNews, currentPage, news } = props;

  return (
    <Fragment>
      <Paginator
        totalItems={totalNews}
        currentPage={currentPage}
        itemsPerPage={5}
        onChange={props.onChangePage}
      />

      {news.map((post, index) => (
        <div key={index} className="photo list">
          <div className="photo-preview photo-detail edit-btn">
            <div className="btn-info">
              <div className="row btn-height">
                <Link
                  to={`/admin/news/edit/${post.id}`}
                  className="button btn-edit"
                >
                  Editer
                </Link>
              </div>
              <div className="row btn-height">
                <button
                  className="button btn-delete"
                  onClick={() => props.onDelete(post.id)}
                >
                  Supprimer
                </button>
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
    </Fragment>
  );
}
