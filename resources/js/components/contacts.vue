<template>
    <section class="contacts">
        <div class="section-img">
            <div class="img">
                <img src="../../images/contacts@3x.jpg" alt="">
            </div>
            <div class="wrapper-16">
                <div class="items">
                    <div class="item">
                        <h2>ООО &laquo;Еда в&nbsp;каждый рот&raquo;</h2>
                        <div class="socials">
                            <a class="socials__telegram" href=""><img src="../../images/social icons/telegram.svg" alt=""></a>
                            <a class="socials__whatsapp" href=""><img src="../../images/social icons/whatsapp.svg" alt=""></a>
                            <a class="socials__vkontakte" href=""><img src="../../images/social icons/vkontakte.svg" alt=""></a>
                            <a class="socials__facebook" href=""><img src="../../images/social icons/facebook.svg" alt=""></a>
                            <a class="socials__twitter" href=""><img src="../../images/social icons/twitter.svg" alt=""></a>
                            <a class="socials__instagram" href=""><img src="../../images/social icons/instagram.svg" alt=""></a>
                        </div>
                        <ul class="list">
                            <li class="list__item">
                                <div class="list__item__name">
                                    <div class="credentials">
                                        <p class="credentials__field">Телефон</p>
                                        <div>
                                            <a href="tel:79161234567" class="credentials__value">+7 916 123 45 67 <img src="../../images/icons/phone_blue.svg" alt=""></a>

                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list__item">
                                <div class="list__item__name">
                                    <div class="credentials">
                                        <p class="credentials__field">E-mail</p>
                                        <div>
                                            <a href="mailto:mail@site.com" class="credentials__value">mail@site.com <img src="../../images/icons/mail_blue.svg" alt=""></a>

                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list__item">
                                <div class="list__item__name">
                                    <div class="credentials">
                                        <p class="credentials__field">Юридический адрес</p>
                                        <p class="credentials__value">111111, Москва, ул. Ленина, д. 1, офис 1273</p>
                                    </div>
                                </div>
                            </li>
                            <li class="list__item">
                                <div class="list__item__name">
                                    <div class="credentials">
                                        <p class="credentials__field">Фактический адрес</p>
                                        <p class="credentials__value">111111, Москва, ул. Ленина, д. 1, офис 1273</p>
                                    </div>
                                </div>
                            </li>
                            <li class="list__item">
                                <div class="list__item__name">
                                    <div class="credentials">
                                        <p class="credentials__field">ОГРН</p>
                                        <p class="credentials__value">764857682562659</p>
                                    </div>
                                </div>
                            </li>
                            <li class="list__item">
                                <div class="list__item__name">
                                    <div class="credentials">
                                        <p class="credentials__field">ИНН</p>
                                        <p class="credentials__value">57645635723756</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
    import {mapActions} from 'vuex';

    export default {
        beforeRouteEnter(to, from, next) {
            next(vm => vm.changeTitle('КОНТАКТЫ'));
        },
        methods: {
            ...mapActions('header', {
                changeTitle: 'setTitle'
            })
        }
    }
</script>
