<script setup lang="ts">
import { onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { useVacancies } from '~/composables/useVacancies'

const route = useRoute()
const { vacancy, getOne } = useVacancies()

onMounted(async () => {
  await getOne(Number(route.params.id))
})
</script>

<template>
  <div class="p-6 max-w-3xl mx-auto space-y-4">
    <NuxtLink to="/" class="text-blue-600 underline">
      ← Назад
    </NuxtLink>

    <div v-if="vacancy" class="space-y-2">
      <h1 class="text-2xl font-bold">
        {{ vacancy.title }}
      </h1>

      <p class="text-gray-700 whitespace-pre-line">
        {{ vacancy.description }}
      </p>

      <p class="text-sm text-gray-500">
        {{ vacancy.salary }}
      </p>

      <p class="text-xs text-gray-400">
        {{ vacancy.created_at }}
      </p>
    </div>

    <div v-else class="text-gray-500">
      Loading...
    </div>
  </div>
</template>