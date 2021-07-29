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
import {useInView} from "react-intersection-observer";

const GRAPHIC_DATA_SERIES_LOAD = 'GRAPHIC_DATA_SERIES_LOAD';
const GRAPHIC_DATA_HISTORY_LOAD = 'GRAPHIC_DATA_HISTORY_LOAD';
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
            name: 'UV',
            data: action.data,
          },
        ],
        options: {
          ...state.options,
          yaxis: {
            ...state.yaxis,
            forceNiceScale: true,
          },
          tooltip: {
            x: {
              format: 'dd MMM HH:mm',
            },
            y: [
              {
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
    case GRAPHIC_DATA_HISTORY_LOAD:
      return {
        ...state,
        options: {
          ...state.options,
          annotations: {
            xaxis: [
              {
                x: action.maxTime,
                borderColor: '#999',
                label: {
                  text: action.maxValue.toString(),
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
  }

  return state;
};

function useUVPeriodGraphic({ data, history, period, unit }, inView) {
  const initialState = {
    series: [],
    options: {
      colors: ['#e7bf22'],
      chart: {
        locales: [fr],
        defaultLocale: 'fr',
        type: 'line',
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
      stroke: {
        curve: 'smooth',
        width: 2,
      },
      title: {
        text: 'UV',
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
        max: 14,
      },
    },
  };

  const [state, dispatch] = useReducer(reducer, initialState);

  useEffect(() => {
    if (!data || !inView) {
      return;
    }

    dispatch({
      type: GRAPHIC_DATA_SERIES_LOAD,
      data: data,
      unit: unit,
    });
  }, [data, inView]);

  useEffect(() => {
    if (!history || !inView) {
      return;
    }

    dispatch({
      type: GRAPHIC_DATA_HISTORY_LOAD,
      maxTime: new Date(history.maxUvReceivedAt).getTime(),
      maxValue: history.maxUv,
    });
  }, [history, inView]);

  useEffect(() => {
    if (!period || !inView) {
      return;
    }

    dispatch({
      type: GRAPHIC_DATA_PERIOD_CHANGE,
      min: periodToDateBegin(period).unix() * 1000,
      max: periodToDateEnd(period).unix() * 1000,
    });
  }, [period, inView]);

  return [state, dispatch];
}

function UVPeriodGraphic(props) {
  const { ref, inView, entry } = useInView({ threshold: 0 });
  const [state, dispatch] = useUVPeriodGraphic(props, inView);

  return (
    <div id="chart" ref={ref}>
      <Charts
        options={state.options}
        series={state.series}
        type="line"
        height={350}
      />
    </div>
  );
}

export default React.memo(UVPeriodGraphic);
