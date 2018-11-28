<template>
    <section class="sort-list">
        <div class="wrapper-16">
            <div class="items">
                <ul class="list">
                    <li v-for="(item, index) in sortVariants" :key="index"
                        class="list__item">
                        <my-radio :index="index"
                                  name="radio"
                                  :label="item.name"
                                  :value="item.value"
                                  @onchange="updateValue($event)"
                        ></my-radio>
                    </li>
                </ul>
            </div>
            <button class="btn"
                    @click.prevent="applySort"
            >применить</button>
        </div>
    </section>
</template>
<script>
    import {mapGetters} from 'vuex';
    import {mapActions} from 'vuex';
    import myRadio from './helpers/radio';
    export default {
        components: {
            myRadio
        },
        beforeRouteEnter(to, from, next) {
              next(vm => vm.changeTitle('СОРТИРОВКА'));
        },
        data() {
            return {
                sortVariants: [
                    {
                        name : 'Цена по возрастанию',
                        value: 'price_asc'
                    },
                    {
                        name: 'Цена по убыванию',
                        value: 'price_desc'
                    },
                    {
                        name: 'По рейтингу',
                        value: 'rating'
                    },
                    {
                        name: 'Новинки',
                        value: 'new'
                    },
                    {
                        name: 'По умолчанию',
                        value: 'default'
                    }
                ],
                checked: this.sort
            }
        },
        computed: {
            ...mapGetters('products', {
                sort:'getSort'
            }),
        },
        methods: {
            ...mapActions('products', {
                changeSort: 'sortChange'
            }),
            ...mapActions('header', {
                changeTitle: 'setTitle'
            }),
            updateValue(data) {
                this.checked = data;
            },

            applySort() {
                this.changeSort(this.checked);
                this.$router.go(-1);
            }
        }
    }
</script>
