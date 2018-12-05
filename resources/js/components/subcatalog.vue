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
                        <router-link tag="li"
                                     :to="{ name:'section', params: {cat_id: $route.params.cat_id} }"
                                     class="list__item">
                            <a class="list__item__name list__item__name">Показать все товары раздела</a>
                        </router-link>

                        <router-link v-for="(item, index) in childrenCategories"
                                     :key="index"
                                     tag="li"
                                     :to="routeTo(item)"
                                     class="list__item">
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
                                     class="list__item">
                            <a v-html="highlight(item.name)" class="list__item__name" href="">{{ item.name }}</a>
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
    import mySearch from './helpers/search';
    import {mapGetters} from 'vuex';
    import {mapActions} from 'vuex';

    export default {
        components: {
            mySearch
        },
        beforeRouteEnter(to, from, next) {
            next(vm => {
                let found = vm.catalogItems.find(item => item.id === parseInt(to.params.cat_id));
                if (found) {
                    vm.changeTitle(found.name);
                }
            });
        },
        beforeRouteUpdate(to, from, next) {
            let found = this.catalogItems.find(item => item.id === parseInt(to.params.cat_id));
            if (found) {
                this.changeTitle(found.name);
            }
            next();
        },
        data() {
            return {
                keywords: null,
                cat_id: parseInt(this.$route.params.cat_id)
            }
        },
        computed: {
            ...mapGetters('catalog', {
                catalogItems: 'getCatalogItems',
            }),
            ...mapGetters('search', {
                results: 'getResults'
            }),
            emptyInput() {
                return this.keywords === null || this.keywords === '' || this.keywords === ' ';
            },
            childrenCategories() {
                return this.catalogItems.filter(item => {
                    return item.parent_id === this.cat_id;
                });
            },
            routeTo() {
                return (item) => item.children_count && item.children_count > 0 ? { name: 'subcatalog', params: { cat_id: item.id } } : { name:'section', params: {cat_id: item.id} }
            }
        },
        methods: {
            ...mapActions('header', {
                changeTitle: 'setTitle',
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
