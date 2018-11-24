<template>
    <section class="filtration">
        <div class="wrapper-16">
            <div class="items">
                <ul class="list">
                    <li v-for="(filter, index) in filters" :ket="index"
                        class="list__item">
                        <router-link tag="a" :to="{ name:'parameters', params: {cat_id: $route.params.cat_id, filter_id: filter.id} }">
                            <div class="item-wrapper">
                                <div class="name-wrapper">
                                    <span class="list__item__name">{{ filter.name }}</span>
                                    <span v-show="filterParams(filter) ? filterParams(filter).values.length > 0 : false"
                                          class="list__item__filtercounter">{{ filterParams(filter) ? filterParams(filter).values.length : 0 }}</span>
                                </div>
                                <button v-show="filterParams(filter) ? filterParams(filter).values.length > 0 : false"
                                        class="list__item__close list__item__close-active"
                                        @click.prevent="clearParams(filter)"
                                ><img src="../../images/icons/close_gray.svg" alt=""></button>
                            </div>
                        </router-link>
                    </li>
                    <li class="list__item">
                        <div class="price-filter list__item__name">
                            <p class="price-count"><span>Цена от</span><input class="from" v-model="minRange" @change="updateSlider"><span>до </span> <input class="from" v-model="maxRange" @change="updateSlider"><span> руб.</span> </p>
                            <div id="slider" ref="slider"></div>
                        </div>
                    </li>

                </ul>
            </div>
            <div class="filter-actions">
                <p class="product-found">
                    Отобрано {{ countSortedProducts.length }} товаров из {{ products.length }}
                </p>
                <div class="action-buttons">
                    <button class="btn clear"
                            @click="clear"
                    >очистить</button>
                    <button class="btn show"
                            @click="showFiltered"
                    >показать</button>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
    import Vue from 'vue';
    import {mapActions, mapGetters} from 'vuex';

    export default {
        beforeRouteEnter(to, from, next) {
            next(vm => {
                let products = vm.$store.state.products.items;
                if (products.length > 0) {
                    let prices = [];
                    products.forEach(item => {
                        let price = parseInt(item.price) - parseInt(item.discount);
                        prices.push(price);
                    });

                    let minPrice = Math.min(...prices);
                    let maxPrice = Math.max(...prices);

                    vm.changeTitle('ФИЛЬТР');
                    vm.slider.min = 0;
                    vm.slider.max = maxPrice;
                    vm.minRange = minPrice;
                    vm.maxRange = maxPrice;
                    vm.slider.startMin = minPrice;
                    vm.slider.startMax = maxPrice;
                }
                else {
                    vm.changeTitle('ФИЛЬТР');
                }
            });
        },
        created() {
            Vue.nextTick(function() {
                this.installSlider();
            }.bind(this));
        },
        data() {
            return {
                sorted: [],
                minRange: '',
                maxRange: '',
                slider: {
                    startMin: 0,
                    startMax: 0,
                    min: 0,
                    max: 10000,
                    step:1
                }
            }
        },
        computed: {
            ...mapGetters('products', {
                products: 'getItems',

                // FILTERS
                paramsChecked: 'getChecked',
                filteredProducts: 'getFilteredItems',
                sliderMinRange: 'getSliderMinRange',
                sliderMaxRange: 'getSliderMaxRange',
                sliderStartMin: 'getSliderStartMin',
                sliderStartMax: 'getSliderStartMax',

            }),
            filterParams() {
                return (filter) => this.paramsChecked.find(item => item.filter === filter.name)
            },
            filters() {
                let properties = [];
                this.products.forEach((item) => {
                    if (item.properties && item.properties.length > 0) {
                        item.properties.forEach((elem) => {
                            properties.push(elem);
                        });
                    }
                });

                return properties.filter((item, i) => {
                    return properties.findIndex((elem) => {
                        return elem.name === item.name;
                    }) === i;

                });
            },
            lowestPrice() {
                let prices = [];
                this.products.forEach(item => {
                    let price = item.price - item.discount;
                    prices.push(price);
                });

                return Math.min(...prices);

            },
            highestPrice() {
                let prices = [];
                this.products.forEach(item => {
                    let price = item.price - item.discount;
                    prices.push(price);
                });

                return Math.max(...prices);
            },
            countSortedProducts() {
                return this.products.filter(item => {
                    let totalPrice = item.price - item.discount;

                    if (this.paramsChecked && this.paramsChecked.length > 0) {
                        return (
                            totalPrice >= parseInt(this.minRange)
                            && totalPrice <= parseInt(this.maxRange)


                           /* && item.properties[0].name === 'Color'
                            && (item.properties[0].value === 'LightBlue'
                            || item.properties[0].value === 'PaleGreen'
                            || item.properties[0].value === 'Plum')*/
                        );
                    }


                    return (
                        totalPrice >= parseInt(this.minRange)
                        && totalPrice <= parseInt(this.maxRange)
                    );
                });
            },
            countByParams() {
                return this.products.filter(item => {
                    let filterNames = item.properties.filter(elem => {
                        let filtered = [];
                        this.paramsChecked.forEach(it => {
                            if (it.filter === elem.name) {
                                filtered.push(elem.name);
                            }
                        });

                        return filtered;

                    });

                });
            }
        },
        methods: {
            ...mapActions('products', {
                changeSliderMinRange: 'changeMinRange',
                changeSliderMaxRange: 'changeMaxRange',
                changeSliderStartMax: 'changeStartMax',
                changeSliderStartMin: 'changeStartMin',
                addToFilteredProducts: 'addToFiltered',
                removeFromFilteredProducts: 'removeFromFiltered',
                clearFilterParameters: 'clearCheckedParams'
            }),
            ...mapActions('header', {
                changeTitle: 'setTitle'
            }),


            updateSlider() {
                this.$refs.slider.noUiSlider.set([this.minRange, this.maxRange]);
            },

            installSlider() {
                noUiSlider.create(this.$refs.slider, {
                    start: [this.slider.startMin, this.slider.startMax],
                    step: this.slider.step,
                    connect: true,
                    range: {
                        'min': this.slider.min,
                        'max': this.slider.max
                    },
                    format: wNumb({
                        decimals: 0,
                        thousand: '',
                    })

                });

                this.$refs.slider.noUiSlider.on('update',(values, handle) => {
                    this.minRange = values[0];
                    this.maxRange = values[1];
                    this.startMin = values[0];
                    this.startMax = values[1];
                });
            },
            clearParams(filter) {
                this.clearFilterParameters(filter);
            },
            showFiltered() {
                this.changeSliderMinRange(this.minRange);
                this.changeSliderMaxRange(this.maxRange);
                this.changeSliderStartMax(this.slider.startMax);
                this.changeSliderStartMin(this.slider.startMin);
                this.$router.go(-1);

            },
            clear() {
                this.filters.forEach(item => {
                    this.clearFilterParameters(item);
                });

                this.slider.startMin = 0;
                this.minRange = 0;
                this.maxRange = this.highestPrice;
                this.$refs.slider.noUiSlider.set([0, this.highestPrice]);

            }
        },

    }
</script>
<style scoped lang="scss">
    .vue-slider-component {
        padding: 0px;
    }
</style>
