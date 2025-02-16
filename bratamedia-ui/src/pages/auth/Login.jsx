import { useNavigate } from "react-router-dom";
import useAuthStore from "../../store/authStore";
import { useEffect, useRef, useState } from "react";
import axios from "axios";

const Login = () => {
  // Get Zustand Data and Function
  const { setToken } = useAuthStore();
  const navigate = useNavigate();

  // Create Ref For Form Handler
  const emailRef = useRef("");
  const passwordRef = useRef("");
  const [loading, setLoading] = useState(false);

  // Focus Form With useEffect
  useEffect(() => {
    emailRef.current.focus();
  }, [emailRef]);

  // Form Handler
  const LoginHandler = async (e) => {
    e.preventDefault();
    setLoading(true);
    try {
      const data = await axios.post(
        `${import.meta.env.VITE_API_ENDPOINT}/auth/login`,
        {
          email: emailRef.current.value,
          password: passwordRef.current.value,
        }
      );
      setToken(data.data.data);
      navigate("/dashboard");
    } catch {
      alert("Username atau Password Salah!");
    } finally {
      setLoading(false);
    }
  };

  return (
    <>
      <div className='flex items-center justify-center min-h-screen bg-gray-100 px-5'>
        <div className='bg-white p-8 rounded-lg shadow-lg w-96'>
          <h2 className='text-2xl font-bold text-center '>Login</h2>
          <h3 className={"text-center text-xl my-2 font-semibold"}>
            Sistem Manajemen Siswa
          </h3>
          <form onSubmit={LoginHandler}>
            <div className='mb-4'>
              <label className='block text-gray-700'>Email</label>
              <input
                type='email'
                className='w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400'
                placeholder='Enter your email'
                ref={emailRef}
                required
              />
            </div>
            <div className='mb-4'>
              <label className='block text-gray-700'>Password</label>
              <input
                type='password'
                className='w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400'
                placeholder='Enter your password'
                ref={passwordRef}
                required
              />
            </div>
            <button
              type='submit'
              className='w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition'
              disabled={loading}>
              Login
            </button>
          </form>
        </div>
      </div>
    </>
  );
};

export default Login;
