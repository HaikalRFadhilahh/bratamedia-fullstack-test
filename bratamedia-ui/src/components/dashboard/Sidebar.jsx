import PropTypes from "prop-types";
import { Link } from "react-router-dom";

const Sidebar = ({ isOpen, toggleSidebar }) => {
  return (
    <aside
      className={`bg-gray-800 text-white w-64 h-screen fixed top-16 left-0 p-4 transition-transform lg:translate-x-0 ${
        isOpen ? "translate-x-0" : "-translate-x-64"
      }`}>
      <button
        onClick={toggleSidebar}
        className='text-white text-2xl lg:hidden absolute top-4 right-4'>
        X
      </button>

      <ul className='mt-8'>
        <li className='mb-2'>
          <Link to='/dashboard' className='block p-2 hover:bg-gray-700 rounded'>
            Data Siswa berdasarkan Kelas
          </Link>
        </li>
        <li className='mb-2'>
          <Link
            to='/dashboard/gurubykelas'
            className='block p-2 hover:bg-gray-700 rounded'>
            Data Guru berdasarkan Kelas
          </Link>
        </li>
        <li className='mb-2'>
          <Link
            to='/dashboard/gurudetail'
            className='block p-2 hover:bg-gray-700 rounded'>
            Data Guru Detail
          </Link>
        </li>
        <li className='mb-2'>
          <Link
            to='/dashboard/siswa'
            className='block p-2 hover:bg-gray-700 rounded'>
            Data Siswa
          </Link>
        </li>
        <li className='mb-2'>
          <Link
            to='/dashboard/kelas'
            className='block p-2 hover:bg-gray-700 rounded'>
            Data Kelas
          </Link>
        </li>
        <li className='mb-2'>
          <Link
            to='/dashboard/guru'
            className='block p-2 hover:bg-gray-700 rounded'>
            Data Guru
          </Link>
        </li>
        <li className='mb-2'>
          <Link
            to='/dashboard/matapelajaran'
            className='block p-2 hover:bg-gray-700 rounded'>
            Data Mata Pelajaran
          </Link>
        </li>
      </ul>
    </aside>
  );
};

Sidebar.propTypes = {
  toggleSidebar: PropTypes.bool,
  isOpen: PropTypes.bool,
};

export default Sidebar;
