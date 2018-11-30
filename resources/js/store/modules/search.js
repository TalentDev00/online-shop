import axios from "axios";

export default {
    namespaced: true,
    state: {
        results: [],
        searchKeywords: null,
    },
    getters: {
        getResults(state) {
            return state.results;
        },
        getKeywords(state) {
            return state.searchKeywords;
        }
    },
    mutations: {
        mutateSetResults(state, data) {
            state.results = data;
        },
        mutateSearchKeywords(state, keywords) {
            state.searchKeywords = keywords;
        }
    },
    actions: {
        loadData(store, keywords) {
            axios.get('/search', { params: { keywords: keywords } })
                .then(response => {
                    store.commit('mutateSetResults', response.data);
                })
                .catch(error => console.log(error))
        },
        syncKeywords(store, keywords) {
            store.commit('mutateSearchKeywords', keywords);
        }
    }
}
