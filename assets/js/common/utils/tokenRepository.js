import Basil from 'basil.js';

class TokenRepository {
  constructor(basil, key) {
    this.basil = basil;
    this.key = key;
  }

  getToken() {
    return this.basil.get(this.key);
  }

  setToken(value) {
    this.basil.set(this.key, value);
  }

  removeToken() {
    this.basil.remove(this.key);
  }
}

export default new TokenRepository(new Basil({ namespace: 'token' }), 'user');
