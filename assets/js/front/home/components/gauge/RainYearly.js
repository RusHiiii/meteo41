import React, {
  Fragment,
  useEffect,
  useReducer,
  useRef,
  useState,
} from 'react';
import { RainGauge } from '../../../../../../public/static/js/raingauge';

let grainYearly = null;

function initGauge(canvas, value, unit) {
  grainYearly = new RainGauge(canvas, {
    minValue: 0,
    maxValue: 750,
    majorTicks: ['0', '150', '300', '450', '600', '750'],
    highlights: [
      { from: 0, to: 150, color: '#DBEFF5' },
      { from: 150, to: 300, color: '#B6DFEB' },
      { from: 300, to: 450, color: '#92CFE1' },
      { from: 450, to: 600, color: '#6DBFD7' },
      { from: 600, to: 750, color: '#49AFCD' },
    ],
  });

  grainYearly.draw();
}

export default function RainYearly(props) {
  const canvasRef = useRef(null);

  useEffect(() => {
    const canvas = canvasRef.current;
    initGauge(canvas, props.value, props.unit);
  }, []);

  useEffect(() => {
    if (props.value === undefined) {
      return;
    }

    grainYearly.config.units = props.unit;
    grainYearly.setValue(props.value);
  }, [props.value]);

  return <canvas id="rainYearly" ref={canvasRef} />;
}
