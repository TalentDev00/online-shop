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

                    <template v-if="searchValue === ''">
                        <router-link v-for="(item, index) in rootCategories"
                                     :key="index"
                                     tag="li"
                                     :to="{ name: 'subcatalog', params: { cat_id: item.id } }"
                                     class="list__item"
                        >
                            <a class="list__item__name" href="">{{ item.name }}</a>
                        </router-link>
                    </template>
                    <template v-else>
                        <router-link v-for="(item, index) in filteredList"
                                     :key="index"
                                     tag="li"
                                     :to="{ name: 'subcatalog', params: { cat_id: item.id } }"
                                     class="list__item"
                        >
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
                vm.changeTitle('КАТАЛОГ');
            });
        },
        data() {
            return {
                searchValue: '',
            }
        },
        computed: {
            ...mapGetters('catalog', {
                catalogItems: 'getCatalogItems'
            }),
            filteredList() {
                return this.catalogItems.filter(item => {
                    return item.name.toLowerCase().includes(this.searchValue.toLowerCase())
                })
            },
            rootCategories() {
                let found = [];

                for (let i = 0; i < this.catalogItems.length; i++) {
                    if (this.catalogItems[i].parent_id === null) {
                        found.push(this.catalogItems[i]);
                    }
                }

                return found;
            },
        },
        methods: {
            ...mapActions('header', {
                changeTitle: 'setTitle'
            }),
            search(e) {
                this.searchValue = e.target.value;
            },
        }
    }
</script>
