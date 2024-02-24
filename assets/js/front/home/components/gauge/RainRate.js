import React, {
  Fragment,
  useEffect,
  useReducer,
  useRef,
  useState,
} from 'react';
import { RadialGauge } from '../../../../../../public/static/js/radialgauge';

let grainrate = null;

function initGauge(canvas, value, unit) {
  grainrate = new RadialGauge(canvas, {
    units: ` ${unit ?? 'mm'}/h`,
    minValue: 0,
    maxValue: 60,
    colors: { majorTicks: '#FFFFFF' },
    strokeTicks: false,
    majorTicks: ['0', '10', '20', '30', '40', '50', '60'],
    highlights: [
      { from: 0, to: 10, color: '#D6ECF4' },
      { from: 10, to: 20, color: '#ADD9E9' },
      { from: 20, to: 30, color: '#85c6df' },
      { from: 30, to: 40, color: '#5cb3d4' },
      { from: 40, to: 50, color: '#33a0c9' },
      { from: 50, to: 60, color: '#0d7499' },
    ],
  });

  grainrate.draw();
}

export default function RainRate(props) {
  const canvasRef = useRef(null);

  useEffect(() => {
    const canvas = canvasRef.current;
    initGauge(canvas, props.value, props.unit);
  }, []);

  useEffect(() => {
    if (props.value === undefined) {
      return;
    }

    grainrate.config.units = props.unit;
    grainrate.setValue(props.value);
  }, [props.value]);

  return <canvas id="rainRate" ref={canvasRef} />;
}
