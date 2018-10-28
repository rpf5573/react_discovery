import { MENU_ITEM_TOGGLE_ACTIVE } from '../actions/types';

export const menuItemToggleActive = () => dispatch => {
  console.log( 'menuItemToggleActive is called' );
  dispatch({
    type: MENU_ITEM_TOGGLE_ACTIVE,
    payload: null
  });
};