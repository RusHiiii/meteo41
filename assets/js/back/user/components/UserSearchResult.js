import React, { Fragment, useEffect, useReducer, useState } from 'react';
import { Date } from '../../../common/components/Date';
import Paginator from '../../../common/components/Paginator';
import { Link } from 'react-router-dom';
import ConfirmButton from '../../../common/components/ConfirmButton';
import { userIsAdmin } from '../../../common/utils/hooks/security/userIsAdmin';

export default function UserSearchResult(props) {
  const isAdmin = userIsAdmin();
  const { totalUser, currentPage, users } = props;

  return (
    <Fragment>
      <Paginator
        totalItems={totalUser}
        currentPage={currentPage}
        itemsPerPage={5}
        onChange={props.onChangePage}
      />

      {users.map((user, index) => (
        <div key={index} className="photo list">
          <div className="photo-details">
            <h3>
              <strong>{user.email}</strong>
            </h3>
            <p>
              <strong>Prénom:</strong> {user.firstname}
            </p>
            <p>
              <strong>Nom:</strong> {user.lastname}
            </p>
            <p>
              <strong>Roles:</strong> {user.roles}
            </p>
            <p>
              <strong>Date de création:</strong>{' '}
              <Date date={user.createdAt} format="LLLL" />
            </p>
            <p>
              <strong>Date d'édition:</strong>{' '}
              <Date date={user.updatedAt} format="LLLL" />
            </p>
            {isAdmin && (
              <div className="photo-access">
                <Link
                  to={`/admin/user/edit/${user.id}`}
                  className="button btn-edit"
                >
                  Editer
                </Link>
                <ConfirmButton
                  key={user.id}
                  onClick={() => props.onDelete(user.id)}
                />
              </div>
            )}
          </div>
        </div>
      ))}
    </Fragment>
  );
}
