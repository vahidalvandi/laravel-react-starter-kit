import { SET_USER } from "./actions";
import { SET_LOGGED_IN_STATUS } from "./actions";
import { SET_LOADING_STATUS } from "./actions";

const initialState = {
  user: {},
  isLoggedIn: false,
  loading: false,
};

const authReducer = (state = initialState, action) => {
  switch (action.type) {
    case SET_USER:
      return {
        ...state,
        user: action.payload,
      };
    case SET_LOGGED_IN_STATUS:
      return {
        ...state,
        isLoggedIn: action.payload,
      };
    case SET_LOADING_STATUS:
      return {
        ...state,
        loading: action.payload,
      };
    default:
      return state;
  }
};

export default authReducer;
