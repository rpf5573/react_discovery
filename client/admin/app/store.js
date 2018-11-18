import { createStore, applyMiddleware } from 'redux';
import thunk from 'redux-thunk';
import reducers from './reducers/main-menu-reducer';

let middleWare = [thunk];

export default async function configureStore(initialState) {
  const store = createStore(
    reducers,
    initialState,
    applyMiddleware(...middleWare)
  );
  return store
}