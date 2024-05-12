import authService from '../../services/auth-service';

export const SET_USER = "SET_USER";
export const SET_LOGGED_IN_STATUS = "SET_LOGGED_IN_STATUS";
export const SET_LOADING_STATUS = "SET_LOADING_STATUS";

export const set_user = (payload) => ({
  type: SET_USER,
  payload: payload,
});

export const set_logged_in_status = (payload) => ({
  type: SET_LOGGED_IN_STATUS,
  payload: payload,
});

export const set_loading_status = (payload) => ({
  type: SET_LOADING_STATUS,
  payload: payload,
});

export const request_login = (payload) => {
    return async (dispatch) => {
      dispatch(set_loading_status(true));
      try {
        const response = await authService.login(payload);
        console.log(response.data);
        dispatch(set_loading_status(false));
      } catch (error) {
        console.log(error.message);
      }
    };
  };


