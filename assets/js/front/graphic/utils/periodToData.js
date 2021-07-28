import {
  PERIOD_DAILY,
  PERIOD_MONTHLY,
  PERIOD_WEEKLY,
  PERIOD_YEALY,
} from '../../../common/constant';
import moment from 'moment';

export function periodToDateBegin(value) {
  if (value === PERIOD_DAILY) {
    return moment().startOf('day');
  }

  if (value === PERIOD_WEEKLY) {
    return moment().startOf('week');
  }

  if (value === PERIOD_MONTHLY) {
    return moment().startOf('month');
  }

  if (value === PERIOD_YEALY) {
    return moment().startOf('year');
  }

  return null;
}

export function periodToDateEnd(value) {
  if (value === PERIOD_DAILY) {
    return moment().endOf('day');
  }

  if (value === PERIOD_WEEKLY) {
    return moment().endOf('week');
  }

  if (value === PERIOD_MONTHLY) {
    return moment().endOf('month');
  }

  if (value === PERIOD_YEALY) {
    return moment().endOf('year');
  }

  return null;
}
