import React, {
  Fragment,
  useEffect,
  useReducer,
  useRef,
  useState,
} from 'react';
import { RainGauge } from '../../../../../../public/static/js/raingauge';
import { RadialGauge } from '../../../../../../public/static/js/radialgauge';

let gwspd = null;

function initGauge(canvas, value, unit) {
  gwspd = new RadialGauge(canvas, {
    units: ` ${unit ?? 'km/h'}`,
    minValue: 0,
    maxValue: 60,
    majorTicks: ['0', '10', '20', '30', '40', '50', '60'],
    colors: { majorTicks: '#FFFFFF' },
    strokeTicks: false,
    highlights: [
      { from: 0, to: 10, color: '#D6ECF4' },
      { from: 10, to: 20, color: '#ADD9E9' },
      { from: 20, to: 30, color: '#85c6df' },
      { from: 30, to: 40, color: '#5cb3d4' },
      { from: 40, to: 50, color: '#33a0c9' },
      { from: 50, to: 60, color: '#0d7499' },
    ],
  });

  gwspd.draw();
}

export default function WindMaxGust(props) {
  const canvasRef = useRef(null);

  useEffect(() => {
    const canvas = canvasRef.current;
    initGauge(canvas, props.value, props.unit);
  }, []);

  useEffect(() => {
    if (props.value === undefined) {
      return;
    }

    gwspd.config.units = props.unit;
    gwspd.setValue(props.value);
  }, [props.value]);

  return <canvas id="windMaxGust" ref={canvasRef} />;
}
