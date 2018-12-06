import Vue from 'vue';
import {post as sendData, get as loadData} from '../../api';

export default {
    namespaced: true,
    state: {
        items: [],
        paymentMethod: 'Наличными',
        deliveryMethod: 'Курьером - 300 рублей',
        deliveryAddress: '',
        comment: '',
        checkoutStatus: null
    },
    getters: {
        getProducts(state) {
            return state.items;
        },
        getCountProducts(state) {
            return state.items.length;
        },
        itemQty(state, getters) {
            return (product) => getters.getProducts.find(item => item.item.id === product.id || item.item.item_id === product.id)
                ? getters.getProducts.find(item => item.item.id === product.id || item.item.item_id === product.id).qty
                : null;
        },
        inCart(state, getters) {
            return (product) => getters.getProducts.find(item => item.item.id === product.id || item.item.item_id === product.id)
        },
        cartTotalPrice(state, getters) {
            return getters.getProducts.reduce((total, cartItem) => {
                return total + cartItem.item.price * cartItem.qty
            }, 0);
        },
        cartDiscountPrice(state, getters) {
            return getters.getProducts.reduce((total, cartItem) => {
                 return total + cartItem.item.discount * cartItem.qty
            }, 0);
        },
        cartFinalPrice(state, getters) {
            return getters.cartTotalPrice - getters.cartDiscountPrice;
        },
        getDeliveryMethod(state) {
            return state.deliveryMethod;
        },
        getPaymentMethod(state) {
            return state.paymentMethod;
        },
        getDeliveryAddress(state) {
            return state.deliveryAddress;
        },
        getComment(state) {
            return state.comment;
        }
    },
    mutations: {
        mutateAddToCart(state, product) {
            let found = state.items.find(item => item.item.id === product.id);
            if (found) {
                found.qty++;
            }
            else {
                state.items.push({
                    qty: 1,
                    item: product,
                });
            }
        },
        mutateRemoveFromCart(state, product) {
            let found = state.items.find(item => item.item.id === product.id);
            let index = state.items.indexOf(found);
            if (index > -1) {
                let cartItem = state.items[index];
                if (cartItem.qty > 1) {
                    cartItem.qty = cartItem.qty - 1;
                }
                else {
                    state.items.splice(index, 1);
                }
            }
        },
        mutateRemoveFromCartWithAllCounts(state, product) {
            let found = state.items.find(item => item.item.id === product.id);
            let index = state.items.indexOf(found);
            if (index > -1) {
                state.items.splice(index, 1);
            }
        },
        mutateProductVariant(state, obj) {
            let found = state.items.find(item => item.item.id === obj.product.id);
            if (found) {

                let foundVariant = found.item.variants.find(item => item.name === obj.variant.name);

                if (foundVariant) {
                    if (foundVariant.selected) {
                        foundVariant.selected = obj.value;
                    }
                    else {
                        Vue.set(foundVariant, 'selected', obj.value)
                    }

                    let first = obj.value;
                    foundVariant.values.sort((x, y) => {
                        return x === first ? -1 : y === first ? 1 : 0;
                    });
                }
            }
        },
        mutatePutSelectedVariantToFirstPosition(state, obj) {
            let found = state.items.find(item => item.item.id === obj.product.id);
            if (found) {

                let foundVariant = found.item.variants.find(item => item.name === obj.variant.name);

                if (foundVariant) {
                    let first = obj.value;
                    foundVariant.values.sort((x, y) => {
                        return x === first ? -1 : y === first ? 1 : 0;
                    });
                }
            }
        },
        mutateClearCartItems(state) {
            state.items = [];
        },
        mutateSetCartItems(state, data) {
            state.items = data;
        },
        mutateCheckoutStatus(state, status) {
            state.checkoutStatus = status;
        },
        mutatePaymentMethod(state, data) {
            state.paymentMethod = data;
        },
        mutateDeliveryMethod(state, data) {
            state.deliveryMethod = data;
        },
        mutateDeliveryAddress(state, data) {
            state.deliveryAddress = data;
        },
        mutateComment(state, data) {
            state.comment = data;
        },
    },
    actions: {
        addToCart(store, product) {
            store.commit('mutateAddToCart', product);
        },
        removeFromCart(store, product) {
            store.commit('mutateRemoveFromCart', product);
        },
        removeFromCartWithAllCounts(store, product){
            store.commit('mutateRemoveFromCartWithAllCounts', product);
            if (Vue.auth.check()) {
                sendData('/store/cart', {
                        item_id: product.id,
                        qty: null
                    }
                );
            }
        },
        setProductSelectedVariantInCart(store, obj) {
            store.commit('mutateProductVariant', obj);
        },
        checkout({commit, state}, cartItems) {
            const savedCartItems = [...state.items];
            commit('mutateCheckoutStatus', null);
            commit('mutateClearCartItems');

            sendData(
                '/store/order',
                {
                    items: cartItems,
                    payment_method: state.paymentMethod,
                    delivery_method: state.deliveryMethod,
                    delivery_address: state.deliveryAddress,
                    status: 'в обработке',
                    comment: state.comment
                },
                (data) => {
                    commit('mutateCheckoutStatus', 'successful');
                    Vue.router.replace({ name: 'order', params: { order_id: data.order.id } });
                },
                () => {
                    commit('mutateCheckoutStatus', 'failed');
                    commit('mutateSetCartItems', savedCartItems)
                }
            )
        },
        setPaymentMethod(store, data) {
            store.commit('mutatePaymentMethod', data);
        },
        setDeliveryMethod(store, data) {
            store.commit('mutateDeliveryMethod', data);
        },
        setDeliveryAddress(store, data) {
            store.commit('mutateDeliveryAddress', data);
        },
        setComment(store, data) {
            store.commit('mutateComment', data);
        },
        setCartItems({state, commit}, data) {
            commit('mutateSetCartItems', data);
        },
        addCartItem({state, getters, commit}, product) {
            commit('mutateAddToCart', product);
            if (Vue.auth.check()) {
                sendData('/store/cart', {
                        item_id: product.id,
                        qty: getters.itemQty(product)
                    },
                );
            }
        },
        removeCartItem({state, getters, commit}, product) {
            commit('mutateRemoveFromCart', product);
            if (Vue.auth.check()) {
                sendData('/store/cart', {
                        item_id: product.id,
                        qty: getters.itemQty(product)
                    },
                );
            }
        },
        loadUserCart({state, commit}) {
            if (Vue.auth.check()) {
                loadData('/store/cart', {},
                    (data) => {
                        commit('mutateSetCartItems', data.cart_items);
                    }
                );
            }
        },
        syncCartItem({state, commit, getters}, product) {
            if (Vue.auth.check()) {
                sendData('/store/cart', {
                        item_id: product.id,
                        qty: getters.itemQty(product)
                    }
                );
            }
        },
        syncCart({commit, state}, cartItems) {
            sendData(
                '/store/cart/sync',
                {
                    syncItems: cartItems,
                },
            )
        }
    }
}
