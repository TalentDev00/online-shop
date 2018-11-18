import Vue from 'vue';
import axios from "axios";

export default {
    namespaced: true,
    state: {
        items: [],
    },
    getters: {
        getItems(state) {
            return state.items;
        },
    },
    mutations: {
        mutateLoadItems(state, data) {
            state.items = data;
        },
        mutateFavorite(state, product) {
            if (product.product === false) {
                Vue.set(product, 'product_favorite', true);
            } else {
                Vue.set(product, 'product_favorite', false);
            }
        },
        mutateProductCondition(state, obj) {
            let found = state.items.find(item => item.id === obj.product.id);
            if (found) {
                let foundCondition = found.product_conditions.find(item => item.name === obj.condition.name);

                if (foundCondition) {
                    foundCondition.selected = obj.selected;
                }
            }
        },
    },
    actions: {
        loadItems(store) {
           /* Vue.http.get('anystore_prods.php')
                .then(response => response.json())
                .then(data => {
                    store.commit('mutateLoadItems', data);
                });*/
            axios.get('http://localhost/api/anystore_prods.php')
                .then(({ data }) => {
                    store.commit('mutateLoadItems', data);
                }).catch(error => {
                console.log(error)
            })
        },
        like(store, product) {
            store.commit('mutateFavorite', product);
        },
        productConditionSelect(store, obj) {
            store.commit('mutateProductCondition', obj);
        },



    }
}
