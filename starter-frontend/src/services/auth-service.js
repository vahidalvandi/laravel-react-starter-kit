import axios from "axios";
import config from "../../config";

export const authService = axios.create({
  baseURL: config.api_url + "/api",
  timeout: 1000 * 60 * 10,
  headers: client_header(),
});

function client_header() {
  let header = {
    Accept: "application/json",
    "Content-Type": "application/json",
  };
  return header;
}

export default {
  login(payload) {
    return authService.post("/login", payload);
  },
  register(payload) {
    return authService.post("/register", payload);
  },
};
