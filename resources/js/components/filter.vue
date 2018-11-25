<template>
    <section class="filtration">
        <div class="wrapper-16">
            <div class="items">
                <ul class="list">
                    <li v-for="(filter, index) in filters" :key="index"
                        class="list__item">
                        <router-link tag="a" :to="{ name:'parameters', params: {cat_id: $route.params.cat_id, filter_id: filter.id} }">
                            <div class="item-wrapper">
                                <div class="name-wrapper">
                                    <span class="list__item__name">{{ filter.name }}</span>
                                    <span v-show="hasActiveParams(filter)"
                                          class="list__item__filtercounter">{{ countActiveParams(filter) }}</span>
                                </div>
                                <button v-show="hasActiveParams(filter)"
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
                    Отобрано {{ countByParams.length }} товаров из {{ products.length }}
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
                        prices.push(item.price);
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
                minRange: 0,
                maxRange: 0,
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
            filterParams() {
                return (filter) => this.paramsChecked.find(item => item.filter === filter.name);
            },
            hasActiveParams() {
                return (filter) => this.filterParams(filter) ? this.filterParams(filter).values.length > 0 : false;
            },
            countActiveParams() {
                return (filter) => this.hasActiveParams(filter) ? this.filterParams(filter).values.length : 0;
            },
            countSortedProducts() {
                return this.products.filter(item => {
                    let totalPrice = item.price - item.discount;

                    if (this.paramsChecked && this.paramsChecked.length > 0) {
                        return (
                            totalPrice >= parseInt(this.minRange)
                            && totalPrice <= parseInt(this.maxRange)
                        );
                    }

                    return (
                        totalPrice >= parseInt(this.minRange)
                        && totalPrice <= parseInt(this.maxRange)
                    );
                });
            },
            countByParams() {
                let newFilters = [];
                this.paramsChecked.forEach(item => {
                    item.values.forEach(elem => {
                        newFilters.push({
                            name: item.filter,
                            value: elem
                        });
                    })
                });
                let sorted = [];
                this.products.filter(item => {
                    if (newFilters && newFilters.length > 0) {
                        item.properties.forEach(property => {
                            newFilters.forEach(filter => {
                                if (property.name === filter.name
                                    && property.value === filter.value
                                    && (item.price >= parseInt(this.minRange)
                                        && item.price <= parseInt(this.maxRange))) {
                                    sorted.push(item);
                                }
                            });
                        });
                    }

                    else {
                        if (item.price >= parseInt(this.minRange)
                            && item.price <= parseInt(this.maxRange)) {
                            sorted.push(item);
                        }
                    }

                });

                return sorted;
            },
        },
        methods: {
            ...mapActions('products', {
                changeSliderMinRange: 'changeMinRange',
                changeSliderMaxRange: 'changeMaxRange',
                changeSliderStartMax: 'changeStartMax',
                changeSliderStartMin: 'changeStartMin',
                addToFilteredProducts: 'addToFiltered',
                removeFromFilteredProducts: 'removeFromFiltered',
                clearFilterParameters: 'clearCheckedParams',

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
                this.minRange = '';
                this.maxRange = '';
                //this.$refs.slider.noUiSlider.set([this.minRange, this.maxRange]);
                this.filters.forEach(item => {
                    this.clearFilterParameters(item);
                });


            }
        },

    }
</script>
<style scoped lang="scss">
    .vue-slider-component {
        padding: 0px;
    }
</style>
