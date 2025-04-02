import axios from "./";

export default {
    getFilter(params) {
        return axios.get(`/api/metrics-summary-filter`, {params: params})
    },
    getSummary(params) {
        return axios.get(`/api/metrics-summary`, {params: params})
    },
    getNewDocumentData(params) {
        return axios.get(`/api/input-documents`, {params: params})
    },
    getDocument(id) {
        return axios.get(`/api/input-documents/${id}`)
    },
    storeDocument(document) {
        return axios.post(`/api/input-documents`, document)
    },
    updateDocument(document) {
        return axios.put(`/api/input-documents/${document?.id}`, document)
    },
    deleteDocument(id) {
        return axios.delete(`/api/input-documents/${id}`)
    },
    getMetricCategory(id) {
        return axios.get(`/api/metric-categories/${id}`)
    },
    getMetricPeriod(id) {
        return axios.get(`/api/metric-periods/${id}`)
    },
    approveDocument(id) {
        return axios.post(`/api/approved-documents`, {id: id})
    },
    disapproveDocument(id) {
        return axios.delete(`/api/approved-documents/${id}`)
    }
};
