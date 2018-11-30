<template>
    <section class="start1" >
        <div class="wrapper">
            <div class="items">
                <div class="img">
                    <img src="../../images/logo.svg" class="logo" alt="">
                </div>
                <p class="greetings">
                    Приветствуем вас в&nbsp;нашем мобильном магазине! Здесь&nbsp;вы всегда сможете получать актуальную информацию о&nbsp;статусах заказов
                    и&nbsp;скидках, а&nbsp;также получать эксклюзивные предложения, поэтому не&nbsp;забудьте разрешить уведомления!
                </p>
            </div>
        </div>
    </section>
</template>

<script>
    import axios from 'axios';
    import {mapGetters} from 'vuex';
    import {mapActions} from 'vuex';

    const getCatalog = (callback) => {
        axios
            .get('/info')
            .then(response => {
                callback(response.data);
            }).catch(error => {
            callback(error.response.data);
        });
    };

    export default {
        beforeRouteEnter (to, from, next) {
            getCatalog(data => {
                next(vm => {
                    vm.loadItems(data.categories);
                    vm.payments(data.payment_methods);
                    vm.delivery(data.delivery_methods);
                    vm.name(data.name);
                    vm.logo(data.logo);
                    vm.description(data.description);
                    vm.loadPromotions(data.vouchers);
                });
            });
        },
        methods: {
            ...mapActions('catalog', {
                loadItems: 'loadNewItems'
            }),
            ...mapActions({
                payments: 'loadPaymentMethods',
                delivery: 'loadDeliveryMethods',
                name: 'loadShopName',
                logo: 'loadShopLogo',
                description: 'loadShopDescription'
            }),
            ...mapActions('promotions', {
                loadPromotions: 'setPromotions'
            })
        },

    }
</script>
