import React, { Fragment, useEffect, useReducer, useState } from 'react';
import TextArea from '../../../common/components/form/TextArea';
import { useForm } from '../../../common/utils/hooks/useForm';
import WeatherStationSelect from "../../../common/components/form/select/WeatherStationSelect";

export default function ObservationForm(props) {
  const { sending, errors } = props;

  const { inputs, handleInputChange, handleSubmit } = useForm(
    props.onSubmit,
    props.initialValues
  );

  return (
    <form className="contact-form min-height-entry" onSubmit={handleSubmit}>
      <div className="row">
        <div className="col-sm-3 text-center">
          <label className="label-center">Station météo</label>
        </div>
        <div className="col-sm-9">
          <span className="select control">
            <WeatherStationSelect
              onChange={handleInputChange}
              value={inputs.weatherStation}
              name="weatherStation"
              useSpan
            />
          </span>
          <ul className="error-list">
            {errors
              .filter((error) => error.propertyPath === 'weatherStation')
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
