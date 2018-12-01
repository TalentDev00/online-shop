import Vue from 'vue';
import {post as syncItems, gets as loadFavoriteItems,} from '../../api/index';

export default {
    namespaced: true,
    state: {
        items: [],
        syncStatus: null
    },
    getters: {
        allFavoriteItems(state) {
            return state.items;
        },
        countFavorites(state) {
            return state.items.length;
        },
        isFavoriteItem(state) {
            return (product) => state.items.find(elem => elem.id === product.id || elem.item_id === product.id);
        },

    },
    mutations: {
        changeSyncStatus(state, status) {
            state.syncStatus = status;
        },
        setFavoriteItems(state, items) {
            state.items = items;
        },
        clearFavoriteItems(state) {
            state.items = [];
        },
        pushItemToFavorite(state, product) {

            state.items.push(product)
        },
        spliceItemFromFavorites(state, index) {
            state.items.splice(index, 1);
        },
    },
    actions: {
        syncFavorite({commit, state}, items) {
            commit('changeSyncStatus', null);
            const savedFavoriteItems = [...state.items];
            let itemIds = [];
            items.forEach(item => {
                itemIds.push(item.id);
            });
            syncItems('/store/favorite', {
                    items: itemIds.length > 0 ? JSON.stringify(itemIds) : itemIds,
                    user_id: Vue.auth.user().id
                },
                () => {
                    commit('changeSyncStatus', 'success')
                },
                () => {
                    commit('changeSyncStatus', 'failed');
                    commit('setFavoriteItems', { items: savedFavoriteItems });
                }
            )
        },
        addOrRemoveFavorite({state, commit}, product) {
            syncItems('/store/favorite', {
                    item_id: product.id,
                    user_id: Vue.auth.user().id
                },
            );
            let found = state.items.find(item => item.id === product.id);
            let index = state.items.indexOf(found);
            if (index > -1) {
                commit('spliceItemFromFavorites', index)
            }
            else {
                commit('pushItemToFavorite', product);
            }
        },
        getFavoriteItems({commit, state, rootState}) {
            let options = {
                user_id: Vue.auth.user().id,
                sort: rootState.products.sort,
                min: rootState.products.minRange,
                max: rootState.products.maxRange,
            };
            loadFavoriteItems('/store/favorite', options, rootState.products.checked,
                (data) => {

                    commit('setFavoriteItems', data);
                },
                (error) => {
                    console.log(error)
                }
            );
        },
        setItems({commit, state}, data) {
            commit('setFavoriteItems', data);
        },
        clearItems({commit, state}) {
            commit('clearFavoriteItems');
        }
    }
}

