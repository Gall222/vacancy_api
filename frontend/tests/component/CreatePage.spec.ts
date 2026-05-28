import { describe, it, expect, vi, beforeEach } from 'vitest'
import { mount } from '@vue/test-utils'
import CreatePage from '../../pages/create.vue'

const mockPush = vi.fn()

vi.mock('vue-router', () => ({
    useRouter: () => ({
        push: mockPush
    })
}))

const mockCreate = vi.fn().mockResolvedValue({})

vi.mock('~/composables/useVacancies', () => ({
    useVacancies: () => ({
        vacancies: { value: [] },
        vacancy: { value: null },
        loading: { value: false },
        error: { value: null },
        getAll: vi.fn(),
        getOne: vi.fn(),
        create: mockCreate
    })
}))

describe('Create vacancy page', () => {
    beforeEach(() => {
        vi.clearAllMocks()
    })

    it('renders form with all inputs', () => {
        const wrapper = mount(CreatePage)

        expect(wrapper.find('input[placeholder="Введите название"]').exists()).toBe(true)
        expect(wrapper.find('textarea[placeholder="Введите описание"]').exists()).toBe(true)
        expect(wrapper.find('input[type="number"]').exists()).toBe(true)
        expect(wrapper.find('button[type="submit"]').text()).toContain('Создать')
    })

    it('handles form submission', async () => {
        const wrapper = mount(CreatePage)

        await wrapper.find('input[placeholder="Введите название"]').setValue('Test Vacancy')
        await wrapper.find('textarea[placeholder="Введите описание"]').setValue('Test Description')
        await wrapper.find('input[type="number"]').setValue(100000)
        await wrapper.find('form').trigger('submit.prevent')

        expect(mockCreate).toHaveBeenCalledWith({
            title: 'Test Vacancy',
            description: 'Test Description',
            salary: 100000
        })
        expect(mockPush).toHaveBeenCalledWith('/')
    })
})