import Vue from 'vue';
import axios from 'axios';

export default {
    namespaced: true,
    state: {
        catalogItems: []
    },
    getters: {
        getCatalogItems(state) {
            return state.catalogItems;
        }
    },
    mutations: {
        mutateLoadCatalogItems(state, data) {
            state.catalogItems = data;
        },
    },
    actions: {
        loadCatalogItems(store) {
          /*  Vue.http.get('anystore_catalog.php')
                .then(response => response.json())
                .then(data => {
                    store.commit('mutateLoadCatalogItems', data);
                });*/
            /*axios.get('http://localhost/api/anystore_catalog.php')
                .then(({ data }) => {
                    store.commit('mutateLoadCatalogItems', data);
                }).catch(error => {
                    console.log(error)
                })*/
            axios.get('/catalog')
                .then(({ data }) => {
                    store.commit('mutateLoadCatalogItems', data.data);
                }).catch(error => {
                console.log(error)
            })
        },

    }
}
