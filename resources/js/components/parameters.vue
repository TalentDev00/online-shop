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
                products: 'getItems'
            }),
            getFilters() {
                let properties = [];
                for (let i = 0; i < this.products.length; i++) {
                    if (this.products[i].properties && this.products[i].properties.length > 0) {
                        let prop = this.products[i].properties;
                        for (let i = 0; i < prop.length; i++) {
                            properties.push(prop[i]);
                        }
                    }
                }

                return properties.filter((e, i) => {
                    return properties.findIndex((x) => {
                        return x.name === e.name;
                    }) === i;

                });
            },
        },
        methods: {
            changeValue(e) {
                this.check(e);
            },
            backToFilter() {
                this.$router.go(-1);
            }
        }
    }
</script>
