import configure from './store';

export let store = null;

export default () => {
  store = configure();

  return store;
};
