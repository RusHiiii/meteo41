import React, { Fragment, useEffect, useReducer, useState } from 'react';
import TextArea from '../../../common/components/form/TextArea';
import { useForm } from '../../../common/utils/hooks/useForm';
import Input from '../../../common/components/form/Input';

export default function NewsForm(props) {
  const { sending, errors } = props;

  const { inputs, handleInputChange, handleSubmit } = useForm(
    props.onSubmit,
    props.initialValues
  );

  return (
    <form className="contact-form min-height-not-found" onSubmit={handleSubmit}>
      <div className="row">
        <div className="col-sm-3 text-center">
          <label className="label-center">Titre</label>
        </div>
        <div className="col-sm-9">
          <Input
            type="text"
            name="name"
            placeholder="Titre"
            onChange={handleInputChange}
            value={inputs.name}
          />
          <ul className="error-list">
            {errors
              .filter((error) => error.propertyPath === 'name')
              .map((error, index) => (
                <li key={index}>{error.message}</li>
              ))}
          </ul>
        </div>
      </div>
      <div className="row">
        <div className="col-sm-3 text-center">
          <label className="label-center">Description</label>
        </div>
        <div className="col-sm-9">
          <TextArea
            name="description"
            placeholder="Description"
            onChange={handleInputChange}
            value={inputs.description}
          />
          <ul className="error-list">
            {errors
              .filter((error) => error.propertyPath === 'description')
              .map((error, index) => (
                <li key={index}>{error.message}</li>
              ))}
          </ul>
        </div>
      </div>
      <div className="text-right">
        <input type="submit" placeholder="Valider" disabled={sending} />
      </div>
    </form>
  );
}
