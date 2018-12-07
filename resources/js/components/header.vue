<template>
    <header>
        <my-search v-if="currentScreenHome"
                   :value="keywords"
                   @onchange="updateInput($event)"
                   @onclear="resetSearch"
        ></my-search>

        <div v-else-if="currentScreenWithFilters">
            <div class="commercial">
                <button class="back"><img src="../../images/icons/back.svg" alt=""
                                          @click="back"
                ></button>
                <slot name="title"></slot>
                <button class="chat"><img :src="currentScreenChat ? '' : '/images/icons/chat.svg'" alt=""
                                          @click="toChat"
                ></button>
            </div>
            <div class="filters">
                <button class="sort"
                        @click="toSort"
                >Сортировка</button>
                <button class="filter"
                        @click="toFilter"
                >Фильтр
                    <span v-show="filtersActiveCount !== 0" class="filter-count">{{ filtersActiveCount }}</span>
                </button>
            </div>
        </div>

        <div class="commercial" v-else>
            <button class="back"><img src="../../images/icons/back.svg" alt=""
                    @click="back"
            ></button>
            <slot name="title"></slot>
            <button class="chat"><img :src="currentScreenChat ? '' : '/images/icons/chat.svg'" alt=""
                    @click="toChat"
            ></button>
        </div>

    </header>
</template>
<script>
    import mySearch from './helpers/search';
    import {mapGetters} from 'vuex';
    import {mapActions} from 'vuex';

    export default {
        components: {
            mySearch
        },
        data(){
            return {
                //keywords: (this.$route.params.keywords && this.$route.name !== 'home') ? this.$route.params.keywords : null,
                keywords: null
            }
        },
        methods: {
            ...mapActions('search', {
                setKeywords: 'syncKeywords'
            }),
            back() {
                this.$route.name === 'parameters' ? this.$router.replace({name: 'filter', params: {cat_id: this.$route.params.cat_id, keywords: this.$route.params.keywords} }) : this.$router.go(-1);
            },
            toChat() {
              this.$router.push({name: 'chat'});
            },
            toSort() {
                this.$router.push({name: 'sort', params: {cat_id: this.$route.params.cat_id, keywords: this.$route.params.keywords} })
            },
            toFilter() {
                this.$router.push({name: 'filter', params: {cat_id: this.$route.params.cat_id, keywords: this.$route.params.keywords} })
            },
            updateInput(e) {
                this.keywords = e;
                this.setKeywords(e);
            },
            resetSearch() {
                if (this.routeHasKeywords) {
                    this.$router.push({ name: 'catalog' });
                }
                else {
                    this.keywords = null;
                }
            },
        },
        computed: {
            ...mapGetters('products', {
                filtersActiveCount: 'getCheckedCount'
            }),
            routeHasKeywords() {
                return this.$route.params.keywords;
            },
            currentScreenChat(){
                return this.$route.name === 'chat';
            },
            currentScreenHome(){
                return this.$route.name === 'home';
            },
            currentScreenWithFilters(){
                return this.$route.name === 'favorite'
                    || this.$route.name === 'section'
                    || this.$route.name === 'result'
            },
        }
    }
</script>

