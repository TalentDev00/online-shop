<template>
    <div >
        <my-header v-show="!showHeader">
            <h2 class="head" slot="title">{{ headerTitle }}</h2>
        </my-header>
        <div class="transition-wrapper">
            <transition name="swipe" mode="out-in">
                <router-view></router-view>
            </transition>
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
    export default {
        components: {
            myFooter,
            myHeader,
        },

        data(){
            return {
            }
        },
        methods: {
            onNext(){
                if (this.currentScreenStart1) {
                    this.$router.push({name: 'start2'});
                }

                else {
                    this.$router.push({name: 'start3'});
                }
            },
            skip(){
                this.$router.push({name: 'start3'});
            }
        },
        computed: {
            ...mapGetters('header', {
                headerTitle: 'getTitle'
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
<style>
    .transition-wrapper {
        overflow-x: hidden;
        overflow-y: scroll;
    }
</style>
