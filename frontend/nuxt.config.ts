// nuxt.config.ts
import { defineNuxtConfig } from 'nuxt/config'

export default defineNuxtConfig({
  runtimeConfig: {
    public: {
      apiUrl: 'http://localhost:8080/api'
    }
  }
})
