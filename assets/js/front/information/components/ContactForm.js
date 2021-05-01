import React, { Fragment, useEffect, useReducer, useState } from 'react';
import TextArea from '../../../common/components/form/TextArea';
import { useForm } from '../../../common/utils/hooks/useForm';
import Input from '../../../common/components/form/Input';
import Select from '../../../common/components/form/Select';

export default function ContactForm(props) {
  const { sending, errors } = props;

  const { inputs, handleInputChange, handleSubmit } = useForm(
    props.onSubmit,
    props.initialValues
  );

  return (
    <Fragment>
      <form className="contact-form" onSubmit={handleSubmit}>
        <div className="row">
          <div className="col-md-6">
            <Input
              type="text"
              name="name"
              placeholder="Nom"
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
          <div className="col-md-6">
            <Input
              type="text"
              name="email"
              placeholder="Email"
              onChange={handleInputChange}
              value={inputs.email}
            />
            <ul className="error-list">
              {errors
                .filter((error) => error.propertyPath === 'email')
                .map((error, index) => (
                  <li key={index}>{error.message}</li>
                ))}
            </ul>
          </div>
        </div>
        <div className="row">
          <div className="col-md-12">
            <Input
              type="text"
              name="subject"
              placeholder="Sujet"
              onChange={handleInputChange}
              value={inputs.subject}
            />
            <ul className="error-list">
              {errors
                .filter((error) => error.propertyPath === 'subject')
                .map((error, index) => (
                  <li key={index}>{error.message}</li>
                ))}
            </ul>
          </div>
        </div>
        <TextArea
          name="message"
          placeholder="Message..."
          onChange={handleInputChange}
          value={inputs.message}
        />
        <ul className="error-list">
          {errors
            .filter((error) => error.propertyPath === 'message')
            .map((error, index) => (
              <li key={index}>{error.message}</li>
            ))}
        </ul>
        <div className="text-right">
          <input type="submit" placeholder="Valider" disabled={sending} />
        </div>
      </form>
    </Fragment>
  );
}
