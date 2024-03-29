import { localStorageManager } from './localStorageManager';
import { useHistory } from 'react-router-dom';

export const apiClient = () => {
  const request = (request, options = {}) => {
    const token = localStorageManager().get('token');

    if (token) {
      request.headers.set('Authorization', 'Bearer ' + token);
    }

    request.headers.set(
      'cache-control',
      'no-cache, max-age=0, must-revalidate, no-store'
    );

    return fetch(request, options).then((response) => {
      if (response.status === 401) {
        localStorageManager().remove('token');

        location.reload();
      }

      return response;
    });
  };

  return {
    request,
  };
};
