import { MENU_ITEM_TOGGLE_ACTIVE } from '../actions/types';

const initialState = {
  items: [],
  item: {}
};

export default function(state = initialState, action) {
  switch( action.type ) {
    case MENU_ITEM_TOGGLE_ACTIVE :
      return Object.assign({}, state, {
        isActive: true,
        btnKey: action.payload
      });
    default: 
      return state;
  }
}