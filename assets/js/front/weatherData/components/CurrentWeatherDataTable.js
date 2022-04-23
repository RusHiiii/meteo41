import React, { Fragment, useEffect, useReducer } from 'react';
import { Date } from '../../../common/components/Date';
import { degToCompass } from '../utils/degreesToCompass';
import { beaufortScaleToText } from '../utils/beaufortScaleToText';
import { aqiToText } from '../utils/aqiToText';

const showVariation = (value, unit) => {
  if (value) {
    const sign = value > 0 ? '+' : '';

    return `${sign}${value.toFixed(1)} ${unit}`;
  }

  return '-';
};

const showOptionnalSensor = (value, unit, precision = 1) => {
  if (value) {
    return `${value.toFixed(precision)} ${unit}`;
  }

  return '-';
};

const showObservation = (value) => {
  if (value) {
    return value.message;
  }

  return '-';
};

export default function CurrentWeatherDataTable(props) {
  const { weatherData, observation } = props;

  return (
    <table className="table-obs" width="100%">
      <caption className="caption-obs">
        <strong>
          Observations à <Date date={weatherData.receivedAt} format={'LT'} />,
          le <Date date={weatherData.receivedAt} format={'LL'} />
        </strong>{' '}
        (heure locale)
      </caption>
      <tbody>
        <tr>
          <td colSpan="4" className="table-obs-header">
            <strong>Température et humidité</strong>
          </td>
        </tr>
        <tr className="table-obs-first-data">
          <td>Température</td>
          <td>
            {weatherData.temperature} {weatherData.unit.temperatureUnit}
          </td>
          <td>Variation depuis 1h</td>
          <td>
            {showVariation(
              weatherData.temperatureVariation,
              weatherData.unit.temperatureUnit
            )}
          </td>
        </tr>
        <tr>
          <td>Température du sol (-30cm)</td>
          <td>
            {showOptionnalSensor(weatherData.soilTemperature, weatherData.unit.temperatureUnit)}
          </td>
          <td>Variation depuis 1h</td>
          <td>
            {showVariation(
              weatherData.soilTemperatureVariation,
              weatherData.unit.temperatureUnit
            )}
          </td>
        </tr>
        <tr>
          <td>Humidex</td>
          <td>
            {weatherData.humidex} {weatherData.unit.temperatureUnit}
          </td>
          <td>Variation depuis 1h</td>
          <td>
            {showVariation(
              weatherData.humidexVariation,
              weatherData.unit.temperatureUnit
            )}
          </td>
        </tr>
        <tr>
          <td>Point de rosée</td>
          <td>
            {weatherData.dewPoint} {weatherData.unit.temperatureUnit}
          </td>
          <td>Heat Index</td>
          <td>
            {weatherData.heatIndex} {weatherData.unit.temperatureUnit}
          </td>
        </tr>
        <tr>
          <td>Facteur éolien</td>
          <td>
            {weatherData.windChill} {weatherData.unit.temperatureUnit}
          </td>
          <td>Humidité</td>
          <td>
            {weatherData.humidity}
            {weatherData.unit.humidityUnit}
          </td>
        </tr>
        <tr>
          <td>Humidité foliaire</td>
          <td>
            {showOptionnalSensor(weatherData.leafWetness, weatherData.unit.humidityUnit, 0)}
          </td>
          <td>Couvert. nuageuse</td>
          <td>
            {weatherData.cloudBase} {weatherData.unit.cloudBaseUnit}
          </td>
        </tr>
        <tr className="table-obs-last-data">
          <td>Observation</td>
          <td>{showObservation(observation)}</td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td colSpan="4" className="table-obs-header">
            <strong>Pression atmosphérique</strong>
          </td>
        </tr>
        <tr className="table-obs-first-data table-obs-last-data">
          <td>Baromètre</td>
          <td>
            {weatherData.relativePressure} {weatherData.unit.pressureUnit}
          </td>
          <td>Variation depuis 1h</td>
          <td>
            {showVariation(
              weatherData.relativePressureVariation,
              weatherData.unit.pressureUnit
            )}
          </td>
        </tr>
        <tr>
          <td colSpan="4" className="table-obs-header">
            <strong>Précipitations</strong>
          </td>
        </tr>
        <tr className="table-obs-first-data">
          <td>Averse</td>
          <td>
            {weatherData.rainRate} {weatherData.unit.rainUnit}/hr
          </td>
          <td>Période de pluie</td>
          <td>
            {weatherData.rainEvent} {weatherData.unit.rainUnit}
          </td>
        </tr>
        <tr>
          <td>L'heure passée</td>
          <td>
            {weatherData.rainHourly} {weatherData.unit.rainUnit}
          </td>
          <td>Total aujourd'hui</td>
          <td>
            {weatherData.rainDaily} {weatherData.unit.rainUnit}
          </td>
        </tr>
        <tr>
          <td>Total pour la semaine</td>
          <td>
            {weatherData.rainWeekly} {weatherData.unit.rainUnit}
          </td>
          <td>Total pour le mois</td>
          <td>
            {weatherData.rainMonthly} {weatherData.unit.rainUnit}
          </td>
        </tr>
        <tr className="table-obs-last-data">
          <td>Total pour l'année</td>
          <td>
            {weatherData.rainYearly} {weatherData.unit.rainUnit}
          </td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td colSpan="4" className="table-obs-header">
            <strong>Vents</strong>
          </td>
        </tr>
        <tr className="table-obs-first-data">
          <td>Vitesse actuelle</td>
          <td>
            {weatherData.windSpeed} {weatherData.unit.speedUnit}
          </td>
          <td>Direction du vent</td>
          <td>{degToCompass(weatherData.windDirection)}</td>
        </tr>
        <tr className="td_data">
          <td>Échelle de Beaufort</td>
          <td>F{weatherData.beaufortScale}</td>
          <td>Brise légère</td>
          <td>{beaufortScaleToText(weatherData.beaufortScale)}</td>
        </tr>
        <tr className="td_data">
          <td>Vent (moy/10mn)</td>
          <td>
            {weatherData.windSpeedAvg} {weatherData.unit.speedUnit}
          </td>
          <td>Direction (moy/10mn)</td>
          <td>{degToCompass(weatherData.windDirectionAvg)}</td>
        </tr>
        <tr className="table-obs-last-data">
          <td>Vent (rafale)</td>
          <td>
            {weatherData.windGust} {weatherData.unit.speedUnit}
          </td>
          <td>Vent (rafale max.)</td>
          <td>
            {weatherData.windMaxDailyGust} {weatherData.unit.speedUnit}
          </td>
        </tr>
        <tr>
          <td colSpan="4" className="table-obs-header">
            <strong>Qualité de l'air</strong>
          </td>
        </tr>
        <tr className="table-obs-first-data">
          <td>Particule fine</td>
          <td>
            {weatherData.pm25} {weatherData.unit.pmUnit}
          </td>
          <td>Indice de qualité</td>
          <td>{weatherData.aqi}</td>
        </tr>
        <tr className="td_data">
          <td>Particule fine (moy/24h)</td>
          <td>
            {weatherData.pm25Avg} {weatherData.unit.pmUnit}
          </td>
          <td>Indice de qualité (moy/24h)</td>
          <td>{weatherData.aqiAvg}</td>
        </tr>
        <tr className="table-obs-last-data">
          <td>Etat de l'air</td>
          <td>{aqiToText(weatherData.aqi)}</td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td colSpan="4" className="table-obs-header">
            <strong>Radiation solaire et UV</strong>
          </td>
        </tr>
        <tr className="table-obs-first-data">
          <td>Radiation solaire</td>
          <td>
            {weatherData.solarRadiation} {weatherData.unit.solarRadiationUnit}
          </td>
          <td>Variation depuis 1h</td>
          <td>
            {showVariation(
              weatherData.solarRadiationVariation,
              weatherData.unit.solarRadiationUnit
            )}
          </td>
        </tr>
        <tr className="table-obs-last-data">
          <td>UV</td>
          <td>{weatherData.uv}</td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td colSpan="4" className="table-obs-header">
            <strong>Notre localisation</strong>
          </td>
        </tr>
        <tr className="table-obs-first-data">
          <td>Latitude</td>
          <td>{weatherData.weatherStation.lat}</td>
          <td>Longitude</td>
          <td>{weatherData.weatherStation.lng}</td>
        </tr>
        <tr className="table-obs-last-data">
          <td>Altitude</td>
          <td colSpan="0">{weatherData.weatherStation.elevation}</td>
          <td>Lieu</td>
          <td>{weatherData.weatherStation.city}</td>
        </tr>
      </tbody>
    </table>
  );
}
