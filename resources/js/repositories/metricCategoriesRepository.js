import axios from './'

export default {
    getMetricCategories(params) {
        return axios.get(`/api/metric-categories`, {params: params})
    },
    getMetricCategory(id) {
        return axios.get(`/api/metric-categories/${id}`)
    },
    storeMetricCategory(category) {
        return axios.post(`/api/metric-categories`, category)
    },
    updateMetricCategory(category) {
        return axios.put(`/api/metric-categories/${category?.id}`, category)
    },
    deleteMetricCategory(id){
        return axios.delete(`/api/metric-categories/${id}`)
    }
}
