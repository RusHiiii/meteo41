import React, { Fragment, useEffect, useReducer, useState } from 'react';
import TextArea from '../../../common/components/form/TextArea';
import { useForm } from '../../../common/utils/hooks/useForm';
import Input from '../../../common/components/form/Input';

export default function ForecastSearchForm(props) {
  const { sending, errors } = props;

  const { inputs, handleInputChange, handleSubmit } = useForm(
    props.onSubmit,
    props.initialValues
  );

  return (
    <form className="find-location" onSubmit={handleSubmit}>
      <Input
        type="text"
        name="text"
        placeholder="Rechercher..."
        onChange={handleInputChange}
        value={inputs.text}
      />
      <input className="no-margin-top" type="submit" value="Valider" />
    </form>
  );
}
