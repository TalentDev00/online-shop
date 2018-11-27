import Vue from 'vue';
import VueRouter from 'vue-router';
import $ from 'jquery';
import 'owl.carousel';
import noUiSlider from 'nouislider';
import wNumb from 'wnumb';
import Snap from 'snapjs';
import axios from 'axios';
import VueAxios from 'vue-axios';
import VueScrollTo from 'vue-scrollto';
Vue.use(VueAxios, axios);
Vue.use(VueRouter);
Vue.use(VueScrollTo);

Vue.router = router;
Vue.use(require('@websanova/vue-auth'), {
    auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
    http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
    router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
    registerData:       {url: '/user/register',     method: 'POST', redirect: null},
    loginData:          {url: '/user/login',        method: 'POST', redirect: '/home'},
    logoutData:         {url: '/user/logout',       method: 'POST', redirect: '/user', makeRequest: false},
    oauth1Data:         {url: '/user/login',        method: 'POST'},
    fetchData:          {url: '/user',         method: 'GET'},
    refreshData:        {url: '/refresh',      method: 'GET'},
    authRedirect: {path: '/user'},
    forbiddenRedirect: {path: '/menu'},
    notFoundRedirect: {path: '/home'}
});
import router from './routes';
import store from './store';
import App from './components/App';

App.router = Vue.router;

function debounce(fn, delay = 300) {
    let timeoutID = null;

    return function () {
        clearTimeout(timeoutID);

        let args = arguments;
        let that = this;

        timeoutID = setTimeout(function () {
            fn.apply(that, args);
        }, delay);
    }
}

Vue.directive('debounce', (el, binding) => {
    if (binding.value !== binding.oldValue) {
        el.oninput = debounce(ev => {
            el.dispatchEvent(new Event('change'));
        }, parseInt(binding.value) || 300);
    }
});

Vue.directive('delayed', {
    bind(el, options){
        let timer;
        let timeout = 0;

        for(let name in options.modifiers){
            if(!isNaN(+name)){
                timeout = parseInt(name);
            }
        }

        let callback = (e) => {
            if(timer !== undefined){
                clearInterval(timer);
            }

            if(options.modifiers.prevent){
                e.preventDefault();
            }

            timer = setTimeout(() => {
                options.value.call(this, e);
            }, timeout);
        };

        el.addEventListener(options.arg, callback);
    }
});

const app = new Vue({
    el: '#app',
    components: { App },
    store,
    router,
});
