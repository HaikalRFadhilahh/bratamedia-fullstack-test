import axios from "axios";
import { useEffect, useRef, useState } from "react";
import { useNavigate } from "react-router-dom";
import useAuthStore from "../../store/authStore";

const AddMataPelajaran = () => {
  const navigate = useNavigate();
  const namaMataPelajaran = useRef("");
  const { token } = useAuthStore();
  const [listGuru, setListGuru] = useState([]);
  const [guruId, setGuruId] = useState(0);

  // Get Guru List
  const getListGuru = async () => {
    try {
      const res = await axios.get(
        `${import.meta.env.VITE_API_ENDPOINT}/guru?dataInPage=1000`,
        {
          headers: { Authorization: `Bearer ${token}` },
        }
      );
      setListGuru(res.data.data);
    } catch {
      setListGuru([]);
    }
  };

  //useEffect
  useEffect(() => {
    getListGuru();
  }, []);

  //Handler
  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      await axios.post(
        `${import.meta.env.VITE_API_ENDPOINT}/matapelajaran`,
        {
          nama: namaMataPelajaran.current.value,
          guruId: guruId,
        },
        { headers: { Authorization: `Bearer ${token}` } }
      );
    } catch {
      alert("Ada Kesalahan Saat Menambahkan Data");
    }

    navigate("/dashboard/matapelajaran");
  };

  return (
    <div className='p-6 bg-white shadow-md rounded-lg'>
      {/* Judul Halaman */}
      <h2 className='text-2xl font-bold mb-6'>Tambah Data Mata Pelajaran</h2>

      {/* Form */}
      <div className=' p-6 rounded-lg'>
        <form onSubmit={handleSubmit}>
          <label className='block mb-2 font-medium text-gray-700'>
            Nama Mata Pelajaran
          </label>
          <input
            type='text'
            className='w-full p-2 border rounded mb-4'
            placeholder='Masukkan Nama Mata Pelajaran'
            min={5}
            required={true}
            ref={namaMataPelajaran}
          />

          <label className='block mb-2 font-medium text-gray-700'>
            Nama Guru
          </label>
          <select
            className='w-full p-2 border rounded mb-4'
            required
            onChange={(e) => setGuruId(e.target.value)}>
            <option value=''>Pilih Guru</option>
            {listGuru.map((d, i) => {
              return (
                <option value={d.id} key={i}>
                  {d.nama}
                </option>
              );
            })}
          </select>
          {/* Tombol Action */}
          <div className='flex justify-end space-x-2'>
            <button
              type='button'
              className='px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500'
              onClick={() => navigate("/dashboard/matapelajaran")}>
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

export default AddMataPelajaran;
