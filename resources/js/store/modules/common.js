import axios from 'axios'

// state
export const state = {
    collapse: false,
}

// getters
export const getters = {
    collapse: state => state.collapse,
}

// mutations
export const mutations = {
    toggleCollapse(state) {
        state.collapse = !state.collapse
    },
}

// actions
export const actions = {
    toggleCollapse({commit}) {
        commit('toggleCollapse')
    },

    logout({commit}) {
        commit('logout')
    },
}
