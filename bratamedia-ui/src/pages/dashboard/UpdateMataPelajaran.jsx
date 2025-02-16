import axios from "axios";
import { useEffect, useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import useAuthStore from "../../store/authStore";

const UpdateMataPelajaran = () => {
  const { id } = useParams();
  const navigate = useNavigate();
  const { token } = useAuthStore();
  const [listGuru, setListGuru] = useState([]);
  const [request, setRequest] = useState({ nama: "", guruId: 0 });

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

  // Get Default Data
  const getDataDefaultMataPelajaran = async () => {
    try {
      const res = await axios.get(
        `${import.meta.env.VITE_API_ENDPOINT}/matapelajaran/${id}`,
        {
          headers: { Authorization: `Bearer ${token}` },
        }
      );
      setRequest({ nama: res.data.data.nama, guruId: res.data.data.guruId });
    } catch {
      navigate("/dashboard/matapelajaran");
    }
  };

  //useEffect
  useEffect(() => {
    getListGuru();
    getDataDefaultMataPelajaran();
  }, []);

  //Handler
  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      await axios.patch(
        `${import.meta.env.VITE_API_ENDPOINT}/matapelajaran/${id}`,
        {
          nama: request.nama,
          guruId: request.guruId,
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
      <h2 className='text-2xl font-bold mb-6'>Edit Data Mata Pelajaran</h2>

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
            value={request.nama}
            onChange={(e) => setRequest({ ...request, nama: e.target.value })}
          />

          <label className='block mb-2 font-medium text-gray-700'>
            Nama Guru
          </label>
          <select
            className='w-full p-2 border rounded mb-4'
            required
            onChange={(e) =>
              setRequest({ ...request, guruId: e.target.value })
            }>
            <option value='' disabled={true}>
              Pilih Guru
            </option>
            {listGuru.map((d, i) => {
              return (
                <option value={d.id} key={i} selected={d.id == request.guruId}>
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

export default UpdateMataPelajaran;
