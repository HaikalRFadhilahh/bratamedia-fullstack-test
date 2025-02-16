import axios from "axios";
import { useRef } from "react";
import { useNavigate } from "react-router-dom";
import useAuthStore from "../../store/authStore";

const AddGuru = () => {
  const navigate = useNavigate();
  const namaGuruRef = useRef("");
  const { token } = useAuthStore();

  //Handler
  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      await axios.post(
        `${import.meta.env.VITE_API_ENDPOINT}/guru`,
        {
          nama: namaGuruRef.current.value,
        },
        { headers: { Authorization: `Bearer ${token}` } }
      );
    } catch {
      alert("Ada Kesalahan Saat Menambahkan Data");
    }

    navigate("/dashboard/guru");
  };

  return (
    <div className='p-6 bg-white shadow-md rounded-lg'>
      {/* Judul Halaman */}
      <h2 className='text-2xl font-bold mb-6'>Tambah Data Guru</h2>

      {/* Form */}
      <div className=' p-6 rounded-lg'>
        <form onSubmit={handleSubmit}>
          <label className='block mb-2 font-medium text-gray-700'>
            Nama Guru
          </label>
          <input
            type='text'
            className='w-full p-2 border rounded mb-4'
            placeholder='Masukkan Nama Guru'
            min={5}
            required={true}
            ref={namaGuruRef}
          />

          {/* Tombol Action */}
          <div className='flex justify-end space-x-2'>
            <button
              type='button'
              className='px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500'
              onClick={() => navigate("/dashboard/guru")}>
              Cancel
            </button>
            <button
              type='submit'
              className='px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700'>
              Submit
            </button>
          </div>
        </form>
      </div>
    </div>
  );
};

export default AddGuru;
