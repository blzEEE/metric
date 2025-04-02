import companiesRepository from "@/repositories/companiesRepository"

export default {
    namespaced: true,
    state: {
        companies: [],
        links: null
    },
    getters: {
        companies(state) {
            return state.companies
        },
        links: (state) => {
            return state.links
        }
    },
    mutations: {
        SET_COMPANIES(state, companies) {
            state.companies = companies
        },
        SET_LINKS(state, links) {
            state.links = links
        }
    },
    actions:{
        getCompanies({ commit }, params) {
            return companiesRepository.getCompanies(params)
                .then((response) => {
                    commit("SET_COMPANIES", response.data.data)
                    commit("SET_LINKS", response.data.meta.links)
                })
                .catch((error) => {
                    commit("SET_COMPANIES", [])
                    throw error
                })
        }
    }
}
