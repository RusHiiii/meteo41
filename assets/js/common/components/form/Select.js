import React, { Fragment, useEffect, useReducer } from 'react';

export default function Select(props) {
  const handleInputChange = (evt) => {
    props.onChange(evt.target.value, evt.target.name);
  };

  return (
    <span className="select control">
      <select
        className={props.className}
        value={props.value}
        name={props.name}
        onChange={handleInputChange}
      >
        {props.choices.map((choice) => (
          <option key={choice.value} value={choice.value}>
            {choice.text}
          </option>
        ))}
      </select>
    </span>
  );
}
