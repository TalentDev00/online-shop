<template>
    <div class=popup>
        <div class=popup__content>
            <h2 class=name>{{ product.name }}</h2>
            <form action="">
                <my-select v-for="(variant, index) in product.variants " :key="variant.name + index"
                           :variant="variant"
                           :product="product"
                           :value="variant.values[0]"
                           @onchange="updateValue($event)"
                ></my-select>
                <div v-if="routeCart"
                     class="buttons">
                    <div class="product__actions__counter">
                        <button class="product__actions__counter__remove"
                                @click.prevent="removeFromCartAndClose(product)"
                        ><span>-</span></button>
                        <div class="product__actions__counter__count">{{ productQty(product) }}</div>
                        <button class="product__actions__counter__add"
                                @click.prevent="addWithoutSync(product)"
                        ><span>+</span></button>
                    </div>
                    <button class="btn"
                            @click.prevent="closeWithSync(product)"
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
                selected: []
            }
        },
        computed: {
            ...mapGetters('cart', {
                productsInCart: 'getProducts'
            }),
            routeCart() {
                return this.$route.name === 'cart';
            },
            productQty() {
                return (product) => this.productsInCart.find(item => item.item.id === product.id) ? this.productsInCart.find(item => item.item.id === product.id).qty : null;
            }
        },
        methods: {
            ...mapActions('cart', {
                add: 'addCartItem',
                remove: 'removeCartItem',
                addWithoutSync: 'addToCart',
                removeWithoutSync: 'removeFromCart',
                removeWithAllCounts: 'removeFromCartWithAllCounts',
                setProductVariantInCart: 'setProductSelectedVariantInCart',
                syncItem: 'syncCartItem'
            }),
            ...mapActions('products', {
                changeProductCondition: 'productConditionSelect',
                setProductVariantInProducts: 'setProductSelectedVariantInProducts'
            }),
            updateValue(e) {
                if (this.routeCart) {
                    this.setProductVariantInCart({
                        product: e.product,
                        variant: e.variant,
                        value: e.value
                    })
                } else {
                    this.setProductVariantInProducts({
                        product: e.product,
                        variant: e.variant,
                        value: e.value
                    })
                }
            },
            close() {
                this.$emit('close');
            },
            closeWithSync(product) {
                this.syncItem(product);
                this.$emit('close');
            },
            addToCartAndClose(product) {
                this.add(product);
                this.$emit('close');
            },
            removeFromCartAndClose(product) {
                if (this.productQty(product) > 1)
                    this.removeWithoutSync(product);
                else {
                    this.close();
                    this.remove(product);
                }
            },
        }
    }
</script>
