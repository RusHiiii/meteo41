import {
  DEFAULT_WEATHER_STATION_REFERENCE,
  DEFAULT_WEATHER_STATION_TITLE,
} from '../constant';

export const WEATHER_STATION_CHANGE_LOCATION =
  'WEATHER_STATION_CHANGE_LOCATION';

const initialState = {
  reference: DEFAULT_WEATHER_STATION_REFERENCE,
};

export default function reducer(state = initialState, action = {}) {
  switch (action.type) {
    case WEATHER_STATION_CHANGE_LOCATION:
      return {
        reference: action.reference,
      };
  }

  return state;
}
