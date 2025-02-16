import PropTypes from "prop-types";
import useAuthStore from "../store/authStore";
import { useEffect } from "react";
import { useNavigate } from "react-router-dom";

const AuthMiddleware = ({ children }) => {
  const { token, validate, loading } = useAuthStore();
  const navigate = useNavigate();

  useEffect(() => {
    validate();
    if (token == null || token == undefined) {
      navigate("/auth/login");
    }
  }, [validate, navigate, token]);

  return loading ? (
    <>
      <p>Loading...</p>
    </>
  ) : (
    <>{children}</>
  );
};

AuthMiddleware.propTypes = {
  children: PropTypes.node,
};

export default AuthMiddleware;
