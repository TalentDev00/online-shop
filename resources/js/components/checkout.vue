<template>
    <section class="cart-checkout">
        <div class="items">
            <div class="payment">
                <div class="wrapper-16">
                    <h2 class="options">Оплата</h2>
                    <ul class="list payment">
                        <li class="list__item">
                            <div class="radiobutton">
                                <label class="radiobutton__container">Наличными
                                    <input class="radiobutton__container__input" type="radio" checked="checked" name="radio1">
                                    <span class="radiobutton__container__checkmark"></span>
                                </label>
                            </div>
                        </li>
                        <li class="list__item">
                            <div class="radiobutton">
                                <label class="radiobutton__container">Картой
                                    <input class="radiobutton__container__input" type="radio" name="radio1">
                                    <span class="radiobutton__container__checkmark"></span>
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="delivery">
                <div class="wrapper-16">
                    <h2 class="options">Доставка</h2>
                    <ul class="list delivery">
                        <li class="list__item">
                            <div class="radiobutton">
                                <label class="radiobutton__container">Курьером — 300 рублей
                                    <input class="radiobutton__container__input" type="radio" checked="checked" name="radio2">
                                    <span class="radiobutton__container__checkmark"></span>
                                </label>
                            </div>
                        </li>
                        <li class="list__item">
                            <div class="radiobutton">
                                <label class="radiobutton__container">Самовывоз — бесплатно
                                    <input class="radiobutton__container__input" type="radio" name="radio2">
                                    <span class="radiobutton__container__checkmark"></span>
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="address">
                <div class="wrapper-16">
                    <h2 class="options">Адрес доставки</h2>
                    <ul class="list address">
                        <li class="list__item">
                            <div class="inputfield">
                                <input value="111111, Москва, ул. Ленина, д.1, кв.1" class="inputfield__input" type="text" placeholder="индекс, город, улица, дом, квартира">
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="comment">
                <div class="wrapper-16">
                    <h2 class="options">Комментарий</h2>
                    <ul class="list comment">
                        <li class="list__item">
                            <div class="inputfield">
                                <input class="inputfield__input" type="text" placeholder="подъезд, номер домофона, ...">
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <button class="btn btn__fixed">заказать</button>
    </section>
</template>