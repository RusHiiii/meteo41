import React, {
  Fragment,
  useEffect,
  useReducer,
  useRef,
  useState,
} from 'react';
import { RainGauge } from '../../../../../../public/static/js/raingauge';
import { RadialGauge } from '../../../../../../public/static/js/radialgauge';

let gwspd = null;

function initGauge(canvas, value, unit) {
  gwspd = new RadialGauge(canvas, {
    units: ` ${unit}`,
    minValue: 0,
    maxValue: 25,
    majorTicks: ['0', '5', '10', '15', '20', '25'],
    colors: { majorTicks: '#FFFFFF' },
    strokeTicks: false,
    highlights: [
      { from: 0, to: 5, color: '#D6ECF4' },
      { from: 5, to: 10, color: '#ADD9E9' },
      { from: 10, to: 15, color: '#85C6DF' },
      { from: 15, to: 20, color: '#5CB3D4' },
      { from: 20, to: 25, color: '#33A0C9' },
    ],
  });

  gwspd.draw();
}

export default function WindSpeed(props) {
  const canvasRef = useRef(null);

  useEffect(() => {
    const canvas = canvasRef.current;
    initGauge(canvas, props.value, props.unit);
  }, []);

  useEffect(() => {
    if (props.value === undefined) {
      return;
    }

    gwspd.config.units = props.unit;
    gwspd.setValue(props.value);
  }, [props.value]);

  return <canvas id="windSpeed" ref={canvasRef} />;
}
