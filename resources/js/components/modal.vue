<template>
    <div class=popup>
        <div class=popup__content>
            <h2 class=name>{{ product.name }}</h2>
            <form action="">
                <my-select v-for="(variant, index) in product.variants " :key="index"
                           :variant="variant"
                           :product="product"
                           :value="variant.name"
                           @onchange="updateValue($event)"
                ></my-select>
                <div v-if="routeCart"
                     class="buttons">
                    <div class="product__actions__counter">
                        <button class="product__actions__counter__remove"
                                @click.prevent="removeFromCartAndClose(product)"
                        ><span>-</span></button>
                        <div class="product__actions__counter__count">{{ product.product_quantity }}</div>
                        <button class="product__actions__counter__add"
                                @click.prevent="add(product)"
                        ><span>+</span></button>
                    </div>
                    <button class="btn"
                            @click.prevent="close"
                    >сохранить</button>
                </div>
                <button v-else
                        class="btn"
                        @click.prevent="addToCartAndClose(product)"
                >добавить в корзину</button>
            </form>
        </div>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex';
    import {mapActions} from 'vuex';
    import mySelect from './helpers/select';
    export default {
        components: {
            mySelect
        },
        props: ['product'],
        data() {
            return {

            }
        },
        computed: {
            ...mapGetters('cart', {
                productsInCart: 'getProducts'
            }),
            routeCart() {
                return this.$route.name === 'cart';
            }
        },
        methods: {
            ...mapActions('cart', {
                add: 'addToCart',
                remove: 'removeFromCart',
                removeWithAllCounts: 'removeFromCartWithAllCounts',
                changeCondition: 'productConditionSelect'
            }),
            ...mapActions('products', {
                changeProductCondition: 'productConditionSelect'
            }),
            updateValue(e) {
                if (this.routeCart) {
                    this.changeCondition(e);
                }
                else {
                    this.changeProductCondition(e);
                }
            },
            close() {
                this.$emit('close');
            },
            addToCartAndClose(product) {
                this.add(product);
                this.$emit('close');
            },
            removeFromCartAndClose(product) {
                if (product.product_quantity > 1)
                    this.remove(product);
                else {
                    this.close();
                    this.remove(product);
                }
            },
        }
    }
</script>
