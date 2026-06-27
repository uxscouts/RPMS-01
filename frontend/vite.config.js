import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react'; // <-- Imported to fix the plugin error

export default defineConfig({
  plugins: [react()],
  server: {
    host: true,
    port: 3000, 
    strictPort: true,
    hmr: {
      clientPort: 443, 
    },
    watch: {
      usePolling: true, 
    },
    // 👇 ADD THIS PROXY BLOCK HERE 👇
    proxy: {
      '/api': {
        target: 'http://backend:8000',
        changeOrigin: true,
        secure: false,
        rewrite: (path) => path.replace(/^\/api/, ''),
      }
    }
  },
})
