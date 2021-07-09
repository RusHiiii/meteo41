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
    maxValue: 75,
    majorTicks: ['0', '15', '30', '45', '60', '75'],
    highlights: [
      { from: 0, to: 15, color: '#DBEFF5' },
      { from: 15, to: 30, color: '#B6DFEB' },
      { from: 30, to: 45, color: '#92CFE1' },
      { from: 45, to: 60, color: '#6DBFD7' },
      { from: 60, to: 75, color: '#49AFCD' },
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
    if (!props.value) {
      return;
    }

    grainMonthly.config.units = props.unit;
    grainMonthly.setValue(props.value);
  }, [props.value]);

  return <canvas id="rainMonthly" ref={canvasRef} />;
}
