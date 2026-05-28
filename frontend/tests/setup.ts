import { vi } from 'vitest'
import { config } from '@vue/test-utils'

// Мокаем NuxtLink
vi.mock('#app', () => ({
    defineNuxtComponent: vi.fn(),
    useRouter: () => ({
        push: vi.fn(),
        replace: vi.fn(),
        back: vi.fn()
    }),
    useRoute: () => ({
        params: {},
        query: {},
        path: '/'
    })
}))

// Глобальный мок для NuxtLink компонента
config.global.components = {
    NuxtLink: {
        name: 'NuxtLink',
        template: '<a><slot /></a>',
        props: ['to']
    }
}

// Мокаем API вызовы
global.fetch = vi.fn()

// Мокаем localStorage
const localStorageMock = {
    getItem: vi.fn(),
    setItem: vi.fn(),
    clear: vi.fn(),
    removeItem: vi.fn()
}
global.localStorage = localStorageMock as any