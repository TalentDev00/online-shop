import Vue from 'vue';

export default {
    namespaced: true,
    state: {
        items: [],
        sort: 'price_asc',
        checked: [],
        minRange: '',
        maxRange: '',
        slider: {
            startMin: '',
            startMax: '',
        }
    },
    getters: {
        getItems(state) {
            return state.items;
        },
        getSort(state) {
            return state.sort;
        },

        /*
        *
        * FILTER GETTERS
        *
        * */
        getChecked(state) {
            return state.checked;
        },
        getCheckedCount(state) {
            return state.checked.length;
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
    },
    mutations: {
        mutateCheckFilters(state, data) {
            let found = state.checked.find(item => item.filter === data.filter);

            if (found) {
                found.filter = data.filter;
                found.values = data.values;
            }

            else {
                state.checked.push({
                    filter: data.filter,
                    values: data.values
                });
            }
        },
        mutateClearItems(state) {
            state.items = [];
        },
        mutateLoadItems(state, data) {
            state.items = data;
        },
        mutateFavorite(state, product) {
            if (product.product === false) {
                Vue.set(product, 'product_favorite', true);
            } else {
                Vue.set(product, 'product_favorite', false);
            }
        },
        mutateProductCondition(state, obj) {
            let found = state.items.find(item => item.id === obj.product.id);
            if (found) {
                let foundCondition = found.product_conditions.find(item => item.name === obj.condition.name);

                if (foundCondition) {
                    foundCondition.selected = obj.selected;
                }
            }
        },
        mutateSort(state, value) {
            state.sort = value;
        },
        /*
        *
        * FILTER MUTATIONS
        *
        * */
        mutateClearCheckedParams(state, filter) {
            let found = state.checked.find(item => item.filter === filter.name);
            let index = state.checked.indexOf(found);

            if (index > -1) {
                state.checked.splice(index, 1);
            }
        },
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
    },
    actions: {

        like(store, product) {
            store.commit('mutateFavorite', product);
        },
        productConditionSelect(store, obj) {
            store.commit('mutateProductCondition', obj);
        },

        loadItems(store, data){
            store.commit('mutateLoadItems', data);
        },
        clearItems(store) {
            store.commit('mutateClearItems');
        },
        sortChange(store, value) {
            store.commit('mutateSort', value);
        },
        /*
        *
        * FILTER ACTIONS
        *
        * */
        clearCheckedParams(store, filter) {
            store.commit('mutateClearCheckedParams', filter);
        },
        checkFilter(store, data) {
            store.commit('mutateCheckFilters', data);
        },
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
    }
}
