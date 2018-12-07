<template>
    <section class="cart-active">
        <div class="order__status" :class="statusColor(order)">{{ order.status }}</div>
        <div class="items">
            <div class="incart">
                <div class="cart-item"
                     v-for="(cartItem, index) in order.cart_items"
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
                        <p class="cartsum__products"><span class="cartsum__products__count">{{ countOrderProducts(order) }}</span> {{ wordEndings(order) }} на сумму <span class="cartsum__products__price">{{ totalPrice(order) }} руб.</span></p>
                        <p class="cartsum__discount">Скидка: <span class="cartsum__discount__amount">-{{ discountPrice(order) }} руб.</span></p>
                        <p class="cartsum__final">Итого: <span class="cartsum__final__num">{{ finalPrice(order) }} руб.</span></p>
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
                totalPrice: 'orderTotalPrice',
                discountPrice: 'orderDiscount',
                finalPrice: 'orderFinalPrice',
                countOrderProducts: 'countOrderItems',
                statusColor: 'orderStatusColor'
            }),
            wordEndings() {
                return (order) => wordEnds(this.countOrderProducts(order), 'товаров', 'товар', 'товара');
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
