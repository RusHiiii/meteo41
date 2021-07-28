import React, { Fragment, useEffect, useReducer } from 'react';
import fr from 'apexcharts/dist/locales/fr.json';
import Charts from 'react-apexcharts';
import {
  PERIOD_DAILY,
  PERIOD_MONTHLY,
  PERIOD_WEEKLY,
  PERIOD_YEALY,
} from '../../../common/constant';
import { periodToDateBegin, periodToDateEnd } from '../utils/periodToData';

const GRAPHIC_DATA_SERIES_LOAD = 'GRAPHIC_DATA_SERIES_LOAD';
const GRAPHIC_DATA_PERIOD_CHANGE = 'GRAPHIC_DATA_PERIOD_CHANGE';

const reducer = (state, action) => {
  switch (action.type) {
    case GRAPHIC_DATA_PERIOD_CHANGE:
      return {
        ...state,
        options: {
          ...state.options,
          xaxis: {
            type: 'datetime',
            min: action.minTime,
            max: action.maxTime,
            labels: {
              datetimeUTC: false,
            },
          },
        },
      };
    case GRAPHIC_DATA_SERIES_LOAD:
      return {
        ...state,
        series: [
          {
            name: 'Direction du vent',
            data: action.data,
          },
        ],
        options: {
          ...state.options,
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
                  return (
                    w.globals.series[seriesIndex][dataPointIndex] +
                    ' ' +
                    action.unit
                  );
                },
                title: {
                  formatter: function (val, opts) {
                    return val + ' -';
                  },
                },
              },
            ],
          },
        },
      };
  }

  return state;
};

function useWindDirectionPeriodGraphic({ data, period, unit }) {
  const initialState = {
    series: [],
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
      noData: {
        text: 'Aucune données :(',
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
        min: periodToDateBegin(period).unix() * 1000,
        max: periodToDateEnd(period).unix() * 1000,
        labels: {
          datetimeUTC: false,
        },
      },
      legend: {
        showForSingleSeries: true,
      },
      yaxis: {
        min: 0,
        max: 360,
        tickAmount: 4,
      },
    },
  };

  const [state, dispatch] = useReducer(reducer, initialState);

  useEffect(() => {
    if (!data) {
      return;
    }

    dispatch({
      type: GRAPHIC_DATA_SERIES_LOAD,
      data: data,
      unit: unit,
    });
  }, [data]);

  useEffect(() => {
    if (!period) {
      return;
    }

    dispatch({
      type: GRAPHIC_DATA_PERIOD_CHANGE,
      min: periodToDateBegin(period).unix() * 1000,
      max: periodToDateEnd(period).unix() * 1000,
    });
  }, [period]);

  return [state, dispatch];
}

function WindDirectionPeriodGraphic(props) {
  const [state, dispatch] = useWindDirectionPeriodGraphic(props);

  return (
    <div id="chart">
      <Charts
        options={state.options}
        series={state.series}
        type="scatter"
        height={350}
      />
    </div>
  );
}

export default React.memo(WindDirectionPeriodGraphic);
