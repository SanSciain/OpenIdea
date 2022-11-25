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
        getIdeas() {
            return axiosClient.get("/ideaindex").then((resp) => {
                return resp;
            });
        },
        getIdeasOwned() {
            return axiosClient.get("/ideaownedindex").then((resp) => {
                return resp;
            });
        },
        getIdeaCreate() {
            return axiosClient.get("/ideacreate").then((resp) => {
                return resp;
            });
        },
        getMatchingTags({}, tagSrc) {
            return axiosClient
                .get("/tagindex", {
                    params: { tagSearched: tagSrc.tagSearched },
                })
                .then((resp) => {
                    return resp;
                });
        },
        getMatchingRoles({}, roleSrc) {
            return axiosClient
                .get("/roleindex", {
                    params: { roleSearched: roleSrc.roleSearched },
                })
                .then((resp) => {
                    return resp;
                });
        },
        postIdeaStore({}, req) {
            return axiosClient.post("/ideastore", req).then((resp) => {
                return resp;
            });
        },
        getIdeaShow({}, req) {
            return axiosClient.get(`/ideashow/${req}`).then((resp) => {
                return resp;
            });
        },
        getIdeaShowOwned({}, req) {
            return axiosClient.get(`/ideaownedshow/${req}`).then((resp) => {
                return resp;
            });
        },
        deleteIdea({}, req) {
            return axiosClient.delete(`/ideadelete/${req}`).then((resp) => {
                return resp;
            });
        },
        updateIdea({}, [slug, req]) {
            return axiosClient
                .patch(`/ideaupdate/${slug}`, req)
                .then((resp) => {
                    return resp;
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
