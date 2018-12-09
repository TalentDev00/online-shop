<template>
    <section class="orders">
        <div class="wrapper-16">
            <div class="items">
                <ul class="list">
                    <router-link v-for="(order, index) in orders" :key="index"
                                 tag="li"
                                 :to="{ name: 'order', params: { order_id: order.id } }"
                                 class="list__item"
                    >
                        <a href="" class="list__item__name">
                            <div class="order">
                                <div class="order__details">
                                    <p class="order__details__number">#{{ order.id }}</p>
                                    <p class="order__details__price"><span>{{ order.final_price }} ₽ </span><span>({{ order.updated_at }})</span></p>
                                </div>
                                <div class="order__status "
                                     :class="statusColor(order)"
                                >{{ order.status }}</div>
                            </div>
                        </a>
                    </router-link>
                </ul>
            </div>
        </div>
    </section>
</template>
<script>
    import {mapGetters} from 'vuex';
    import {mapActions} from 'vuex';

    export default {
        beforeRouteEnter(to, from, next) {
            next(vm => {
                vm.changeTitle('МОИ ЗАКАЗЫ');
                vm.loadOrders();
            });
        },
        computed: {
            ...mapGetters('orders', {
                orders: 'getOrders',
                statusColor: 'orderStatusColor',
            }),
        },
        methods: {
           ...mapActions('header', {
               changeTitle: 'setTitle'
           }),
           ...mapActions('orders', {
                loadOrders: 'loadOrderItems'
           })
        }
    }
</script>
