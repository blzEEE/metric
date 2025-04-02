import metricCategoryRepository from "@/repositories/metricCategoriesRepository"

export default {
    namespaced: true,
    state:{
        metricCategories:[],
    },
    getters:{
        metricCategories(state){
            return state.metricCategories
        },
        metricCategoryOptions(state){
            return state.metricCategories.map((n) => {
                return {
                    id: n.id,
                    name: n.name
                }
            })
        }
    },
    mutations:{
        SET_METRIC_CATEGORIES(state, metricCategories){
            state.metricCategories = metricCategories
        }
    },
    actions:{
        getMetricCategories({ commit }, params) {
            return metricCategoryRepository.getMetricCategories(params)
                .then((response) => {
                    commit("SET_METRIC_CATEGORIES", response.data.data)
                })
                .catch((error) => {
                    commit("SET_METRIC_CATEGORIES", [])
                    throw error
                })
        }
    }
}
