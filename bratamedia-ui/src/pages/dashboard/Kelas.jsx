import axios from "axios";
import { useEffect, useState } from "react";
import { useDebounce } from "use-debounce";
import useAuthStore from "../../store/authStore";
import { useNavigate } from "react-router-dom";

const Kelas = () => {
  // State
  const [trigger, setTrigger] = useState(false);
  const [search, setSearch] = useState("");
  const [valueSearch] = useDebounce(search, 1000);
  const [data, setData] = useState([]);
  const [pagination, setPagination] = useState({
    totalData: 0,
    dataInPage: 10,
    currentPage: 1,
    totalPage: 1,
  });
  const [page, setPage] = useState(1);
  const { token } = useAuthStore();
  const [loading, setLoading] = useState(true);
  const navigate = useNavigate();

  // Create Function Pull
  const getDataAllKelas = async () => {
    setLoading(true);
    try {
      const res = await axios.get(
        `${
          import.meta.env.VITE_API_ENDPOINT
        }/kelas?page${page}&search=${search}`,
        {
          headers: { Authorization: `Bearer ${token}` },
        }
      );
      setData(res.data.data);
      setPagination(res.data.pagination);
    } catch {
      setData([]);
      setPagination({
        totalData: 0,
        dataInPage: 10,
        currentPage: 1,
        totalPage: 1,
      });
    } finally {
      setLoading(false);
    }
  };

  // useEffect
  useEffect(() => {
    getDataAllKelas();
  }, [valueSearch, page, trigger]);

  // Delete Action
  const deleteKelasHandler = async (id) => {
    try {
      await axios.delete(`${import.meta.env.VITE_API_ENDPOINT}/kelas/${id}`, {
        headers: { Authorization: `Bearer ${token}` },
      });
    } catch {
      alert("Ada Kesalahan Saat Menghapus Data");
    } finally {
      setTrigger(!trigger);
    }
  };

  return (
    <div>
      <h2 className='text-2xl font-bold mb-4'>Data kelas</h2>

      <div className='mb-4 flex justify-between items-center'>
        <div className='flex items-center space-x-2'>
          <label htmlFor='search'>Search : </label>
          <input
            id='search'
            type='text'
            placeholder='Cari Nama Kelas'
            className='p-2 border rounded w-1/3 md:min-w-[300px]'
            value={search}
            onChange={(e) => setSearch(e.target.value)}
          />
        </div>

        {/* Tombol Add Data */}
        <button
          className='bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600'
          onClick={() => {
            navigate("/dashboard/kelas/tambah");
          }}>
          Tambah Kelas
        </button>
      </div>

      {/* Tabel Data */}
      <div className='bg-white shadow-md rounded-lg overflow-hidden'>
        <table className='w-full border-collapse'>
          <thead>
            <tr className='bg-gray-200 py-2'>
              <th className='p-3 text-left'>No.</th>
              <th className='p-3 text-left'>Nama Kelas</th>
              <th className='p-3 text-left'>Aksi</th>
            </tr>
          </thead>
          <tbody>
            {/* Loading Table Handler */}
            {loading ? (
              <tr>
                <td colSpan={3} className={"text-center py-2"}>
                  Loading...
                </td>
              </tr>
            ) : data.length == 0 ? (
              <tr>
                <td colSpan={3} className={"text-center py-2"}>
                  Data Kelas Not Found!
                </td>
              </tr>
            ) : (
              <></>
            )}

            {/* Read Array of Data */}
            {data.map((d, i) => {
              return (
                <tr key={i} className={"py-2 border-b"}>
                  <td className={"p-3"}>
                    {(page - 1) * pagination.dataInPage + i + 1}
                  </td>
                  <td className={"p-3"}>{d.nama}</td>
                  <td className='p-3'>
                    <button
                      className='bg-yellow-500 text-white px-3 py-1 rounded mr-2 hover:bg-yellow-600'
                      onClick={() => {
                        navigate(`/dashboard/kelas/edit/${d.id}`);
                      }}>
                      Update
                    </button>
                    <button
                      className='bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600'
                      onClick={() => deleteKelasHandler(d.id)}>
                      Delete
                    </button>
                  </td>
                </tr>
              );
            })}
          </tbody>
        </table>
      </div>
      {/* Pagination */}
      {pagination.totalPage != 1 ? (
        <div className='flex justify-end mt-4'>
          <button
            className={`px-4 py-2 rounded border mx-1 ${
              page === 1
                ? "bg-gray-500 cursor-not-allowed"
                : "bg-blue-600 text-white"
            }`}
            onClick={() => setPage(page - 1)}
            disabled={page === 1}>
            Prev
          </button>

          <button
            className={`px-4 py-2 rounded border mx-1 ${
              page === pagination.totalPage
                ? "bg-gray-500 cursor-not-allowed"
                : "bg-blue-600 text-white"
            }`}
            onClick={() => setPage(page + 1)}
            disabled={page === pagination.totalPage}>
            Next
          </button>
        </div>
      ) : (
        <></>
      )}
    </div>
  );
};

export default Kelas;
