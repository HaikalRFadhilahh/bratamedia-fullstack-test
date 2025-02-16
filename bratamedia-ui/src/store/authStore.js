import { create } from "zustand";
import { persist } from "zustand/middleware";
import axios from "axios";

const useAuthStore = create(
  persist(
    (set, get) => ({
      data: {},
      token: null,
      loading: false,
      setToken: (t) => set({ token: t }),
      setLoading: (e) => set({ loading: e }),
      validate: async () => {
        try {
          set({ loading: true });
          // Take Token
          const token = get().token;

          // Validate Token
          const data = await axios.post(
            `${import.meta.env.VITE_API_ENDPOINT}/auth/validate`,
            {},
            {
              headers: { Authorization: `Bearer ${token}` },
            }
          );

          // Insert Data To Zustand
          set({ data: data.data.data });
        } catch {
          // Print Error To Console
          set({ token: null, loading: false });
          // Set Default Token Value
        } finally {
          set({ loading: false });
        }
      },
      logout: async (navigate) => {
        try {
          set({ loading: true });
          // Take Token
          const token = get().token;

          // Validate Token
          await axios.post(
            `${import.meta.env.VITE_API_ENDPOINT}/auth/logout`,
            {},
            {
              headers: { Authorization: `Bearer ${token}` },
            }
          );

          // Navigate
          navigate("/");
        } catch {
          set({ loading: false });
        } finally {
          set({ loading: false });
        }
      },
    }),
    {
      name: "auth-data",
    }
  )
);

export default useAuthStore;
