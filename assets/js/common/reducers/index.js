import { combineReducers } from 'redux';
import user from './user.js';
import router from './router.js';
import weatherStation from './weatherStation.js';

export default combineReducers({
  user,
  weatherStation,
  router,
});
