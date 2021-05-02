import React, { Fragment, useEffect, useReducer, useState } from 'react';
import TextArea from '../../../common/components/form/TextArea';
import { useForm } from '../../../common/utils/hooks/useForm';
import Input from '../../../common/components/form/Input';

export default function ContactForm(props) {
  const { sending, errors } = props;

  const { inputs, handleInputChange, handleSubmit } = useForm(
    props.onSubmit,
    props.initialValues
  );

  return (
    <form className="contact-form min-height-entry" onSubmit={handleSubmit}>
      <div className="row">
        <div className="col-sm-3 text-center">
          <label className="label-center">Nom</label>
        </div>
        <div className="col-sm-9">
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
      </div>
      <div className="row">
        <div className="col-sm-3 text-center">
          <label className="label-center">Email</label>
        </div>
        <div className="col-sm-9">
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
        <div className="col-sm-3 text-center">
          <label className="label-center">Sujet</label>
        </div>
        <div className="col-sm-9">
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
      <div className="row">
        <div className="col-sm-3 text-center">
          <label className="label-center">Message</label>
        </div>
        <div className="col-sm-9">
          <TextArea
            name="message"
            placeholder="Message"
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
        </div>
      </div>
      <div className="text-right">
        <input type="submit" placeholder="Valider" disabled={sending} />
      </div>
    </form>
  );
}
