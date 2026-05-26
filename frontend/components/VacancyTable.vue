<template>
  <div>
    <div v-if="loading">
      Загрузка...
    </div>

    <div v-else-if="error">
      {{ error }}
    </div>

    <table v-else border="1" cellpadding="10">
      <thead>
      <tr>
        <th>
          Название
          <button @click="sort('title')">
            {{ sortDir === 'asc' ? '↑' : '↓' }}
          </button>
        </th>

        <th>
          Зарплата
          <button @click="sort('salary')">
            {{ sortDir === 'asc' ? '↑' : '↓' }}
          </button>
        </th>

        <th>
          Дата создания
          <button @click="sort('created_at')">
            {{ sortDir === 'asc' ? '↑' : '↓' }}
          </button>
        </th>
      </tr>
      </thead>

      <tbody>
      <tr v-for="item in pagedVacancies" :key="item.id">
        <td>
          <NuxtLink :to="`/vacancies/${item.id}`">
            {{ item.title }}
          </NuxtLink>
        </td>

        <td>{{ item.salary }}</td>

        <td>{{ item.created_at }}</td>
      </tr>
      </tbody>
    </table>

    <Pagination
        v-model:page="currentPage"
        :total="vacancies.length"
        :per-page="perPage"
    />
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import Pagination from './Pagination.vue'
import { useVacancies } from '~/composables/useVacancies'

const {
  vacancies,
  loading,
  error,
  getAll
} = useVacancies()

const currentPage = ref(1)
const perPage = 5

const sortField = ref<'title' | 'salary' | 'created_at'>('created_at')
const sortDir = ref<'asc' | 'desc'>('desc')

onMounted(async () => {
  await getAll()
})

function sort(field: typeof sortField.value) {
  if (sortField.value === field) {
    sortDir.value = sortDir.value === 'asc'
        ? 'desc'
        : 'asc'
  } else {
    sortField.value = field
    sortDir.value = 'asc'
  }
}

const sortedVacancies = computed(() => {
  return [...vacancies.value].sort((a, b) => {
    const aValue = a[sortField.value]
    const bValue = b[sortField.value]

    if (aValue < bValue) {
      return sortDir.value === 'asc' ? -1 : 1
    }

    if (aValue > bValue) {
      return sortDir.value === 'asc' ? 1 : -1
    }

    return 0
  })
})

const pagedVacancies = computed(() => {
  const start = (currentPage.value - 1) * perPage

  return sortedVacancies.value.slice(
      start,
      start + perPage
  )
})
</script>