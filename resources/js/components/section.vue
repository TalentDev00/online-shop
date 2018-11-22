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
            <p class="product-found" v-if="searchValue === ''">Найдено товаров: {{ products.length }}</p>
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
                         v-for="(product, index) in products"
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
    import storeCatalogModule from '../store/modules/catalog.js';
    import axios from 'axios';
    import myModal from './modal';
    import {mapGetters} from 'vuex';
    import {mapActions} from 'vuex';

    const getProducts = (cat_id, sort, callback) => {
        const params = { cat_id, sort };

        axios
            .get('/store/catalog', { params })
            .then(response => {
                callback(response.data);
            }).catch(error => {
            callback(error.response.data);
        });
    };

    export default {
        components: {
            myModal
        },
        beforeRouteEnter(to, from, next) {
            let sort = storeCatalogModule.state.sort;
            getProducts(to.params.cat_id, sort, (data) => {
                next(vm => {
                    vm.loadProducts(data);
                });
            });
        },
        beforeRouteUpdate(to, from, next) {
            this.clearProducts();
            axios.get(`/store/catalog?cat_id=${to.params.cat_id}?sort=${this.sort}`)
                .then(data => {
                    this.loadProducts(data.data);
                }).catch(error => {
                console.log(error);
            });
            next();
        },
        data() {
            return {
                showModal: false,
                currentProduct: '',
                searchValue: '',
            }
        },
        computed: {
            ...mapGetters('catalog', {
                catalogItems: 'getCatalogItems',
                sort:'getSort'
            }),
            ...mapGetters('products', {
                products: 'getItems'
            }),
            ...mapGetters('cart', {
                productsInCart: 'getProducts',
                countProductsInCart: 'getCountProducts'
            }),
            filteredList() {
                return this.products.filter(item => {
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
