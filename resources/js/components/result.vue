<template>
    <div>
        <section class="product-search">
            <div class="wrapper-16">
                <my-search :value="keywords"
                           :classList="'search__form-fixed'"
                           :input-styles="'search__form__input-greenbackground search__form__input-whitefont search__form__input-whitesearchicon search__form__input-placehodlercolorwhite'"
                           @onchange="updateInput($event)"
                           @onclear="keywords = null"
                ></my-search>
            </div>
            <p class="product-found">Найдено товаров: {{ itemsInResults.length }}</p>
        </section>
        <section class="found">
            <div class="wrapper-16">

         <!--       <ul v-if="!emptyInput" class="list">
                    <li class="list__item">
                        <p class="list__item__name list__item__name-reactive">{{ keywords }}</p>
                    </li>
                    <router-link v-for="(item, index) in results"
                                 :key="index"
                                 tag="li"
                                 :to="'/result/' + item.id"
                                 class="list__item">
                        <a  v-html="highlight(item.name)" class="list__item__name" href="">{{ item.name }}</a>
                        <img v-if="!item.cat_id"
                             class="list__item__catalog" src="../../images/icons/folder.svg" alt="">
                    </router-link>
                </ul>-->

                <div class="items">
                    <div class="product"
                         v-for="(product, index) in itemsInResults"
                         :key="index"
                    >
                        <router-link tag="div" :to="'/catalog/products/' + product.id" class="product__img">
                            <a href=""><img :src="'/images/' + product.images[0].large" :alt="product.name"></a>
                        </router-link>
                        <div class="product__prices">
                            <p v-show="product.discount === 0" class="product__prices__nodiscount">{{ product.price }} <span>руб.</span></p>
                            <p v-show="product.discount !== 0" class="product__prices__oldprice">{{ product.price }}</p>
                            <p v-show="product.discount !== 0" class="product__prices__newprice">{{ product.price - product.discount }} <span>руб.</span></p>
                        </div>
                        <p class="product__name">{{ product.name }}</p>
                        <div class="product__actions">
                            <button class="product__actions__like product__actions__like-active"
                                    @click="addOrRemoveLike(product)"
                            >
                                <img v-if="!product.favorite" src="../../images/icons/favorite.svg" alt="">
                                <img v-else src="../../images/icons/favorite_fill.svg" alt="">
                            </button>
                            <button v-if="!productsInCart.find(item => item.item.id === product.id)" class="product__actions__buy"
                                    @click="popModal(product)"
                            >купить</button>
                            <div v-else class="product__actions__counter">
                                <button class="product__actions__counter__remove"
                                        @click="remove(product)"
                                ><span>-</span></button>
                                <div class="product__actions__counter__count">{{ productsInCart.find(item => item.item.id === product.id).qty }}</div>
                                <button class="product__actions__counter__add"
                                        @click="add(product)"
                                ><span>+</span></button>
                            </div>
                        </div>
                    </div>

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
    import mySearch from './helpers/search';
    import myModal from './modal';
    import {mapGetters} from 'vuex';
    import {mapActions} from 'vuex';


    export default {
        components: {
            myModal,
            mySearch
        },
        data() {
            return {
                showModal: false,
                keywords: this.$route.params.keywords,
                currentProduct: '',
            }
        },
        computed: {
            ...mapGetters('products', {
                products: 'getItems'
            }),
            ...mapGetters('cart', {
                productsInCart: 'getProducts',
                countProductsInCart: 'getCountProducts'
            }),
            ...mapGetters('search', {
                results: 'getResults'
            }),
            itemsInResults() {
                return this.results.filter(item => {
                    return item.cat_id;
                });
            },
            emptyInput() {
                return this.keywords === null || this.keywords === '' || this.keywords === ' ';
            }

        },
        methods: {
            ...mapActions('products', {
                loadProducts: 'loadItems',
                addOrRemoveLike: 'like'
            }),
            ...mapActions('cart', {
                add: 'addToCart',
                remove: 'removeFromCart',
            }),
            popModal(product) {
                this.currentProduct = product;
                this.showModal = !this.showModal;
            },
            highlight(text) {
                return text.replace(new RegExp(this.keywords, 'gi'), '<span class="highlighted">$&</span>');
            },
            updateInput(e) {
                this.keywords = e;
            }
        }
    }
</script>
