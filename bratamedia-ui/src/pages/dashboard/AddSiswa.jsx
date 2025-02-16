import axios from "axios";
import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import useAuthStore from "../../store/authStore";

const AddSiswa = () => {
  const navigate = useNavigate();
  const { token } = useAuthStore();
  const [listKelas, setListKelas] = useState([]);
  const [request, setRequest] = useState({ nama: "", umur: 0, kelasId: 0 });

  // Get Guru List
  const getListKelas = async () => {
    try {
      const res = await axios.get(
        `${import.meta.env.VITE_API_ENDPOINT}/kelas?dataInPage=1000`,
        {
          headers: { Authorization: `Bearer ${token}` },
        }
      );
      setListKelas(res.data.data);
    } catch {
      setListKelas([]);
    }
  };

  //useEffect
  useEffect(() => {
    getListKelas();
  }, []);

  //Handler
  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      await axios.post(
        `${import.meta.env.VITE_API_ENDPOINT}/siswa`,
        {
          nama: request.nama,
          umur: request.umur,
          kelasId: request.kelasId,
        },
        { headers: { Authorization: `Bearer ${token}` } }
      );
    } catch {
      alert("Ada Kesalahan Saat Menambahkan Data");
    }

    navigate("/dashboard/siswa");
  };

  return (
    <div className='p-6 bg-white shadow-md rounded-lg'>
      <h2 className='text-2xl font-bold mb-6'>Tambah Data Siswa</h2>

      {/* Form */}
      <div className=' p-6 rounded-lg'>
        <form onSubmit={handleSubmit}>
          <label className='block mb-2 font-medium text-gray-700'>
            Nama Siswa
          </label>
          <input
            type='text'
            className='w-full p-2 border rounded mb-4'
            placeholder='Masukkan Nama Mata Pelajaran'
            min={5}
            required={true}
            value={request.nama}
            onChange={(e) => setRequest({ ...request, nama: e.target.value })}
          />

          <label className='block mb-2 font-medium text-gray-700'>
            Umur Siswa
          </label>
          <input
            type='number'
            className='w-full p-2 border rounded mb-4'
            placeholder='Masukkan Nama Mata Pelajaran'
            min={1}
            required={true}
            value={request.umur}
            onChange={(e) => setRequest({ ...request, umur: e.target.value })}
          />

          <label className='block mb-2 font-medium text-gray-700'>Kelas</label>
          <select
            className='w-full p-2 border rounded mb-4'
            required
            onChange={(e) =>
              setRequest({ ...request, kelasId: e.target.value })
            }>
            <option value='0'>Pilih Kelas</option>
            {listKelas.map((d, i) => {
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
              onClick={() => navigate("/dashboard/siswa")}>
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

export default AddSiswa;
