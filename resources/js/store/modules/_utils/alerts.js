export default {
    namespaced: true,
    state: {
        alerts: []
    },
    mutations: {
        SET_ALERT(state, {type, message}) {
            state.alerts.push({
                type: type,
                message: message,
                id: (Math.random().toString(36) + Date.now().toString(36)).substr(2)
            })
        },
        REMOVE_ALERT(state, id) {
            state.alerts = state.alerts.filter(alert => {
                return alert.id != id
            })
        }
    },
    actions:{
        setAlert({ commit }, {type, message}) {
            commit('SET_ALERT', {type, message})
        },
        removeAlert({ commit }, id) {
            commit('REMOVE_ALERT', id)
        }
    }
}
