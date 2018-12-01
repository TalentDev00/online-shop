<template>
    <section class="favorite">
        <p class="product-found">Найдено товаров: {{ favoriteCount }}</p>
        <div class="wrapper-16">
            <div class="items">
                <div v-for="(product, index) in favoriteItems"
                     :key="index"
                     class="product"
                >
                    <router-link tag="div" :to="'/catalog/products/' + product.id" class="product__img">
                        <a href=""><img :src="'/images/' + product.images[0].large" alt=""></a>
                    </router-link>
                    <div class="product__prices">
                        <p v-show="product.discount === 0" class="product__prices__nodiscount">{{ product.price }} <span>руб.</span></p>
                        <p v-show="product.discount !== 0" class="product__prices__oldprice">{{ product.price }}</p>
                        <p v-show="product.discount !== 0" class="product__prices__newprice">{{ product.price - product.discount }} <span>руб.</span></p>
                    </div>
                    <p class="product__name">{{ product.name }}</p>
                    <div class="product__actions">
                        <button v-if="isFavorite(product)" class="product__actions__like product__actions__like-active"
                                @click="likeUnLike(product)"
                        ><img src="../../images/icons/favorite_fill.svg" alt=""></button>
                        <button v-else class="product__actions__like product__actions__like-active"
                                @click="likeUnLike(product)"
                        ><img src="../../images/icons/favorite.svg" alt=""></button>
                        <button v-if="!productInCart(product)"
                                class="product__actions__buy"
                                @click="add(product)"
                        >купить</button>
                        <div v-else class="product__actions__counter">
                            <button class="product__actions__counter__remove"
                                    @click="remove(product)"
                            ><span>-</span></button>
                            <div class="product__actions__counter__count">{{ productQty(product) }}</div>
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
        beforeRouteEnter(to, from, next) {
            next(vm => {
                if (vm.$auth.check()) {

                    vm.loadFavorites();
                }

                vm.changeTitle('ИЗБРАННОЕ');
            });
        },
        computed: {
            ...mapGetters('favorites', {
                favoriteItems: 'allFavoriteItems',
                favoriteCount: 'countFavorites',
                isFavorite: 'isFavoriteItem'
            }),
            ...mapGetters('cart', {
                productsInCart: 'getProducts',
                productQty: 'itemQty',
                productInCart: 'inCart',
            }),
        },
        methods: {
            ...mapActions('favorites', {
                syncFavoriteItems: 'syncFavorite',
                likeUnLike: 'addOrRemoveFavorite',
                loadFavorites: 'getFavoriteItems',
            }),
            ...mapActions('cart', {
                add: 'addToCart',
                remove: 'removeFromCart'
            }),
            ...mapActions('header', {
                changeTitle: 'setTitle'
            }),
        },
    }
</script>
