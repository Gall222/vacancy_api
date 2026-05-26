<template>
  <div class="min-h-screen bg-gray-100 text-gray-900">
    <header class="bg-white shadow p-4 flex justify-between items-center">
      <h1 class="text-xl font-bold">Vacancy App</h1>

      <NuxtLink
          to="/create"
          class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
      >
        + Создать
      </NuxtLink>
    </header>

    <main class="max-w-5xl mx-auto p-6">
      <slot />
    </main>
  </div>
</template>