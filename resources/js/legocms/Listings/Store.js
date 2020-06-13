import { map } from "lodash"

export default {
    namespaced: true,
    state() {
        return {
            primaryColumn: null,
            columns: new Map()
        }
    },
    mutations:{
        registerColumn(state, {key, column}) {
            state.columns.set(key, column)
        },
        registerPrimaryColumn(state, column) {
            state.primaryColumn = column
        }
    },
    actions: {
        registerColumn({commit}, column) {
            commit('registerColumn', column)
            if(column.column.primary) {
                commit('registerPrimaryColumn', column.key)
            } 
        }
    },
    getters: {
        columns(state) {
            return state.columns
        },
        primaryColumn(state) {
            return state.primaryColumn
        }
    }
}