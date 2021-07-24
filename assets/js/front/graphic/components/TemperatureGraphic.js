import React, { Fragment, useEffect, useReducer, useState } from 'react';
import fr from 'apexcharts/dist/locales/fr.json';
import Charts from 'react-apexcharts';

function getRandomInt(min, max) {
  let nb = Math.random() * (min - max) + max;

  return parseFloat(parseFloat(nb).toFixed(1));
}

const generateData = () => {
  let timestampbegin = 1626220800000;
  let timestampEnd = 1626307200000;
  let dataBegin = 19;
  let d = [[timestampbegin, dataBegin]];

  let min = 19;
  let max = 19;
  let minTime = timestampbegin;
  let maxTime = timestampbegin;

  while (timestampbegin <= timestampEnd) {
    timestampbegin = timestampbegin + 120000;
    dataBegin = getRandomInt(dataBegin - 0.1, dataBegin + 0.1);

    let a = [timestampbegin, dataBegin];
    d.push(a);

    if (dataBegin <= min) {
      min = dataBegin;
      minTime = timestampbegin;
    }

    if (dataBegin >= max) {
      max = dataBegin;
      maxTime = timestampbegin;
    }
  }

  return [d, min, max, minTime, maxTime];
};

export default function TemperatureGraphic(props) {
  var begin = new Date('15 Jul 2021');
  begin.setUTCHours(0);

  var end = new Date('16 Jul 2021');
  end.setUTCHours(0);

  let [a, b, c, minTime, maxTime] = generateData();
  let [aa, ba, ca] = generateData();
  let [aaa, baa, caa] = generateData();

  const reload = () => {
    let [a, b, c, minTime, maxTime] = generateData();
    let [aa, ba, ca] = generateData();
    let [aaa, baa, caa] = generateData();

    setDataa({
      ...dataa,
      series: [
        {
          name: 'Température',
          data: a,
        },
        {
          name: 'Température ressentie',
          data: aa,
        },
        {
          name: 'Point de rosée',
          data: aaa,
        },
      ],
      options: {
        ...dataa.options,
        yaxis: {
          forceNiceScale: true,
          min: b - 2,
          max: c + 2,
        },
        annotations: {
          ...dataa.options.annotations,
          xaxis: [
            {
              x: minTime,
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
              x: maxTime,
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
    });
  };

  const data = {
    series: [
      {
        name: 'Température',
        data: a,
      },
      {
        name: 'Température ressentie',
        data: aa,
      },
      {
        name: 'Point de rosée',
        data: aaa,
      },
    ],
    options: {
      colors: ['#dec137', '#7ab11b', '#09a8e6'],
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
        min: begin.getTime(),
        max: end.getTime(),
      },
      yaxis: {
        forceNiceScale: true,
        min: b - 2,
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
            x: minTime,
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
            x: maxTime,
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

  const [dataa, setDataa] = useState(data);

  return (
    <>
      <button onClick={() => reload()}>reload</button>
      <div id="chart">
        <Charts
          options={dataa.options}
          series={dataa.series}
          type="line"
          height={350}
        />
      </div>
    </>
  );
}
