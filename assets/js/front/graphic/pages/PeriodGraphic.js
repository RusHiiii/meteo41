import React, { Fragment, useEffect, useReducer } from 'react';
import BreadCrumb from '../../../common/components/BreadCrumb';
import SummaryWeatherData from '../../../common/components/weather/SummaryWeatherData';
import { useSelector } from 'react-redux';
import Charts from "react-apexcharts";
import ApexCharts from 'apexcharts';
import fr from "apexcharts/dist/locales/fr.json";

export default function PeriodGraphic(props) {
  const weatherStation = useSelector((state) => state.weatherStation);
  var d = new Date('14 Jul 2021');
  d.setHours(0,0,0,0);

  const state2 = {


    series: [{
      name: "Desktops",
      data: [
        [1626224358000,27.5],
        [1626225958000,28.5],
        [1626226958000,28.2],
        [1626227958000,27.6],
        [1626228958000,12.3],
        [1626229958000,16.5],
        [1626230958000,17.3],
        [1626231958000,15.6],
        [1626232958000,25.6],

      ]
    }],
    options: {
      chart: {
        locales: [fr],
        defaultLocale: "fr",
        height: 350,
        type: 'line',
        zoom: {
          enabled: false
        },
        foreColor: '#fff'
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'straight',
        width: 2,
      },
      title: {
        text: 'Product Trends by Month',
        align: 'left'
      },
      grid: {
        row: {
          opacity: 0.5
        },
        borderColor: '#f1f1f1',
      },
      xaxis: {
        type: 'datetime',
        min: d.getTime(),
        max: new Date('15 Jul 2021').getTime(),
        tickAmount: 6,
        labels: {
          datetimeUTC: false
        }
      },
      tooltip: {
        enabled: true,
        x: {
          format: 'dd MMM HH:mm'
        },
        y: [
          {
            formatter: function(val, { series, seriesIndex, dataPointIndex, w }) {
              return w.globals.series[seriesIndex][dataPointIndex] + ' °C'
            },
            title: {
              formatter: function(val, opts) {
                return val + ' -'
              }
            }
          }
        ]
      },
      legend: {
        show: true,
        position: 'bottom',
        showForSingleSeries: true,
        tooltipHoverFormatter: function(val, opts) {
          return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ' °C'
        }
      },
      annotations: {
        xaxis: [{
          x: 1626228958000,
          borderColor: '#999',
          yAxisIndex: 0,
          label: {
            show: true,
            text: 'Min',
            style: {
              color: "#fff",
              background: '#09a8e6'
            }
          }
        },
          {
            x: 1626231958000,
            borderColor: '#999',
            yAxisIndex: 0,
            label: {
              show: true,
              text: 'Max',
              style: {
                color: "#fff",
                background: '#ed7839'
              }
            }
          }],
      },
    }


  };

  const state = {

    series: [{
      name: "Session Duration",
      data: [45, 52, 38, 24, 33, 26, 21, 20, 6, 8, 15, 10]
    },
      {
        name: "Page Views",
        data: [35, 41, 62, 42, 13, 18, 29, 37, 36, 51, 32, 35]
      },
      {
        name: 'Total Visits',
        data: [87, 57, 74, 99, 75, 38, 62, 47, 82, 56, 45, 47]
      }
    ],
    options: {
      chart: {
        height: 350,
        type: 'line',
        zoom: {
          enabled: false
        },
        foreColor: '#fff'
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        width: [5, 7, 5],
        curve: 'straight',
        dashArray: [0, 8, 5]
      },
      title: {
        text: 'Page Statistics',
        align: 'left'
      },
      legend: {
        tooltipHoverFormatter: function(val, opts) {
          return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
        }
      },
      markers: {
        size: 0,
        hover: {
          sizeOffset: 6
        }
      },
      xaxis: {
        min: d,
        max: new Date(),
        labels: {
          datetimeFormatter: {
            hour: 'HH:mm'
          }
        }
      },
      tooltip: {
        y: [
          {
            title: {
              formatter: function (val) {
                return val + " (mins)"
              }
            }
          },
          {
            title: {
              formatter: function (val) {
                return val + " per session"
              }
            }
          },
          {
            title: {
              formatter: function (val) {
                return val;
              }
            }
          }
        ]
      },
      grid: {
        borderColor: '#f1f1f1',
      }
    },


  };

  return (
    <Fragment>
      <BreadCrumb
        url="/weather/current"
        page="Graphiques"
        text="Données"
      />

      <div className="fullwidth-block no-padding-top">
        <div className="container">
          <div className="row">
            <div className="fullwidth-block padding-content">
              <div className="content col-md-12">
                <div className="post single">
                  <h2 className="entry-title">
                    Graphique de la station
                  </h2>
                </div>
              </div>
              <div className="content col-md-8">
                <div className="post single">
                  <div className="featured-image">
                    <img
                      src={'/static/images/chenonceau.png'}
                      alt="Chenonceau"
                    />
                  </div>

                  <div className="entry-content">
                    <div className="primary-alert">
                      Les graphiques ne sont pas encore accessible :(
                    </div>
                  </div>
                </div>
              </div>
              <SummaryWeatherData />
              <div className="content col-md-12">
                <div id="chart">
                  <Charts options={state.options} series={state.series} type="line" height={350} />
                </div>
                <div id="chart">
                  <Charts options={state2.options} series={state2.series} type="line" height={350} />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </Fragment>
  );
}
