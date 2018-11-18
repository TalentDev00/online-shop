<template>
    <div>
        <section class="product-search">
            <div class="wrapper-16">
                <div class="search">
                    <form class="search__form search__form-static" action="catalog.html">
                        <input class="search__form__input" type="text" placeholder="поиск по каталогу"
                               :value="searchValue"
                               @input="search($event)"
                        >
                        <a v-show="searchValue !== ''" class="search__form__cancel" href=""
                           @click.prevent="searchValue = ''"
                        ><img src="../../images/icons/close.svg" alt=""></a>
                    </form>
                </div>
            </div>
            <p class="product-found" v-if="searchValue === ''">Найдено товаров: {{ sectionProducts.length }}</p>
        </section>
        <section class="found">
            <div class="wrapper-16">

                <ul v-if="searchValue !== ''" class="list">
                    <li class="list__item">
                        <p class="list__item__name list__item__name-reactive">{{ searchValue }}</p>
                    </li>
                    <router-link v-for="(item, index) in filteredList"
                                 :key="index"
                                 tag="li"
                                 :to="'/result/' + item.id"
                                 class="list__item">
                        <a class="list__item__name" href="">{{ item.name }}</a>
                    </router-link>
                </ul>

                <div v-else class="items" >
                    <div class="product"
                         v-for="(product, index) in sectionProducts"
                         :key="index"
                    >
                        <router-link tag="div" :to="'/catalog/products/' + product.id" class="product__img">
                            <a href=""><img :src="'../../images/' + product.images[0].large" :alt="product.name"></a>
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
    import myModal from './modal';
    import {mapGetters} from 'vuex';
    import {mapActions} from 'vuex';
    import axios from 'axios';

    export default {
        components: {
            myModal
        },
        created() {
            axios.get('/catalog/' + this.$route.params.catalog_id + '/' + this.$route.params.category_id)
                .then(({ data }) => {
                    this.sectionProducts = data.data;
                });
        },
        data() {
            return {
                showModal: false,
                currentProduct: '',
                searchValue: '',
                sectionProducts: []
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
            findByCategoryId() {
                let found = [];
                for (let i = 0; i < this.products.length; i++) {
                    if (this.products[i].cat_id === parseInt(this.$route.params.category_id)) {
                        found.push(this.products[i]);
                    }
                }

                return found;
            },
            filteredList() {
                return this.findByCategoryId.filter(item => {
                    return item.name.toLowerCase().includes(this.searchValue.toLowerCase())
                })
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
            }),
            popModal(product) {
                this.currentProduct = product;
                this.showModal = !this.showModal;
            },
            search(e) {
                this.searchValue = e.target.value;
            }
        }
    }
</script>
