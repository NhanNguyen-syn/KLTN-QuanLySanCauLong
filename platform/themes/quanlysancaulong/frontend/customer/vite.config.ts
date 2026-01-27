import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueJsx from '@vitejs/plugin-vue-jsx'
import { fileURLToPath } from 'node:url'
import { dirname, resolve } from 'node:path'

const __filename = fileURLToPath(import.meta.url)
const __dirname = dirname(__filename)

export default defineConfig({
  plugins: [vue(), vueJsx()],
  root: '.',
  base: '/frontend/customer/',
  build: {
    // Go from .../platform/themes/quanlysancaulong/frontend/customer to project root then public
    outDir: resolve(__dirname, '../../../../../public/frontend/customer'),
    emptyOutDir: true,
  },
  server: {
    port: 5173,
    open: false,
  },
})

