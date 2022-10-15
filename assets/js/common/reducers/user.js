import jwtDecode from 'jwt-decode';
import { localStorageManager } from '../utils/localStorageManager';

export const USER_LOGGED = 'USER_LOGGED';
export const USER_LOGOUT = 'USER_LOGOUT';

const token = localStorageManager().get('token');

const initialState = token
  ? {
      ...jwtDecode(token),
      connected: jwtDecode(token).exp > Date.now() / 1000,
    }
  : {
      roles: [],
      connected: false,
    };

export default function reducer(state = initialState, action = {}) {
  switch (action.type) {
    case USER_LOGGED:
      return {
        ...jwtDecode(action.token),
        connected: jwtDecode(action.token).exp > Date.now() / 1000,
      };
    case USER_LOGOUT:
      return {
        roles: [],
        connected: false,
      };
  }

  return state;
}
