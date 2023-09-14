import { createApp } from 'vue';
import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate'

const store = createStore({
    state: {
        userInfo: {},
    },
    mutations: {
        loginUserName: (state, name) => (state.name = name),
    },
    actions: {
        async checkLogin({ commit }) {
            const response = await axios.get("/api/user-get")
            commit('loginUserName',response.data.name);
        },
    },
    plugins: [createPersistedState({})]
}, );

export default store;


