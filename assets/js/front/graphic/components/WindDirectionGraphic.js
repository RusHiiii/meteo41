import React, { Fragment, useEffect, useReducer } from 'react';
import fr from 'apexcharts/dist/locales/fr.json';
import Charts from 'react-apexcharts';

function getRandomInt(min, max) {
  min = Math.ceil(min);
  max = Math.floor(max);
  return (Math.floor(Math.random() * (max - min + 1)) + min) % 360;
}

const generateData = () => {
  let timestampbegin = 1626220800000;
  let timestampEnd = 1626307200000;
  let dataBegin = 180;
  let d = [[timestampbegin, dataBegin]];

  let min = 71;
  let max = 71;

  while (timestampbegin <= timestampEnd) {
    timestampbegin = timestampbegin + 300000;
    dataBegin = getRandomInt(dataBegin - 1, dataBegin + 1);

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

export default function WindDirectionGraphic(props) {
  var begin = new Date('15 Jul 2021');
  begin.setUTCHours(0);

  var end = new Date('16 Jul 2021');
  end.setUTCHours(0);

  const [a, b, c] = generateData();

  const data = {
    series: [
      {
        name: 'Direction du vent',
        data: a,
      },
    ],
    options: {
      colors: ['#e7bf22'],
      chart: {
        locales: [fr],
        defaultLocale: 'fr',
        type: 'scatter',
        foreColor: '#fff',
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
      },
      dataLabels: {
        enabled: false,
      },
      markers: {
        size: 2,
      },
      title: {
        text: 'Direction du vent',
        align: 'left',
      },
      grid: {
        borderColor: '#f1f1f1',
      },
      xaxis: {
        type: 'datetime',
        min: begin.getTime(),
        max: end.getTime(),
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
              return w.globals.series[seriesIndex][dataPointIndex] + ' °';
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
        showForSingleSeries: true,
      },
      yaxis: {
        min: 0,
        max: 360,
        tickAmount: 4,
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
        type="scatter"
        height={350}
      />
    </div>
  );
}
