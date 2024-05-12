import React, { lazy, Suspense } from "react";
import PropTypes from "prop-types";
import { Routes, Route } from "react-router-dom";

const Login = lazy(() => import("../pages/Login.jsx"));
const Registration = lazy(() => import("../pages/Registration.jsx"));

const Routers = () => {
  return (
    <>
      <Suspense>
        <Routes>
          <Route
            path="/"
            element={<Login />}
          />
          <Route
            path="/signup"
            element={<Registration />}
          />
        </Routes>
      </Suspense>
    </>
  );
};

Routers.propTypes = {
  location: PropTypes.object, // React Router Passed Props
};

export default Routers;
