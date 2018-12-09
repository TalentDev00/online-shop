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
        getPromoByCodeName(state, getters) {
            return (code) => getters.getPromotions.find(item => item.code === code && item.type === 2)
        },
        getPromoById(state, getters) {
            return (promoCode) => getters.getPromotions.find(item => item.id === promoCode.id && item.type === 2)
        },
        getSpecificAction(state, getters) {
            return (id) => getters.getPromotions.find(item => item.id === id);
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
        incrementUses({state,getters}, promoCode) {
            let promo = getters.getPromoById(promoCode);
            if (promo) {
                promo.uses++;
            }
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
