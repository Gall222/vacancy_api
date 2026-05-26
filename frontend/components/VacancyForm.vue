<template>
  <form @submit.prevent="submit">
    <div>
      <label>Название</label>
      <input v-model="form.title" required />
    </div>
    <div>
      <label>Описание</label>
      <textarea v-model="form.description" required></textarea>
    </div>
    <div>
      <label>Зарплата</label>
      <input type="number" v-model.number="form.salary" required />
    </div>
    <button type="submit">Создать</button>
    <NuxtLink to="/">Отмена</NuxtLink>
  </form>
</template>

<script setup lang="ts">
import { reactive } from 'vue'
import { useRouter } from 'vue-router'
import { useVacancies } from '~/composables/useVacancies'

const router = useRouter()
const { create } = useVacancies()

const form = reactive({
  title: '',
  description: '',
  salary: 0,
})

async function submit() {
  try {
    await create(form)
    router.push('/')
  } catch (err) {
    alert('Ошибка создания вакансии')
  }
}
</script>
