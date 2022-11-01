import axios from 'axios'

// state
export const state = {
    user: null,
}

// getters
export const getters = {
    user: state => state.user,
    check: state => state.user !== null
}

// mutations
export const mutations = {
    logout(state) {
        state.user = null
    },

    updateUser(state, {user}) {
        state.user = user
    }
}

// actions
export const actions = {
    updateUser({commit}, payload) {
        commit('updateUser', payload)
    },

    logout({commit}) {
        commit('logout')
    },
}
