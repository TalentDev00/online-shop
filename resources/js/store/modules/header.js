export default {
    namespaced: true,
    state: {
        title: ''
    },
    getters: {
        getTitle(state) {
            return state.title;
        },
    },
    mutations: {
        mutateSetTitle(state, title) {
            state.title = title.toUpperCase();
        }

    },
    actions: {
        setTitle(store, title) {
            store.commit('mutateSetTitle', title);
        }
    }
}
