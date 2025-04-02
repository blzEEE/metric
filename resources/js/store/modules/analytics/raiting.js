import analyticsRepository from "@/repositories/analyticsRepository"

export default {
    namespaced: true,
    state: {
        year: null,
        quarter: null,
        month: null,
        category_id: null,
        summary: {},
    },
    getters: {
        year(state) {
            return state.year
        },
        quarter(state) {
            return state.quarter
        },
        month(state) {
            return state.month
        },
        category(state) {
            return state.category_id
        },
        summary(state) {
            return state.summary
        }
    },
    mutations: {
        SET_YEAR(state, year) {
            state.year = year
        },
        SET_QUARTER(state, quarter) {
            state.quarter = quarter
        },
        SET_MONTH(state, month) {
            state.quarter = month
        },
        SET_CATEGORY_ID(state, category_id) {
            state.category_id = category_id
        },
        SET_SUMMARY(state, summary) {
            state.summary = summary
        }
    },
    actions: {
        getRaitingSummary({ commit }, params) {
            return analyticsRepository.getRaitingSummary(params)
                .then((response) => {
                    commit("SET_SUMMARY", response.data.data)
                })
                .catch((error) => {
                    commit("SET_SUMMARY", {})
                    throw error
                })
        },
        setYear({ commit }, year) {
            commit("SET_YEAR", year)
        },
        setQuarter({ commit }, quarter) {
            commit("SET_QUARTER", quarter)
        },
        setMonth({ commit }, month) {
            commit("SET_MONTH", month)
        },
        setCategoryId({ commit }, category_id) {
            commit("SET_CATEGORY_ID", category_id)
        }
    }
}
