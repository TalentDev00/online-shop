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
import myParameters from '../components/parameters';
Vue.use(VueRouter);

const routes = [

    /*
    *  Root Routes
    * */
    {
        path: '',
        redirect: { name: 'start1' }
    },
    {
        name: 'start1',
        path: '/info',
        component: start1,
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
        path: '/store/catalog/discounts',
        component: myAction,
    },
    {
        name: 'home',
        path: '/store/home',
        component: myHome,
    },
    {
        name: 'favorite',
        path: '/store/favorite',
        component: myFavorite,
    },
    {
        name: 'chat',
        path: '/store/chat',
        component: myChat,
    },
    /*
    *  Route for Single product
    * */
    {
        name: 'product',
        path: '/store/catalog/:cat_id?/section/:keywords?/items/:item_id?',
        component: myItem,
    },
    {
        name: 'gallery',
        path: '/store/catalog/:cat_id?/section/:keywords?/items/:item_id?/gallery',
        component: myGallery,
    },
    /*
    *  Routes for Catalog
    * */
    {
        name: 'catalog',
        path: '/store/catalog',
        component: myCatalog,
    },
    {
        name: 'subcatalog',
        path: '/store/catalog/:cat_id?',
        component: mySubcatalog,
    },
    {
        name: 'section',
        path: '/store/catalog/:cat_id?/section/:keywords?',
        component: mySection,
    },
    {
        name: 'sort',
        path: 'sort',
        component: mySort,
    },
    {
        name: 'filter',
        path: 'filter',
        component: myFilter,
    },
    {
        name: 'parameters',
        path: 'parameters',
        component: myParameters,
    },
    /*
    *  Routes for Cart
    * */
    {
        name: 'cart',
        path: '/store/cart',
        component: myCart,
    },
    {
        name: 'checkout',
        path: '/store/cart/checkout',
        component: myCheckout,
    },
    /*
    *  Routes for Menu
    * */
    {
        name: 'menu',
        path: '/store/menu',
        component: myMenu,
    },
    {
        name: 'orders',
        path: '/store/menu/order',
        component: myOrders,
    },
    {
        name: 'order',
        path: '/store/menu/order/:order_id?',
        component: myOrder,
    },
    {
        name: 'settings',
        path: '/store/menu/settings',
        component: mySettings,
    },
    {
        name: 'edit',
        path: '/store/menu/settings/edit',
        component: myEdit,
    },
    {
        name: 'about',
        path: '/store/menu/about',
        component: myAbout,
    },
    {
        name: 'delivery',
        path: '/store/menu/delivery',
        component: myDelivery,
    },
    {
        name: 'contacts',
        path: '/store/menu/contacts',
        component: myContacts,
    },
];

export default new VueRouter({
    routes,
    scrollBehavior (to, from, savedPosition) {
        return { x: 0, y: 0 }
    },
    mode: 'history'
});
