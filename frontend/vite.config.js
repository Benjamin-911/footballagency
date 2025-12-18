import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';

// Vite config for the React frontend.
// In development, we proxy backend PHP requests to the XAMPP server at
// http://localhost/footballagency so that API calls work without CORS issues.
export default defineConfig({
  plugins: [react()],
  build: {
    outDir: 'dist',
    emptyOutDir: true
  },
  server: {
    port: 5173,
    open: false,
    proxy: {
      // Any request starting with /backend will be forwarded to XAMPP
      '/backend': {
        target: 'http://localhost/footballagency',
        changeOrigin: true
      },
      // Serve images from the existing PHP app so paths like /images/logo.jpg work in dev
      '/images': {
        target: 'http://localhost/footballagency',
        changeOrigin: true
      },
      // Serve uploaded avatars from the PHP app
      '/uploads': {
        target: 'http://localhost/footballagency',
        changeOrigin: true
      }
    }
  },
  preview: {
    port: 4173
  }
});


