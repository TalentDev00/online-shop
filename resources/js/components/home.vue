<template>
    <div>
        <template v-if="results.length === 0">
            <section class="banner">
                <div class="owl-carousel">
                    <router-link v-for="(action, index) in actions"
                                 :key="index"
                                 tag="div"
                                 :to="{name: 'action', params: { action_id: action.id } }"
                                 class="carousel-item"
                    >
                        <a href="">
                            <img :src="'/images/' + action.image" alt="">
                            <p class="discount">{{ action.name }}</p>
                        </a>
                    </router-link>
                </div>
            </section>
            <section class="new">
                <div class="wrapper-16">
                    <h2 class="head">Новинки</h2>
                    <div class="items">
                        <div v-for="(product, index) in freshItems"
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
                                        @click="$auth.check() ? likeUnLike(product) : $router.push({ name: 'start2' })"
                                ><img src="../../images/icons/favorite_fill.svg" alt=""></button>
                                <button v-else class="product__actions__like product__actions__like-active"
                                        @click="$auth.check() ? likeUnLike(product) : $router.push({ name: 'start2' })"
                                ><img src="../../images/icons/favorite.svg" alt=""></button>
                                <button v-if="!productInCart(product)" class="product__actions__buy"
                                        @click="popModal(product)"
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
            <section class="popular">
                <div class="wrapper-16">
                    <h2 class="head">Популярное</h2>
                    <div class="items">
                        <div v-for="(product, index) in popularItems"
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
                                        @click="$auth.check() ? likeUnLike(product) : $router.push({ name: 'start2' })"
                                ><img src="../../images/icons/favorite_fill.svg" alt=""></button>
                                <button v-else class="product__actions__like product__actions__like-active"
                                        @click="$auth.check() ? likeUnLike(product) : $router.push({ name: 'start2' })"
                                ><img src="../../images/icons/favorite.svg" alt=""></button>
                                <button v-if="!productInCart(product)" class="product__actions__buy"
                                        @click="popModal(product)"
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
        <template v-else>
            <div class="wrapper-16">
                <ul class="list result-search">
                    <router-link
                        tag="li"
                        :to="{ name: 'section', params: { keywords:  keywords ? keywords : null} }"
                        class="list__item">
                        <a class="list__item__name list__item__name-reactive" href="">{{ keywords }}</a>
                    </router-link>
                    <router-link v-for="(item, index) in results"
                                 :key="index"
                                 tag="li"
                                 :to="'/result/' + item.id"
                                 class="list__item">
                        <a  v-html="highlight(item.name)" class="list__item__name" href="">{{ item.name }}</a>
                        <img v-if="!item.cat_id"
                             class="list__item__catalog" src="../../images/icons/folder.svg" alt="">
                    </router-link>
                </ul>
            </div>
        </template>
        <my-modal v-show="showModal"
                  :product="currentProduct"
                  @close="showModal = false"
        ></my-modal>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex';
    import {mapActions} from 'vuex';
    import myModal from './modal';
    export default {
        components: {
          myModal
        },
        beforeRouteEnter(to, from, next) {
            next(vm => {
                vm.installOwlCarousel();
                vm.loadPopular( { popular: 4 } );
                vm.loadFresh( { fresh: 4 } );
            });
        },
        updated() {
            this.installOwlCarousel();
        },
        data() {
            return {
                showModal: false,
                currentProduct: ''
            }
        },
        computed: {
            ...mapGetters('promotions', {
                actions: 'getActions'
            }),
            ...mapGetters('products', {
                allProducts: 'getItems',
                popularItems: 'getPopularItems',
                freshItems: 'getFreshItems'
            }),
            ...mapGetters('search', {
                results: 'getResults',
                keywords: 'getKeywords'
            }),
            ...mapGetters('cart', {
                productQty: 'itemQty',
                productInCart: 'inCart',
            }),
            ...mapGetters('favorites', {
                favoriteItems: 'allFavoriteItems',
                isFavorite: 'isFavoriteItem'
            }),
        },
        methods: {
            ...mapActions('products', {
                loadProducts: 'loadItems',
                loadPopular: 'setProductPopularItems',
                loadFresh: 'setProductFreshItems'
            }),
            ...mapActions('cart', {
              /*  add: 'addToCart',
                remove: 'removeFromCart'*/
                add: 'addCartItem',
                remove: 'removeCartItem'
            }),
            ...mapActions('favorites', {
                likeUnLike: 'addOrRemoveFavorite',
                loadFavorites: 'getFavoriteItems',

            }),
            installOwlCarousel() {
                $('section.banner>.owl-carousel').owlCarousel({
                    loop: true,
                    items: 1,
                    center: true,
                    nav: true,
                    navText: ["<img src='../../images/icons/back_orange.svg'>", "<img src='../../images/icons/forvard_orange.svg'>"],
                    dots: true,
                    dotsEach: false,
                    rtl: false
                });
            },
            popModal(product) {
                if (product.variants && product.variants.length > 0) {
                    this.currentProduct = product;
                    this.showModal = !this.showModal;
                }
                else {
                    this.add(product);
                }
            },
            highlight(text) {
                return text.replace(new RegExp(this.keywords, 'gi'), '<span class="highlighted">$&</span>');
            },
        }
    }
</script>

