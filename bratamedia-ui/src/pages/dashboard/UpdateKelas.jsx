import axios from "axios";
import { useEffect, useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import useAuthStore from "../../store/authStore";

const UpdateKelas = () => {
  const navigate = useNavigate();
  const [namaKelas, setNamaKelas] = useState("");
  const { token } = useAuthStore();
  const { id } = useParams();

  // Function Cek Data
  const CheckDataKelas = async () => {
    try {
      const res = await axios.get(
        `${import.meta.env.VITE_API_ENDPOINT}/kelas/${id}`,
        {
          headers: { Authorization: `Bearer ${token}` },
        }
      );

      setNamaKelas(res.data.data.nama);
    } catch {
      navigate("/dashboard/kelas");
    }
  };

  //Handler
  useEffect(() => {
    if (id == null || id == undefined) {
      console.log(id);
      navigate("/dashboard/kelas");
    }
    CheckDataKelas();
  }, []);

  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      await axios.patch(
        `${import.meta.env.VITE_API_ENDPOINT}/kelas/${id}`,
        {
          nama: namaKelas,
        },
        { headers: { Authorization: `Bearer ${token}` } }
      );
    } catch {
      alert("Ada Kesalahan Saat Memperbaharui Data");
    }

    navigate("/dashboard/kelas"); // Redirect kembali ke halaman kelas
  };

  return (
    <div className='p-6 bg-white shadow-md rounded-lg'>
      {/* Judul Halaman */}
      <h2 className='text-2xl font-bold mb-6'>Update Data Kelas</h2>

      {/* Form */}
      <div className=' p-6 rounded-lg'>
        <form onSubmit={handleSubmit}>
          <label className='block mb-2 font-medium text-gray-700'>
            Nama Kelas
          </label>
          <input
            type='text'
            className='w-full p-2 border rounded mb-4'
            placeholder='Masukkan Nama Kelas'
            min={5}
            required={true}
            value={namaKelas}
            onChange={(e) => setNamaKelas(e.target.value)}
          />

          {/* Tombol Action */}
          <div className='flex justify-end space-x-2'>
            <button
              type='button'
              className='px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500'
              onClick={() => navigate("/dashboard/kelas")}>
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

export default UpdateKelas;
