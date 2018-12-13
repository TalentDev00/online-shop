<template>
    <div >
        <my-header v-show="!showHeader">
            <h2 class="head" slot="title">{{ headerTitle }}</h2>
        </my-header>
        <div class="transition-wrapper" v-if="$auth.ready()">
            <transition :name="transitionName"
            >
                <router-view :key="$route.fullPath"></router-view>
            </transition>
        </div>
        <div v-if="!$auth.ready()">
            Loading ...
        </div>

        <div class="nav" v-show="startScreen">
            <button class="nav__btn nav__btn-previous"
                    v-show="!currentScreenStart3"
                    @click="skip"
            >ПРОПУСТИТЬ</button>
            <div class="nav__dots">
                <div class="nav__dots__dot"><span :class=" currentScreenStart1 ? 'nav__dots__dot-active' : '' "></span></div>
                <div class="nav__dots__dot"><span :class=" currentScreenStart2 ? 'nav__dots__dot-active' : '' "></span></div>
                <div class="nav__dots__dot"><span :class=" currentScreenStart3 ? 'nav__dots__dot-active' : '' "></span></div>
            </div>
            <button class="nav__btn nav__btn-next"
                    v-show="!currentScreenStart3"
                    @click="onNext"
            >ДАЛЕЕ</button>
        </div>

        <my-footer v-show="!showFooter"
        ></my-footer>
    </div>
</template>
<script>
    import myHeader from './header';
    import myFooter from './footer';
    import {mapGetters} from 'vuex';
    import {mapActions} from 'vuex';

    export default {
        components: {
            myFooter,
            myHeader,
        },
        created() {
            this.$auth.ready(() => {
                if (this.$auth.check()) {
                    this.loadFavorites(this.$auth.user().favorites);
                    this.loadCart(this.$auth.user().cart.cart_items);
                }
            });
        },
        data() {
            return {
                transitionName: 'swipe-left'
            }
        },
        watch: {
            '$route' (to, from) {
                const toDepth = to.path.split('/').length;
                const fromDepth = from.path.split('/').length;
                const toDepthCatNumber = parseInt(to.path.split('/')[to.path.split('/').length - 1]);
                const fromDepthCatNumber = parseInt(from.path.split('/')[from.path.split('/').length - 1]);
                if (from.name === 'action') {
                    this.transitionName = 'swipe-right'
                }
                else if ((from.name === 'filter' || from.name === 'sort') && to.name === 'favorite') {
                    this.transitionName = 'swipe-right'
                }
                else if (
                        (to.name === 'home' && from.name !== 'start3')
                        || to.name === 'cart'
                        || (to.name === 'favorite' && (from.name !== 'filter' || from.name !== 'sort'))
                        || (to.name === 'catalog' && from.name !== 'start3' )
                    )
                {
                    this.transitionName = ''
                }

                else if (to.name === 'home' && from.name === 'start3') {
                    this.transitionName = 'swipe-left'
                }
                else if (to.name === 'menu' &&
                    (
                        from.name === 'contacts'
                        || from.name === 'delivery'
                        || from.name === 'about'
                        || from.name === 'orders'
                        || from.name === 'settings'
                        || from.name === 'chat'
                    ))
                {
                    this.transitionName = 'swipe-right'
                }
                else if (to.name === 'menu' &&
                    (
                        from.name !== 'contacts'
                        || from.name !== 'delivery'
                        || from.name !== 'about'
                        || from.name !== 'orders'
                        || from.name !== 'settings'
                        || from.name !== 'chat'
                    ))
                {
                    this.transitionName = ''
                }
                else if (to.name === 'parameters' && from.name === 'filter') {
                    this.transitionName = 'swipe-left'
                }
                else if (from.name === 'parameters' && to.name === 'filter') {
                    this.transitionName = 'swipe-right'
                }
                else if (to.name === 'filter' || to.name === 'sort') {
                    this.transitionName = 'swipe-left'
                }
                else if (from.name === 'filter' || from.name === 'sort') {
                    this.transitionName = 'swipe-right'
                }
                else if (to.name === 'chat') {
                    this.transitionName = 'swipe-left'
                }
                else if (from.name === 'chat') {
                    this.transitionName = 'swipe-right'
                }
                else if (from.name === 'subcatalog' && to.name === 'section') {
                    this.transitionName = 'swipe-left'
                }
                else if (from.name === 'subcatalog' && toDepthCatNumber < fromDepthCatNumber) {
                    this.transitionName = 'swipe-right'
                }
                else if (from.name === 'home' && to.name === 'action') {
                    this.transitionName = 'swipe-left'
                }

                else if (toDepth < fromDepth) {
                    this.transitionName = 'swipe-right'
                }
                else {
                    this.transitionName = 'swipe-left'
                }
            }
        },
        methods: {
            ...mapActions('favorites', {
                loadFavorites: 'setItems'
            }),
            ...mapActions('cart', {
                loadCart: 'setCartItems'
            }),
            onNext(){
                if (this.currentScreenStart1) {
                    this.$router.push({name: 'start2'});
                }
                else {
                    this.$router.push({name: 'start3'});
                }
            },
            skip(){
                this.$router.push({name: 'home'});
            }
        },
        computed: {
            ...mapGetters('header', {
                headerTitle: 'getTitle',
                animationName: 'getAnimationName'
            }),
            startScreen(){
                return this.currentScreenStart1
                    || this.currentScreenStart2
                    || this.currentScreenStart
                    || this.currentScreenStart3;
            },
            showHeader() {
                return this.currentScreenStart1
                    || this.currentScreenStart2
                    || this.currentScreenGallery
                    || this.currentScreenStart
                    || this.currentScreenStart3;
            },
            showFooter() {
                return this.currentScreenStart1
                    || this.currentScreenStart2
                    || this.currentScreenStart3
                    || this.currentScreenSort
                    || this.currentScreenFilter
                    || this.currentScreenParameters
                    || this.currentScreenStart
                    || this.currentScreenGallery;
            },
            currentScreenStart1(){
                return this.$route.name === 'start1'
            },
            currentScreenStart2(){
                return this.$route.name === 'start2'
            },
            currentScreenStart3(){
                return this.$route.name === 'start3'
            },
            currentScreenSort() {
                return this.$route.name === 'sort'
            },
            currentScreenFilter() {
                return this.$route.name === 'filter'
            },
            currentScreenParameters() {
                return this.$route.name === 'parameters'
            },
            currentScreenGallery() {
                return this.$route.name === 'gallery'
            },
            currentScreenStart() {
                return this.$route.name === 'test'
            }
        },
    }
</script>
