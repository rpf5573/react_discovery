import { UPDATE_INITIAL_STATE } from '../actions/types';

export default function(state, action) {
  switch( action.type ) {
    case UPDATE_INITIAL_STATE :
      return Object.assign({}, state, {
        meta: action.payload
      });
    default: 
      return state;
  }
}