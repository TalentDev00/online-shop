import Vue from 'vue';

export default {
    namespaced: true,
    state: {
        products: [],
        promoCodeApplied: false,
        promoCodeDiscount: ''
    },
    getters: {
        getProducts(state) {
            return state.products;
        },
        getCountProducts(state) {
            return state.products.length;
        },
        getPromoCodeAppliedStatus(state) {
            return state.promoCodeApplied;
        },
        getPromoCodeAmount(state) {
            return state.promoCodeDiscount;
        }
    },
    mutations: {
        mutateAddToCart(state, product) {
            let found = state.products.find(item => item.item.id === product.id);
            if (found) {
                found.qty++;
            }

            else {
                state.products.push({
                    qty: 1,
                    item: product,
                });
            }
          /* let found = state.products.find(item => item.id === product.id);

           let product_price = product.price;

           if (found) {

               found.product_quantity ++;
               found.product_totalPrice = found.product_quantity * product_price;
           }
           else {
               state.products.push(product);
               Vue.set(product, 'product_incart', true);
               Vue.set(product, 'product_quantity', 1);
               Vue.set(product, 'product_totalPrice', product_price);
           }*/
        },
        mutateRemoveFromCart(state, product) {
            let found = state.products.find(item => item.item.id === product.id);
            let index = state.products.indexOf(found);
            if (index > -1) {
                let cartItem = state.products[index];
                if (cartItem.qty > 1) {
                    cartItem.qty = cartItem.qty - 1;
                }

                else {
                    state.products.splice(index, 1);
                }
            }
          /*  let index = state.products.indexOf(product);
            let product_price = product.product_nodiscount || product.product_newprice;

            if (index > -1) {
                let item = state.products[index];
                if (item.product_quantity > 1) {
                    item.product_quantity = item.product_quantity - 1;
                    item.product_totalPrice = item.product_quantity * product_price;
                }
                else {
                    state.products.splice(index, 1);
                }

            }*/
        },
        mutateRemoveFromCartWithAllCounts(state, product) {
            let found = state.products.find(item => item.item.id === product.id);
            let index = state.products.indexOf(found);
            if (index > -1) {
                state.products.splice(index, 1);
            }
        },
        mutateProductVariant(state, obj) {
            let found = state.products.find(item => item.item.id === obj.product.id);
            if (found) {

                let foundVariant = found.item.variants.find(item => item.name === obj.variant);

                if (foundVariant) {
                    if (foundVariant.selected) {
                        foundVariant.selected = obj.value;
                    }
                    else {
                        Vue.set(foundVariant, 'selected', obj.value)
                    }
                }

            }
        },
        mutatePromocodeAppliedChangeStatus(state) {
            state.promoCodeApplied = true;
        },
        mutatePromoCodeDiscountChange(state, amount) {
            state.promoCodeDiscount = amount;
        }
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
        },
        promocodeApply(store) {
            store.commit('mutatePromocodeAppliedChangeStatus');
        },
        promocodeAdd(store, amount) {
            store.commit('mutatePromoCodeDiscountChange', amount);
        },
        setProductSelectedVariantInCart(store, obj) {
            store.commit('mutateProductVariant', obj);
        }
    }
}
