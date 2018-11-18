<template>
    <section class="filtration">
        <div class="wrapper-16">
            <div class="items">
                <ul class="list">
                    <li v-for="(filter, index) in allFilters" :ket="index"
                        class="list__item">
                        <router-link tag="a" :to="'/filter/' + filter.id + '/parameters'">
                            <div class="item-wrapper">
                                <div class="name-wrapper">
                                    <span class="list__item__name">{{ filter.name }}</span>
                                    <span v-show="filter.selected.length > 0" class="list__item__filtercounter">{{ filter.selected.length }}</span>
                                </div>
                                <button v-show="filter.selected.length > 0"
                                        @click.prevent="clearSelectedParams(filter)"
                                        class="list__item__close list__item__close-active"
                                ><img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyB3aWR0aD0iMjRweCIgaGVpZ2h0PSIyNHB4IiB2aWV3Qm94PSIwIDAgMjQgMjQiIHZlcnNpb249IjEuMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+CiAgICA8IS0tIEdlbmVyYXRvcjogU2tldGNoIDUyLjIgKDY3MTQ1KSAtIGh0dHA6Ly93d3cuYm9oZW1pYW5jb2RpbmcuY29tL3NrZXRjaCAtLT4KICAgIDx0aXRsZT5pY29ucyAvIGNsb3NlPC90aXRsZT4KICAgIDxkZXNjPkNyZWF0ZWQgd2l0aCBTa2V0Y2guPC9kZXNjPgogICAgPGRlZnM+CiAgICAgICAgPHBhdGggZD0iTTMuMTA1NDE2NjcsNS4yMjY0MTY2NyBDMi41MjA0MTY2Nyw0LjY0MTQxNjY3IDIuNTIwNDE2NjcsMy42OTA0MTY2NyAzLjEwNTQxNjY3LDMuMTA1NDE2NjcgQzMuNjkwNDE2NjcsMi41MjA0MTY2NyA0LjY0MTQxNjY3LDIuNTIwNDE2NjcgNS4yMjY0MTY2NywzLjEwNTQxNjY3IEwxMS45OTkyNSw5Ljg3ODI1IEwxOC43NzIwODMzLDMuMTA1NDE2NjcgQzE5LjM1NzA4MzMsMi41MjA0MTY2NyAyMC4zMDgwODMzLDIuNTIwNDE2NjcgMjAuODkzMDgzMywzLjEwNTQxNjY3IEMyMS40NzgwODMzLDMuNjkwNDE2NjcgMjEuNDc4MDgzMyw0LjY0MTQxNjY3IDIwLjg5MzA4MzMsNS4yMjY0MTY2NyBMMTQuMTIwMjUsMTEuOTk5MjUgTDIwLjg5MzA4MzMsMTguNzcyMDgzMyBDMjEuNDc4MDgzMywxOS4zNTcwODMzIDIxLjQ3ODA4MzMsMjAuMzA4MDgzMyAyMC44OTMwODMzLDIwLjg5MzA4MzMgQzIwLjMwODA4MzMsMjEuNDc4MDgzMyAxOS4zNTcwODMzLDIxLjQ3ODA4MzMgMTguNzcyMDgzMywyMC44OTMwODMzIEwxMS45OTkyNSwxNC4xMjAyNSBMNS4yMjY0MTY2NywyMC44OTMwODMzIEM0LjY0MTQxNjY3LDIxLjQ3ODA4MzMgMy42OTA0MTY2NywyMS40NzgwODMzIDMuMTA1NDE2NjcsMjAuODkzMDgzMyBDMi41MjA0MTY2NywyMC4zMDgwODMzIDIuNTIwNDE2NjcsMTkuMzU3MDgzMyAzLjEwNTQxNjY3LDE4Ljc3MjA4MzMgTDkuODc4MjUsMTEuOTk5MjUgTDMuMTA1NDE2NjcsNS4yMjY0MTY2NyBaIiBpZD0icGF0aC0xIj48L3BhdGg+CiAgICA8L2RlZnM+CiAgICA8ZyBpZD0iaWNvbnMtLy1jbG9zZSIgc3Ryb2tlPSJub25lIiBzdHJva2Utd2lkdGg9IjEiIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+CiAgICAgICAgPG1hc2sgaWQ9Im1hc2stMiIgZmlsbD0id2hpdGUiPgogICAgICAgICAgICA8dXNlIHhsaW5rOmhyZWY9IiNwYXRoLTEiPjwvdXNlPgogICAgICAgIDwvbWFzaz4KICAgICAgICA8dXNlIGlkPSJTaGFwZSIgZmlsbD0iIzAwMDAwMCIgb3BhY2l0eT0iMC4yOTk1NDg5MjEiIHhsaW5rOmhyZWY9IiNwYXRoLTEiPjwvdXNlPgogICAgPC9nPgo8L3N2Zz4=" alt=""></button>
                            </div>
                        </router-link>
                    </li>
                    <li class="list__item">
                        <div class="price-filter list__item__name">
                            <p class="price-count"><span>Цена от</span><input class="from" v-model="sliderMinRange" @change="updateSlider"><span>до </span> <input class="from" v-model="sliderMaxRange" @change="updateSlider"><span> руб.</span> </p>
                            <div id="slider" ref="slider"></div>
                        </div>
                    </li>

                </ul>
            </div>
            <div class="filter-actions">
                <p class="product-found">
                    Отобрано {{ allSortedItems.length }} товаров из {{ allProducts.length }}
                </p>
                <div class="action-buttons">
                    <button class="btn clear">очистить</button>
                    <button class="btn show">показать</button>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
    import Vue from 'vue';
    import {mapGetters} from 'vuex';
    import {mapActions} from 'vuex';
    export default {
        components: {
        },
        created() {
         /*   this.$http.get('anystore_filters.php')
                .then(response => response.json())
                .then(data => {
                    this.filters = data;
                    Vue.nextTick(function(){
                        this.installSlider();
                    }.bind(this))
                }).catch((err)=>{
                if(err) console.log(err)
            })*/
            if (this.loadProducts.length === 0) {
                this.loadProducts();
            }
            if (this.allFilters.length === 0) {
                this.loadFilters();

            }
            this.changeSliderMin(this.lowestPrice);
            this.changeSliderMax(this.highestPrice);
            Vue.nextTick(function() {
                this.installSlider();
            }.bind(this));


        },

        data() {
            return {
                sorted: [],


            }
        },
        computed: {
            ...mapGetters('filters', {
                allFilters: 'getFilterItems',
                allSortedItems: 'getSortedItems',
                sliderMinRange: 'getSliderMinRange',
                sliderMaxRange: 'getSliderMaxRange',
                sliderStartMin: 'getSliderStartMin',
                sliderStartMax: 'getSliderStartMax',
                sliderMin: 'getSliderMin',
                sliderMax: 'getSliderMax',
                sliderStart: 'getSliderStart',
                sliderStep: 'getSliderStep'
            }),
            ...mapGetters('products', {
                allProducts: 'getItems',

            }),
            priceSort() {
                let sorted = [];
                for (let i = 0; i < this.allProducts.length; i++) {
                    if (this.allProducts[i].product_nodiscount) {
                        if ((this.allProducts[i].product_nodiscount >= parseFloat(this.sliderMinRange) && this.allProducts[i].product_nodiscount <= parseFloat(this.sliderMaxRange))) {
                            sorted.push(this.allProducts[i]);
                        }

                    }
                    else {
                        if ((this.allProducts[i].product_newprice >= parseFloat(this.sliderMinRange) && this.allProducts[i].product_newprice <= parseFloat(this.sliderMaxRange))) {
                            sorted.push(this.allProducts[i]);
                        }
                    }
                }
                this.setStoredItems(sorted);
                return this.allSortedItems;
            },
            lowestPrice() {
                let prices = [];
                for (let i = 0; i < this.allProducts.length; i++) {
                    if (this.allProducts[i].product_nodiscount) {
                        prices.push(this.allProducts[i].product_nodiscount);
                    }
                    else {
                        prices.push(this.allProducts[i].product_newprice)
                    }
                }
                return Math.min(...prices);
            },
            highestPrice() {
                let prices = [];
                for (let i = 0; i < this.allProducts.length; i++) {
                    if (this.allProducts[i].product_nodiscount) {
                        prices.push(this.allProducts[i].product_nodiscount);
                    }
                    else {
                        prices.push(this.allProducts[i].product_newprice)
                    }
                }
                return Math.max(...prices);
            },


        },
        methods: {
            ...mapActions('filters', {
                loadFilters: 'loadFilterItems',
                clearSelectedParams: 'clearSelected',
                setStoredItems: 'loadSortItems',
                addSortItem: 'addSortedItem',
                removeSortItem: 'removeSortedItem',
                changeSliderMinRange: 'changeMinRange',
                changeSliderMaxRange: 'changeMaxRange',
                changeSliderStartMax: 'changeStartMax',
                changeSliderStartMin: 'changeStartMin',
                changeSliderMin: 'changeMin',
                changeSliderMax: 'changeMax',
                changeSliderStart: 'changeStart',
                changeSliderStep: 'changeStep'
            }),
            ...mapActions('products', {
                loadProducts: 'loadItems',

            }),

            updateSlider() {
                this.$refs.slider.noUiSlider.set([this.sliderMinRange, this.sliderMaxRange]);
            },

            installSlider() {
                noUiSlider.create(this.$refs.slider, {
                    start: [this.sliderStartMin, this.sliderStartMax],
                    step: this.sliderStep,
                    connect: true,
                    range: {
                        'min': this.sliderMin,
                        'max': this.sliderMax
                    },
                    format: wNumb({
                        decimals: 0,
                        thousand: '',
                    })

                });

                /*this.$refs.slider.noUiSlider.on('update', function (values, handle) {
                    document.querySelector('.from').innerHTML = values[0];
                    document.querySelector('.to').innerHTML = values[1];
                });*/

                this.$refs.slider.noUiSlider.on('update',(values, handle) => {
                    //this[handle ? this.sliderMaxRange : this.sliderMinRange] = values[handle];
                    this.priceSort;
                    this.changeSliderMinRange(values[0]);
                    this.changeSliderMaxRange(values[1]);
                    this.changeSliderStartMin(values[0]);
                    this.changeSliderStartMax(values[1]);
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
