<template>
    <section class="menu">
        <div class="wrapper-16">
            <div class="items">

                <ul class="list">
                    <li class="list__item">
                        <h2 class="username">user@site.com</h2>
                    </li>
                    <router-link tag="li" class="list__item" :to="{name: 'orders'}">
                        <a href="" class="list__item__name list__item__name-bold">Мои Заказы</a>
                    </router-link>
                    <router-link tag="li" class="list__item" :to="{name: 'settings'}">
                        <a href="" class="list__item__name list__item__name-bold">Настройки</a>
                    </router-link>
                    <router-link tag="li" :to="{name: 'about'}" class="list__item">
                        <a href="" class="list__item__name">О компании</a>
                    </router-link>
                    <router-link tag="li" :to="{name: 'delivery'}" class="list__item">
                        <a href="" class="list__item__name">Доставка и оплата</a>
                    </router-link>
                    <router-link tag="li" :to="{name: 'contacts'}" class="list__item">
                        <a href="" class="list__item__name">Контакты</a>
                    </router-link>
                </ul>
            </div>
        </div>
    </section>
</template>