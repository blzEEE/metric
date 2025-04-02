import axios from "./";

export default {
    csrf() {
        return axios.get('/sanctum/csrf-cookie')
    },
    userLogin(email, password, remember) {
        return axios.post('/api/login', {email, password, remember})
    },
    userForgotPassword(email) {
        return axios.post('/api/forgot-password', {email})
    },
    userResetPassword(email, password, password_confirmation, token) {
        return axios.post('/api/reset-password', {email, password, password_confirmation, token})
    },
    userLogout() {
        return axios.post('/api/logout')
    },
    getUser() {
        return axios.get('/api/user')
    }
};
