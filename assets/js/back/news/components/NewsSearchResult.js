import React, { Fragment, useEffect, useReducer } from 'react';
import { Date } from '../../../common/components/Date';
import Paginator from '../../../common/components/Paginator';
import { Link } from 'react-router-dom';
import ConfirmButton from '../../../common/components/ConfirmButton';

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
          <div className="photo-details">
            <h3 className="photo-title">
              <strong>{post.name}</strong>
            </h3>
            <p>
              <strong>Description:</strong> {post.description}
            </p>
            <p>
              <strong>Date de création:</strong>{' '}
              <Date date={post.createdAt} format="LLLL" />
            </p>
            <p>
              <strong>Date d'édition:</strong>{' '}
              <Date date={post.updatedAt} format="LLLL" />
            </p>
            <div className="photo-access">
              <Link
                to={`/admin/news/edit/${post.id}`}
                className="button btn-edit"
              >
                Editer
              </Link>
              <ConfirmButton
                key={post.id}
                onClick={() => props.onDelete(post.id)}
              />
            </div>
          </div>
        </div>
      ))}
    </Fragment>
  );
}
