<template>
    <header>
        <div class="search" v-if="currentScreenHome">
            <form class="search__form" action="">
                <input class="search__form__input" type="text" placeholder="поиск по каталогу">
                <a class="search__form__cancel search__form__cancel-removed" href=""><img src="../../images/icons/close.svg" alt=""></a>
            </form>
        </div>
        <div v-else-if="currentScreenWithFilters">
            <div class="commercial">
                <button class="back"><img src="../../images/icons/back.svg" alt=""
                                          @click="back"
                ></button>
                <h2 class="head" ref="title">{{ newTitle }}</h2>
                <button class="chat"><img :src="currentScreenChat ? '' : '../../images/icons/chat.svg'" alt=""
                                          @click="toChat"
                ></button>
            </div>
            <div class="filters">
                <button class="sort"
                        @click="toSort"
                >Сортировка</button>
                <button data-count="3" class="filter"
                        @click="toFilter"
                >Фильтр&nbsp;&nbsp;&nbsp;&nbsp;</button>
            </div>

        </div>

        <div class="commercial" v-else>
            <button class="back"><img src="../../images/icons/back.svg" alt=""
                    @click="back"
            ></button>
            <h2 class="head" ref="title">{{ newTitle }}</h2>
            <button class="chat"><img :src="currentScreenChat ? '' : '../../images/icons/chat.svg'" alt=""
                    @click="toChat"
            ></button>
        </div>

    </header>

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
            back() {
                this.$router.go(-1);
            },
            toChat() {
              this.$router.push({name: 'chat'});
            },
            toSort() {
                this.$router.push({name: 'sort'})
            },
            toFilter() {
                this.$router.push({name: 'filter'})
            }
        },
        computed: {
            ...mapGetters('products', {
                allProducts: 'getItems'
            }),
            ...mapGetters('filters', {
                allFilters: 'getFilterItems'
            }),
            currentScreenChat(){
                return this.$route.name === 'chat';
            },
            currentScreenHome(){
                return this.$route.name === 'home';
            },
            currentScreenWithFilters(){
                return this.$route.name === 'favorite' || this.$route.name === 'section'
            },
            newTitle() {
                if (this.$route.meta.title) {
                    return this.$route.meta.title.toUpperCase();
                }
              /*  if (!this.$route.params.section && this.$route.params.subcatalog) {
                    return this.$route.params.subcatalog.toUpperCase();
                }
                if (this.$route.name !== 'parameters' && this.$route.params.id) {
                    return this.getProduct.product_name.toUpperCase();
                }
                if (this.$route.name === 'parameters' && this.$route.params.id) {
                    return  this.getFilter.name.toUpperCase()
                }*/
               /* if (this.$route.params.section && this.$route.params.subcatalog) {
                    return this.$route.params.section.toUpperCase();
                }*/
                else {
                    return 'ОШИБКА';
                }

            },
            getProduct() {
                return this.allProducts.find(item => item.product_id === parseInt(this.$route.params.id));
            },
            getFilter() {
                return this.allFilters.find(item => item.id === parseInt(this.$route.params.id));
            }
        }
    }
</script>
<style scoped lang="scss">

</style>