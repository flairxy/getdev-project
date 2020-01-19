import Vue from "vue";
import Vuex from "vuex";
import "es6-promise/auto";
import router from "../router";

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        role: ""
    },
    getters: {
        getRole: state => {
            return state.role;
        }
    },
    mutations: {
        storeRole(state, data) {
            state.role = data;
        }
    },
    actions: {}
});
