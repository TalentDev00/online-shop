import Vue from 'vue';
import VueRouter from 'vue-router';
import store from "../store";
import start1 from '../components/start1';
import start2 from '../components/start2';
import start3 from '../components/start3';
import myAction from '../components/action';
import myChat from '../components/chat';
import myCatalog from '../components/catalog';
import myMenu from '../components/menu';
import myCart from '../components/cart';
import myHome from '../components/home';
import myFavorite from '../components/favorite';
import myOrders from '../components/orders';
import mySettings from '../components/settings';
import myAbout from '../components/about';
import myDelivery from '../components/delivery';
import myContacts from '../components/contacts';
import myEdit from '../components/edit';
import myOrder from '../components/order';
import mySubcatalog from '../components/subcatalog';
import mySection from '../components/section';
import myCheckout from '../components/checkout';
import myItem from '../components/product';
import mySort from '../components/sort';
import myFilter from '../components/filter';
import myGallery from '../components/gallery';
import myTest from '../components/test';
import myParameters from '../components/parameters';
import myResult from '../components/result';
Vue.use(VueRouter);


const routes = [

    /*
    *
    *  Real Routes
    *
    * */
    {
        path: '',
        redirect: { name: 'start1' }
    },
    {
        name: 'start1',
        path: '/info',
        component: start1,
        meta: {
            auth: false,
        }
    },
    {
        name: 'start2',
        path: '/user',
        component: start2,
        meta: {
            auth: false,
        }
    },
    {
        name: 'start3',
        path: '/start3',
        component: start3
    },
    {
        name: 'action',
        path: '/discounts',
        component: myAction,
        meta: {
            title: 'АКЦИИ',
            auth: false
        }
    },

    /*
    *
    *
    *  Route for Single product
    *
    * */
    {
        name: 'product',
        path: '/store/catalog/products/:id',
        component: myItem,
        meta: {
            auth: false,
        }
    },
    {
        name: 'gallery',
        path: '/catalog/products/:id/gallery',
        component: myGallery,
        meta: {
            auth: false,
        }
    },
    {
        name: 'chat',
        path: '/chat',
        component: myChat,
        meta: {
            title: 'МЫ ВСЕГДА НА СВЯЗИ!',
            auth: false,
        }
    },
    /*
    *
    *
    *  Routes for Catalog
    *
    * */
    {
        name: 'catalog',
        path: '/store/catalog',
        component: myCatalog,
        meta: {
            auth: false,
            title: 'КАТАЛОГ'
        },
    },
    {
        name: 'subcatalog',
        path: '/store/catalog/:cat_id?',
        component: mySubcatalog,
        meta: {
            auth: false,
        },

    },
    {
        name: 'section',
        path: '/store/catalog/:cat_id?/section',
        component: mySection,
        meta: {
            auth: false,
        }
    },
    {
        name: 'sort',
        path: '/store/catalog/:cat_id?/section/sort',
        component: mySort,
        meta: {
            auth: false,
        }
    },
    {
        name: 'filter',
        path: '/store/catalog/:cat_id?/section/filter',
        component: myFilter,
        meta: {
            auth: false,
        },
    },
    {
        name: 'parameters',
        path: '/store/catalog/:cat_id?/section/filter/:filter_id/parameters',
        component: myParameters,
        meta: {
            auth: false,
        }
    },
    {
        name: 'result',
        path: '/result/:id',
        component: myResult,
        meta: {
            auth: false,
        }
    },

    {
        name: 'home',
        path: '/home',
        component: myHome,
        meta: {
            auth: false,
        }
    },
    /*
    *
    *
    *  Routes for Cart
    *
    * */
    {
        name: 'cart',
        path: '/store/cart',
        component: myCart,
        meta: {
            auth: false,
            title: 'КОРЗИНА'
        }
    },
    {
        name: 'checkout',
        path: '/store/cart/checkout',
        component: myCheckout,
        meta: {
            auth: false,
            title: 'ОФОРМЛЕНИЕ ЗАКАЗА'
        }
    },
    {
        name: 'favorite',
        path: '/store/favorite',
        component: myFavorite,
        meta: {
            auth: false,
            title: 'ИЗБРАННОЕ'
        }
    },
    /*
    *
    *  Routes for Menu
    *
    * */
    {
        name: 'menu',
        path: '/menu',
        component: myMenu,
        meta: {
            auth: false,
            title: 'ЛИЧНЫЙ КАБИНЕТ'
        }
    },
    {
        name: 'orders',
        path: '/store/orders',
        component: myOrders,
        meta: {
            auth: false,
            title: 'МОИ ЗАКАЗЫ'
        }
    },
    {
        name: 'order',
        path: '/store/orders/:id',
        component: myOrder,
        meta: {
            auth: false,
            title: ':order-id'
        }
    },
    {
        name: 'settings',
        path: '/menu/settings',
        component: mySettings,
        meta: {
            auth: false,
            title: 'НАСТРОЙКИ'
        }
    },
    {
        name: 'edit',
        path: '/menu/settings/edit',
        component: myEdit,
        meta: {
            auth: false,
            title: 'НАСТРОЙКИ'
        }
    },
    {
        name: 'about',
        path: '/menu/about',
        component: myAbout,
        meta: {
            auth: false,
            title: 'О КОМПАНИИ'
        }
    },
    {
        name: 'delivery',
        path: '/menu/delivery',
        component: myDelivery,
        meta: {
            auth: false,
            title: 'ДОСТАВКА И ОПЛАТА'
        }
    },
    {
        name: 'contacts',
        path: '/menu/contacts',
        component: myContacts,
        meta: {
            auth: false,
            title: 'КОНТАКТЫ'
        }
    },

];

export default new VueRouter({
    routes,
    mode: 'history'
});
