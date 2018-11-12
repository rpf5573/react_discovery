import { OPEN_MODAL, MAKE_ALL_INACTIVE } from '../actions/types';

export const openModal = () => dispatch => {
  dispatch({
    type: OPEN_MODAL,
    payload: null
  });
};

export const makeAllInActive = () => dispatch => {
  dispatch({
    type: MAKE_ALL_INACTIVE,
    payload: null
  });
}