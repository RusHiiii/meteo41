import React, {
  Fragment,
  useEffect,
  useReducer,
  useRef,
  useState,
} from 'react';
import { RainGauge } from '../../../../../../public/static/js/raingauge';
import { RadialGauge } from '../../../../../../public/static/js/radialgauge';

let guvi = null;

function initGauge(canvas, value, unit) {
  guvi = new RadialGauge(canvas, {
    units: ' ',
    minValue: 0,
    maxValue: 12,
    majorTicks: ['0', '', '2', '', '4', '', '6', '', '8', '', '10', '', '12+'],
    colors: { majorTicks: '#FFFFFF' },
    strokeTicks: false,
    highlights: [
      { from: 0, to: 1, color: '#20A120' },
      { from: 1, to: 2, color: '#67B715' },
      { from: 2, to: 3, color: '#AFCD0A' },
      { from: 3, to: 4, color: '#F7E400' },
      { from: 4, to: 5, color: '#F9BA0D' },
      { from: 5, to: 6, color: '#FB911A' },
      { from: 6, to: 7, color: '#FD6828' },
      { from: 7, to: 8, color: '#DC3414' },
      { from: 8, to: 9, color: '#BB0000' },
      { from: 9, to: 10, color: '#A01842' },
      { from: 10, to: 11, color: '#853085' },
      { from: 11, to: 12, color: '#6B49C8' },
    ],
  });

  guvi.draw();
}

export default function Uv(props) {
  const canvasRef = useRef(null);

  useEffect(() => {
    const canvas = canvasRef.current;
    initGauge(canvas, props.value, props.unit);
  }, []);

  useEffect(() => {
    if (props.value === undefined) {
      return;
    }

    guvi.setValue(props.value);
  }, [props.value]);

  return <canvas id="uv" ref={canvasRef} />;
}
