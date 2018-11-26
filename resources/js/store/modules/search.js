import axios from "axios";

export default {
    namespaced: true,
    state: {
        results: []
    },
    getters: {
        getResults(state) {
            return state.results;
        },
    },
    mutations: {
        mutateSetResults(state, data) {
            state.results = data;
        }
    },
    actions: {
        loadData(store, keywords) {
            axios.get('/search', { params: { keywords: keywords } })
                .then(response => {
                    store.commit('mutateSetResults', response.data);
                })
                .catch(error => console.log(error))
        }
    }
}
