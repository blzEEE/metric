import axios from "./";

export default {
    getCompanies(params) {
        return axios.get(`/api/companies`, {params: params})
    },
    getCompany(id) {
        return axios.get(`/api/companies/${id}`)
    },
    storeCompany(company) {
        return axios.post(`/api/companies`, company)
    },
    updateCompany(company) {
        return axios.put(`/api/companies/${company?.id}`, company)
    },
    getRegions() {
        return axios.get('/api/regions')
    },
    getCompanyTypes() {
        return axios.get('/api/company-types')
    },
    getCompanyOwnerships() {
        return axios.get('/api/company-ownerships')
    },
    getCompanyLevels() {
        return axios.get('/api/company-levels')
    },
    getCompanyBedCapacities() {
        return axios.get('/api/company-bed-capacities')
    }
};
