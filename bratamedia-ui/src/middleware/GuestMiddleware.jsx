import useAuthStore from "../store/authStore";
import { useEffect } from "react";
import { Outlet, useNavigate } from "react-router-dom";

const GuestMiddleware = () => {
  const { token, loading } = useAuthStore();
  const navigate = useNavigate();
  useEffect(() => {
    if (token != null) {
      navigate("/dashboard");
    }
  }, [token, navigate]);

  return loading ? (
    <>Loading Guest Middleware...</>
  ) : (
    <>
      <Outlet />
    </>
  );
};
export default GuestMiddleware;
