<template>
    <section class="sort-list">
        <div class="wrapper-16">
            <div class="items">
                <ul class="list">
                    <li class="list__item">
                        <div class="radiobutton">
                            <label class="radiobutton__container">Цена по возрастанию
                                <input class="radiobutton__container__input" type="radio" checked="checked" name="radio">
                                <span class="radiobutton__container__checkmark"></span>
                            </label>
                        </div>
                    </li>
                    <li class="list__item">
                        <div class="radiobutton">
                            <label class="radiobutton__container">Цена по убыванию
                                <input class="radiobutton__container__input" type="radio" checked="checked" name="radio">
                                <span class="radiobutton__container__checkmark"></span>
                            </label>
                        </div>
                    </li>
                    <li class="list__item">
                        <div class="radiobutton">
                            <label class="radiobutton__container">По рейтингу
                                <input class="radiobutton__container__input" type="radio" checked="checked" name="radio">
                                <span class="radiobutton__container__checkmark"></span>
                            </label>
                        </div>
                    </li>
                    <li class="list__item">
                        <div class="radiobutton">
                            <label class="radiobutton__container">По размеру скидки
                                <input class="radiobutton__container__input" type="radio" checked="checked" name="radio">
                                <span class="radiobutton__container__checkmark"></span>
                            </label>
                        </div>
                    </li>
                    <li class="list__item">
                        <div class="radiobutton">
                            <label class="radiobutton__container">Новинки
                                <input class="radiobutton__container__input" type="radio" checked="checked" name="radio">
                                <span class="radiobutton__container__checkmark"></span>
                            </label>
                        </div>
                    </li>
                    <li class="list__item">
                        <div class="radiobutton">
                            <label class="radiobutton__container">По умолчанию
                                <input class="radiobutton__container__input" type="radio" checked="checked" name="radio">
                                <span class="radiobutton__container__checkmark"></span>
                            </label>
                        </div>
                    </li>
                </ul>
            </div>
            <button class="btn">применить</button>
        </div>
    </section>
</template>
<script>
    export default {
        data() {
            return {

            }
        },
        computed: {

        },
        methods: {

        }
    }
</script>
