import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/
export default defineConfig({
    plugins: [vue()],

    server: {
        proxy: {
          '/token': 'http://localhost:3000',
          '/checkout': 'http://localhost:3000'
        }
    },
    
    resolve: {
        alias: [
            {
                // this is required for the SCSS modules
                find: /^~(.*)$/,
                replacement: '$1',
            },
        ],
    },
})
