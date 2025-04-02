import utilsRepository from "@/repositories/utilsRepository"

export default {
    namespaced: true,
    state: {
        serverDate: null
    },
    getters: {
        serverDate(state) {
            return state.serverDate
        },
    },
    mutations: {
        SET_SERVER_DATE(state, serverDate) {
            state.serverDate = serverDate
        }
    },
    actions:{
        getServerDate({ commit }) {
            return utilsRepository.getServerDate()
                .then((response) => {
                    commit("SET_SERVER_DATE", new Date(response.data.slice(0, -1)))
                })
                .catch((error) => {
                    commit("SET_SERVER_DATE", null)
                    throw error
                })
        }
    }
}
