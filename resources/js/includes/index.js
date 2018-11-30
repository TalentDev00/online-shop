import axios from 'axios';
export {
    scrollToTop
}

const scrollToTop = (scrollDuration) => {
    let scrollStep = -window.scrollY / (scrollDuration / 15),
        scrollInterval = setInterval(() => {
            if (window.scrollY !== 0) {
                window.scrollBy(0, scrollStep);
            }
            else clearInterval(scrollInterval);
        }, 15);
};

const getProducts = (cat_id, sort, min, max, filters, callback) => {
    let params = { cat_id, sort, min, max, filters };
    axios.get('/store/catalog', { params })
        .then(response => {
            callback(response.data);
        }).catch(error => {
        callback(error.response.data);
    });
};

const getResults = (keywords, sort, min, max, filters, callback) => {
    let params = { keywords, sort, min, max, filters };
    axios.get('/store/catalog', { params })
        .then(response => {
            callback(response.data);
        }).catch(error => {
        callback(error.response.data);
    });
};
