import React, {
  useEffect,
  useRef,
} from 'react';
import { Thermometer } from '../../../../../../public/static/js/thermometer';

let gsoil = null;

function initGauge(canvas, value, unit) {
  gsoil = new Thermometer(canvas, {
    units: ` ${unit ?? '°C'}`,
    minValue: 0,
    maxValue: 25,
    majorTicks: ['0', '5', '10', '15', '20', '25'],
    colors: { majorTicks: '#FFFFFF' },
    strokeTicks: false,
    highlights: [
      { from: 0, to: 5, color: '#49afcd' },
      { from: 5, to: 10, color: '#7fc3dd' },
      { from: 10, to: 15, color: '#d2b9be' },
      { from: 15, to: 20, color: '#da7777' },
      { from: 20, to: 25, color: '#c83333' },
    ],
  });

  gsoil.draw();
}

export default function SoilTemperature(props) {
  const canvasRef = useRef(null);

  useEffect(() => {
    const canvas = canvasRef.current;
    initGauge(canvas, props.value, props.unit);
  }, []);

  useEffect(() => {
    if (props.value === undefined) {
      return;
    }

    if (props.unit === undefined) {
      return;
    }

    gsoil.config.units = props.unit;
    gsoil.setValue(props.value);
  }, [props.value]);

  return <canvas id="soilTemperature" ref={canvasRef} />;
}
