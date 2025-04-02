import Axios from 'axios'
import store from '@/store'
import router from '@/router'

const axios = Axios.create({
    baseURL: import.meta.env.VITE_PUBLIC_BACKEND_URL,
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
    },
    withCredentials: true,
})

axios.interceptors.response.use(
    //если код ответа 2**, то ничего не делаем
    response => response,
    //в случае ошибки
    (error) => {
        if (error.response.status === 401) { //не авторизован
            store.dispatch('auth/userClearData')
                .then(() => {
                    router.push({name: 'login'})
                })
        }
        return Promise.reject(error)
    }
)

export default axios
