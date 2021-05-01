import React, { Fragment, useEffect, useReducer } from 'react';
import { Date } from '../../../common/components/Date';
import Paginator from '../../../common/components/Paginator';
import { Link } from 'react-router-dom';

export default function ContactSearchResult(props) {
  const { totalContact, currentPage, contacts } = props;

  return (
    <Fragment>
      <Paginator
        totalItems={totalContact}
        currentPage={currentPage}
        itemsPerPage={5}
        onChange={props.onChangePage}
      />

      {contacts.map((contact, index) => (
        <div key={index} className="photo list">
          <div className="photo-details">
            <h3 className="photo-title">
              <strong>{contact.subject}</strong>
            </h3>
            <p>
              <strong>Nom:</strong> {contact.name}
            </p>
            <p>
              <strong>Email:</strong> {contact.email}
            </p>
            <p>
              <strong>Message:</strong> {contact.message}
            </p>
            <p>
              <strong>Date de création:</strong>{' '}
              <Date date={contact.createdAt} format="LLLL" />
            </p>
            <p>
              <strong>Date d'édition:</strong>{' '}
              <Date date={contact.updatedAt} format="LLLL" />
            </p>
            <div className="photo-access">
              <Link
                to={`/admin/contact/edit/${contact.id}`}
                className="button btn-edit"
              >
                Editer
              </Link>
              <button
                className="button btn-delete margin-left"
                onClick={() => props.onDelete(contact.id)}
              >
                Supprimer
              </button>
            </div>
          </div>
        </div>
      ))}
    </Fragment>
  );
}
