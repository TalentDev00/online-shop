<template>
    <section class="favorite">
        <p class="product-found">Найдено товаров: {{ allFavoriteItems.length }}</p>
        <div class="wrapper-16">
            <div class="items">
                <div v-for="(product, index) in allFavoriteItems"
                     :key="index"
                     v-show="product.product_favorite"
                     class="product"
                >
                    <router-link tag="div" :to="'/catalog/products/' + product.product_id" class="product__img">
                        <a href=""><img :src="'../../images/' + product.product_image" alt=""></a>
                    </router-link>
                    <div class="product__prices">
                        <p v-show="product.product_nodiscount !== ''" class="product__prices__nodiscount">{{ product.product_nodiscount }} <span>руб.</span></p>
                        <p v-show="product.product_oldprice !== ''" class="product__prices__oldprice">{{ product.product_oldprice }}</p>
                        <p v-show="product.product_newprice !== ''" class="product__prices__newprice">{{ product.product_newprice }} <span>руб.</span></p>
                    </div>
                    <p class="product__name">{{ product.product_name }}</p>
                    <div class="product__actions">
                        <button v-if="product.product_favorite" class="product__actions__like product__actions__like-active"
                                @click="changeLikeStatus(product)"
                        ><img src="../../images/icons/favorite_fill.svg" alt=""></button>
                        <button v-else class="product__actions__like product__actions__like-active"
                                @click="changeLikeStatus(product)"
                        ><img src="../../images/icons/favorite.svg" alt=""></button>
                        <button v-if="!productsInCart.find(item => item.product_id === product.product_id)"
                                class="product__actions__buy"
                                @click="add(product)"
                        >купить</button>
                        <div v-else class="product__actions__counter">
                            <button class="product__actions__counter__remove"
                                    @click="remove(product)"
                            ><span>-</span></button>
                            <div class="product__actions__counter__count">{{ product.product_quantity }}</div>
                            <button class="product__actions__counter__add"
                                    @click="add(product)"
                            ><span>+</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
    import {mapGetters} from 'vuex';
    import {mapActions} from 'vuex';

    export default {
        computed: {
            ...mapGetters('products', {
                allProducts: 'getItems'
            }),
            ...mapGetters('cart', {
                productsInCart: 'getProducts'
            }),
            allFavoriteItems() {
                let found = [];
                for (let i = 0; i < this.allProducts.length; i++) {
                    if (this.allProducts[i].product_favorite === true) {
                        found.push(this.allProducts[i]);
                    }
                }
                return found;
            }
        },
        methods: {
            ...mapActions('products', {
                changeLikeStatus: 'like'
            }),
            ...mapActions('cart', {
                add: 'addToCart',
                remove: 'removeFromCart'
            })
        }
    }
</script>