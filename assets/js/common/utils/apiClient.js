import tokenRepository from './tokenRepository';

class ApiClient {
  constructor(tokenRepository) {
    this.tokenRepository = tokenRepository;
  }

  request(request, options = {}) {
    const token = this.tokenRepository.getToken();
    if (token) {
      request.headers.set('Authorization', 'Bearer ' + token);
    }

    request.headers.set(
      'cache-control',
      'no-cache, max-age=0, must-revalidate, no-store'
    );

    return fetch(request, options).then((response) => {
      if (response.status == 401) {
        this.tokenRepository.removeToken();
        location.reload();
      }

      return response;
    });
  }
}

export default new ApiClient(tokenRepository);
