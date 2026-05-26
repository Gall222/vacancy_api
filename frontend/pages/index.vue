<script setup lang="ts">
import { onMounted } from 'vue'
import { useVacancies } from '~/composables/useVacancies'

const { vacancies, getAll } = useVacancies()

onMounted(() => getAll())
</script>

<template>
  <div>
    <h2 class="text-2xl font-semibold mb-6">Вакансии</h2>

    <div v-if="vacancies.length === 0" class="text-gray-500">
      Нет вакансий
    </div>

    <div class="grid gap-4">
      <NuxtLink
          v-for="v in vacancies"
          :key="v.id"
          :to="`/vacancies/${v.id}`"
          class="bg-white p-4 rounded-lg shadow hover:shadow-md transition block"
      >
        <div class="flex justify-between items-center">
          <h3 class="text-lg font-semibold">{{ v.title }}</h3>
          <span class="text-green-600 font-bold">
            {{ v.salary }} €
          </span>
        </div>

        <p class="text-gray-500 mt-2 line-clamp-2">
          {{ v.description }}
        </p>

        <div class="text-xs text-gray-400 mt-3">
          {{ v.created_at }}
        </div>
      </NuxtLink>
    </div>
  </div>
</template>