<template>
    <section class="catalog">
        <div class="wrapper-16">
            <div class="items">
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
                <ul class="list">
                    <li v-if="searchValue !== ''"
                        class="list__item">
                        <p class="list__item__name list__item__name-reactive">{{ searchValue }}</p>
                    </li>
                    <router-link tag="li"
                                 :to="{ name:'section', params: {cat_id: $route.params.cat_id} }"
                                 class="list__item">
                        <a class="list__item__name list__item__name">Показать все товары раздела</a>
                    </router-link>
                    <template v-if="searchValue === ''">
                        <router-link v-for="(item, index) in childrenCategories"
                                     :key="index"
                                     tag="li"
                                     :to="item.children_count > 0 ? { name: 'subcatalog', params: { cat_id: item.id } } : { name:'section', params: {cat_id: item.id} }"
                                     class="list__item">
                            <a class="list__item__name" href="">{{ item.name }}</a>
                        </router-link>
                    </template>
                    <template v-else>
                        <router-link v-for="(item, index) in filteredList"
                                     :key="index"
                                     tag="li"
                                     :to="item.children_count > 0 ? { name: 'subcatalog', params: { cat_id: item.id } } : { name:'section', params: {cat_id: item.id} }"
                                     class="list__item">
                            <a class="list__item__name" href="">{{ item.name }}</a>
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

    export default {
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
                searchValue: '',
                cat_id: parseInt(this.$route.params.cat_id)
            }
        },
        computed: {
            ...mapGetters('catalog', {
                catalogItems: 'getCatalogItems',
            }),
            filteredList() {
                return this.childrenCategories.filter(item => {
                    return item.name.toLowerCase().includes(this.searchValue.toLowerCase())
                })
            },
            childrenCategories() {
                let found = [];
                for (let i = 0; i < this.catalogItems.length; i++) {
                    if (this.catalogItems[i].parent_id === this.cat_id) {
                        found.push(this.catalogItems[i]);
                    }
                }

                return found;
            }
        },
        methods: {
            ...mapActions('header', {
                changeTitle: 'setTitle',
            }),
            search(e) {
                this.searchValue = e.target.value;
            },
        }
    }
</script>
