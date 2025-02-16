import PropTypes from "prop-types";
import useAuthStore from "../../store/authStore";
import { useNavigate } from "react-router-dom";

const Navbar = ({ toggleSidebar }) => {
  const { logout } = useAuthStore();
  const navigate = useNavigate();

  const LogoutHandler = () => {
    logout(navigate);
  };

  return (
    <nav className='bg-gray-900 text-white p-4 flex justify-between items-center fixed top-0 left-0 w-full z-50'>
      <div className='flex items-center space-x-4'>
        <button
          onClick={toggleSidebar}
          className='text-white text-2xl lg:hidden'>
          ☰
        </button>
        <h1 className='text-lg font-bold'>Aplikasi Manajemen Siswa</h1>
      </div>
      <div className='flex items-center'>
        <button
          className='bg-red-600 px-4 py-2 rounded-lg text-white'
          onClick={LogoutHandler}>
          Logout
        </button>
      </div>
    </nav>
  );
};

Navbar.propTypes = {
  toggleSidebar: PropTypes.bool,
};

export default Navbar;
