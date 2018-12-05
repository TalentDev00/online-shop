<template>
    <section class="menu">
        <div class="wrapper-16">
            <div class="items">

                <ul class="list">
                    <li v-if="$auth.check()" class="list__item">
                        <h2 class="username">{{ $auth.user().email }}</h2>
                    </li>
                    <router-link v-if="$auth.check() && ordersCount > 0" tag="li" class="list__item" :to="{name: 'orders'}">
                        <a href="" class="list__item__name list__item__name-bold">Мои Заказы</a>
                    </router-link>
                    <router-link v-if="$auth.check()" tag="li" class="list__item" :to="{name: 'settings'}">
                        <a href="" class="list__item__name list__item__name-bold">Настройки</a>
                    </router-link>
                    <router-link tag="li" :to="{name: 'about'}" class="list__item">
                        <a href="" class="list__item__name">О компании</a>
                    </router-link>
                    <router-link tag="li" :to="{name: 'delivery'}" class="list__item">
                        <a href="" class="list__item__name">Доставка и оплата</a>
                    </router-link>
                    <router-link tag="li" :to="{name: 'contacts'}" class="list__item">
                        <a href="" class="list__item__name">Контакты</a>
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
                vm.changeTitle('ЛИЧНЫЙ КАБИНЕТ');
                vm.loadOrders();
            });
        },
        computed: {
            ...mapGetters('orders', {
                ordersCount: 'orderNumber'
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
