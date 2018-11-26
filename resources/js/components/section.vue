<template>
    <div>
        <section class="product-search">
            <div class="wrapper-16">
                <my-search :value="keywords"
                           :formClass="'search__form-static'"
                           @onchange="updateInput($event)"
                           @onclear="keywords = null"
                ></my-search>
            </div>
            <p class="product-found" v-if="emptyInput">Найдено товаров: {{ products.length }}</p>
        </section>
        <section class="found">
            <div class="wrapper-16">

                <ul v-if="!emptyInput" class="list">
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
                </ul>

                <div v-else class="items" >
                    <div
                         class="product"
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
    import mySearch from './helpers/search';
    import storeProductsModule from '../store/modules/products.js';
    import axios from 'axios';
    import myModal from './modal';
    import {mapGetters} from 'vuex';
    import {mapActions} from 'vuex';

    const getProducts = (cat_id, sort, min, max, filters, callback) => {
        let params = { cat_id, sort, min, max, filters };
        axios.get('/store/catalog', { params })
            .then(response => {
                callback(response.data);
            }).catch(error => {
            callback(error.response.data);
        });
    };

    const getResults = (keywords, sort, min, max, filters, callback) => {
        let params = { keywords, sort, min, max, filters };
        axios.get('/store/catalog', { params })
            .then(response => {
                callback(response.data);
            }).catch(error => {
            callback(error.response.data);
        });
    };

    export default {
        components: {
            myModal,
            mySearch
        },
        beforeRouteEnter(to, from, next) {
            let filters = storeProductsModule.state.checked;
            let newFilters = [];
            filters.forEach(item => {
                item.values.forEach(elem => {
                    newFilters.push({
                        name: item.filter,
                        value: elem
                    });
                })
            });

            let params = {
                cat_id: to.params.cat_id,
                sort: storeProductsModule.state.sort,
                min : storeProductsModule.state.minRange,
                max: storeProductsModule.state.maxRange,
                filters: newFilters.length > 0 ? JSON.stringify(newFilters) : newFilters
            };
            if (params.cat_id) {
                getProducts(params.cat_id, params.sort, params.min, params.max, params.filters, (data) => {
                    next(vm => {
                        vm.loadProducts(data);

                        let found = vm.catalogItems.find(item => item.id === parseInt(to.params.cat_id));
                        if (found) {
                            vm.changeTitle(found.name);
                        }
                    });
                });
            }
            else {
                let params = {
                    keywords: to.params.keywords,
                    sort: storeProductsModule.state.sort,
                    min : storeProductsModule.state.minRange,
                    max: storeProductsModule.state.maxRange,
                    filters: newFilters.length > 0 ? JSON.stringify(newFilters) : newFilters
                };
                getResults(params.keywords, params.sort, params.min, params.max, params.filters, (data) => {
                    next(vm => {
                        vm.loadProducts(data);
                        vm.changeTitle(params.keywords.toUpperCase());
                    });
                });
            }

        },
/*        beforeRouteUpdate(to, from, next) {
            this.clearProducts();
            axios.get(`/store/catalog?cat_id=${to.params.cat_id}?sort=${this.sort}`)
                .then(data => {
                    this.loadProducts(data.data);
                }).catch(error => {
                console.log(error);
            });

            let found = this.catalogItems.find(item => item.id === parseInt(to.params.cat_id));
            if (found) {
                this.changeTitle(found.name);
            }
            next();
        },*/
        data() {
            return {
                showModal: false,
                keywords: null,
                currentProduct: '',
            }
        },
        computed: {
            ...mapGetters('catalog', {
                catalogItems: 'getCatalogItems',

            }),
            ...mapGetters('products', {
                products: 'getItems',
                sort:'getSort'
            }),
            ...mapGetters('cart', {
                productsInCart: 'getProducts',
                countProductsInCart: 'getCountProducts'
            }),
            ...mapGetters('search', {
                results: 'getResults'
            }),
            emptyInput() {
                return this.keywords === null || this.keywords === '' || this.keywords === ' ';
            }
        },
        methods: {
            ...mapActions('products', {
                loadProducts: 'loadItems',
                addOrRemoveLike: 'like',
                clearProducts: 'clearItems'
            }),
            ...mapActions('cart', {
                add: 'addToCart',
                remove: 'removeFromCart',
            }),
            ...mapActions('header', {
                changeTitle: 'setTitle'
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
