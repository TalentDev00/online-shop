export default {
    namespaced: true,
    state: {
        title: '',
        animationName: 'swipe-left'
    },
    getters: {
        getTitle(state) {
            return state.title;
        },
        getAnimationName(state) {
            return state.animationName;
        }
    },
    mutations: {
        mutateSetTitle(state, title) {
            state.title = title.toUpperCase();
        },
        mutateSetAnimationName(state, name) {
            state.animationName = name;
        }

    },
    actions: {
        setTitle(store, title) {
            store.commit('mutateSetTitle', title);
        },
        setAnimationName(store, name) {
            store.commit('mutateSetAnimationName', name);
        }
    }
}
