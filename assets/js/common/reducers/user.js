import jwtDecode from 'jwt-decode';
import { cookieManager } from '../utils/cookieManager';

export const USER_LOGGED = 'USER_LOGGED';
export const USER_LOGOUT = 'USER_LOGOUT';

const token = cookieManager().get('token');

const initialState = token
  ? jwtDecode(token)
  : {
      roles: [],
      connected: false,
    };

export default function reducer(state = initialState, action = {}) {
  switch (action.type) {
    case USER_LOGGED:
      return jwtDecode(action.token);
    case USER_LOGOUT:
      return {
        roles: [],
        connected: false,
      };
  }

  return state;
}
