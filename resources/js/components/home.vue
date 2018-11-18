<template>
    <div>
        <section class="banner">
            <div class="owl-carousel">
                <router-link v-for="(action, index) in actions"
                             :key="index"
                             tag="div"
                             :to="{name: 'action'}"
                             class="carousel-item"
                >
                    <a href="">
                        <img :src="'../../images/' + action.image" alt="">
                        <p class="discount">Акция {{ action.discount }}</p>
                    </a>
                </router-link>
            </div>
        </section>
        <section class="new">
            <div class="wrapper-16">
                <h2 class="head">Новинки</h2>
                <div class="items">
                    <div v-for="(product, index) in allFreshItems"
                         :key="index"
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
                            <button v-if="product.product_favorite" class="product__actions__like"
                                    @click="changeLikeStatus(product)"
                            ><img src="../../images/icons/favorite_fill.svg" alt=""></button>
                            <button v-else class="product__actions__like  "
                                    @click="changeLikeStatus(product)"
                            ><img src="../../images/icons/favorite.svg" alt=""></button>
                            <button v-if="!productsInCart.find(item => item.product_id === product.product_id)"
                                    class="product__actions__buy"
                                    @click="popModal(product)"
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
        <section class="popular">
            <div class="wrapper-16">
                <h2 class="head">Популярное</h2>
                <div class="items">
                    <div v-for="(product, index) in allPopularItems"
                         :key="index"
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
                        <p class="product__name">Вафли с черникой на завтрак</p>
                        <div class="product__actions">
                            <button v-if="product.product_favorite" class="product__actions__like  "
                                    @click="changeLikeStatus(product)"
                            ><img src="../../images/icons/favorite_fill.svg" alt=""></button>
                            <button v-else class="product__actions__like  "
                                    @click="changeLikeStatus(product)"
                            ><img src="../../images/icons/favorite.svg" alt=""></button>
                            <button v-if="!productsInCart.find(item => item.product_id === product.product_id)"
                                    class="product__actions__buy"
                                    @click.prevent="popModal(product)"
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
        <my-modal v-show="showModal"
                  :product="currentProduct"
                  @close="showModal = false"
        ></my-modal>
    </div>
</template>
<script>
    import Vue from 'vue';
    import axios from 'axios';
    import {mapGetters} from 'vuex';
    import {mapActions} from 'vuex';
    import myModal from './modal';
    export default {
        components: {
          myModal
        },
        created(){
            if (this.actions.length === 0) {
                /*this.$http.get('anystore_actions.php')
                    .then(response => response.json())
                    .then(data => {
                        this.actions = data;
                        Vue.nextTick(function(){
                            this.installOwlCarousel();
                        }.bind(this))
                    })*/
                axios.get('http://localhost/api/anystore_actions.php')
                    .then(({ data }) => {
                        this.actions = data;
                        Vue.nextTick(function(){
                            this.installOwlCarousel();
                        }.bind(this))
                    }).catch(errors => {
                        console.log(errors)
                    });
            }

            if (this.allProducts.length === 0) {
                this.loadProducts();
            }
        },
        data() {
            return {
                actions: [],
                showModal: false,
                currentProduct: ''
            }
        },
        computed: {
            ...mapGetters('products', {
                allProducts: 'getItems',

            }),
            ...mapGetters('cart', {
                productsInCart: 'getProducts'
            }),
            allFreshItems() {
                let found = [];
                for (let i = 0; i < this.allProducts.length; i++) {
                   if (this.allProducts[i].product_new) {
                       found.push(this.allProducts[i]);
                   }
                }
                return found;
            },
            allPopularItems() {
                let found = [];
                for (let i = 0; i < this.allProducts.length; i++) {
                    if (this.allProducts[i].product_popular) {
                        found.push(this.allProducts[i]);
                    }
                }
                return found;
            }
        },
        methods: {
            ...mapActions('products', {
                loadProducts: 'loadItems',
                changeLikeStatus: 'like'
            }),
            ...mapActions('cart', {
                add: 'addToCart',
                remove: 'removeFromCart'
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
                this.currentProduct = product;
                this.showModal = !this.showModal;
            }
        }
    }
</script>
