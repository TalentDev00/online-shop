<template>
    <div>
        <section class="product-search">
            <div class="wrapper-16">
                <my-search :value="keywords"
                           :formClass="'search__form-static'"
                           @onchange="updateInput($event)"
                           @onclear="resetSearch"
                ></my-search>
            </div>
            <p class="product-found" v-if="emptyInput || routeHasKeywords && keywords === $route.params.keywords">Найдено товаров: {{ routeHasKeywords && emptyInput ? results.length : products.length }}</p>
        </section>
        <section class="found">
            <div class="wrapper-16">

                <ul v-if="!emptyInput && !routeHasKeywords" class="list">
                    <router-link
                                 tag="li"
                                 :to="{ name: 'section', params: { keywords:  keywords ? keywords : null} }"
                                 class="list__item">
                        <a class="list__item__name list__item__name-reactive" href="">{{ keywords }}</a>
                    </router-link>
                    <router-link v-for="(item, index) in results"
                                 :key="index"
                                 tag="li"
                                 :to="routeTo(item)"
                                 class="list__item">
                        <a  v-html="highlight(item.name)" class="list__item__name" href="">{{ item.name }}</a>
                        <img v-if="!item.cat_id"
                             class="list__item__catalog" src="../../images/icons/folder.svg" alt="">
                    </router-link>
                </ul>

                <ul v-else-if="$route.params.keywords && $route.params.keywords !== keywords" class="list">
                    <router-link
                                 tag="li"
                                 :to="{ name: 'section', params: { keywords:  keywords ? keywords : null} }"
                                 class="list__item">
                        <a class="list__item__name list__item__name-reactive" href="">{{ keywords }}</a>
                    </router-link>
                    <router-link v-for="(item, index) in results"
                                 :key="index"
                                 tag="li"
                                 :to="routeTo(item)"
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
                        <router-link tag="div" :to="{ name: 'product', params: { item_id: product.id } }" class="product__img">
                            <a href=""><img :src="'/images/' + product.images[0].large" :alt="product.name"></a>
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
        beforeRouteEnter(to, from, next) {
            next(vm => {
                let obj;
                if (to.params.cat_id) {
                    obj = { cat_id: to.params.cat_id };
                }
                else {
                    obj = { keywords: to.params.keywords };
                    vm.keywords = obj.keywords;
                }

                vm.getSectionProducts(obj);

                let found = vm.catalogItems.find(item => item.id === parseInt(to.params.cat_id));
                found ? vm.changeTitle(found.name) : vm.changeTitle('ПОИСК');
            });
        },
        beforeRouteUpdate(to, from, next) {
            let obj;
            if (to.params.cat_id) {
                obj = {
                    cat_id: to.params.cat_id
                };
            }
            else {
                obj = {
                    keywords: to.params.keywords
                };
                this.changeTitle('ПОИСК');
                this.keywords = obj.keywords;
            }
            this.clearProducts();
            this.getSectionProducts(obj);

            let found = this.catalogItems.find(item => item.id === parseInt(to.params.cat_id));
            found ? this.changeTitle(found.name) : this.changeTitle('ПОИСК');
            next();
        },
        data() {
            return {
                showModal: false,
                keywords: this.$route.params.keywords ? this.$route.params.keywords : null,
                currentProduct: '',
            }
        },
        computed: {
            ...mapGetters('catalog', {
                catalogItems: 'getCatalogItems',
            }),
            ...mapGetters('products', {
                products: 'getItems',
            }),
            ...mapGetters('cart', {
                productQty: 'itemQty',
                productInCart: 'inCart',
            }),
            ...mapGetters('search', {
                results: 'getResults'
            }),
            ...mapGetters('favorites', {
                isFavorite: 'isFavoriteItem'
            }),
            emptyInput() {
                return this.keywords === null || this.keywords === '' || this.keywords === ' ';
            },
            routeHasKeywords() {
                return this.$route.params.keywords;
            },
            routeTo() {
                return (item) => !item.cat_id ? { name: 'subcatalog', params: { cat_id: item.id } } : { name: 'product', params: { item_id: item.id } };
            }
        },
        methods: {
            ...mapActions('products', {
                clearProducts: 'clearItems',
                getSectionProducts: 'setProductItems'
            }),
            ...mapActions('cart', {
                add: 'addCartItem',
                remove: 'removeCartItem'
            }),
            ...mapActions('header', {
                changeTitle: 'setTitle'
            }),
            ...mapActions('favorites', {
                likeUnLike: 'addOrRemoveFavorite',
                loadFavorites: 'getFavoriteItems'
            }),
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
            updateInput(e) {
                this.keywords = e;
            },
            resetSearch() {
                if (this.routeHasKeywords) {
                    this.$router.push({ name: 'catalog' });
                }
                else {
                    this.keywords = null;
                }
            },
        }
    }
</script>
