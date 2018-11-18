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
            <p class="product-found" v-if="searchValue === ''">Найдено товаров: {{ findByCategoryId.length }}</p>
        </section>
        <section class="found">
            <div class="wrapper-16">
                <div class="items">
                    <div class="product"
                         v-for="(product, index) in findByCategoryId"
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
    </div>
</template>
<script>
    import myModal from './modal';
    import {mapGetters} from 'vuex';
    import {mapActions} from 'vuex';


    export default {
        components: {
            myModal
        },
        created() {
            //this.$store.dispatch('products/loadItems')
        },
        data() {
            return {
                showModal: false,
                currentProduct: '',
                searchValue: ''
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
                    if (this.products[i].id === parseInt(this.$route.params.id)) {
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