<template>
    <section class="filtration">
        <div class="wrapper-16">
            <div class="items">
                <ul class="list">
                    <li v-for="(filter, index) in getFilters" :ket="index"
                        class="list__item">
                        <router-link tag="a" :to="{ name:'parameters', params: {cat_id: $route.params.cat_id, filter_id: filter.id} }">
                            <div class="item-wrapper">
                                <div class="name-wrapper">
                                    <span class="list__item__name">{{ filter.name }}</span>
                                    <span class="list__item__filtercounter">3</span>
                                </div>
                                <button
                                        class="list__item__close list__item__close-active"
                                ><img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyB3aWR0aD0iMjRweCIgaGVpZ2h0PSIyNHB4IiB2aWV3Qm94PSIwIDAgMjQgMjQiIHZlcnNpb249IjEuMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+CiAgICA8IS0tIEdlbmVyYXRvcjogU2tldGNoIDUyLjIgKDY3MTQ1KSAtIGh0dHA6Ly93d3cuYm9oZW1pYW5jb2RpbmcuY29tL3NrZXRjaCAtLT4KICAgIDx0aXRsZT5pY29ucyAvIGNsb3NlPC90aXRsZT4KICAgIDxkZXNjPkNyZWF0ZWQgd2l0aCBTa2V0Y2guPC9kZXNjPgogICAgPGRlZnM+CiAgICAgICAgPHBhdGggZD0iTTMuMTA1NDE2NjcsNS4yMjY0MTY2NyBDMi41MjA0MTY2Nyw0LjY0MTQxNjY3IDIuNTIwNDE2NjcsMy42OTA0MTY2NyAzLjEwNTQxNjY3LDMuMTA1NDE2NjcgQzMuNjkwNDE2NjcsMi41MjA0MTY2NyA0LjY0MTQxNjY3LDIuNTIwNDE2NjcgNS4yMjY0MTY2NywzLjEwNTQxNjY3IEwxMS45OTkyNSw5Ljg3ODI1IEwxOC43NzIwODMzLDMuMTA1NDE2NjcgQzE5LjM1NzA4MzMsMi41MjA0MTY2NyAyMC4zMDgwODMzLDIuNTIwNDE2NjcgMjAuODkzMDgzMywzLjEwNTQxNjY3IEMyMS40NzgwODMzLDMuNjkwNDE2NjcgMjEuNDc4MDgzMyw0LjY0MTQxNjY3IDIwLjg5MzA4MzMsNS4yMjY0MTY2NyBMMTQuMTIwMjUsMTEuOTk5MjUgTDIwLjg5MzA4MzMsMTguNzcyMDgzMyBDMjEuNDc4MDgzMywxOS4zNTcwODMzIDIxLjQ3ODA4MzMsMjAuMzA4MDgzMyAyMC44OTMwODMzLDIwLjg5MzA4MzMgQzIwLjMwODA4MzMsMjEuNDc4MDgzMyAxOS4zNTcwODMzLDIxLjQ3ODA4MzMgMTguNzcyMDgzMywyMC44OTMwODMzIEwxMS45OTkyNSwxNC4xMjAyNSBMNS4yMjY0MTY2NywyMC44OTMwODMzIEM0LjY0MTQxNjY3LDIxLjQ3ODA4MzMgMy42OTA0MTY2NywyMS40NzgwODMzIDMuMTA1NDE2NjcsMjAuODkzMDgzMyBDMi41MjA0MTY2NywyMC4zMDgwODMzIDIuNTIwNDE2NjcsMTkuMzU3MDgzMyAzLjEwNTQxNjY3LDE4Ljc3MjA4MzMgTDkuODc4MjUsMTEuOTk5MjUgTDMuMTA1NDE2NjcsNS4yMjY0MTY2NyBaIiBpZD0icGF0aC0xIj48L3BhdGg+CiAgICA8L2RlZnM+CiAgICA8ZyBpZD0iaWNvbnMtLy1jbG9zZSIgc3Ryb2tlPSJub25lIiBzdHJva2Utd2lkdGg9IjEiIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+CiAgICAgICAgPG1hc2sgaWQ9Im1hc2stMiIgZmlsbD0id2hpdGUiPgogICAgICAgICAgICA8dXNlIHhsaW5rOmhyZWY9IiNwYXRoLTEiPjwvdXNlPgogICAgICAgIDwvbWFzaz4KICAgICAgICA8dXNlIGlkPSJTaGFwZSIgZmlsbD0iIzAwMDAwMCIgb3BhY2l0eT0iMC4yOTk1NDg5MjEiIHhsaW5rOmhyZWY9IiNwYXRoLTEiPjwvdXNlPgogICAgPC9nPgo8L3N2Zz4=" alt=""></button>
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
    import storeProducts from '../store/modules/products';
    import {mapActions, mapGetters} from 'vuex';

    export default {
        beforeRouteEnter(to, from, next) {
            let products =  storeProducts.state.items;
            if (products.length > 0) {
                let prices = [];
                for (let i = 0; i < products.length; i++) {
                    let product_price  = parseInt(products[i].price) - parseInt(products[i].discount);
                    prices.push(product_price);
                }

                let minPrice = Math.min(...prices);
                let maxPrice = Math.max(...prices);
                next(vm => {
                    vm.changeTitle('ФИЛЬТР');
                    vm.slider.min = 0;
                    vm.slider.max = maxPrice;
                    vm.minRange = minPrice;
                    vm.maxRange = maxPrice;
                    vm.slider.startMin = minPrice;
                    vm.slider.startMax = maxPrice;
                });
            }
            else {
                next(vm =>  vm.changeTitle('ФИЛЬТР'));
            }
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
                filteredProducts: 'getFilteredItems',
                sliderMinRange: 'getSliderMinRange',
                sliderMaxRange: 'getSliderMaxRange',
                sliderStartMin: 'getSliderStartMin',
                sliderStartMax: 'getSliderStartMax',

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
            lowestPrice() {
                let prices = [];
                for (let i = 0; i < this.products.length; i++) {
                    let product_price  = this.products[i].price - this.products[i].discount;
                    prices.push(product_price);
                }

                return Math.min(...prices);

            },
            highestPrice() {
                let prices = [];
                for (let i = 0; i < this.products.length; i++) {
                    for (let i = 0; i < this.products.length; i++) {
                        let product_price  = this.products[i].price - this.products[i].discount;
                        prices.push(product_price);
                    }
                }
                return Math.max(...prices);
            },
            countSortedProducts() {
                return this.products.filter(item => {
                    let totalPrice = item.price - item.discount;
                    return (totalPrice >= parseInt(this.minRange) && totalPrice <= parseInt(this.maxRange));
                });
            },
        },
        methods: {
            ...mapActions('products', {
                changeSliderMinRange: 'changeMinRange',
                changeSliderMaxRange: 'changeMaxRange',
                changeSliderStartMax: 'changeStartMax',
                changeSliderStartMin: 'changeStartMin',
                addToFilteredProducts: 'addToFiltered',
                removeFromFilteredProducts: 'removeFromFiltered'
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
            }
        },

    }
</script>
<style scoped lang="scss">
    .vue-slider-component {
        padding: 0px;
    }
</style>
