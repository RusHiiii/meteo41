import React, {
  Fragment,
  useEffect,
  useReducer,
  useRef,
  useState,
} from 'react';
import { RainGauge } from '../../../../../../public/static/js/raingauge';

function initGauge(canvas, value, unit) {
  let grain = new RainGauge(canvas, {
    units: ` ${unit}`,
    minValue: 0,
    maxValue: 50,
    majorTicks: ['0', '10', '20', '30', '40', '50'],
    highlights: [
      { from: 0, to: 10, color: '#DBEFF5' },
      { from: 10, to: 20, color: '#B6DFEB' },
      { from: 20, to: 30, color: '#92CFE1' },
      { from: 30, to: 40, color: '#6DBFD7' },
      { from: 40, to: 50, color: '#49AFCD' },
    ],
  });

  grain.draw();
  grain.setValue(value);
}

export default function Rain(props) {
  const canvasRef = useRef(null);

  useEffect(() => {
    const canvas = canvasRef.current;
    initGauge(canvas, props.value, props.unit);
  }, [props.value]);

  return <canvas id="rain" ref={canvasRef} />;
}
