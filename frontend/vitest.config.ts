import { defineConfig } from 'vitest/config'
import vue from '@vitejs/plugin-vue'
import path from 'path'

export default defineConfig({
    plugins: [vue()],
    test: {
        environment: 'jsdom',
        globals: true,
        setupFiles: ['./tests/setup.ts'],
        include: ['tests/**/*.{test,spec}.{js,ts,vue}'],
        exclude: ['node_modules', '.nuxt'],
    },
    resolve: {
        alias: {
            '~': path.resolve(__dirname),
            '@': path.resolve(__dirname),
            '#app': path.resolve(__dirname, 'node_modules/nuxt/dist/app')
        }
    },
    define: {
        'process.client': true,
        'process.server': false
    }
})