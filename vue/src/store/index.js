import { createStore } from "vuex";
import axiosClient from "../axios.js";

import createPersistedState from "vuex-persistedstate";

const store = createStore({
    state: {
        user: {
            data: {},
            token: sessionStorage.getItem("TOKEN"),
        },
    },
    getters: {},
    actions: {
        register({ commit }, user) {
            return axiosClient.post("/register", user).then((resp) => {
                if (resp.data) {
                    commit("setUser", resp.data.user);
                    commit("setToken", resp.data.token);
                    return resp.data;
                }
                throw resp;
            });
        },
        login({ commit }, user) {
            return axiosClient
                .post("/login", user)
                .then((resp) => {
                    if (resp.data) {
                        commit("setUser", resp.data.user);
                        commit("setToken", resp.data.token);
                        return resp.data;
                    }
                    throw resp;
                })
                .catch((err) => {
                    throw err;
                });
        },

        // register({ commit }, user) {
        //     return axiosClient.post("/register", user).then(({ data }) => {
        //         commit("setUser", data.user);
        //         commit("setToken", data.token);
        //         return data;
        //     });
        // },
        // login({ commit }, user) {
        //     return axiosClient.post("/login", user).then(({ data }) => {
        //         commit("setUser", data.user);
        //         commit("setToken", data.token);
        //         return data;
        //     });
        // },

        logout({ commit }) {
            return axiosClient.post("/logout").then((response) => {
                commit("logout");
                return response;
            });
        },
        getUser({ commit }) {
            return axiosClient.get("/user").then((res) => {
                commit("setUser", res.data);
            });
        },
    },
    mutations: {
        logout: (state) => {
            state.user.token = null;
            state.user.data = {};
            sessionStorage.removeItem("TOKEN");
        },

        setUser: (state, user) => {
            state.user.data = user;
        },
        setToken: (state, token) => {
            state.user.token = token;
            sessionStorage.setItem("TOKEN", token);
        },
    },
    modules: {},
    plugins: [createPersistedState()],
});

export default store;
