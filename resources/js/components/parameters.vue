<template>
    <section class="params">
        <div class="wrapper-16">
            <div class="items">
                <ul class="list">
                    <li v-for="(variant, index) in findFilter.variants" :key="index"
                        class="list__item">
                        <my-checkbox :name="variant.name"
                                     :filter="findFilter"
                                     :value="variant.value"
                                     @onchange="changeValue($event)"
                        ></my-checkbox>
                    </li>
                </ul>
                <button class="btn"
                        @click.prevent="backToFilter"
                >применить</button>
            </div>
        </div>
    </section>
</template>
<script>
    import {mapGetters} from 'vuex';
    import {mapActions} from 'vuex';
    import myCheckbox from './helpers/checkbox';
    export default {
        components: {
            myCheckbox
        },
        data() {
            return {

            }
        },
        computed: {
            ...mapGetters('filters', {
                allFilters: 'getFilterItems'
            }),
            findFilter() {
                return this.allFilters.find(item => item.id === parseInt(this.$route.params.id));
            }
        },
        methods: {
            ...mapActions('filters', {
                loadFilters: 'loadFilterItems',
                check: 'checkFilter'
            }),
            changeValue(e) {
                this.check(e);
            },
            backToFilter() {
                this.$router.go(-1);
            }
        }
    }
</script>