<template>
    <footer>
        <div class="menu">
            <button class="menu__button menu__button__home"><img :src="currentScreenHome ? '/images/icons/home_active.svg' : '/images/icons/home.svg'" alt=""
                    @click="toHome"
            >
            </button>
            <button class="menu__button menu__button__search"><img :src="currentScreenCatalog ? '/images/icons/catalog_active.svg' : '/images/icons/catalog.svg'" alt=""
                    @click="toCatalog"
            ></button>
            <button :data-notification="countProductsInCart" class="menu__button menu__button__cart"><img :src="currentScreenCart ? '/images/icons/cart_active.svg' : '/images/icons/cart.svg'"
                    @click="toCart"
            ></button>
            <button class="menu__button menu__button__favorite"><img :src="currentScreenFavorite ? '/images/icons/favorite_active.svg' : '/images/icons/favorite.svg'"
                    @click="toFavorite"
            ></button>
            <button class="menu__button menu__button__menu"><img :src="currentScreenMenu ? '/images/icons/menu_active.svg' : '/images/icons/menu.svg'"
                    @click="toMenu"
            ></button>
        </div>
    </footer>
</template>

<script>
    import {mapGetters} from 'vuex';
    export default {
        components: {
        },
        data(){
            return {
            }
        },
        methods: {
            toHome(){
                this.$router.push({name: 'home'});
            },
            toCatalog(){
                this.$router.push({name: 'catalog'});
            },
            toCart(){
                this.$router.push({name: 'cart'});
            },
            toMenu(){
                this.$router.push({name: 'menu'});
            },
            toFavorite(){
                this.$router.push({name: 'favorite'});
            }
        },
        computed: {
            ...mapGetters('cart', {
                productsInCart: 'getProducts',
                countProductsInCart: 'getCountProducts'
            }),
            currentScreenHome(){
                return this.$route.name === 'home'
            },
            currentScreenCatalog(){
                return this.$route.name === 'catalog'
                    || this.$route.name === 'subcatalog'
                    || this.$route.name === 'section'
                    || this.$route.name === 'product'
                    || this.$route.name === 'gallery'
            },
            currentScreenCart(){
                return this.$route.name === 'cart'
                    || this.$route.name === 'checkout'
            },
            currentScreenFavorite(){
                return this.$route.name === 'favorite'
            },
            currentScreenMenu(){
                return this.$route.name === 'menu'
                    || this.$route.name === 'orders'
                    || this.$route.name === 'settings'
                    || this.$route.name === 'about'
                    || this.$route.name === 'delivery'
                    || this.$route.name === 'edit'
                    || this.$route.name === 'order'
                    || this.$route.name === 'contacts';
            },
        }
    }
</script>

