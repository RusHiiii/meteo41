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
    maxValue: 900,
    majorTicks: ['0', '150', '300', '450', '600', '750', '900'],
    highlights: [
      { from: 0, to: 150, color: '#D6ECF4' },
      { from: 150, to: 300, color: '#ADD9E9' },
      { from: 300, to: 450, color: '#85c6df' },
      { from: 450, to: 600, color: '#5cb3d4' },
      { from: 600, to: 750, color: '#33a0c9' },
      { from: 750, to: 900, color: '#0d7499' },
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
