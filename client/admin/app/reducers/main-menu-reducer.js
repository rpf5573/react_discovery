import { OPEN_MODAL, MAKE_ALL_INACTIVE } from '../actions/types';

const initialState = {
  items: [],
  item: {}
};

export default function(state = initialState, action) {
  switch( action.type ) {
    case OPEN_MODAL :
      return Object.assign({}, state, {
      });
    case MAKE_ALL_INACTIVE :
      return Object.assign({}, state, {
        isActive: false
      });
    default: 
      return state;
  }
}