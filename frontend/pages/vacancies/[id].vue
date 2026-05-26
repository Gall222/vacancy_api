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
  <div v-if="vacancy">
    <h1>{{ vacancy.title }}</h1>
    <p>{{ vacancy.description }}</p>
    <p>{{ vacancy.salary }}</p>
    <p>{{ vacancy.created_at }}</p>
  </div>

  <div v-else>
    Loading...
  </div>
</template>