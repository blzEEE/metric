import metricCategoryRepository from "@/repositories/metricCategoriesRepository"

export default {
    namespaced: true,
    state: {
        category: {}
    },
    getters: {
        metricCategory(state) {
            return state.category
        },
    },
    mutations: {
        SET_CATEGORY(state, category) {
            state.category = category
        }
    },
    actions: {
        getMetricCategory({commit}, id) {
            commit("SET_CATEGORY", {})

            return metricCategoryRepository.getMetricCategory(id)
                .then((response) => {
                    commit("SET_CATEGORY", response.data.data)
                })
                .catch((error) => {
                    throw error
                })
        },

        storeMetricCategory({commit}, category) {
            return metricCategoryRepository.storeMetricCategory(category)
                .then((response) => {
                    commit("SET_CATEGORY", response.data.data)
                })
                .catch((error) => {
                    throw error
                })
        },

        updateMetricCategory({commit}, category) {
            return metricCategoryRepository.updateMetricCategory(category)
                .then((response) => {
                    commit("SET_CATEGORY", response.data.data)
                })
                .catch((error) => {
                    throw error
                })
        },

        deleteMetricCategory({commit}, id){
            return metricCategoryRepository.deleteMetricCategory(id)
                .then((response) => {
                    commit("SET_CATEGORY", response.data.data)
                })
                .catch((error) => {
                    throw error
                })
        }
    }
}