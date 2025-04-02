import companiesRepository from "@/repositories/companiesRepository"

export default {
    namespaced: true,
    state: {
        company: {},
        regions: [],
        companyTypes: [],
        companyOwnerships: [],
        companyLevels: [],
        companyBedCapacities: [],
    },
    getters: {
        company(state) {
            return state.company
        },
        regions(state) {
            return state.regions
        },
        companyTypes(state) {
            return state.companyTypes
        },
        companyOwnerships(state) {
            return state.companyOwnerships
        },
        companyLevels(state) {
            return state.companyLevels
        },
        companyBedCapacities(state) {
            return state.companyBedCapacities
        },
    },
    mutations: {
        SET_COMPANY(state, company) {
            state.company = company
        },
        SET_REGIONS(state, regions) {
            state.regions = regions
        },
        SET_COMPANY_TYPES(state, companyTypes) {
            state.companyTypes = companyTypes
        },
        SET_COMPANY_OWNERSHIPS(state, companyOwnerships) {
            state.companyOwnerships = companyOwnerships
        },
        SET_COMPANY_LEVELS(state, companyLevels) {
            state.companyLevels = companyLevels
        },
        SET_COMPANY_BED_CAPACITIES(state, companyBedCapacities) {
            state.companyBedCapacities = companyBedCapacities
        },
    },
    actions:{
        getCompany({ commit }, id) {
            commit("SET_COMPANY", {})

            return companiesRepository.getCompany(id)
                .then((response) => {
                    commit("SET_COMPANY", response.data.data)
                })
                .catch((error) => {
                    throw error
                })
        },
        storeCompany({ commit }, company) {
            return companiesRepository.storeCompany(company)
                .then((response) => {
                    commit("SET_COMPANY", response.data.data)
                })
                .catch((error) => {
                    throw error
                })
        },
        updateCompany({ commit }, company) {
            return companiesRepository.updateCompany(company)
                .then((response) => {
                    commit("SET_COMPANY", response.data.data)
                })
                .catch((error) => {
                    throw error
                })
        },
        getRegions({ commit }) {
            return companiesRepository.getRegions()
                .then((response) => {
                    commit("SET_REGIONS", response.data.data)
                })
                .catch((error) => {
                    commit("SET_REGIONS", [])
                    throw error
                })
        },
        getCompanyTypes({ commit }) {
            return companiesRepository.getCompanyTypes()
                .then((response) => {
                    commit("SET_COMPANY_TYPES", response.data.data)
                })
                .catch((error) => {
                    commit("SET_COMPANY_TYPES", [])
                    throw error
                })
        },
        getCompanyOwnerships({ commit }) {
            return companiesRepository.getCompanyOwnerships()
                .then((response) => {
                    commit("SET_COMPANY_OWNERSHIPS", response.data.data)
                })
                .catch((error) => {
                    commit("SET_COMPANY_OWNERSHIPS", [])
                    throw error
                })
        },
        getCompanyLevels({ commit }) {
            return companiesRepository.getCompanyLevels()
                .then((response) => {
                    commit("SET_COMPANY_LEVELS", response.data.data)
                })
                .catch((error) => {
                    commit("SET_COMPANY_LEVELS", [])
                    throw error
                })
        },
        getCompanyBedCapacities({ commit }) {
            return companiesRepository.getCompanyBedCapacities()
                .then((response) => {
                    commit("SET_COMPANY_BED_CAPACITIES", response.data.data)
                })
                .catch((error) => {
                    commit("SET_COMPANY_BED_CAPACITIES", [])
                    throw error
                })
        },
    }
}
