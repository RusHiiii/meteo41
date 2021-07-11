import React, {
  Fragment,
  useEffect,
  useReducer,
  useRef,
  useState,
} from 'react';
import { RainGauge } from '../../../../../../public/static/js/raingauge';
import { RadialGauge } from '../../../../../../public/static/js/radialgauge';

let gsol = null;

function initGauge(canvas, value, unit) {
  gsol = new RadialGauge(canvas, {
    units: ` ${unit}`,
    minValue: 0,
    maxValue: 1500,
    majorTicks: ['0', '300', '600', '900', '1200', '1500'],
    colors: { majorTicks: '#FFFFFF' },
    strokeTicks: false,
    highlights: [
      { from: 0, to: 300, color: '#f7e34a' },
      { from: 300, to: 600, color: '#edbe3e' },
      { from: 600, to: 900, color: '#e39a32' },
      { from: 900, to: 1200, color: '#da7526' },
      { from: 1200, to: 1500, color: '#d0511a' },
    ],
  });

  gsol.draw();
}

export default function SolarRadiation(props) {
  const canvasRef = useRef(null);

  useEffect(() => {
    const canvas = canvasRef.current;
    initGauge(canvas, props.value, props.unit);
  }, []);

  useEffect(() => {
    if (props.value === undefined) {
      return;
    }

    gsol.config.units = props.unit;
    gsol.setValue(props.value);
  }, [props.value]);

  return <canvas id="solarRadiation" ref={canvasRef} />;
}
