import { describe, it, expect, vi } from 'vitest'
import { mount } from '@vue/test-utils'
import VacancyTable from '../../components/VacancyTable.vue'

const mockVacancies = [
    { id: 1, title: 'Vacancy 1', salary: 50000, created_at: '2024-01-01' },
    { id: 2, title: 'Vacancy 2', salary: 60000, created_at: '2024-01-02' }
]

vi.mock('~/composables/useVacancies', () => ({
    useVacancies: () => ({
        vacancies: { value: mockVacancies },
        getAll: vi.fn()
    })
}))

describe('VacancyTable component', () => {
    it('renders table with vacancies', () => {
        const wrapper = mount(VacancyTable)

        expect(wrapper.find('table').exists()).toBe(true)
        expect(wrapper.text()).toContain('Vacancy 1')
        expect(wrapper.text()).toContain('Vacancy 2')
    })

    it('displays sorting controls', () => {
        const wrapper = mount(VacancyTable)
        expect(wrapper.find('.flex.items-center.gap-3').exists()).toBe(true)
    })

    it('pagination buttons are rendered', () => {
        const wrapper = mount(VacancyTable)
        const paginationButtons = wrapper.findAll('.flex.items-center.gap-2.mt-4 button')
        expect(paginationButtons.length).toBe(4)
    })
})