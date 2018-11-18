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
    {
        name:'test',
        path: '/test',
        component: myTest
    },
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
        path: '/start1',
        component: start1
    },
    {
        name: 'start2',
        path: '/start2',
        component: start2
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
            title: 'АКЦИИ'
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
        path: '/catalog/products/:id',
        component: myItem,
    },
    {
        name: 'gallery',
        path: '/catalog/products/:id/gallery',
        component: myGallery
    },
    {
        name: 'chat',
        path: '/chat',
        component: myChat,
        meta: {
            title: 'МЫ ВСЕГДА НА СВЯЗИ!'
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
        path: '/catalog',
        component: myCatalog,
        meta: {
            title: 'КАТАЛОГ'
        }
    },
    {
        name: 'subcatalog',
        path: '/catalog/:catalog_id',
        component: mySubcatalog,
    },
    {
        name: 'section',
        path: '/catalog/:catalog_id/:category_id',
        component: mySection,
    },
    {
        name: 'result',
        path: '/result/:id',
        component: myResult
    },
    {
        name: 'sort',
        path: '/sort',
        component: mySort,
        meta: {
            title: 'СОРТИРОВКА'
        }
    },
    {
        name: 'filter',
        path: '/filter',
        component: myFilter,
        meta: {
            title: 'ФИЛЬТРАЦИЯ'
        },
    },
    {
        name: 'parameters',
        path: '/filter/:id/parameters',
        component: myParameters
    },
    {
        name: 'home',
        path: '/home',
        component: myHome,
    },
    /*
    *
    *
    *  Routes for Cart
    *
    * */
    {
        name: 'cart',
        path: '/cart',
        component: myCart,
        meta: {
            title: 'КОРЗИНА'
        }
    },
    {
        name: 'checkout',
        path: '/cart/checkout',
        component: myCheckout,
        meta: {
            title: 'ОФОРМЛЕНИЕ ЗАКАЗА'
        }
    },
    {
        name: 'favorite',
        path: '/favorite',
        component: myFavorite,
        meta: {
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
            title: 'ЛИЧНЫЙ КАБИНЕТ'
        }
    },
    {
        name: 'orders',
        path: '/menu/orders',
        component: myOrders,
        meta: {
            title: 'МОИ ЗАКАЗЫ'
        }
    },
    {
        name: 'order',
        path: '/menu/orders/:id',
        component: myOrder,
        meta: {
            title: ':order-id'
        }
    },
    {
        name: 'settings',
        path: '/menu/settings',
        component: mySettings,
        meta: {
            title: 'НАСТРОЙКИ'
        }
    },
    {
        name: 'edit',
        path: '/menu/settings/edit',
        component: myEdit,
        meta: {
            title: 'НАСТРОЙКИ'
        }
    },
    {
        name: 'about',
        path: '/menu/about',
        component: myAbout,
        meta: {
            title: 'О КОМПАНИИ'
        }
    },
    {
        name: 'delivery',
        path: '/menu/delivery',
        component: myDelivery,
        meta: {
            title: 'ДОСТАВКА И ОПЛАТА'
        }
    },
    {
        name: 'contacts',
        path: '/menu/contacts',
        component: myContacts,
        meta: {
            title: 'КОНТАКТЫ'
        }
    },

];

export default new VueRouter({
    routes,
    mode: 'history'
});
