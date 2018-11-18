<template>
    <section class="product-single">
        <div class="product-photo">
            <router-link  class="photo"
                          :to="'/catalog/products/' + productById.product_id + '/gallery'"
                          v-for="(name, value) in productById.product_photos"
                          :key="value"
            >
                <a href=""><img :src="'../../images/' + name" alt=""></a>
            </router-link>
        </div>
        <div class="wrapper-16">
            <div class="product-price">
                <div class="price">
                    <p v-show="productById.product_oldprice !== ''" class="oldprice">{{ productById.product_oldprice }}</p>
                    <p v-show="productById.product_newprice !== ''" class="newprice">{{ productById.product_newprice }} <span>руб.</span></p>
                    <p v-show="productById.product_nodiscount !== ''" class="nodiscount">{{ productById.product_nodiscount }}<span>руб.</span></p>
                </div>
                <div class="buttons">
                    <button class="product__actions__share"><img src="../../images/icons/share_gray.svg" alt=""></button>
                    <button v-if="productById.product_favorite"
                            class="product__actions__like"
                            @click="favoriteStatusChange(productById)"
                    ><img src="../../images/icons/favorite_fill.svg" alt=""></button>
                    <button v-else
                            class="product__actions__like"
                            @click="favoriteStatusChange(productById)"
                    ><img src="../../images/icons/favorite.svg" alt=""></button>
                </div>
            </div>
        </div>
        <div class="wrapper-16" v-show="productById.product_conditions.length !== 0">
            <div class="product-conditions">
                <form action="product.html">
                    <label for="sauce">Соус</label>
                    <div class="select">
                        <select class="select__slct" name="slct" id="sauce">
                            <option class="select__slct__opt" value="1">острый</option>
                            <option class="select__slct__opt" value="2">сырный</option>
                            <option class="select__slct__opt" value="3">кисло-сладкий</option>
                        </select>
                    </div>
                    <label for="roast">Степень прожарки бекона</label>
                    <div class="select">
                        <select class="select__slct" name="slct" id="roast">
                            <option class="select__slct__opt" value="1">средняя</option>
                            <option class="select__slct__opt" value="2">полная</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
        <div class="wrapper-16">
            <div class="product-info">
                <h2 class="product-name">{{ productById.product_name }}</h2>
                <p class="product-ingredients">
                    <span v-for="(element, index) in productById.product_ingredients" :key="index">{{element}}</span>
                </p>
                <ul class="list">
                    <li class="list__item" v-for="(value, name) in productById.product_qualities" :key="name">
                        <div class="list__item__name">
                            <div class="credentials">
                                <p class="credentials__field">{{ name }}</p>
                                <p class="credentials__value">{{ value }}</p>
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
                    <div class="product">
                        <div class="product__img">
                            <a href=""><img src="../../images/pie@3x.jpg" alt=""></a>
                        </div>
                        <div class="product__prices">
                            <p class="product__prices__odlprice">450</p>
                            <p class="product__prices__newprice">400 руб.</p>
                        </div>
                        <p class="product__name">Вафли с черникой на завтрак</p>
                        <div class="product__actions">
                            <button class="product__actions__like product__actions__like-active"><img src="../../images/icons/favorite_fill.svg" alt=""></button>
                            <button class="product__actions__buy">купить</button>
                        </div>
                    </div>
                    <div class="product">
                        <div class="product__img">
                            <a href=""><img src="../../images/coffe@3x.jpg" alt=""></a>
                        </div>
                        <div class="product__prices">
                            <p class="product__prices__nodiscount">500 руб.</p>
                        </div>
                        <p class="product__name">Крепкий кофе со сливками</p>
                        <div class="product__actions">
                            <button class="product__actions__like product__actions__like-notactive"><img src="../../images/icons/favorite.svg" alt=""></button>
                            <div class="product__actions__counter">
                                <button class="product__actions__counter__remove"><span>-</span></button>
                                <div class="product__actions__counter__count">1</div>
                                <button class="product__actions__counter__add"><span>+</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button v-show="productById.product_incart === false"
                class="btn btn__fixed"
                @click="add(productById)"
        >добавить в корзину</button>
    </section>
</template>
<script>
    import {mapGetters} from 'vuex';
    import {mapActions} from 'vuex';
    export default {
        computed: {
            ...mapGetters('products', {
                allProducts: 'getItems'
            }),
            productById() {
                return this.allProducts.find(item => item.product_id === parseInt(this.$route.params.id));
            }
        },
        methods: {
            ...mapActions('products', {
                favoriteStatusChange: 'like'
            }),
            ...mapActions('cart', {
                add: 'addToCart',
                remove: 'removeFromCart'
            })
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