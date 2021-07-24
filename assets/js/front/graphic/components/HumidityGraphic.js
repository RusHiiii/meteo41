import React, { Fragment, useEffect, useReducer } from 'react';
import fr from 'apexcharts/dist/locales/fr.json';
import Charts from 'react-apexcharts';

export default function HumidityGraphic(props) {
  var d = new Date('14 Jul 2021');
  d.setHours(0, 0, 0, 0);

  const data = {
    series: [
      {
        name: 'Humidité',
        data: [
          [1626224358000, 80],
          [1626225958000, 79],
          [1626226958000, 80],
          [1626227958000, 81],
          [1626228958000, 82],
          [1626229958000, 83],
          [1626230958000, 84],
          [1626231958000, 84],
          [1626232958000, 83],
        ],
      },
    ],
    options: {
      colors: ['#dec137'],
      chart: {
        locales: [fr],
        defaultLocale: 'fr',
        type: 'line',
        foreColor: '#fff',
        toolbar: {
          show: true,
          tools: {
            download: false,
            pan: false
          }
        },
        zoom: {
          type: 'x',
        }
      },
      dataLabels: {
        enabled: false,
      },
      stroke: {
        curve: 'straight',
        width: 2,
      },
      title: {
        text: 'Humidité',
        align: 'left',
      },
      grid: {
        borderColor: '#f1f1f1',
      },
      xaxis: {
        type: 'datetime',
        min: d.getTime(),
        max: new Date('15 Jul 2021').getTime(),
        labels: {
          datetimeUTC: false,
        },
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
              return w.globals.series[seriesIndex][dataPointIndex] + ' %';
            },
            title: {
              formatter: function (val, opts) {
                return val + ' -';
              },
            },
          }
        ],
      },
      legend: {
        showForSingleSeries: true,
        tooltipHoverFormatter: function (val, opts) {
          return (
            val +
            ' - ' +
            opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] +
            ' %'
          );
        },
      },
      yaxis: {
        forceNiceScale: true,
        min: 78,
        max: 86,
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
        ]
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
