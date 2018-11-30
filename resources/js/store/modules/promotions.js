
export default {
    namespaced: true,
    state: {
        items: []
    },
    getters: {
        getPromotions(state) {
            return state.items;
        },
        getActions(state, getters) {
            return getters.getPromotions.filter(item => {
                return item.type === 1;
            });
        },
        getPromocodes(state, getters) {
            return getters.getPromotions.filter(item => {
                return item.type === 2;
            });
        }
    },
    mutations: {
        mutateClearPromotions(state) {
            state.items = [];
        },
        mutateSetPromotions(state, data) {
            state.items = data;
        },
    },
    actions: {
        setPromotions({commit, state}, data) {
            commit('mutateSetPromotions', data);
        },
    }
}
