<template>
    <section class="catalog">
        <div class="wrapper-16">
            <div class="items">
                <my-search :value="keywords"
                           :formClass="'search__form-static'"
                           @onchange="updateInput($event)"
                           @onclear="keywords = null"
                ></my-search>
                <ul class="list">
                    <router-link v-if="!emptyInput"
                                 tag="li"
                                 :to="{ name: 'section', params: { keywords:  keywords} }"
                                 class="list__item">
                        <a class="list__item__name list__item__name-reactive" href="">{{ keywords }}</a>
                    </router-link>
                    <template v-if="emptyInput">
                        <router-link v-for="(item, index) in rootCategories"
                                     :key="index"
                                     tag="li"
                                     :to="{ name: 'subcatalog', params: { cat_id: item.id } }"
                                     class="list__item"
                        >
                            <a class="list__item__name" href="">{{ item.name }}</a>
                            <img v-if="!item.cat_id"
                                 class="list__item__catalog" src="../../images/icons/folder.svg" alt="">
                        </router-link>
                    </template>
                    <template v-else>
                        <router-link v-for="(item, index) in results"
                                     :key="index"
                                     tag="li"
                                     :to="routeTo(item)"
                                     class="list__item"
                        >
                            <a  v-html="highlight(item.name)" class="list__item__name" href="">{{ item.name }}</a>
                            <img v-if="!item.cat_id"
                                 class="list__item__catalog" src="../../images/icons/folder.svg" alt="">
                        </router-link>
                    </template>
                </ul>
            </div>
        </div>
    </section>
</template>
<script>
    import {mapGetters} from 'vuex';
    import {mapActions} from 'vuex';
    import mySearch from './helpers/search';
    export default {
        components: {
            mySearch
        },
        beforeRouteEnter(to, from, next) {
            next(vm => {
                vm.changeTitle('КАТАЛОГ');
            });
        },
        data() {
            return {
                keywords: null,
            }
        },
        computed: {
            ...mapGetters('catalog', {
                catalogItems: 'getCatalogItems'
            }),
            ...mapGetters('search', {
                results: 'getResults'
            }),
            rootCategories() {
                let found = [];

                for (let i = 0; i < this.catalogItems.length; i++) {
                    if (this.catalogItems[i].parent_id === null) {
                        found.push(this.catalogItems[i]);
                    }
                }

                return found;
            },
            emptyInput() {
                return this.keywords === null || this.keywords === '' || this.keywords === ' ';
            },
            routeTo() {
                return (item) => !item.cat_id ? { name: 'subcatalog', params: { cat_id: item.id } } : { name: 'single', params: { item_id: item.id } };
            }
        },
        methods: {
            ...mapActions('header', {
                changeTitle: 'setTitle'
            }),
            highlight(text) {
                return text.replace(new RegExp(this.keywords, 'gi'), '<span class="highlighted">$&</span>');
            },
            updateInput(e) {
                this.keywords = e;
            }
        }
    }
</script>
