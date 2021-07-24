import React, { Fragment, useEffect, useReducer } from 'react';
import BreadCrumb from '../../../common/components/BreadCrumb';
import SummaryWeatherData from '../../../common/components/weather/SummaryWeatherData';
import TemperatureGraphic from '../components/TemperatureGraphic';
import HumidityGraphic from '../components/HumidityGraphic';
import WindDirectionGraphic from '../components/WindDirectionGraphic';
import WindSpeedGraphic from '../components/WindSpeedGraphic';
import Select from '../../../common/components/form/Select';
import { ROLE_ADMIN, ROLE_EDITOR } from '../../../common/constant';

const choices = [
  {
    value: 'DAILY',
    text: 'Jour',
  },
  {
    value: 'WEEKLY',
    text: 'Semaine',
  },
];

export default function PeriodGraphic(props) {
  return (
    <Fragment>
      <BreadCrumb url="/weather/current" page="Graphiques" text="Données" />

      <div className="fullwidth-block no-padding-top">
        <div className="container">
          <div className="row">
            <div className="fullwidth-block padding-content">
              <div className="content col-md-12">
                <div className="post single">
                  <h2 className="entry-title">Graphique de la station</h2>
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

                    <div className="pagination">
                      <div className="filter">
                        <div className="count filter-control">
                          <label htmlFor="">Page</label>
                          <Select
                            name="roles"
                            value="DAILY"
                            choices={choices}
                            onChange={(a) => console.log(a)}
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <SummaryWeatherData />
              <div className="content col-md-12">
                <TemperatureGraphic />
                <HumidityGraphic />
                <WindDirectionGraphic />
                <WindSpeedGraphic />
              </div>
            </div>
          </div>
        </div>
      </div>
    </Fragment>
  );
}
