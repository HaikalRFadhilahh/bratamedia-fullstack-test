import axios from "axios";
import { useEffect, useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import useAuthStore from "../../store/authStore";

const UpdateGuru = () => {
  const navigate = useNavigate();
  const [namaGuru, setNamaGuru] = useState("");
  const { token } = useAuthStore();
  const { id } = useParams();

  // Function Cek Data
  const CheckDataGuru = async () => {
    try {
      const res = await axios.get(
        `${import.meta.env.VITE_API_ENDPOINT}/guru/${id}`,
        {
          headers: { Authorization: `Bearer ${token}` },
        }
      );

      setNamaGuru(res.data.data.nama);
    } catch {
      navigate("/dashboard/guru");
    }
  };

  //Handler
  useEffect(() => {
    if (id == null || id == undefined) {
      console.log(id);
      navigate("/dashboard/guru");
    }
    CheckDataGuru();
  }, []);

  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      await axios.patch(
        `${import.meta.env.VITE_API_ENDPOINT}/guru/${id}`,
        {
          nama: namaGuru,
        },
        { headers: { Authorization: `Bearer ${token}` } }
      );
    } catch {
      alert("Ada Kesalahan Saat Memperbaharui Data");
    }

    navigate("/dashboard/guru"); // Redirect kembali ke halaman kelas
  };

  return (
    <div className='p-6 bg-white shadow-md rounded-lg'>
      {/* Judul Halaman */}
      <h2 className='text-2xl font-bold mb-6'>Update Data Guru</h2>

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
            value={namaGuru}
            onChange={(e) => setNamaGuru(e.target.value)}
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

export default UpdateGuru;
