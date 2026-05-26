import { $fetch } from 'ofetch'
export const api = $fetch.create({
    baseURL: 'http://localhost:8080/api',
    onResponseError({ response }) {
        throw response._data
    }
})
