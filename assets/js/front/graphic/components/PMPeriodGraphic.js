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
import {hasDatas} from "../utils/hasData";

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
            name: 'Particule fine',
            data: action.dataPm25,
          },
          {
            name: "Qualité de l'air moyen",
            data: action.dataAqiAvg,
          },
          {
            name: "Qualité de l'air",
            data: action.dataAqi,
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
              {
                formatter: function (
                  val,
                  { series, seriesIndex, dataPointIndex, w }
                ) {
                  return w.globals.series[seriesIndex][dataPointIndex];
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
                  return w.globals.series[seriesIndex][dataPointIndex];
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
    case GRAPHIC_DATA_HISTORY_LOAD:
      return {
        ...state,
        options: {
          ...state.options,
          annotations: {
            xaxis: [
              {
                x: action.minTime,
                borderColor: '#999',
                label: {
                  text: action.minValue.toString(),
                  style: {
                    color: '#fff',
                    background: '#09a8e6',
                  },
                },
              },
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

function usePMPeriodGraphic({
  dataPm25,
  dataAqi,
  dataAqiAvg,
  history,
  period,
  unit,
}, inView) {
  const initialState = {
    series: [],
    options: {
      colors: ['#dec137', '#7ab11b', '#09a8e6'],
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
        text: 'Particule fine',
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
      yaxis: {
        min: 0,
        max: 60,
      },
    },
  };

  const [state, dispatch] = useReducer(reducer, initialState);

  useEffect(() => {
    if (!dataAqi || !inView) {
      return;
    }

    if (dataAqi.length === 0 || !hasDatas(dataAqi)) {
      return;
    }

    dispatch({
      type: GRAPHIC_DATA_SERIES_LOAD,
      dataPm25: dataPm25,
      dataAqi: dataAqi,
      dataAqiAvg: dataAqiAvg,
      unit: unit,
    });
  }, [dataAqi, inView]);

  useEffect(() => {
    if (!history || !inView) {
      return;
    }

    if (!history.minPm25 || history.maxPm25) {
      return;
    }

    dispatch({
      type: GRAPHIC_DATA_HISTORY_LOAD,
      minTime: new Date(history.minPm25ReceivedAt).getTime(),
      maxTime: new Date(history.maxPm25ReceivedAt).getTime(),
      minValue: history.minPm25,
      maxValue: history.maxPm25,
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

function PMPeriodGraphic(props) {
  const { ref, inView, entry } = useInView({ threshold: 0 });
  const [state, dispatch] = usePMPeriodGraphic(props, inView);

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

export default React.memo(PMPeriodGraphic);
