import Vue from 'vue';
import axios from "axios";
export default {
    namespaced: true,
    state: {
        promotions: []
    },
    getters: {
        getPromotions(state) {
            return state.promotions;
        },
    },
    mutations: {
        mutateClearPromotions(state) {
            state.promotions = [];
        },
        mutateLoadPromotions(state, data) {
            state.promotions = data;
        },
        mutatePromoUse(state, index) {
            if (state.promotions[index].used !== true) {
                Vue.set(state.promotions[index], 'used', true);
            }

        }
    },
    actions: {
        loadPromotions(store) {

          //  store.commit('mutateClearPromotions');

           /* Vue.http.get('anystore_promotions.php')
                .then(response => response.json())
                .then(data => {
                    store.commit('mutateLoadPromotions', data);
                });*/
            axios.get('http://localhost/api/anystore_promotions.php')
                .then(({ data }) => {
                    store.commit('mutateLoadPromotions', data);
                }).catch(error => {
                console.log(error)
            })
        },
        promotionUsed(store, index) {
            store.commit('mutatePromoUse', index);
        }
    }
}
