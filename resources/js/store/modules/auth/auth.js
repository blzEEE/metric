import authRepository from "@/repositories/authRepository"

export default {
    namespaced: true,
    state: {
        authenticated: false,
        user: {}
    },
    getters: {
        authenticated(state) {
            return state.authenticated
        },
        user(state) {
            return state.user
        }
    },
    mutations: {
        SET_AUTHENTICATED(state, value) {
            state.authenticated = value
        },
        SET_USER(state, value) {
            state.user = value
        }
    },
    actions: {
        userLogin({commit, dispatch}, {email, password, remember}) {
            return authRepository.userLogin(email, password, remember)
        },
        userForgotPassword(context, {email}) {
            return authRepository.userForgotPassword(email)
        },
        userResetPassword(context, {email, password, password_confirmation, token}) {
            return authRepository.userResetPassword(email, password, password_confirmation, token)
        },
        userLogout({dispatch}) {
            return authRepository.userLogout()
                .then(() => {
                    dispatch('userClearData')
                })
        },
        userLoad({commit, dispatch}) {
            return authRepository.getUser()
                .then(({data}) => {
                    commit('SET_USER', data)
                    commit('SET_AUTHENTICATED', true)
                })
                .catch((error) => {
                    dispatch('userClearData')
                    throw error
                })
        },
        userClearData({commit}) {
            commit('SET_USER', {})
            commit('SET_AUTHENTICATED', false)
            return new Promise((resolve, reject) => resolve())
        }
    }
}
