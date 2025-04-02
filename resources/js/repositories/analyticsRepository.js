import axios from './'

export default {
    getRaitingSummary(params) {
        return axios.get(`/api/analytics-raiting`, { params: params })
    },
}