import { createStore, applyMiddleware } from 'redux';
import thunk from 'redux-thunk';
import reducers from './reducers/main-menu-reducer';

const initialState = {};
const middleWare = [thunk];

const store = createStore(
  reducers,
  initialState,
  applyMiddleware(...middleWare) 
);

export default store;