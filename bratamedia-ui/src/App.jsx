import { BrowserRouter, Navigate, Route, Routes } from "react-router-dom";
import Login from "./pages/auth/Login";
import DashboardLayout from "./pages/layout/DashboardLayout";
import Home from "./pages/dashboard/Home";
import AuthMiddleware from "./middleware/AuthMiddleware";
import GuestMiddleware from "./middleware/GuestMiddleware";
import GuruByKelas from "./pages/dashboard/GuruByKelas";
import GuruRelationDetail from "./pages/dashboard/GuruRelationDetail";
import Kelas from "./pages/dashboard/Kelas";
import Siswa from "./pages/dashboard/Siswa";
import MataPelajaran from "./pages/dashboard/MataPelajaran";
import Guru from "./pages/dashboard/Guru";
import AddKelas from "./pages/dashboard/AddKelas";
import UpdateKelas from "./pages/dashboard/UpdateKelas";
import AddGuru from "./pages/dashboard/AddGuru";
import UpdateGuru from "./pages/dashboard/UpdateGuru";
import AddMataPelajaran from "./pages/dashboard/AddMataPelajaran";
import UpdateMataPelajaran from "./pages/dashboard/UpdateMataPelajaran";
import AddSiswa from "./pages/dashboard/AddSiswa";
import UpdateSiswa from "./pages/dashboard/UpdateSiswa";
const App = () => {
  return (
    <BrowserRouter>
      <Routes>
        {/* Root Path */}
        <Route path={"/"} element={<Navigate to={"/auth/login"} />} />
        {/* Authentification Page */}
        <Route path={"/auth"} element={<GuestMiddleware />}>
          <Route path={"login"} element={<Login />} />
        </Route>
        {/* Dashboard Routing */}
        <Route
          path={"/dashboard"}
          element={
            <AuthMiddleware>
              <DashboardLayout />
            </AuthMiddleware>
          }>
          <Route index={true} element={<Home />} />
          <Route path={"gurubykelas"} element={<GuruByKelas />} />
          <Route path={"gurudetail"} element={<GuruRelationDetail />} />
          <Route path={"kelas"} element={<Kelas />} />
          <Route path={"kelas/tambah"} element={<AddKelas />} />
          <Route path={"kelas/edit/:id"} element={<UpdateKelas />} />
          <Route path={"siswa"} element={<Siswa />} />
          <Route path={"siswa/tambah"} element={<AddSiswa />} />
          <Route path={"siswa/edit/:id"} element={<UpdateSiswa />} />
          <Route path={"matapelajaran"} element={<MataPelajaran />} />
          <Route path={"matapelajaran/tambah"} element={<AddMataPelajaran />} />
          <Route
            path={"matapelajaran/edit/:id"}
            element={<UpdateMataPelajaran />}
          />
          <Route path={"guru"} element={<Guru />} />
          <Route path={"guru/tambah"} element={<AddGuru />} />
          <Route path={"guru/edit/:id"} element={<UpdateGuru />} />
        </Route>
      </Routes>
    </BrowserRouter>
  );
};

export default App;
