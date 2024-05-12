import React, { useState, useEffect, lazy, Suspense } from "react";
import PropTypes from "prop-types";
import { Routes, Route, Navigate } from "react-router-dom";

const Login = lazy(() => import("../pages/Login.jsx"));
const Registration = lazy(() => import("../pages/Registration.jsx"));
const Dashboard = lazy(() => import("../pages/Dashboard.jsx"));

const Routers = () => {
  const [authenticated, setAuthenticated] = useState(false);

  useEffect(() => {
    const token = localStorage.getItem('token');
    if (token) {
      setAuthenticated(true);
    }
  }, []);

  const PrivateRoute = ({ element, ...rest }) => {
    return authenticated ? element : <Navigate to="/" />;
  };

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
          <Route path="/dashboard" element={<PrivateRoute element={<Dashboard />} />} />
        </Routes>
      </Suspense>
    </>
  );
};

Routers.propTypes = {
  location: PropTypes.object, // React Router Passed Props
};

export default Routers;
