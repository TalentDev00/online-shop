<template>
    <section class="cart-checkout">
        <div class="items">
            <div class="payment">
                <div class="wrapper-16">
                    <h2 class="options">Оплата</h2>
                    <ul class="list payment">

                        <li v-for="(item, index) in paymentMethods" :key="index"
                            class="list__item">
                            <my-radio :label="item.name"
                                      :index="index"
                                      name="payment"
                                      :value="item.name"
                                      @onchange="updatePayment($event)"
                            ></my-radio>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="delivery">
                <div class="wrapper-16">
                    <h2 class="options">Доставка</h2>
                    <ul class="list delivery">
                        <li v-for="(item, index) in deliveryMethods" :key="index"
                            class="list__item">
                            <my-radio :label="item.name"
                                      :index="index"
                                      name="delivery"
                                      :value="item.name"
                                      @onchange="updateDelivery($event)"
                            ></my-radio>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="address">
                <div class="wrapper-16">
                    <h2 class="options">Адрес доставки</h2>
                    <ul class="list address">
                        <li class="list__item">
                            <div class="inputfield">
                                <my-input style-classes="inputfield__input"
                                          type="text"
                                          name="address"
                                          placeholder="индекс, город, улица, дом, квартира"
                                          :value="address"
                                          @oninput="updateAddress($event)"
                                ></my-input>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="comment">
                <div class="wrapper-16">
                    <h2 class="options">Комментарий</h2>
                    <ul class="list comment">
                        <li class="list__item">
                            <div class="inputfield">
                                <my-input style-classes="inputfield__input"
                                          type="text"
                                          name="comment"
                                          placeholder="подъезд, номер домофона, ..."
                                          :value="comment"
                                          @oninput="updateComment($event)"
                                ></my-input>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <button class="btn btn__fixed"
                @click="checkout(productsInCart)"
        >заказать</button>
    </section>
</template>
<script>
    import {mapGetters} from 'vuex';
    import {mapActions} from 'vuex';
    import myRadio from './helpers/radio';
    import myInput from './helpers/input';

    export default {
        components: {
            myRadio,
            myInput
        },
        beforeRouteEnter(to, from, next) {
            next(vm => {
                vm.changeTitle('ОФОРМЛЕНИЕ ЗАКАЗА');
                vm.payment = vm.paymentMethod;
                vm.delivery = vm.deliveryMethod;
                vm.address = vm.deliveryAddress;
                vm.comment = vm.orderComment;
                vm.loadCart();
            });
        },
        data() {
            return {
                payment: '',
                delivery: '',
                address: '',
                comment: '',
            }
        },
        computed: {
            ...mapGetters({
                paymentMethods: 'allPaymentMethods',
                deliveryMethods: 'allDeliveryMethods'
            }),
            ...mapGetters('cart', {
                productsInCart: 'getProducts',
                paymentMethod: 'getPaymentMethod',
                deliveryMethod: 'getDeliveryMethod',
                deliveryAddress: 'getDeliveryAddress',
                orderComment: 'getComment',
            }),
        },
        methods: {
            ...mapActions('cart', {
                changePaymentMethod: 'setPaymentMethod',
                changeDeliveryMethod: 'setDeliveryMethod',
                changeDeliveryAddress: 'setDeliveryAddress',
                changeComment: 'setComment',
                placeOrderAndCheckout: 'checkout',
                loadCart: 'loadUserCart'
            }),
            ...mapActions('header', {
                changeTitle: 'setTitle'
            }),
            updatePayment(value) {
                this.payment = value;
                this.changePaymentMethod(value);
            },
            updateDelivery(value) {
                this.delivery = value;
                this.changeDeliveryMethod(value);
            },
            updateAddress(value) {
                this.address = value;
                this.changeDeliveryAddress(value);
            },
            updateComment(value) {
                this.comment = value;
                this.changeComment(value);
            },
            checkout(cartItems) {
                this.placeOrderAndCheckout(cartItems);
                this.$router.push({ name: 'catalog' });
            }
        }
    }
</script>
