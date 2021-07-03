import React, {
  Fragment,
  useEffect,
  useReducer,
  useRef,
  useState,
} from 'react';
import { RainGauge } from '../../../../../../public/static/js/raingauge';
import { RadialGauge } from '../../../../../../public/static/js/radialgauge';

let giqa = null;

function initGauge(canvas, value, unit) {
  giqa = new RadialGauge(canvas, {
    valueFormat: { dec: 0 },
    minValue: 0,
    maxValue: 300,
    majorTicks: ['0', '50', '100', '150', '200', '250', '300+'],
    colors: { majorTicks: '#FFFFFF' },
    strokeTicks: false,
    highlights: [
      { from: 0, to: 50, color: '#20A120' },
      { from: 50, to: 100, color: '#AFCD0A' },
      { from: 100, to: 150, color: '#F9BA0D' },
      { from: 150, to: 200, color: '#FD6828' },
      { from: 200, to: 250, color: '#BB0000' },
      { from: 250, to: 300, color: '#853085' },
    ],
  });

  giqa.draw();
}

export default function Aqi(props) {
  const canvasRef = useRef(null);

  useEffect(() => {
    const canvas = canvasRef.current;
    initGauge(canvas, props.value, props.unit);
  }, []);

  useEffect(() => {
    if (!props.value) {
      return;
    }

    giqa.setValue(props.value);
  }, [props.value]);

  return <canvas id="aqi" ref={canvasRef} />;
}
