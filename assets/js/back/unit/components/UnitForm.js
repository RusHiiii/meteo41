import React, { Fragment, useEffect, useReducer, useState } from 'react';
import TextArea from '../../../common/components/form/TextArea';
import { useForm } from '../../../common/utils/hooks/useForm';
import Input from '../../../common/components/form/Input';
import Select from '../../../common/components/form/Select';

const choices = [
  {
    value: 'metric',
    text: 'Métric',
  },
  {
    value: 'imperial',
    text: 'Impérial',
  },
];

export default function UnitForm(props) {
  const { sending, errors } = props;

  const { inputs, handleInputChange, handleSubmit } = useForm(
    props.onSubmit,
    props.initialValues
  );

  return (
    <form className="contact-form min-height-entry" onSubmit={handleSubmit}>
      <div className="row">
        <div className="col-sm-3 text-center">
          <label className="label-center">Type</label>
        </div>
        <div className="col-sm-9">
          <Select
            onChange={handleInputChange}
            choices={choices}
            value={inputs.value}
            name="type"
          />

          <ul className="error-list">
            {errors
              .filter((error) => error.propertyPath === 'type')
              .map((error, index) => (
                <li key={index}>{error.message}</li>
              ))}
          </ul>
        </div>
      </div>
      <div className="row">
        <div className="col-sm-3 text-center">
          <label className="label-center">Température</label>
        </div>
        <div className="col-sm-9">
          <Input
            type="text"
            name="temperatureUnit"
            placeholder="Température"
            onChange={handleInputChange}
            value={inputs.temperatureUnit}
          />
          <ul className="error-list">
            {errors
              .filter((error) => error.propertyPath === 'temperatureUnit')
              .map((error, index) => (
                <li key={index}>{error.message}</li>
              ))}
          </ul>
        </div>
      </div>
      <div className="row">
        <div className="col-sm-3 text-center">
          <label className="label-center">Vitesse</label>
        </div>
        <div className="col-sm-9">
          <Input
            type="text"
            name="speedUnit"
            placeholder="Vitesse"
            onChange={handleInputChange}
            value={inputs.speedUnit}
          />
          <ul className="error-list">
            {errors
              .filter((error) => error.propertyPath === 'speedUnit')
              .map((error, index) => (
                <li key={index}>{error.message}</li>
              ))}
          </ul>
        </div>
      </div>
      <div className="row">
        <div className="col-sm-3 text-center">
          <label className="label-center">Pluie</label>
        </div>
        <div className="col-sm-9">
          <Input
            type="text"
            name="rainUnit"
            placeholder="Pluie"
            onChange={handleInputChange}
            value={inputs.rainUnit}
          />
          <ul className="error-list">
            {errors
              .filter((error) => error.propertyPath === 'rainUnit')
              .map((error, index) => (
                <li key={index}>{error.message}</li>
              ))}
          </ul>
        </div>
      </div>
      <div className="row">
        <div className="col-sm-3 text-center">
          <label className="label-center">Radiation solaire</label>
        </div>
        <div className="col-sm-9">
          <Input
            type="text"
            name="solarRadiationUnit"
            placeholder="Radiation solaire"
            onChange={handleInputChange}
            value={inputs.solarRadiationUnit}
          />
          <ul className="error-list">
            {errors
              .filter((error) => error.propertyPath === 'solarRadiationUnit')
              .map((error, index) => (
                <li key={index}>{error.message}</li>
              ))}
          </ul>
        </div>
      </div>
      <div className="row">
        <div className="col-sm-3 text-center">
          <label className="label-center">Particule fine</label>
        </div>
        <div className="col-sm-9">
          <Input
            type="text"
            name="pmUnit"
            placeholder="Particule fine"
            onChange={handleInputChange}
            value={inputs.pmUnit}
          />
          <ul className="error-list">
            {errors
              .filter((error) => error.propertyPath === 'pmUnit')
              .map((error, index) => (
                <li key={index}>{error.message}</li>
              ))}
          </ul>
        </div>
      </div>
      <div className="row">
        <div className="col-sm-3 text-center">
          <label className="label-center">Humidité</label>
        </div>
        <div className="col-sm-9">
          <Input
            type="text"
            name="humidityUnit"
            placeholder="Humidité"
            onChange={handleInputChange}
            value={inputs.humidityUnit}
          />
          <ul className="error-list">
            {errors
              .filter((error) => error.propertyPath === 'humidityUnit')
              .map((error, index) => (
                <li key={index}>{error.message}</li>
              ))}
          </ul>
        </div>
      </div>
      <div className="row">
        <div className="col-sm-3 text-center">
          <label className="label-center">Base des nuages</label>
        </div>
        <div className="col-sm-9">
          <Input
            type="text"
            name="cloudBaseUnit"
            placeholder="Base des nuages"
            onChange={handleInputChange}
            value={inputs.cloudBaseUnit}
          />
          <ul className="error-list">
            {errors
              .filter((error) => error.propertyPath === 'cloudBaseUnit')
              .map((error, index) => (
                <li key={index}>{error.message}</li>
              ))}
          </ul>
        </div>
      </div>
      <div className="row">
        <div className="col-sm-3 text-center">
          <label className="label-center">Direction</label>
        </div>
        <div className="col-sm-9">
          <Input
            type="text"
            name="windDirUnit"
            placeholder="Direction"
            onChange={handleInputChange}
            value={inputs.windDirUnit}
          />
          <ul className="error-list">
            {errors
              .filter((error) => error.propertyPath === 'windDirUnit')
              .map((error, index) => (
                <li key={index}>{error.message}</li>
              ))}
          </ul>
        </div>
      </div>
      <div className="row">
        <div className="col-sm-3 text-center">
          <label className="label-center">Pression</label>
        </div>
        <div className="col-sm-9">
          <Input
            type="text"
            name="pressureUnit"
            placeholder="Pression"
            onChange={handleInputChange}
            value={inputs.pressureUnit}
          />
          <ul className="error-list">
            {errors
              .filter((error) => error.propertyPath === 'pressureUnit')
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
