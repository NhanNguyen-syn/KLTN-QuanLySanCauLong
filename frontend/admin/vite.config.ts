import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueJsx from '@vitejs/plugin-vue-jsx'

export default defineConfig({
  plugins: [vue(), vueJsx()],
  root: '.',
  base: '/frontend/admin/',
  build: {
    outDir: '../../public/frontend/admin',
    emptyOutDir: true
  },
  server: {
    port: 5174,
    open: false
  }
})

