import { createStore, applyMiddleware } from 'redux';
import thunk from 'redux-thunk';
import reducers from './reducers/main-menu-reducer';
import 'whatwg-fetch';

const middleWare = [thunk];
const initialState = {
  meta: {
    total_team_count: 0,
    game_state: 0,
    passwords: {
      manager: 1234,
      assistant: 4321,
      teams: [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]
    }
  }
};

const store = createStore(
  reducers,
  initialState,
  applyMiddleware(...middleWare) 
);

export default store;