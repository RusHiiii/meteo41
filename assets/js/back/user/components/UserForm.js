import React, { Fragment, useEffect, useReducer, useState } from 'react';
import TextArea from '../../../common/components/form/TextArea';
import { useForm } from '../../../common/utils/hooks/useForm';
import Input from '../../../common/components/form/Input';
import Select from '../../../common/components/form/Select';
import UnitSelect from '../../../common/components/form/select/UnitSelect';
import { ROLE_ADMIN, ROLE_EDITOR } from '../../../common/constant';

const choices = [
  {
    value: ROLE_ADMIN,
    text: 'Admin',
  },
  {
    value: ROLE_EDITOR,
    text: 'Editeur',
  },
];

export default function UserForm(props) {
  const { sending, errors } = props;

  const { inputs, handleInputChange, handleSubmit } = useForm(
    props.onSubmit,
    props.initialValues
  );

  return (
    <form className="contact-form min-height-entry" onSubmit={handleSubmit}>
      <div className="row">
        <div className="col-sm-3 text-center">
          <label className="label-center">Role</label>
        </div>
        <div className="col-sm-9">
          <Select
            name="roles"
            value={inputs.roles}
            choices={choices}
            onChange={handleInputChange}
          />

          <ul className="error-list">
            {errors
              .filter((error) => error.propertyPath === 'roles')
              .map((error, index) => (
                <li key={index}>{error.message}</li>
              ))}
          </ul>
        </div>
      </div>
      <div className="row">
        <div className="col-sm-3 text-center">
          <label className="label-center">Prénom</label>
        </div>
        <div className="col-sm-9">
          <Input
            type="text"
            name="firstname"
            placeholder="Prénom"
            onChange={handleInputChange}
            value={inputs.firstname}
          />

          <ul className="error-list">
            {errors
              .filter((error) => error.propertyPath === 'firstname')
              .map((error, index) => (
                <li key={index}>{error.message}</li>
              ))}
          </ul>
        </div>
      </div>
      <div className="row">
        <div className="col-sm-3 text-center">
          <label className="label-center">Nom</label>
        </div>
        <div className="col-sm-9">
          <Input
            type="text"
            name="lastname"
            placeholder="Nom"
            onChange={handleInputChange}
            value={inputs.lastname}
          />

          <ul className="error-list">
            {errors
              .filter((error) => error.propertyPath === 'lastname')
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
          <label className="label-center">Mot de passe</label>
        </div>
        <div className="col-sm-9">
          <Input
            type="password"
            name="password"
            placeholder="Mot de passe"
            onChange={handleInputChange}
            value={inputs.password}
          />

          <ul className="error-list">
            {errors
              .filter((error) => error.propertyPath === 'password')
              .map((error, index) => (
                <li key={index}>{error.message}</li>
              ))}
          </ul>
        </div>
      </div>
      <div className="row">
        <div className="col-sm-3 text-center">
          <label className="label-center">Confirmation</label>
        </div>
        <div className="col-sm-9">
          <Input
            type="password"
            name="passwordConfirmation"
            placeholder="Confirmation"
            onChange={handleInputChange}
            value={inputs.passwordConfirmation}
          />

          <ul className="error-list">
            {errors
              .filter((error) => error.propertyPath === 'passwordConfirmation')
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
