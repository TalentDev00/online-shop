<template>
    <div>
        <section class="cart" v-if="countProductsInCart !== 0">
            <div class="items">
                <div class="incart">
                    <div class="cart-item"
                         v-for="(cartItem, index) in productsInCart"
                         :key="index"
                    >
                        <div class="cart-item__body swipable">
                            <div class="cart-item__body__product">
                                <router-link tag="div" :to="'/catalog/products/' + cartItem.item.id" class="cart-item__body__product__img">
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
                                    <button class="cart-item__body__product__actions__menu"
                                            @click="popModal(cartItem.item)"
                                    ><img src="../../images/icons/product_menu.svg" alt=""></button>
                                    <button v-show="cartItem.item.product_favorite" class="cart-item__body__product__actions__like"><img src="../../images/icons/favorite_fill.svg" alt=""></button>
                                </div>
                            </div>
                            <ul class="cart-item__body__conditions">
                                <li class="cart-item__body__conditions__item"
                                    v-for="(variant, index) in cartItem.item.variants"
                                >{{ variant.name }}: <span> {{ variant.selected }}</span></li>
                            </ul>
                        </div>
                        <div class="cart-item__buttons">
                            <button v-if="cartItem.item.product_favorite"
                                    class="cart-item__buttons__like"
                                    @click="addOrRemoveLike(cartItem.item)"
                            ><img src="../../images/icons/favorite_snow_fill.svg" alt=""></button>
                            <button v-else
                                    class="cart-item__buttons__like"
                                    @click="addOrRemoveLike(cartItem.item)"
                            ><img src="../../images/icons/favorite_snow.svg" alt=""></button>
                            <button class="cart-item__buttons__close"
                                    @click="removeWithAllCounts(cartItem.item)"
                            ><img src="../../images/icons/close_snow.svg" alt=""></button>
                        </div>
                    </div>
                </div>
                <div class="promocode-wrapper" v-show="!promoApplyStatus">
                    <div class="wrapper-16">
                        <div class="promocode" >
                            <my-input type="text"
                                      name="promocode"
                                      placeholder="промокод"
                                      :value="promoCode"
                                      @changeValue="updateValue($event)"
                            ></my-input>
                            <button class="promocode__item promocode__apply"
                                    @click="checkPromoCode"
                            >применить</button>
                        </div>

                    </div>
                </div>
                <div class="cartsum-wrapper">
                    <div class="wrapper-16">
                        <div class="cartsum">
                            <p class="cartsum__products"><span class="cartsum__products__count">{{  }}</span> {{ wordEndings }} на сумму <span class="cartsum__products__price">{{  }} руб.</span></p>
                            <p class="cartsum__discount">Скидка: <span class="cartsum__discount__amount">{{}} руб.</span></p>
                            <p class="cartsum__final">Итого: <span class="cartsum__final__num">{{  }} руб.</span></p>
                        </div>
                    </div>
                </div>
                <button class="btn btn__fixed"
                        @click="toCheckout"

                >оформить заказ</button>
            </div>
        </section>
        <section class="cart-empty" v-else>
            <div class="items">
                <h2 class="done">Пусто :-(</h2>
                <div class="img">
                    <img src="../../images/like_box_empty.svg" alt="">
                </div>
                <div class="buttons">
                    <button class="btn btn-stock"
                            @click="toDiscounts"
                    >акции и скидки</button>
                    <button class="btn btn-catalog"
                            @click="toCatalog"
                    >каталог</button>
                </div>
            </div>
        </section>
        <my-modal v-show="showModal"
                  :product="currentProduct"
                  @close="showModal = false"
        ></my-modal>
    </div>
</template>
<script>

    function wordEnds(number, variant1, variant2, variant3){

        let h1 = number % 10;
        let h2 = number % 100;
        let result;

        if (h2 >= 5 && h2 <= 20) {
            result = variant1;
        }

        else if (h1 === 1) {
            result = variant2;
        }

        else if (h1 >= 2 && h1 <= 4) {
            result = variant3;
        }

        else {
                result = variant1;
        }

        return result;
    }
    import Vue from 'vue';
    import {mapGetters} from 'vuex';
    import {mapActions} from 'vuex';
    import myInput from './helpers/input';
    import myModal from '../components/modal';

    export default {
        components: {
            myInput,
            myModal
        },
        created() {
            this.loadPromocodes();
            Vue.nextTick(function() {
                this.installSwipers();
            }.bind(this));
        },
        data() {
          return {
              promoCode: '',
              showModal: false,
              items: [],
              currentProduct: ''
          }
        },
        computed: {
            ...mapGetters('products', {
                products: 'getItems'
            }),
            ...mapGetters('cart', {
                productsInCart: 'getProducts',
                countProductsInCart: 'getCountProducts',
                promoApplyStatus: 'getPromoCodeAppliedStatus',
                promoCodeDiscount: 'getPromoCodeAmount'
            }),
            ...mapGetters('promotions', {
                promotions: 'getPromotions'
            }),
/*            withoutDiscountPrice() {
                let total = 0;

                for (let item of this.productsInCart) {
                    total += item.product_totalPrice;
                }

                return total;
            },
            discount() {
                let discount = 0;
                let discount1 = 0;
                let discount2 = 0;



                if (this.promoCodeDiscount !== '' || this.promoCodeDiscount !== null) {

                    if (typeof this.promoCodeDiscount === 'string' || this.promoCodeDiscount instanceof  String){
                        let promo = this.promoCodeDiscount;
                        if (promo.split('%').length > 1) {
                            promo = parseInt(promo.replace("%", ""));

                            discount1 = this.withoutDiscountPrice * promo / 100;

                            for (let item of this.productsInCart) {
                                discount2 += (item.product_oldprice * item.product_quantity - item.product_newprice * item.product_quantity);
                            }

                            discount = discount1 + discount2;

                        } else {


                            discount1 = this.promoCodeDiscount;

                            for (let item of this.productsInCart) {
                                discount2 += (item.product_oldprice * item.product_quantity - item.product_newprice * item.product_quantity);
                            }

                            discount = discount1 + discount2;
                        }

                    } else {

                        discount1 = this.promoCodeDiscount;

                        for (let item of this.productsInCart) {
                            discount2 += (item.product_oldprice * item.product_quantity - item.product_newprice * item.product_quantity);
                        }

                        discount = discount1 + discount2;
                    }

                } else {
                    for (let item of this.productsInCart) {
                        discount += (item.product_oldprice * item.product_quantity - item.product_newprice * item.product_quantity);
                    }
                }

                return discount;
            },
            totalPrice() {
                return this.withoutDiscountPrice - this.discount;

            },*/
            wordEndings() {
                return wordEnds(this.countProductsInCart, 'товаров', 'товар', 'товара');
            },
        },
        methods: {
            ...mapActions('products', {
                loadProducts: 'loadItems',
                addOrRemoveLike: 'like'
            }),
            ...mapActions('cart', {
                add: 'addToCart',
                remove: 'removeFromCart',
                removeWithAllCounts: 'removeFromCartWithAllCounts',
                promoChangeStatus: 'promocodeApply',
                promoAddToCart: 'promocodeAdd'
            }),
            ...mapActions('promotions', {
                loadPromocodes: 'loadPromotions',
                promoCodeUsed: 'promotionUsed'
            }),
            checkPromoCode() {
                for (let i = 0; i < this.promotions.length; i++) {
                    if (this.promoCode === this.promotions[i].code && this.promotions[i].used !== true && this.promoApplyStatus === false) {
                        this.promoAddToCart(this.promotions[i].discount);
                        this.promoCodeUsed(i);
                        this.promoChangeStatus();
                        return;
                    }
                }

                alert('This promo code already used!');
            },

            updateValue(value) {
                this.promoCode = value;
            },
            toDiscounts(){
                this.$router.push({name: 'action'});
            },
            toCatalog(){
                this.$router.push({name: 'catalog'});
            },
            toCheckout() {
                this.$router.push({name: 'checkout'});
            },
            installSwipers() {
                let products = document.querySelectorAll('.swipable');
                if (products !== null) {
                    for (let i = 0; i < products.length; i++) {
                        let snapper = new Snap({
                            element: products[i],
                            maxPosition: 56,
                            minPosition: -56,
                            hyperextensible: true,
                            minDragDistance: 25,
                            flickThreshold: 200,
                        });
                    }
                }
            },
            popModal(product) {
                this.currentProduct = product;
                this.showModal = !this.showModal;
            }
        }
    }
</script>
<style scoped>

</style>
