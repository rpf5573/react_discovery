import { OPEN_MODAL, TOGGLE_MENU_BTNS, CLOSE_MODAL } from '../actions/types';

const initialState = {
  items: [],
  item: {}
};

export default function(state = initialState, action) {
  switch( action.type ) {
    case OPEN_MODAL :
      return Object.assign({}, state, {
        activeModalClassName: action.payload
      });
    case TOGGLE_MENU_BTNS :
      return Object.assign({}, state, {
        activeMenuBtnClassName: action.payload
      });
    case CLOSE_MODAL:
      return Object.assign({}, state, {
        activeModalClassName: null,
        activeMenuBtnClassName: null
      });
    default: 
      return state;
  }
}