import Vue from 'vue';
import VueRouter from 'vue-router';
import $ from 'jquery';
import 'owl.carousel';
import noUiSlider from 'nouislider';
import wNumb from 'wnumb';
import Snap from 'snapjs';
import axios from 'axios';
Vue.use(VueRouter);

import router from './routes';
import store from './store';

import App from './components/App';

const app = new Vue({
    el: '#app',
    components: { App },
    store,
    router,
});
