import React, { Fragment, useEffect, useReducer } from 'react';
import fr from 'apexcharts/dist/locales/fr.json';
import Charts from 'react-apexcharts';

export default function TemperatureGraphic(props) {
  var d = new Date('14 Jul 2021');
  d.setHours(0, 0, 0, 0);

  const data = {
    series: [
      {
        name: 'Température',
        data: [
          [1626224358000, 27.5],
          [1626225958000, 28.5],
          [1626226958000, 28.2],
          [1626227958000, 27.6],
          [1626228958000, 12.3],
          [1626229958000, 16.5],
          [1626230958000, 17.3],
          [1626231958000, 15.6],
          [1626232958000, 25.6],
        ],
      },
      {
        name: 'Température ressentie',
        data: [
          [1626224358000, 21.5],
          [1626225958000, 22.5],
          [1626226958000, 23.2],
          [1626227958000, 20.6],
          [1626228958000, 16.3],
          [1626229958000, 18.5],
          [1626230958000, 14.3],
          [1626231958000, 16.6],
          [1626232958000, 20.6],
        ],
      },
      {
        name: 'Point de rosée',
        data: [
          [1626224358000, 12.5],
          [1626225958000, 13.5],
          [1626226958000, 15.2],
          [1626227958000, 16.6],
          [1626228958000, 12.3],
          [1626229958000, 15.5],
          [1626230958000, 12.3],
          [1626231958000, 19.6],
          [1626232958000, 20.6],
        ],
      },
    ],
    options: {
      colors: ['#dec137', '#7ab11b', '#3682d3'],
      chart: {
        locales: [fr],
        defaultLocale: 'fr',
        type: 'line',
        toolbar: {
          show: true,
          tools: {
            download: false,
            pan: false
          }
        },
        zoom: {
          type: 'x',
        },
        foreColor: '#fff'
      },
      dataLabels: {
        enabled: false,
      },
      stroke: {
        curve: 'straight',
        width: 2,
      },
      title: {
        text: 'Température, température ressentie et point de rosée',
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
        min: d.getTime(),
        max: new Date('15 Jul 2021').getTime(),
        labels: {
          datetimeUTC: false,
        },
      },
      yaxis: {
        forceNiceScale: true,
        min: 10,
        max: 32,
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
              return w.globals.series[seriesIndex][dataPointIndex] + ' °C';
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
              return w.globals.series[seriesIndex][dataPointIndex] + ' °C';
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
              return w.globals.series[seriesIndex][dataPointIndex] + ' °C';
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
            ' °C'
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
