import Cookies from 'js-cookie';

export const cookieManager = () => {
  const get = (key) => {
    return Cookies.get(key);
  };

  const set = (value, name) => {
    return Cookies.set(name, value, { expires: 1 });
  };

  const remove = (key) => {
    Cookies.remove(key);
  };

  return {
    get,
    set,
    remove,
  };
};
