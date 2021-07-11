import React, {
  Fragment,
  useEffect,
  useReducer,
  useRef,
  useState,
} from 'react';
import { RainGauge } from '../../../../../../public/static/js/raingauge';
import { RadialGauge } from '../../../../../../public/static/js/radialgauge';

let gwdir = null;

function initGauge(canvas, value, unit) {
  gwdir = new RadialGauge(canvas, {
    majorTicks: ['N', 'NE', 'E', 'SE', 'S', 'SW', 'W', 'NW'],
    dirGauge: true,
    minValue: 0,
    maxValue: 360,
    minorTicks: 0,
    colors: { majorTicks: '#FFFFFF' },
    strokeTicks: false,
    highlights: [
      { from: 0, to: 90, color: '#add9e9' },
      { from: 90, to: 180, color: '#add9e9' },
      { from: 180, to: 270, color: '#add9e9' },
      { from: 270, to: 360, color: '#add9e9' },
    ],
  });

  gwdir.draw();
}

export default function WindDirection(props) {
  const canvasRef = useRef(null);

  useEffect(() => {
    const canvas = canvasRef.current;
    initGauge(canvas, props.value, props.unit);
  }, []);

  useEffect(() => {
    if (props.value === undefined) {
      return;
    }

    gwdir.setValue(props.value);
  }, [props.value]);

  return <canvas id="windDirection" ref={canvasRef} />;
}
