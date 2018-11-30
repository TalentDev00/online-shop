import axios from 'axios';

const post = (url, data, cb = null, errorCb = null) => {
    axios.post(url, data)
        .then(response => {
            cb !== null ? cb(response.data) : {}
        })
        .catch(error => {
            errorCb !== null ? errorCb(error.response.data) : console.log(error)
        })
};

const get = (url, params, cb = null, errorCb = null) => {
    axios.get(url, {params})
        .then(response => {
            cb !== null ? cb(response.data) : {}
        })
        .catch(error => {
            errorCb !== null ? errorCb(error.response.data) : console.log(error)
        })
};

const gets = (url, options, filters = null, cb = null, errorCb = null) => {
    let params;
    if (filters !== null) {
        let newFilters = [];
        filters.forEach(item => {
            item.values.forEach(elem => {
                newFilters.push({
                    name: item.filter,
                    value: elem
                });
            })
        });
        let objFilters = {
            filters: newFilters.length > 0 ? JSON.stringify(newFilters) : newFilters
        };
        params = { ...options, ...objFilters};
    }
    else {
        params = options;
    }

    axios.get(url, {params})
        .then(response => {
            cb !== null ? cb(response.data) : {}
        })
        .catch(error => {
            errorCb !== null ? errorCb(error.response.data) : console.log(error)
        })
};

export {
    post,
    get,
    gets
}
