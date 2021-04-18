import jwtDecode from 'jwt-decode';
import tokenRepository from '../utils/tokenRepository';

export const USER_LOGGED = 'USER_LOGGED';
export const USER_LOGOUT = 'USER_LOGOUT';

const token = tokenRepository.getToken();

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
