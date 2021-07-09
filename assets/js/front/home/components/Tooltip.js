import React, { Fragment, useEffect, useReducer, useState } from 'react';
import { apiClient } from '../../../common/utils/apiClient';
import queryString from 'qs';
import {
  Date as DateComponent,
  Date as DateMoment,
} from '../../../common/components/Date';
import { degToCompass } from '../../weatherData/utils/degreesToCompass';
import { iconIdToSvg } from '../utils/iconIdToSvg';
import { showFixedValue } from '../utils/showFixedValue';
import { showSpeedValue } from '../utils/showSpeedValue';
import { showRoundValue } from '../utils/showRoundValue';
import moment from 'moment';
import ReactTooltip from 'react-tooltip';

export default function Tooltip(props) {
  const { min, max, unit, minReceivedAt, maxReceivedAt, id } = props;

  return (
    <ReactTooltip id={id} backgroundColor="#1e202b">
      <p className="blue-min">
        ⤓ {min} {unit} à <DateComponent date={minReceivedAt} format={'LT'} />
      </p>
      <p className="orange-max">
        ⤒ {max} {unit} à <DateComponent date={maxReceivedAt} format={'LT'} />
      </p>
    </ReactTooltip>
  );
}
