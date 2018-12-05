import axios from 'axios';
export {
    scrollToTop,
    wordEnds
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

function wordEnds(number, variant1, variant2, variant3){

    let h1 = number % 10;
    let h2 = number % 100;
    let result;

    if (h2 >= 5 && h2 <= 20) {
        result = variant1;
    }

    else if (h1 === 1) {
        result = variant2;
    }

    else if (h1 >= 2 && h1 <= 4) {
        result = variant3;
    }

    else {
        result = variant1;
    }

    return result;
}
