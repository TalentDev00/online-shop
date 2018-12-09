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
