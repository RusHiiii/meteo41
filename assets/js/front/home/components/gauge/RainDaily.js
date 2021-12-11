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
    maxValue: 30,
    majorTicks: ['0', '5', '10', '15', '20', '25', '30'],
    highlights: [
      { from: 0, to: 5, color: '#D6ECF4' },
      { from: 5, to: 10, color: '#ADD9E9' },
      { from: 10, to: 15, color: '#85c6df' },
      { from: 15, to: 20, color: '#5cb3d4' },
      { from: 20, to: 25, color: '#33a0c9' },
      { from: 25, to: 30, color: '#0d7499' },
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
    if (props.value === undefined) {
      return;
    }

    grainDaily.config.units = props.unit;
    grainDaily.setValue(props.value);
  }, [props.value]);

  return <canvas id="rainDaily" ref={canvasRef} />;
}
