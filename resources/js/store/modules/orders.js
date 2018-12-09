import {deleteMethod as deleteData, get as getData} from '../../api'
import Vue from 'vue'

export default {
    namespaced: true,
    state: {
        items: [],
    },
    getters: {
        getOrders(state) {
            return state.items;
        },
        orderNumber(state, getters) {
            return getters.getOrders.length;
        },
/*        orderTotalPrice(state) {
            return (order) => order.cart_items ? order.cart_items.reduce((total, orderItem) => {
                return total + orderItem.item.price * orderItem.qty
            }, 0) : 0;
        },
        orderDiscount(state) {
            return (order) => order.cart_items ? order.cart_items.reduce((total, orderItem) => {
                return total + orderItem.item.discount * orderItem.qty
            }, 0) : 0;
        },
        orderFinalPrice(state, getters) {
            return (order) => getters.orderTotalPrice(order) - getters.orderDiscount(order);
        },
        countOrderItems(state) {
            return (order) => order.cart_items ? order.cart_items.length : 0;
        },*/
        orderStatusColor(state) {
            return (order) => order.status === 'выполнен' ? 'order__status-complete' : 'order__status-inprocess';
        }
    },
    mutations: {
        clearOrders(state) {
            state.items = [];
        },
        addOrder(state, order) {
            let found = state.items.find(item => item.id === order.id);
            if (!found) {
                state.items.push(order);
            }
        },
        spliceOrder(state, order) {
            let found = state.items.find(item => item.id === order.id);
            let index = state.items.indexOf(found);
            if (index > -1) {
                state.items.splice(index, 1)
            }
        },
        setOrders(state, data) {
            state.items = data;
        }
    },
    actions: {
        removeOrder({state, commit}, order) {
            deleteData(
                '/store/order/' + order.id,
                {},
                () => {
                    Vue.router.go(-1);
                }
            );
        },
        loadOrderItems({state, commit}) {
            getData(
                '/store/order',
                {},
                (data) => {
                    commit('setOrders', data)
                }
            );
        },
    }
}
