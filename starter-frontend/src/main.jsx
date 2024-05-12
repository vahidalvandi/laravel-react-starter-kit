import React from "react";
import { Provider as StoreProvider } from "react-redux";
import ReactDOM from "react-dom/client";
import { BrowserRouter as Router } from "react-router-dom";
import App from "./App.jsx";
import "./index.css";
import { ThemeProvider } from "@material-tailwind/react";
import store from "./store/index.js";

ReactDOM.createRoot(document.getElementById("root")).render(
  <React.StrictMode>
    <StoreProvider store={store}>
      <ThemeProvider>
        <App />
      </ThemeProvider>
    </StoreProvider>
  </React.StrictMode>
);
