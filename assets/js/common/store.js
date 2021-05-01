import { applyMiddleware, compose, createStore } from 'redux';
import thunkMiddleware from 'redux-thunk';
import logger from 'redux-logger';
import rootReducer from './reducers';
import { composeWithDevTools } from 'redux-devtools-extension';

export default function configure(preloadedState) {
  const isDev = process.env.NODE_ENV === 'development';
  const middlewares = [thunkMiddleware];
  if (isDev) {
    middlewares.push(logger);
  }

  const middlewareEnhancer = applyMiddleware(...middlewares);
  const enhancers = [middlewareEnhancer];

  let composedEnhancers = compose(...enhancers);
  if (isDev) {
    composedEnhancers = composeWithDevTools(...enhancers);
  }

  const store = createStore(rootReducer, preloadedState, composedEnhancers);

  if (process.env.NODE_ENV !== 'production' && module.hot) {
    module.hot.accept('./reducers', () => store.replaceReducer(rootReducer));
  }

  return store;
}
