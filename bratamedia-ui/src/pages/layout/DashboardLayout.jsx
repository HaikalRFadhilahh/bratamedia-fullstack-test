import { Outlet } from "react-router-dom";
import Sidebar from "../../components/dashboard/Sidebar";
import Navbar from "../../components/dashboard/Navbar";
import { useState } from "react";

const DashboardLayout = () => {
  const [isSidebarOpen, setIsSidebarOpen] = useState(false);

  const toggleSidebar = () => {
    setIsSidebarOpen(!isSidebarOpen);
  };

  return (
    <div className='h-screen flex overflow-hidden'>
      <Sidebar isOpen={isSidebarOpen} toggleSidebar={toggleSidebar} />
      <div className='flex flex-col flex-1'>
        <Navbar toggleSidebar={toggleSidebar} />
        <main className='flex-1 overflow-auto p-6 bg-gray-100 mt-16 lg:ml-64'>
          <Outlet />
        </main>
      </div>
    </div>
  );
};

export default DashboardLayout;
