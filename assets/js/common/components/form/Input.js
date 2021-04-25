import React, { Fragment, useEffect, useReducer } from 'react';

export default function Input(props) {
  const handleInputChange = (evt) => {
    props.onChange(evt.target.value, evt.target.name);
  };

  return (
    <input
      type={props.type}
      placeholder={props.placeholder}
      value={props.value}
      name={props.name}
      onChange={handleInputChange}
    />
  );
}
