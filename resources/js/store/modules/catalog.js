import Vue from 'vue';
import axios from 'axios';

export default {
    namespaced: true,
    state: {
        catalogItems: [],


    },
    getters: {
        getCatalogItems(state) {
            return state.catalogItems;
        },

    },
    mutations: {
        mutateLoadCatalogItems(state, data) {
            state.catalogItems = data;
        },
        mutateClearCatalog(state) {
            state.catalogItems = [];
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
