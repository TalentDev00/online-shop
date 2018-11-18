import Vue from 'vue';
import axios from "axios";

export default {
    namespaced: true,
    state: {
        filterItems: [],
        sortedItems: [],
        minRange: '',
        maxRange: '',
        slider: {
            startMin: 700,
            startMax: 5700,
            min: 0,
            max: 5700,
            start: 40,
            step: 50
        }
    },
    getters: {
        getFilterItems(state) {
            return state.filterItems;
        },
        /*
        * Sort Getters
        * */
        getSortedItems(state) {
            return state.sortedItems;
        },
        getSliderMinRange(state) {
            return state.minRange;
        },
        getSliderMaxRange(state) {
            return state.maxRange;
        },
        getSliderStartMin(state) {
            return state.slider.startMin;
        },
        getSliderStartMax(state) {
            return state.slider.startMax;
        },
        getSliderMin(state) {
            return state.slider.min;
        },
        getSliderMax(state) {
            return state.slider.max;
        },
        getSliderStart(state) {
            return state.slider.start;
        },
        getSliderStep(state) {
            return state.slider.step;
        }

    },
    mutations: {
        mutateClearFilterItems(state) {
            state.filterItems = [];
        },
        mutateLoadFilterItems(state, data) {
            state.filterItems = data;
        },
        mutateCheckFilter(state, obj) {
            let found = state.filterItems.find(item => item.id === obj.filter.id);

            if (found) {
                let variant = found.variants.find(item => item.name === obj.name) ;

                if (variant) {

                    variant.value = obj.value;
                    let check = found.selected.find(item => item.name === variant.name && variant.value === false);
                    let index = found.selected.indexOf(check);
                    if (check) {
                        found.selected.splice(index, 1);
                    }

                    else {
                        found.selected.push(variant);
                    }
                }
            }
        },
        mutateClearSelectedVariants(state, filter) {
            let found = state.filterItems.find(item => item.id === filter.id);
            if (found) {
                for(let i = 0; i < found.selected.length; i++) {
                    found.selected[i].value = false;
                }
                found.selected = [];
            }
        },
        /*
        * Filter Sort Mutations
        * */
        mutateClearSortedItems(state) {
            state.sortedItems = [];
        },
        mutateLoadSortedItems(state, data) {
            state.sortedItems = data;
        },
        mutateAddSortedItem(state, item) {
            state.sortedItems.push(item);
        },
        mutateRemoveSortedItem(state, item) {
            let index = state.sortedItems.indexOf(item);

            if (index > -1) {
                state.sortedItems.splice(index, 1);
            }
        },
        /*
        * Slider Mutations
        * */
        mutateMinRange(state, value) {
            state.minRange = value;
        },
        mutateMaxRange(state, value) {
            state.maxRange = value;
        },
        mutateStartMin(state, value) {
            state.slider.startMin = value;
        },
        mutateStartMax(state, value) {
            state.slider.startMax = value;
        },
        mutateMin(state, value) {
            state.slider.min = value;
        },
        mutateMax(state, value) {
            state.slider.max = value;
        },
        mutateStart(state, value) {
            state.slider.start = value;
        },
        mutateStep(state, value) {
            state.slider.step = value;
        }



    },
    actions: {
        loadFilterItems(store) {

            //store.commit('mutateClearFilterItems');

           /* Vue.http.get('anystore_filters.php')
                .then(response => response.json())
                .then(data => {
                    store.commit('mutateLoadFilterItems', data);
                });*/
            axios.get('http://localhost/api/anystore_filters.php')
                .then(({ data }) => {
                    store.commit('mutateLoadFilterItems', data);
                }).catch(error => {
                console.log(error)
            })
        },
        checkFilter(store, obj) {
            store.commit('mutateCheckFilter', obj);
        },
        clearSelected(store, filter) {
            store.commit('mutateClearSelectedVariants', filter);
        },
        /*
        * Filter Sort Actions
        * */
        loadSortItems(store, data) {
            store.commit('mutateClearSortedItems');
            store.commit('mutateLoadSortedItems', data);
        },
        addSortedItem(store, item) {

            store.commit('mutateAddSortedItem', item);
        },
        removeSortedItem(store, item) {
            store.commit('mutateRemoveSortedItem', item);
        },
        /*
        * Slider Actions
        * */
        changeMinRange(store, value) {
            store.commit('mutateMinRange', value);
        },
        changeMaxRange(store, value) {
            store.commit('mutateMaxRange', value);
        },
        changeStartMax(store, value) {
            store.commit('mutateStartMax', value);
        },
        changeStartMin(store, value) {
            store.commit('mutateStartMin', value);
        },
        changeMin(store, value) {
            store.commit('mutateMin', value);
        },
        changeMax(store, value) {
            store.commit('mutateMax', value);
        },
        changeStart(store, value) {
            store.commit('mutateStart', value);
        },
        changeStep(store, value) {
            store.commit('mutateStep', value);
        }

    }
}
