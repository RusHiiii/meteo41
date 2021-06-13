import React, { Fragment, useEffect, useReducer, useState } from 'react';
import TextArea from '../../../common/components/form/TextArea';
import { useForm } from '../../../common/utils/hooks/useForm';
import Input from '../../../common/components/form/Input';
import Select from '../../../common/components/form/Select';
import UnitSelect from '../../../common/components/form/select/UnitSelect';

export default function WeatherStationForm(props) {
  const { sending, errors } = props;

  const { inputs, handleInputChange, handleSubmit } = useForm(
    props.onSubmit,
    props.initialValues
  );

  return (
    <form className="contact-form min-height-entry" onSubmit={handleSubmit}>
      <div className="row">
        <div className="col-sm-3 text-center">
          <label className="label-center">Unité</label>
        </div>
        <div className="col-sm-9">
          <span className="select control">
            <UnitSelect
              onChange={handleInputChange}
              value={inputs.preferedUnit}
              name="preferedUnit"
            />
          </span>

          <ul className="error-list">
            {errors
              .filter((error) => error.propertyPath === 'preferedUnit')
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
      <div className="row">
        <div className="col-sm-3 text-center">
          <label className="label-center">Description courte</label>
        </div>
        <div className="col-sm-9">
          <TextArea
            name="shortDescription"
            placeholder="Description courte"
            onChange={handleInputChange}
            value={inputs.shortDescription}
          />
          <ul className="error-list">
            {errors
              .filter((error) => error.propertyPath === 'shortDescription')
              .map((error, index) => (
                <li key={index}>{error.message}</li>
              ))}
          </ul>
        </div>
      </div>
      <div className="row">
        <div className="col-sm-3 text-center">
          <label className="label-center">Pays</label>
        </div>
        <div className="col-sm-9">
          <Input
            type="text"
            name="country"
            placeholder="Pays"
            onChange={handleInputChange}
            value={inputs.country}
          />
          <ul className="error-list">
            {errors
              .filter((error) => error.propertyPath === 'country')
              .map((error, index) => (
                <li key={index}>{error.message}</li>
              ))}
          </ul>
        </div>
      </div>
      <div className="row">
        <div className="col-sm-3 text-center">
          <label className="label-center">Adresse</label>
        </div>
        <div className="col-sm-9">
          <Input
            type="text"
            name="address"
            placeholder="Adresse"
            onChange={handleInputChange}
            value={inputs.address}
          />
          <ul className="error-list">
            {errors
              .filter((error) => error.propertyPath === 'address')
              .map((error, index) => (
                <li key={index}>{error.message}</li>
              ))}
          </ul>
        </div>
      </div>
      <div className="row">
        <div className="col-sm-3 text-center">
          <label className="label-center">Ville</label>
        </div>
        <div className="col-sm-9">
          <Input
            type="text"
            name="city"
            placeholder="Ville"
            onChange={handleInputChange}
            value={inputs.city}
          />
          <ul className="error-list">
            {errors
              .filter((error) => error.propertyPath === 'city')
              .map((error, index) => (
                <li key={index}>{error.message}</li>
              ))}
          </ul>
        </div>
      </div>
      <div className="row">
        <div className="col-sm-3 text-center">
          <label className="label-center">Latitude</label>
        </div>
        <div className="col-sm-9">
          <Input
            type="text"
            name="lat"
            placeholder="Latitude"
            onChange={handleInputChange}
            value={inputs.lat}
          />
          <ul className="error-list">
            {errors
              .filter((error) => error.propertyPath === 'lat')
              .map((error, index) => (
                <li key={index}>{error.message}</li>
              ))}
          </ul>
        </div>
      </div>
      <div className="row">
        <div className="col-sm-3 text-center">
          <label className="label-center">Longitude</label>
        </div>
        <div className="col-sm-9">
          <Input
            type="text"
            name="lng"
            placeholder="Longitude"
            onChange={handleInputChange}
            value={inputs.lng}
          />
          <ul className="error-list">
            {errors
              .filter((error) => error.propertyPath === 'lng')
              .map((error, index) => (
                <li key={index}>{error.message}</li>
              ))}
          </ul>
        </div>
      </div>
      <div className="row">
        <div className="col-sm-3 text-center">
          <label className="label-center">API Token</label>
        </div>
        <div className="col-sm-9">
          <Input
            type="text"
            name="apiToken"
            placeholder="API Token"
            onChange={handleInputChange}
            value={inputs.apiToken}
          />
          <ul className="error-list">
            {errors
              .filter((error) => error.propertyPath === 'apiToken')
              .map((error, index) => (
                <li key={index}>{error.message}</li>
              ))}
          </ul>
        </div>
      </div>
      <div className="row">
        <div className="col-sm-3 text-center">
          <label className="label-center">Modèle</label>
        </div>
        <div className="col-sm-9">
          <Input
            type="text"
            name="model"
            placeholder="Modèle"
            onChange={handleInputChange}
            value={inputs.model}
          />
          <ul className="error-list">
            {errors
              .filter((error) => error.propertyPath === 'model')
              .map((error, index) => (
                <li key={index}>{error.message}</li>
              ))}
          </ul>
        </div>
      </div>
      <div className="row">
        <div className="col-sm-3 text-center">
          <label className="label-center">Altitude</label>
        </div>
        <div className="col-sm-9">
          <Input
            type="text"
            name="elevation"
            placeholder="Altitude"
            onChange={handleInputChange}
            value={inputs.elevation}
          />
          <ul className="error-list">
            {errors
              .filter((error) => error.propertyPath === 'elevation')
              .map((error, index) => (
                <li key={index}>{error.message}</li>
              ))}
          </ul>
        </div>
      </div>
      <div className="row">
        <div className="col-sm-3 text-center">
          <label className="label-center">Référence</label>
        </div>
        <div className="col-sm-9">
          <Input
            type="text"
            name="reference"
            placeholder="Référence"
            onChange={handleInputChange}
            value={inputs.reference}
          />
          <ul className="error-list">
            {errors
              .filter((error) => error.propertyPath === 'reference')
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
