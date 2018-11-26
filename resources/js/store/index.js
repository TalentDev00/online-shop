import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import products from './modules/products';
import cart from './modules/cart';
import promotions from './modules/promotions';
import catalog from './modules/catalog';
import header from './modules/header';
import search from './modules/search';

export default new Vuex.Store({
    modules: {
        products,
        cart,
        promotions,
        catalog,
        header,
        search
    },
    strict: process.env.NODE_ENV !== 'production',

});
