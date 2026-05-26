<script setup lang="ts">
import {ref} from 'vue'
import {useRouter} from 'vue-router'
import {useVacancies} from '~/composables/useVacancies'

const router = useRouter()
const {create} = useVacancies()

const title = ref('')
const description = ref('')
const salary = ref('')

async function handleSubmit() {
  await create({
    title: title.value,
    description: description.value,
    salary: Number(salary.value),
  })

  router.push('/')
}
</script>

<template>
  <form
      class="space-y-5 bg-white p-6 rounded-xl shadow-md"
      @submit.prevent="handleSubmit"
  >

    <div class="space-y-1">
      <label class="text-sm text-gray-600">Название</label>
      <input
          v-model="title"
          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
          placeholder="Введите название"
      />
    </div>

    <div class="space-y-1">
      <label class="text-sm text-gray-600">Описание</label>
      <textarea
          v-model="description"
          class="w-full border border-gray-300 rounded-lg px-3 py-2 h-32 resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"
          placeholder="Введите описание"
      />
    </div>

    <div class="space-y-1">
      <label class="text-sm text-gray-600">Зарплата</label>
      <input
          v-model="salary"
          type="number"
          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
          placeholder="например 100000"
      />
    </div>

    <!-- КНОПКИ -->
    <div class="flex gap-3 pt-2">

      <button
          type="submit"
          class="flex-1 bg-blue-600 hover:bg-blue-700 active:scale-[0.98] transition text-white font-semibold py-2.5 rounded-lg shadow-md"
      >
        Создать
      </button>

      <button
          type="button"
          @click="router.push('/')"
          class="flex-1 bg-gray-200 hover:bg-gray-300 active:scale-[0.98] transition text-gray-800 font-semibold py-2.5 rounded-lg"
      >
        Отмена
      </button>

    </div>

  </form>
</template>