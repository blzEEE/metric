export default {
    namespaced: true,
    state: {
        breadcrumbs: []
    },
    getters: {
        breadcrumbs(state) {
            return state.breadcrumbs
        }
    },
    mutations: {
        SET_BREADCRUMBS(state, value) {
            state.breadcrumbs = value
        }
    },
    actions:{
        async setBreadcrumbs({ commit }, payload) {
            commit('SET_BREADCRUMBS', payload)
        }
    }
}
