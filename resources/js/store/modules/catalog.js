import {get as loadData} from '../../api'

export default {
    namespaced: true,
    state: {
        items: [],
    },
    getters: {
        getCatalogItems(state) {
            return state.items;
        },
        rootCategoryItems(state, getters) {
            return getters.getCatalogItems.filter(item => {
                return item.parent_id === null;
            });
        }
    },
    mutations: {
        mutateLoadCatalogItems(state, data) {
            state.items = data;
        },
        mutateClearCatalog(state) {
            state.items = [];
        },
    },
    actions: {
        loadCatalogItems({commit}) {
            loadData('store/catalog', {}, ({data}) => {
                commit('mutateLoadCatalogItems', data);
            });
        },
        loadNewItems(store, data) {
            store.commit('mutateLoadCatalogItems', data);
        },
        clearCatalog(store) {
            store.commit('mutateClearCatalog');
        },
    }
}
