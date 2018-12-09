<template>
    <section class="cart-active">
        <div class="order__status" :class="statusColor(order)">{{ order.status }}</div>
        <div class="items">
            <div class="incart">
                <div class="cart-item"
                     v-for="(cartItem, index) in order.cart_data"
                     :key="index"
                >
                    <div class="cart-item__body">
                        <div class="cart-item__body__product">
                            <router-link tag="div" :to="{ name: 'product', params: { item_id: cartItem.item.id } }" class="cart-item__body__product__img">
                                <a href=""><img :src="'/images/' + cartItem.item.images[0].large" alt=""></a>
                            </router-link>
                            <div class="cart-item__body__product__details">
                                <p class="cart-item__body__product__details__name">{{ cartItem.item.name }}</p>
                                <div class="cart-item__body__product__details__prices">
                                    <p v-show="cartItem.item.discount === 0" class="cart-item__body__product__details__prices__nodiscount">{{ cartItem.item.price }} <span>руб.</span></p>
                                    <p v-show="cartItem.item.discount !== 0" class="cart-item__body__product__details__prices__odlprice">{{ cartItem.item.price }}</p>
                                    <p v-show="cartItem.item.discount !== 0" class="cart-item__body__product__details__prices__newprice">{{ cartItem.item.price - cartItem.item.discount }} <span>руб.</span></p>
                                    <p class="cart-item__body__product__details__prices__amount">x {{ cartItem.qty }} шт</p>
                                </div>
                            </div>
                            <div class="cart-item__body__product__actions">
                            </div>
                        </div>
                        <ul class="cart-item__body__conditions">
                            <li class="cart-item__body__conditions__item"
                                v-for="(variant, index) in cartItem.item.variants" :key="index"
                            >{{ variant.name }}: <span> {{ variant.values[0] }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="cartsum-wrapper">
                <div class="wrapper-16">
                    <div class="cartsum">
                        <p class="cartsum__products"><span class="cartsum__products__count">{{ order.cart_data ? order.cart_data.length : null }}</span> {{ wordEndings }} на сумму <span class="cartsum__products__price">{{ order.total_price }} руб.</span></p>
                        <p class="cartsum__discount">Скидка: <span class="cartsum__discount__amount">-{{ order.total_discount }} руб.</span></p>
                        <p class="cartsum__final">Итого: <span class="cartsum__final__num">{{ order.final_price }} руб.</span></p>
                    </div>
                </div>
            </div>
            <button v-show="order.status !== 'выполнен'"
                    class="btn btn__fixed btn__redbg"
                    @click="cancelOrder(order)"
            >отменить заказ</button>
        </div>
    </section>
</template>
<script>
    import {mapGetters} from 'vuex';
    import {mapActions} from 'vuex';
    import {wordEnds} from '../includes';
    import {get as methodGet} from '../api';

    export default {
        beforeRouteEnter(to, from, next) {
            next(vm => {
                let params = { orderId: to.params.order_id };
                methodGet(
                    '/store/order',
                    params,
                    (data) => vm.setData(data)
                );

                vm.changeTitle('ЗАКАЗ #' + to.params.order_id);
            });
        },
        data() {
            return {
                order: ''
            }
        },
        computed: {
            ...mapGetters('orders', {
                statusColor: 'orderStatusColor'
            }),
            countOrderProducts() {
                return this.order.cart_data ? this.order.cart_data.length : 0;
            },
            wordEndings() {
                return wordEnds(this.countOrderProducts, 'товаров', 'товар', 'товара');
            },
        },
        methods: {
            ...mapActions('header', {
                changeTitle: 'setTitle',

            }),
            ...mapActions('orders', {
                cancelOrder: 'removeOrder'
            }),
            setData(data) {
                this.order = data;
            },
        }
    }
</script>
