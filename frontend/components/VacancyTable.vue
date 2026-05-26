<template>
  <div>

    <!-- SORT CONTROL -->
    <div class="flex items-center gap-3 mb-4">
      <select v-model="sortField" class="border p-2 rounded">
        <option value="title">Название</option>
        <option value="salary">Зарплата</option>
        <option value="created_at">Дата создания</option>
      </select>

      <button
          class="px-3 py-2 border rounded"
          @click="toggleSort"
      >
        {{ sortDir === 'asc' ? '↑ По возрастанию' : '↓ По убыванию' }}
      </button>
    </div>

    <!-- TABLE -->
    <table class="w-full border-collapse border">

      <thead>
      <tr class="bg-gray-100">
        <th class="border p-2 text-left">Название</th>
        <th class="border p-2 text-left">Зарплата</th>
        <th class="border p-2 text-left">Дата</th>
      </tr>
      </thead>

      <tbody>
      <tr
          v-for="item in pagedVacancies"
          :key="item.id"
          class="hover:bg-gray-50"
      >
        <td class="border p-2">
          <NuxtLink :to="`/vacancies/${item.id}`">
            {{ item.title }}
          </NuxtLink>
        </td>

        <td class="border p-2">
          {{ item.salary }} €
        </td>

        <td class="border p-2">
          {{ item.created_at }}
        </td>
      </tr>
      </tbody>
    </table>

    <!-- PAGINATION -->
    <div class="flex items-center gap-2 mt-4">

      <button
          class="px-3 py-1 border rounded"
          :disabled="currentPage === 1"
          @click="currentPage = 1"
      >
        «
      </button>

      <button
          class="px-3 py-1 border rounded"
          :disabled="currentPage === 1"
          @click="currentPage--"
      >
        ‹
      </button>

      <span class="px-2">
        {{ currentPage }} / {{ totalPages }}
      </span>

      <button
          class="px-3 py-1 border rounded"
          :disabled="currentPage === totalPages"
          @click="currentPage++"
      >
        ›
      </button>

      <button
          class="px-3 py-1 border rounded"
          :disabled="currentPage === totalPages"
          @click="currentPage = totalPages"
      >
        »
      </button>

    </div>

  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { useVacancies } from '~/composables/useVacancies'

const { vacancies, getAll } = useVacancies()

const currentPage = ref(1)
const perPage = 5

const sortField = ref<'title' | 'salary' | 'created_at'>('created_at')
const sortDir = ref<'asc' | 'desc'>('desc')

onMounted(() => getAll())

function toggleSort() {
  sortDir.value = sortDir.value === 'asc' ? 'desc' : 'asc'
}

const totalPages = computed(() =>
    Math.ceil(vacancies.value.length / perPage)
)

const sortedVacancies = computed(() => {
  return [...vacancies.value].sort((a, b) => {
    const aVal = a[sortField.value]
    const bVal = b[sortField.value]

    if (aVal < bVal) return sortDir.value === 'asc' ? -1 : 1
    if (aVal > bVal) return sortDir.value === 'asc' ? 1 : -1
    return 0
  })
})

const pagedVacancies = computed(() => {
  const start = (currentPage.value - 1) * perPage
  return sortedVacancies.value.slice(start, start + perPage)
})
</script>