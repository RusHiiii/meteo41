import React, {
  Fragment,
  useEffect,
  useReducer,
  useRef,
  useState,
} from 'react';
import { RainGauge } from '../../../../../../public/static/js/raingauge';

let grainDaily = null;

function initGauge(canvas, value, unit) {
  grainDaily = new RainGauge(canvas, {
    minValue: 0,
    maxValue: 25,
    majorTicks: ['0', '5', '10', '15', '20', '25'],
    highlights: [
      { from: 0, to: 5, color: '#DBEFF5' },
      { from: 5, to: 10, color: '#B6DFEB' },
      { from: 10, to: 15, color: '#92CFE1' },
      { from: 15, to: 20, color: '#6DBFD7' },
      { from: 20, to: 25, color: '#49AFCD' },
    ],
  });

  grainDaily.draw();
}

export default function RainDaily(props) {
  const canvasRef = useRef(null);

  useEffect(() => {
    const canvas = canvasRef.current;
    initGauge(canvas, props.value, props.unit);
  }, []);

  useEffect(() => {
    if (!props.value) {
      return;
    }

    grainDaily.config.units = props.unit;
    grainDaily.setValue(props.value);
  }, [props.value]);

  return <canvas id="rainDaily" ref={canvasRef} />;
}
