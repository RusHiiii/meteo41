import React, {
  useEffect,
  useRef,
} from 'react';
import { RadialGauge } from '../../../../../../public/static/js/radialgauge';

let gleaf = null;

function initGauge(canvas, value, unit) {
  gleaf = new RadialGauge(canvas, {
    units: ` ${unit ?? '%'}`,
    valueFormat: { dec: 0 },
    minValue: 0,
    maxValue: 100,
    majorTicks: ['0', '20', '40', '60', '80', '100'],
    colors: { majorTicks: '#FFFFFF' },
    strokeTicks: false,
    highlights: [
      { from: 0, to: 20, color: '#e4e4eb' },
      { from: 20, to: 40, color: '#c1c1d0' },
      { from: 40, to: 60, color: '#a1a1b8' },
      { from: 60, to: 80, color: '#8484a1' },
      { from: 80, to: 100, color: '#68688b' },
    ],
  });

  gleaf.draw();
}

export default function LeafWetness(props) {
  const canvasRef = useRef(null);

  useEffect(() => {
    const canvas = canvasRef.current;
    initGauge(canvas, props.value, props.unit);
  }, []);

  useEffect(() => {
    if (props.value === undefined) {
      return;
    }

    gleaf.config.units = props.unit;
    gleaf.setValue(props.value);
  }, [props.value]);

  return <canvas id="leafWetness" ref={canvasRef} />;
}
