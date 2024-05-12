import { configureStore } from '@reduxjs/toolkit';
import authReducer from './Auth/reducers';

export default configureStore({
  reducer: {
    auth: authReducer
  },
})