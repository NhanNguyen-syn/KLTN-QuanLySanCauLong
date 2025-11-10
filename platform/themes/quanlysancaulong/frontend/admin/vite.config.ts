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
  base: '/frontend/admin/',
  build: {
    outDir: resolve(__dirname, '../../../../public/frontend/admin'),
    emptyOutDir: true,
  },
  server: {
    port: 5174,
    open: false,
  },
})

