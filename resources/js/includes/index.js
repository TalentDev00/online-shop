export {
    scrollToTop,
    wordEnds,
    debounce
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

const wordEnds = (number, variant1, variant2, variant3) => {
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
};

const debounce = (fn, delay = 300) => {
    let timeoutID = null;

    return function () {
        clearTimeout(timeoutID);

        let args = arguments;
        let that = this;

        timeoutID = setTimeout(function () {
            fn.apply(that, args);
        }, delay);
    }
};
