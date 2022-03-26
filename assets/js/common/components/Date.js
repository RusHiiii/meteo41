import React, { useMemo } from 'react';
import moment from 'moment';

export function Date(props) {
  const { format, date } = props;

  if (!props.date) {
    return '-';
  }

  return useMemo(() => {
    return moment(date).locale(document.documentElement.lang).format(format);
  }, [date]);
}
