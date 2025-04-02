import axios from './'

export default {
    getMetrics(params) {
        return axios.get(`/api/metrics`, {params: params})
    },
    getMetric(id) {
        return axios.get(`/api/metrics/${id}`)
    },
    storeMetric(metric) {
        return axios.post(`/api/metrics`, metric)
    },
    updateMetric(metric) {
        return axios.put(`/api/metrics/${metric?.id}`, metric)
    },
    deleteMetric(id){
        return axios.delete(`/api/metrics/${id}`)
    },
    getMetricPeriods() {
        return axios.get(`/api/metric-periods`)
    },
    getMetricTargetOrders() {
        return axios.get(`/api/metric-target-orders`)
    },
    getMetricUnit(id) {
        return axios.get(`/api/metric-unit/${id}`)
    }
}
