import myMetricsRepository from "@/repositories/myMetricsRepository"

export default {
    namespaced: true,
    state: {
        filter: {},
        summary: {},
    },
    getters: {
        filter(state) {
            return state.filter
        },
        summary(state) {
            return state.summary
        }
    },
    mutations: {
        SET_FILTER(state, filter) {
            state.filter = filter
        },
        SET_SUMMARY(state, summary) {
            state.summary = summary
        }
    },
    actions:{
        getFilter({ commit }, params) {
            return myMetricsRepository.getFilter(params)
                .then((response) => {
                    commit("SET_FILTER", response.data.data)
                })
                .catch((error) => {
                    commit("SET_FILTER", {})
                    throw error
                })
        },
        getSummary({ commit }, params) {
            return myMetricsRepository.getSummary(params)
                .then((response) => {
                    commit("SET_SUMMARY", response.data.data)
                })
                .catch((error) => {
                    commit("SET_SUMMARY", {})
                    throw error
                })
        }
    }
}
