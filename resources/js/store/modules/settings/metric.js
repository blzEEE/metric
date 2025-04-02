import metricsRepository from "@/repositories/metricsRepository"

export default {
    namespaced: true,
    state:{
        metric:[],
        metricPeriods:[],
        metricTargetOrders:[],
        metricUnit:{},
    },
    getters:{
        metric(state){
            return state.metric
        },
        metricPeriods(state){
            return state.metricPeriods
        },
        metricTargetOrders(state){
            return state.metricTargetOrders
        },
        metricUnit(state){
            return state.metricUnit
        }
    },
    mutations:{
        SET_METRIC(state, metric){
            state.metric = metric
        },
        SET_METRIC_PERIODS(state, metricPeriods){
            state.metricPeriods = metricPeriods
        },
        SET_METRIC_TARGET_ORDERS(state, metricTargetOrders){
            state.metricTargetOrders = metricTargetOrders
        },
        SET_METRIC_UNIT(state, metricUnit){
            state.metricUnit = metricUnit
        }
    },
    actions:{
        getMetric({ commit }, id) {
            return metricsRepository.getMetric(id)
                .then((response) => {
                    commit("SET_METRIC", response.data.data)
                })
                .catch((error) => {
                    commit("SET_METRIC", [])
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
        getMetricUnit({ commit }, id) {
            return metricsRepository.getMetricUnit(id)
                .then((response) => {
                    commit("SET_METRIC_UNIT", response.data.data)
                })
                .catch((error) => {
                    commit("SET_METRIC_UNIT", [])
                    throw error
                })
        },
        storeMetric({ commit }, metric){
            return metricsRepository.storeMetric(metric)
                .then((response) => {
                    commit("SET_METRIC", response.data.data)
                })
                .catch((error) => {
                    throw error
                })
        },
        updateMetric({ commit }, metric) {
            return metricsRepository.updateMetric(metric)
                .then((response) => {
                    commit("SET_METRIC", response.data.data)
                })
                .catch((error) => {
                    throw error
                })
        },
        deleteMetric({ commit }, id){
            return metricsRepository.deleteMetric(id)
                .then((response) => {
                    commit("SET_METRIC", response.data.data)
                })
                .catch((error) => {
                    throw error
                })
        }
    }
}
