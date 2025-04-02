import metricsRepository from "@/repositories/metricsRepository"

export default {
    namespaced: true,
    state:{
        metrics:[],
        metricPeriods:[],
        metricTargetOrders:[],
    },
    getters:{
        metrics(state){
            return state.metrics
        },
        metricPeriods(state){
            return state.metricPeriods
        },
        metricTargetOrders(state){
            return state.metricTargetOrders
        }
    },
    mutations:{
        SET_METRICS(state, metrics){
            state.metrics = metrics
        },
        SET_METRIC_PERIODS(state, metricPeriods){
            state.metricPeriods = metricPeriods
        },
        SET_METRIC_TARGET_ORDERS(state, metricTargetOrders){
            state.metricTargetOrders = metricTargetOrders
        }
    },
    actions:{
        getMetrics({ commit }, params) {
            return metricsRepository.getMetrics(params)
                .then((response) => {
                    commit("SET_METRICS", response.data.data)
                })
                .catch((error) => {
                    commit("SET_METRICS", [])
                    throw error
                })
        },
        getMetricPeriods({ commit }) {
            return metricsRepository.getMetricPeriods()
                .then((response) => {
                    commit("SET_METRIC_PERIODS", response.data.data)
                })
                .catch((error) => {
                    commit("SET_METRIC_PERIODS", [])
                    throw error
                })
        },
        getMetricTargetOrders({ commit }) {
            return metricsRepository.getMetricTargetOrders()
                .then((response) => {
                    commit("SET_METRIC_TARGET_ORDERS", response.data.data)
                })
                .catch((error) => {
                    commit("SET_METRIC_TARGET_ORDERS", [])
                    throw error
                })
        },
    }
}