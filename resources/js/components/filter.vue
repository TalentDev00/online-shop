<template>
    <section class="filtration">
        <div class="wrapper-16">
            <div class="items">
                <ul class="list">
                    <li v-for="(filter, index) in filters" :key="index"
                        class="list__item">
                        <router-link tag="a" :to="{ name:'parameters', params: {cat_id: $route.params.cat_id, keywords: $route.params.keywords, filter_name: filter.name} }" replace>
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
                    Отобрано {{ countItemsByFilters.length }} товаров из {{ products.length }}
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
    import {get as loadData} from '../api';
    import {mapActions, mapGetters} from 'vuex';

    export default {
        beforeRouteEnter(to, from, next) {
            next(vm => {

                let url;
                let params;

                if (from.name === 'favorite' || (from.name === 'parameters' && from.params.keywords === undefined && from.params.cat_id === undefined) ) {
                    params = {
                        user_id: vm.$auth.user().id
                    };

                    url = '/store/favorite';
                }
                else {
                    params = {
                        cat_id: to.params.cat_id,
                        keywords: to.params.keywords
                    };

                    url = '/store/catalog';
                }
                let that = this;
                loadData(url, params, (data) => {
                    vm.setData(data);
                    // set slider initial values
                    let products = data;
                    if (products.length > 0) {
                        let prices = products.map(item => item.price);
                        let minPrice = Math.min(...prices);
                        let maxPrice = Math.max(...prices);

                        vm.changeTitle('ФИЛЬТР');
                        vm.slider.min = 0;
                        vm.slider.max = maxPrice;
                        if (vm.sliderMinRange === "" || vm.sliderMaxRange === "") {
                            vm.minRange = minPrice;
                            vm.maxRange = maxPrice;
                        }
                        else {
                            vm.minRange = vm.sliderMinRange;
                            vm.maxRange = vm.sliderMaxRange;
                        }

                        vm.slider.startMin = vm.minRange;
                        vm.slider.startMax = vm.maxRange;
                        vm.$nextTick(function() {
                            vm.installSlider();
                        }.bind(that));
                    }
                    else {
                        vm.changeTitle('ФИЛЬТР');
                    }
                });
            });
        },
        data() {
            return {
                products: [],
                minRange: 0,
                maxRange: 0,
                slider: {
                    startMin: 0,
                    startMax: 0,
                    min: 0,
                    step:1
                }
            }
        },
        computed: {
            ...mapGetters('products', {
                paramsChecked: 'getChecked',
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
            lowestPrice() {
                let prices = this.products.map(item => item.price);
                return Math.min(...prices);
            },
            highestPrice() {
                let prices = this.products.map(item => item.price);
                return Math.max(...prices);
            },
            countItemsByFilters() {
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

                return sorted.filter((item, i) => {
                    return sorted.findIndex((elem) => {
                        return elem.name === item.name && elem.value === item.value;
                    }) === i;
                });
            },
        },
        methods: {
            ...mapActions('products', {
                changeSliderMinRange: 'changeMinRange',
                changeSliderMaxRange: 'changeMaxRange',
                changeSliderStartMax: 'changeStartMax',
                changeSliderStartMin: 'changeStartMin',
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
                        'max': this.highestPrice
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
            setData(data) {
                this.products = data;
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
                this.minRange = this.lowestPrice;
                this.maxRange = this.highestPrice;
                this.$refs.slider.noUiSlider.set([this.minRange, this.maxRange]);
                this.filters.forEach(item => {
                    this.clearFilterParameters(item);
                });
            }
        },
    }
</script>
