import { createStore } from "vuex";

const store = createStore({
    state: {
        user: {
            data: {name:'Pino'},
            token:null,
        }
    },
    getters: {},
    mutations: {},
    actions: {},
    modules:{},
});

export default store;