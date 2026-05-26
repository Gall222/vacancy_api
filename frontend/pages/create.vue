<script setup lang="ts">
import VacancyForm from '~/components/VacancyForm.vue'
import { useRouter } from 'vue-router'
import { useVacancies } from '~/composables/useVacancies'

const router = useRouter()
const { create } = useVacancies()

async function handleSubmit(form: any) {
  await create(form)
  router.push('/')
}
</script>

<template>
  <div>
    <h1>Создать вакансию</h1>

    <VacancyForm @submit="handleSubmit" />
  </div>
</template>