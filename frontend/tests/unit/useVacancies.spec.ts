import { describe, it, expect, vi, beforeEach } from 'vitest'
import { useVacancies } from '~/composables/useVacancies'
import { ref } from 'vue'

vi.mock('#app', () => ({
    useRuntimeConfig: vi.fn().mockReturnValue({
        public: {
            apiUrl: 'http://localhost:3000/api'
        }
    })
}))

vi.mock('~/composables/useVacancies', () => ({
    useVacancies: vi.fn(() => ({
        vacancies: ref([]),
        vacancy: ref(null),
        loading: ref(false),
        error: ref(null),
        getAll: vi.fn(),
        getOne: vi.fn(),
        create: vi.fn()
    }))
}))

describe('useVacancies composable', () => {
    let composable: ReturnType<typeof useVacancies>

    beforeEach(() => {
        composable = useVacancies()
    })

    it('should have correct initial state', () => {
        expect(composable.vacancies.value).toEqual([])
        expect(composable.vacancy.value).toBeNull()
    })

    it('getAll should be called', () => {
        composable.getAll()
        expect(composable.getAll).toHaveBeenCalled()
    })

    it('create should be called with correct data', async () => {
        const testData = {
            title: 'Test vacancy',
            description: 'Test description',
            salary: 100000
        }
        await composable.create(testData)
        expect(composable.create).toHaveBeenCalledWith(testData)
    })
})
