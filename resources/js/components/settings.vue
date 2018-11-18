<template>
    <section class="settings">
        <div class="wrapper-16">
            <div class="items">
                <ul class="list">
                    <li class="list__item">
                        <div class="list__item__name">
                            <div class="credentials">
                                <p class="credentials__field">Имя</p>
                                <p class="credentials__value">Иван Иванович</p>
                            </div>
                        </div>
                    </li>
                    <li class="list__item">
                        <div class="list__item__name">
                            <div class="credentials">
                                <p class="credentials__field">Почта</p>
                                <p class="credentials__value">mail@site.com</p>
                            </div>
                        </div>
                    </li>
                    <li class="list__item">
                        <div class="list__item__name">
                            <div class="credentials">
                                <p class="credentials__field">Телефон</p>
                                <p class="credentials__value">+7 916 123 45 67</p>
                            </div>
                        </div>
                    </li>
                    <li class="list__item">
                        <div class="list__item__name">
                            <div class="credentials">
                                <p class="credentials__field">Адрес доставки</p>
                                <p class="credentials__value">111111, Москва, ул. Ленина, д. 1, кв. 1</p>
                            </div>
                        </div>
                    </li>
                    <router-link tag="li" :to="{name: 'edit'}" class="list__item">
                        <a href="" class="list__item__name">Сменить пароль</a>
                    </router-link>
                </ul>
            </div>
        </div>
    </section>
</template>