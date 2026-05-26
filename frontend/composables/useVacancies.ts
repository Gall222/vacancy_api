import { ref } from 'vue'

export interface Vacancy {
    id: number
    title: string
    description: string
    salary: number
    created_at: string
}

export function useVacancies() {
    const config = useRuntimeConfig()

    const BASE_URL = `${config.public.apiUrl}/vacancies`

    const vacancies = ref<Vacancy[]>([])
    const vacancy = ref<Vacancy | null>(null)
    const loading = ref(false)
    const error = ref<string | null>(null)

    async function getAll() {
        loading.value = true
        error.value = null

        try {
            vacancies.value = await $fetch<Vacancy[]>(BASE_URL)
        } catch (e: any) {
            error.value = 'Ошибка загрузки вакансий'
            console.error(e)
        } finally {
            loading.value = false
        }
    }

    async function getOne(id: number) {
        loading.value = true
        error.value = null

        try {
            vacancy.value = await $fetch<Vacancy>(`${BASE_URL}/${id}`)
        } catch (e: any) {
            error.value = 'Ошибка загрузки вакансии'
            console.error(e)
        } finally {
            loading.value = false
        }
    }

    async function create(data: Omit<Vacancy, 'id' | 'created_at'>) {
        loading.value = true
        error.value = null

        try {
            return await $fetch<Vacancy>(BASE_URL, {
                method: 'POST',
                body: data,
            })
        } catch (e: any) {
            error.value = 'Ошибка создания вакансии'
            throw e
        } finally {
            loading.value = false
        }
    }

    return {
        vacancies,
        vacancy,
        loading,
        error,
        getAll,
        getOne,
        create,
    }
}