import React, {
  Fragment,
  useEffect,
  useReducer,
  useRef,
  useState,
} from 'react';
import { RainGauge } from '../../../../../../public/static/js/raingauge';

let grainMonthly = null;

function initGauge(canvas, value, unit) {
  grainMonthly = new RainGauge(canvas, {
    minValue: 0,
    maxValue: 90,
    majorTicks: ['0', '15', '30', '45', '60', '75', '90'],
    highlights: [
      { from: 0, to: 15, color: '#D6ECF4' },
      { from: 15, to: 30, color: '#ADD9E9' },
      { from: 30, to: 45, color: '#85c6df' },
      { from: 45, to: 60, color: '#5cb3d4' },
      { from: 60, to: 75, color: '#33a0c9' },
      { from: 75, to: 90, color: '#0d7499' },
    ],
  });

  grainMonthly.draw();
}

export default function RainMonthly(props) {
  const canvasRef = useRef(null);

  useEffect(() => {
    const canvas = canvasRef.current;
    initGauge(canvas, props.value, props.unit);
  }, []);

  useEffect(() => {
    if (props.value === undefined) {
      return;
    }

    grainMonthly.config.units = props.unit;
    grainMonthly.setValue(props.value);
  }, [props.value]);

  return <canvas id="rainMonthly" ref={canvasRef} />;
}
