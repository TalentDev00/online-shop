<template>
    <section class="product-single">
        <div class="product-photo">
            <router-link  v-for="(image, index) in item.images" :key="index"
                          class="photo"
                          :to="{ name: 'gallery', params: { item_id: item.id } }"
            >
                <a href=""><img :src="'/images/' + image.large" alt=""></a>
            </router-link>
        </div>
        <div class="wrapper-16">
            <div class="product-price">
                <div class="price">
                    <p v-show="item.discount === 0" class="nodiscount">{{ item.price }} <span>руб.</span></p>
                    <p v-show="item.discount !== 0" class="oldprice">{{ item.price }}</p>
                    <p v-show="item.discount !== 0" class="newprice">{{ item.price - item.discount }} <span>руб.</span></p>
                </div>
                <div class="buttons">
                    <button class="product__actions__share"><img src="../../images/icons/share_gray.svg" alt=""></button>
                    <button v-if="isFavorite(item)"
                            class="product__actions__like"
                            @click="$auth.check() ? likeUnLike(item) : $router.push({ name: 'start2' })"
                    ><img src="../../images/icons/favorite_fill.svg" alt=""></button>
                    <button v-else
                            class="product__actions__like"
                            @click="$auth.check() ? likeUnLike(item) : $router.push({ name: 'start2' })"
                    ><img src="../../images/icons/favorite.svg" alt=""></button>
                </div>
            </div>
        </div>
        <div class="wrapper-16" v-show="item.variants && item.variants.length !== 0">
            <div class="product-conditions">
                <form action="">
                    <my-select v-for="(variant, index) in item.variants" :key="index"
                               :variant="variant"
                               :product="item"
                               :value="variant.values[0]"
                               @onchange="updateValue($event)"
                    ></my-select>
                </form>
            </div>
        </div>
        <div class="wrapper-16">
            <div class="product-info">
                <h2 class="product-name">{{ item.name }}</h2>
                <p class="product-ingredients">
                    <span v-for="(property, index) in item.properties" :key="index">{{property.value}}</span>
                </p>
                <ul class="list">
                    <li class="list__item" v-for="(ppty, index) in item.properties" :key="index">
                        <div class="list__item__name">
                            <div class="credentials">
                                <p class="credentials__field">{{ ppty.name }}</p>
                                <p class="credentials__value">{{ ppty.value }}</p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="recommendations">
            <div class="wrapper-16">
                <h2 class="head">С этим товаром покупают</h2>
                <div class="items">
                    <div v-for="(product, index) in boughtWithProducts" :key="index"
                         class="product">
                        <router-link tag="div" :to="{ name: 'product', params: { item_id: product.id } }" class="product__img">
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
        </div>
        <button v-show="!productInCart(item)"
                class="btn btn__fixed"
                @click="add(item)"
        >добавить в корзину</button>
        <my-modal v-show="showModal"
                  :product="currentProduct"
                  @close="showModal = false"
        ></my-modal>
    </section>
</template>
<script>
    import {mapGetters} from 'vuex';
    import {mapActions} from 'vuex';
    import mySelect from './helpers/select';
    import myModal from './modal';
    import {get as getData} from '../api';

    export default {
        components: {
            myModal,
            mySelect
        },
        beforeRouteEnter(to, from, next) {
            next(vm => {
                let params = {
                    item_id: to.params.item_id
                };
                let that = this;
                getData(
                    '/store/catalog/items',
                    params,
                    (data) => {
                        vm.setData(data);
                        vm.loadBoughtWithItems({ boughtWith: 2 });
                        vm.$nextTick(function() {
                            vm.changeTitle(vm.item.name);
                        }.bind(that));
                    }
                );
            });
        },
        data(){
            return {
                item: '',
                showModal: false,
                currentProduct: '',
            }
        },
        computed: {
            ...mapGetters('products', {
                product: 'getProductById',
                boughtWithProducts: 'getBoughtWithItems'
            }),
            ...mapGetters('cart', {
                productQty: 'itemQty',
                productInCart: 'inCart',
            }),
            ...mapGetters('favorites', {
                isFavorite: 'isFavoriteItem'
            }),
        },
        methods: {
            ...mapActions('header', {
                changeTitle: 'setTitle'
            }),
            ...mapActions('cart', {
                add: 'addCartItem',
                remove: 'removeCartItem',
                setProductVariantInCart: 'setProductSelectedVariantInCart',
            }),
            ...mapActions('favorites', {
                likeUnLike: 'addOrRemoveFavorite',
                loadFavorites: 'getFavoriteItems'
            }),
            ...mapActions('products', {
                setProductVariantInProducts: 'setProductSelectedVariantInProducts',
                loadBoughtWithItems: 'setProductBoughtWithItems'
            }),
            updateValue(e) {
                if (this.productInCart(this.item)) {
                    this.setProductVariantInCart({
                        product: e.product,
                        variant: e.variant,
                        value: e.value
                    })
                }
                else {
                    this.setProductVariantInProducts({
                        product: e.product,
                        variant: e.variant,
                        value: e.value
                    });
                }

                let foundVariant = this.item.variants.find(item => item.name === e.variant.name);
                if (foundVariant) {
                    if (foundVariant.selected) {
                        foundVariant.selected = e.value;
                    }
                    else {
                        this.$set(foundVariant, 'selected', e.value)
                    }
                }
            },
            setData(data) {
                this.item = data;
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
        }
    }
</script>
<style scoped lang="scss">
    p.product-ingredients {
        span {

            &:first-letter {
                text-transform: uppercase;
            }

            & + span {
                text-transform: lowercase;
                &:before {
                    content: ", ";
                }
            }
        }
    }
</style>
