import React, { Fragment, useEffect, useReducer, useState } from 'react';
import Input from '../../../../common/components/form/Input';
import { useForm } from '../../../../common/utils/hooks/useForm';
import { useDispatch } from 'react-redux';
import apiClient from '../../../../common/utils/apiClient';
import tokenRepository from '../../../../common/utils/tokenRepository';
import { USER_LOGGED } from '../../../../common/reducers/user';
import { useHistory } from 'react-router-dom';

export default function LoginForm(props) {
  const [hasError, setHasError] = useState(false);
  const [disabled, setDisabled] = useState(false);
  const dispatch = useDispatch();
  const history = useHistory();

  const submitLogin = (data) => {
    setDisabled(true);

    return apiClient
      .request(
        new Request('/api/login', {
          method: 'POST',
          body: JSON.stringify({
            email: data.email,
            password: data.password,
          }),
        })
      )
      .then((response) => {
        if (response.ok) {
          return response;
        }

        setHasError(true);

        throw new Error(response.statusText);
      })
      .then((response) => response.json())
      .then((value) => {
        tokenRepository.setToken(value.token);

        dispatch({ type: USER_LOGGED, token: value.token });

        history.push('/admin/dashboard');
      })
      .catch(() => {
        setDisabled(false);
      });
  };

  const { inputs, handleInputChange, handleSubmit } = useForm(submitLogin, {
    email: '',
    password: '',
  });

  return (
    <form className="contact-form" onSubmit={handleSubmit}>
      {hasError && (
        <div className="error-alert">
          Le couple utilisateur/mot de passe est incorrect
        </div>
      )}

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
        </div>
      </div>
      <div className="text-right">
        <input type="submit" placeholder="Valider" disabled={disabled} />
      </div>
    </form>
  );
}
