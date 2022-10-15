import Cookies from 'js-cookie';

export const localStorageManager = () => {
  const get = (key) => {
    return localStorage.getItem(key);
  };

  const set = (value, name) => {
    return localStorage.setItem(name, value);
  };

  const remove = (key) => {
    localStorage.removeItem(key);
  };

  return {
    get,
    set,
    remove,
  };
};
