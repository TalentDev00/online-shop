import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import products from './modules/products';
import cart from './modules/cart';
import promotions from './modules/promotions';
import catalog from './modules/catalog';
import header from './modules/header';
import search from './modules/search';
import favorites from './modules/favorites';

export default new Vuex.Store({
    modules: {
        products,
        cart,
        promotions,
        catalog,
        header,
        search,
        favorites
    },
    strict: process.env.NODE_ENV !== 'production',
    state: {
        paymentMethods: [],
        deliveryMethods: [],
        logo: '',
        name: '',
        description: ''
    },
    getters: {
        allPaymentMethods(state) {
            return state.paymentMethods;
        },
        allDeliveryMethods(state) {
            return state.deliveryMethods;
        },
        shopLogo(state) {
            return state.logo;
        },
        shopDescription(state) {
            return state.description;
        },
        shopName(state) {
            return state.name;
        }
    },
    mutations: {
        setPaymentMethods(state, data) {
            state.paymentMethods = data;
        },
        setDeliveryMethods(state, data) {
            state.deliveryMethods = data;
        },
        setShopLogo(state, logo) {
            state.logo = logo;
        },
        setShopName(state, name) {
            state.name = name;
        },
        setShopDescription(state, description) {
            state.description = description;
        }
    },
    actions: {
        loadPaymentMethods(store, data) {
            store.commit('setPaymentMethods', data);
        },
        loadDeliveryMethods(store, data) {
            store.commit('setDeliveryMethods', data);
        },
        loadShopLogo(store, logo) {
            store.commit('setShopLogo', logo);
        },
        loadShopName(store, name) {
            store.commit('setShopName', name);
        },
        loadShopDescription(store, description) {
            store.commit('setShopDescription', description);
        }
    }

});
