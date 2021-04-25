import React, { Fragment, useEffect, useReducer } from 'react';

export default function TextArea(props) {
  const handleInputChange = (evt) => {
    props.onChange(evt.target.value, evt.target.name);
  };

  return (
    <textarea
      placeholder={props.placeholder}
      value={props.value}
      name={props.name}
      onChange={handleInputChange}
    />
  );
}
