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
                        <div class="product__actions__counter__count">{{ productQty(product) }}</div>
                        <button class="product__actions__counter__add"
                                @click.prevent="add(product)"
                        ><span>+</span></button>
                    </div>
                    <button class="btn"
                            @click.prevent="close(product)"
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
                add: 'addToCart',
                remove: 'removeFromCart',
                removeWithAllCounts: 'removeFromCartWithAllCounts',
                setProductVariantInCart: 'setProductSelectedVariantInCart'
            }),
            ...mapActions('products', {
                changeProductCondition: 'productConditionSelect',
                setProductVariantInProducts: 'setProductSelectedVariantInProducts'
            }),
            updateValue(e) {
                let found = this.selected.find(item => item.name === e.name);
                if (!found) {
                    this.selected.push(e);
                }

                else {
                    found.value = e.value;
                }
            },
            close(product) {
                product.variants.forEach(item => {
                    this.selected.forEach(elem => {
                        if (item.name === elem.name) {
                            this.setProductVariantInCart({
                                product: product,
                                variant: item.name,
                                value: elem.value
                            });
                        }
                    });
                });
                this.$emit('close');
            },
            addToCartAndClose(product) {
                product.variants.forEach(item => {
                    this.selected.forEach(elem => {
                        if (item.name === elem.name) {
                            this.setProductVariantInProducts({
                                product: product,
                                variant: item.name,
                                value: elem.value
                            })
                        }
                    });
                });
                this.add(product);
                this.$emit('close');
            },
            removeFromCartAndClose(product) {
                if (this.productQty(product) > 1)
                    this.remove(product);
                else {
                    this.close();
                    this.remove(product);
                }
            },
        }
    }
</script>
