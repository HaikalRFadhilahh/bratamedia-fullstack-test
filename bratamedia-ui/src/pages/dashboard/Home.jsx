import { useEffect, useState } from "react";
import { useDebounce } from "use-debounce";
import useAuthStore from "../../store/authStore";
import axios from "axios";

const Home = () => {
  // State
  const [search, setSearch] = useState("");
  const [valueSearch] = useDebounce(search, 1000);
  const [data, setData] = useState([{ siswa: [] }]);
  const [pagination, setPagination] = useState({
    totalData: 0,
    dataInPage: 10,
    currentPage: 1,
    totalPage: 1,
  });
  const [page, setPage] = useState(1);
  const { token } = useAuthStore();
  const [loading, setLoading] = useState(true);

  // Function Pulling
  const getDataSiswaByKelas = async () => {
    setLoading(true);
    try {
      const res = await axios.get(
        `${
          import.meta.env.VITE_API_ENDPOINT
        }/kelas/siswabykelas?page=${page}&search=${valueSearch}`,
        {
          headers: { Authorization: `Bearer ${token}` },
        }
      );
      setData(res.data.data);
      setPagination(res.data.pagination);
    } catch (error) {
      console.log(error);
    } finally {
      setLoading(false);
    }
  };

  // UseEffect Query Data
  useEffect(() => {
    getDataSiswaByKelas();
  }, [valueSearch, page]);

  return (
    <div>
      {/* Judul Halaman */}
      <h2 className='text-2xl font-bold mb-4'>Data Siswa Berdasarkan Kelas</h2>

      {/* Search Form */}
      <div className='mb-4 flex items-center space-x-2'>
        <label htmlFor='search'>Search : </label>
        <input
          id={"search"}
          type='text'
          placeholder='Cari Nama Mahasiswa atau Nama Kelas'
          className='p-2 border rounded w-1/3'
          value={search}
          onChange={(e) => setSearch(e.target.value)}
        />
      </div>

      {/* Tabel Data */}
      <div className='bg-white shadow-md rounded-lg overflow-hidden'>
        <table className='w-full border-collapse'>
          <thead>
            <tr className='bg-gray-200 py-2'>
              <th className='p-3 text-left'>No.</th>
              <th className='p-3 text-left'>Nama Kelas</th>
              <th className='p-3 text-left'>Daftar Siswa</th>
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
            {!loading ? (
              data.map((d, i) => {
                return (
                  <tr key={i} className={"py-2 border-b"}>
                    <td className='p-3 text-left'>
                      {(pagination.currentPage - 1) * pagination.dataInPage +
                        i +
                        1}
                    </td>
                    <td className='p-3 text-left'>{d.nama}</td>
                    <td className='p-3 text-left'>
                      {d.siswa.length > 0 ? (
                        <ul>
                          {d.siswa.map((d, i) => {
                            return <li key={i}>- {d.nama}</li>;
                          })}
                        </ul>
                      ) : (
                        <b>Tidak Ada Siswa</b>
                      )}
                    </td>
                  </tr>
                );
              })
            ) : (
              <></>
            )}
          </tbody>
        </table>
        {/* Pagination */}
      </div>
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

export default Home;
