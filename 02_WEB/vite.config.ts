import { fileURLToPath, URL } from 'node:url'

import { defineConfig, loadEnv } from 'vite';
import vue from '@vitejs/plugin-vue'
import vueJsx from '@vitejs/plugin-vue-jsx'

// https://vitejs.dev/config/
export default defineConfig(({mode}) => {
  process.env = {...process.env, ...loadEnv(mode, process.cwd())};
  return {
    plugins: [
      vue({
        script: {
          globalTypeFiles: [
            './src/types/globals.d.ts'
          ]
        }
      }),
      vueJsx(),
    ],
    resolve: {
      alias: {
        '@': fileURLToPath(new URL('./src', import.meta.url)),
        '@assets': fileURLToPath(new URL('./src/assets', import.meta.url)),
        '@cpn': fileURLToPath(new URL('./src/components', import.meta.url)),
        '@views': fileURLToPath(new URL('./src/views', import.meta.url)),
        '@types': fileURLToPath(new URL('./src/types', import.meta.url))
      }
    },
    server: {
      port: parseInt(process.env.VITE_PORT ?? '7020'),
      proxy: {
        '/api': {
          target: process.env.VITE_API_URI ?? 'http://localhost:7019'
        }
      }
    }
  }
})
