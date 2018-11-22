import Vue from 'vue';
import axios from 'axios';

export default {
    namespaced: true,
    state: {
        catalogItems: [],
        sort: 'price_asc'

    },
    getters: {
        getCatalogItems(state) {
            return state.catalogItems;
        },
        getSort(state) {
            return state.sort;
        }
    },
    mutations: {
        mutateLoadCatalogItems(state, data) {
            state.catalogItems = data;
        },
        mutateClearCatalog(state) {
            state.catalogItems = [];
        },
        mutateSort(state, value) {
            state.sort = value;
        }
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
        sortChange(store, value) {
            store.commit('mutateSort', value);
        }


    }
}
