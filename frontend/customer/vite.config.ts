import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueJsx from '@vitejs/plugin-vue-jsx'

export default defineConfig({
  plugins: [vue(), vueJsx()],
  root: '.',
  base: '/frontend/customer/',
  build: {
    outDir: '../../public/frontend/customer',
    emptyOutDir: true
  },
  server: {
    port: 5173,
    open: false
  }
})

