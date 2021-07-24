import React, { Fragment, useEffect, useReducer } from 'react';
import fr from 'apexcharts/dist/locales/fr.json';
import Charts from 'react-apexcharts';

function getRandomInt(min, max) {
  let nb = Math.random() * (min - max) + max;

  return parseFloat(parseFloat(nb).toFixed(1));
}

const generateData = () => {
  let timestampbegin = 1626220800000;
  let timestampEnd = 1626307200000;
  let dataBegin = 0;
  let d = [[timestampbegin, dataBegin]];

  let min = 0;
  let max = 0;

  while (timestampbegin <= timestampEnd) {
    timestampbegin = timestampbegin + 120000;
    dataBegin = getRandomInt(dataBegin - 1, dataBegin + 1);

    if (dataBegin <= 0) {
      dataBegin += 3;
    }

    let a = [timestampbegin, dataBegin];
    d.push(a);

    if (dataBegin <= min) {
      min = dataBegin;
    }

    if (dataBegin >= max) {
      max = dataBegin;
    }
  }

  return [d, min, max];
};

export default function WindSpeedGraphic(props) {
  var begin = new Date('15 Jul 2021');
  begin.setUTCHours(0);

  var end = new Date('16 Jul 2021');
  end.setUTCHours(0);

  const [a, b, c] = generateData();
  const [aa, ba, ca] = generateData();

  const data = {
    series: [
      {
        name: 'Vitesse du vent',
        data: a,
        type: 'line',
      },
      {
        name: 'Rafale',
        data: aa,
        type: 'area',
      },
    ],
    options: {
      colors: ['#e7bf22', '#0c94c9e3'],
      chart: {
        locales: [fr],
        defaultLocale: 'fr',
        type: 'line',
        toolbar: {
          show: true,
          tools: {
            download: false,
            pan: false,
          },
        },
        zoom: {
          enabled: true,
          type: 'xy',
          autoScaleYaxis: true,
        },
        foreColor: '#fff',
      },
      dataLabels: {
        enabled: false,
      },
      stroke: {
        curve: 'straight',
        width: 2,
      },
      title: {
        text: 'Vent',
        align: 'left',
      },
      grid: {
        row: {
          opacity: 0.5,
        },
        borderColor: '#f1f1f1',
      },
      xaxis: {
        type: 'datetime',
        min: begin.getTime(),
        max: end.getTime(),
      },
      yaxis: {
        forceNiceScale: true,
        min: 0,
        max: c + 2,
      },
      tooltip: {
        x: {
          format: 'dd MMM HH:mm',
        },
        y: [
          {
            formatter: function (
              val,
              { series, seriesIndex, dataPointIndex, w }
            ) {
              return w.globals.series[seriesIndex][dataPointIndex] + ' km/h';
            },
            title: {
              formatter: function (val, opts) {
                return val + ' -';
              },
            },
          },
          {
            formatter: function (
              val,
              { series, seriesIndex, dataPointIndex, w }
            ) {
              return w.globals.series[seriesIndex][dataPointIndex] + ' km/h';
            },
            title: {
              formatter: function (val, opts) {
                return val + ' -';
              },
            },
          },
        ],
      },
      legend: {
        position: 'bottom',
        showForSingleSeries: true,
        tooltipHoverFormatter: function (val, opts) {
          return (
            val +
            ' - ' +
            opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] +
            ' km/h'
          );
        },
      },
      annotations: {
        xaxis: [
          {
            x: 1626228958000,
            borderColor: '#999',
            label: {
              text: 'Min',
              style: {
                color: '#fff',
                background: '#09a8e6',
              },
            },
          },
          {
            x: 1626231958000,
            borderColor: '#999',
            label: {
              text: 'Max',
              style: {
                color: '#fff',
                background: '#ed7839',
              },
            },
          },
        ],
      },
    },
  };

  return (
    <div id="chart">
      <Charts
        options={data.options}
        series={data.series}
        type="line"
        height={350}
      />
    </div>
  );
}
