<template>
    <section class="settings-edit">
        <div class="items">
            <ul>
                <li>
                    <div class="wrapper-16">
                        <div class="inputfield">
                            <label class="inputfield__label" for="input_1">Имя</label>
                            <input id="input_1" value="Иван Иванович" class="inputfield__input" type="text" placeholder="введите имя">
                        </div>
                    </div>
                </li>
                <li>
                    <div class="wrapper-16">
                        <div class="inputfield">
                            <label class="inputfield__label" for="input_2">Почта</label>
                            <input id="input_2" value="mail@site.com" class="inputfield__input" type="email" placeholder="введите e-mail">
                        </div>
                    </div>
                </li>
                <li>
                    <div class="wrapper-16">
                        <div class="inputfield">
                            <label class="inputfield__label" for="input_3">Телефон</label>
                            <input id="input_3" value="+7 916 123 45 67" class="inputfield__input" type="tel" placeholder="введите телефон">
                        </div>
                    </div>
                </li>
                <li>
                    <div class="wrapper-16">
                        <div class="inputfield">
                            <label class="inputfield__label" for="input_4">Адрес доставки</label>
                            <input id="input_4" value="111111, Москва, ул. Ленина, д.1, кв.1" class="inputfield__input" type="text" placeholder="введите индекс, город, улица, дом, квартира...">
                        </div>
                    </div>
                </li>
                <li>
                    <div class="wrapper-16">
                        <div class="inputfield">
                            <label class="inputfield__label" for="input_5">Сменить пароль</label>
                            <input id="input_5" class="inputfield__input" type="password" placeholder="введите новый пароль">
                            <input id="input_6" class="inputfield__input" type="password" placeholder="повторите новый пароль">
                        </div>
                    </div>
                </li>
            </ul>
            <button class="btn btn__fixed">сохранить</button>
        </div>
    </section>
</template>