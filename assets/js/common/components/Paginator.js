import React, { Fragment, useEffect, useReducer } from 'react';

const displayPage = (page) => (
  <option key={page} value={page}>
    {page}
  </option>
);

const displayPagesNumber = (pages) => {
  let elements = [];

  for (let i = 0; i < pages; i++) {
    elements.push(displayPage(i + 1));
  }

  return elements;
};

export default function Paginator(props) {
  const { totalItems, itemsPerPage } = props;
  let pages = 1;

  if (totalItems > 0) {
    pages = Math.ceil(totalItems / itemsPerPage);
  }

  return (
    <div className="pagination">
      <div className="filter">
        <div className="count filter-control filter-right">
          <label htmlFor="">Page</label>
          <span className="select control">
            <select
              name="page"
              id="page"
              onChange={(evt) => props.onChange(evt.target.value)}
            >
              {displayPagesNumber(pages)}
            </select>
          </span>
        </div>
      </div>
    </div>
  );
}
