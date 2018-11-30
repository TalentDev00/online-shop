import Vue from 'vue';
import axios from 'axios';

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
        loadCatalogItems(store) {
            axios.get('/store/catalog')
                .then(({ data }) => {
                    store.commit('mutateLoadCatalogItems', data);
                }).catch(error => {
                console.log(error)
            })
        },

        loadNewItems(store, data) {
            store.commit('mutateLoadCatalogItems', data);
        },
        clearCatalog(store) {
            store.commit('mutateClearCatalog');
        },



    }
}
