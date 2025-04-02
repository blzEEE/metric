import myMetricsRepository from "@/repositories/myMetricsRepository"

export default {
    namespaced: true,
    state: {
        document: {},
        metricCategory: {},
        metricPeriod: {},
    },
    getters: {
        document(state) {
            return state.document
        },
        metricCategory(state) {
            return state.metricCategory
        },
        metricPeriod(state) {
            return state.metricPeriod
        }
    },
    mutations: {
        SET_DOCUMENT(state, document) {
            state.document = document
        },
        SET_METRIC_CATEGORY(state, metricCategory) {
            state.metricCategory = metricCategory
        },
        SET_METRIC_PERIOD(state, metricPeriod) {
            state.metricPeriod = metricPeriod
        }
    },
    actions:{
        getNewDocumentData({ commit, dispatch, state }, { metric_category_id, metric_period_id, year, quarter, month, company_id }) {

            return myMetricsRepository.getNewDocumentData({metric_category_id, metric_period_id, year, quarter, month, company_id})
                .then((response) => {

                    return Promise.all([
                        dispatch('getMetricCategory', metric_category_id),
                        dispatch('getMetricPeriod', metric_period_id),
                    ])
                    .then(() => {

                        let metrics = response.data.data
                        let inputDocumentValues = []

                        for(const metric of metrics) {
                            let inputDocumentValueCalcData = []

                            for (const calcData of metric.metric_calc_data) {
                                inputDocumentValueCalcData.push({
                                    "id": null,
                                    "input_document_value_id": null,
                                    "metric_calc_data_id": calcData.id,
                                    "metric_calc_data": calcData,
                                    "value": 0
                                })
                            }

                            inputDocumentValues.push(
                                {
                                    "id": null,
                                    "input_document_id": null,
                                    "metric_id": metric.id,
                                    "metric": {
                                        "id": metric.id,
                                        "metric_category_id": metric.metric_category_id,
                                        "metric_period_id": metric.metric_period_id,
                                        "metric_target_order_id": metric.metric_target_order_id,
                                        "metric_unit_id": metric.metric_unit_id,
                                        "metric_unit": metric.metric_unit,
                                        "name": metric.name,
                                        "description": metric.description,
                                        "formula": metric.formula
                                    },
                                    "input_document_value_calc_data": inputDocumentValueCalcData,
                                    "value": 0,
                                    "is_active": true
                                }
                            )
                        }

                        let newDocumentData = {
                            "id": null,
                            "company_id": company_id,
                            "metric_category_id": metric_category_id,
                            "metric_category": state.metricCategory,
                            "input_document_status_id": null,
                            "metric_period_id": metric_period_id,
                            "metric_period": state.metricPeriod,
                            "year": year,
                            "quarter": quarter ?? 0,
                            "month": month ?? 0,
                            "input_document_values": inputDocumentValues
                        }

                        commit("SET_DOCUMENT", newDocumentData)

                    })
                    .catch((error) => {
                        commit("SET_DOCUMENT", {})
                        throw error
                    })
            })

        },
        getDocument({ commit }, id) {
            return myMetricsRepository.getDocument(id)
                .then((response) => {
                    commit("SET_DOCUMENT", response.data.data)
                })
                .catch((error) => {
                    commit("SET_DOCUMENT", {})
                    throw error
                })
        },
        storeDocument({ commit }, document) {
            return myMetricsRepository.storeDocument(document)
                .then((response) => {
                    commit("SET_DOCUMENT", response.data.data)
                })
                .catch((error) => {
                    throw error
                })
        },
        updateDocument({ commit }, document) {
            return myMetricsRepository.updateDocument(document)
                .then((response) => {
                    commit("SET_DOCUMENT", response.data.data)
                })
                .catch((error) => {
                    throw error
                })
        },
        deleteDocument({ commit }, id) {
            return myMetricsRepository.deleteDocument(id)
                .then(() => {
                    commit("SET_DOCUMENT", {})
                })
                .catch((error) => {
                    throw error
                })
        },
        getMetricCategory({ commit }, id) {
            return myMetricsRepository.getMetricCategory(id)
                .then((response) => {
                    commit("SET_METRIC_CATEGORY", response.data.data)
                })
                .catch((error) => {
                    commit("SET_METRIC_CATEGORY", {})
                    throw error
                })
        },
        getMetricPeriod({ commit }, id) {
            return myMetricsRepository.getMetricPeriod(id)
                .then((response) => {
                    commit("SET_METRIC_PERIOD", response.data.data)
                })
                .catch((error) => {
                    commit("SET_METRIC_PERIOD", {})
                    throw error
                })
        },
        approveDocument({ commit }, id) {
            return myMetricsRepository.approveDocument(id)
                .catch((error) => {
                    throw error
                })
        },
        disapproveDocument({ commit }, id) {
            return myMetricsRepository.disapproveDocument(id)
                .catch((error) => {
                    throw error
                })
        }
    }
}
