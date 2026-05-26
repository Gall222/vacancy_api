<template>
  <div class="pagination">
    <button :disabled="page <= 1" @click="prev">
      «
    </button>

    <button
        v-for="p in totalPages"
        :key="p"
        :class="{ active: p === page }"
        @click="setPage(p)"
    >
      {{ p }}
    </button>

    <button :disabled="page >= totalPages" @click="next">
      »
    </button>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'

const props = defineProps<{
  total: number
  perPage: number
  page: number
}>()

const emit = defineEmits<{
  (e: 'update:page', value: number): void
}>()

const totalPages = computed(() => {
  return Math.ceil(props.total / props.perPage)
})

function setPage(p: number) {
  emit('update:page', p)
}

function prev() {
  if (props.page > 1) {
    emit('update:page', props.page - 1)
  }
}

function next() {
  if (props.page < totalPages.value) {
    emit('update:page', props.page + 1)
  }
}
</script>

<style scoped>
.pagination {
  display: flex;
  gap: 5px;
  margin-top: 20px;
}

.active {
  font-weight: bold;
}
</style>