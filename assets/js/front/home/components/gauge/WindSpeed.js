import React, {
  Fragment,
  useEffect,
  useReducer,
  useRef,
  useState,
} from 'react';
import { RainGauge } from '../../../../../../public/static/js/raingauge';
import { RadialGauge } from '../../../../../../public/static/js/radialgauge';

function initGauge(canvas, value, unit) {
  let gwspd = new RadialGauge(canvas, {
    units: ` ${unit}`,
    minValue: 0,
    maxValue: 50,
    majorTicks: ['0', '10', '20', '30', '40', '50'],
    colors: { majorTicks: '#FFFFFF' },
    strokeTicks: false,
    highlights: [
      { from: 0, to: 10, color: '#D6ECF4' },
      { from: 10, to: 20, color: '#ADD9E9' },
      { from: 20, to: 30, color: '#85C6DF' },
      { from: 30, to: 40, color: '#5CB3D4' },
      { from: 40, to: 50, color: '#33A0C9' },
    ],
  });

  gwspd.draw();
  gwspd.setValue(value);
}

export default function WindSpeed(props) {
  const canvasRef = useRef(null);

  useEffect(() => {
    const canvas = canvasRef.current;
    initGauge(canvas, props.value, props.unit);
  }, [props.value]);

  return <canvas id="windSpeed" ref={canvasRef} />;
}
