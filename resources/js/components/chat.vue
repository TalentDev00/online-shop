<template>
    <section class="connects">
        <div class="wrapper-16">
            <div class="items">
                <div class="call-us">
                    <p class="product-found">Звоните в&nbsp;рабочее время: 09.00&nbsp;- 18.00</p>
                    <a href="tel:+42352345346" class="btn">
                        <img src="../../images/icons/phone_white.svg" alt="">
                        <span>Позвонить!</span>
                    </a>
                </div>
                <div class="chatman"><img src="../../images/chatman.svg" alt=""></div>
                <div class="write-us">
                    <p class="product-found">Пишите в чат в любое время!</p>
                    <div class="social-btns">
                        <a class="btn" href=""><img src="../../images/social icons/telegram.svg" alt=""><span>Telegram</span></a>
                        <a class="btn" href=""><img src="../../images/social icons/whatsapp.svg" alt=""><span>WhatsApp</span></a>
                        <a class="btn" href=""><img src="../../images/social icons/facebook.svg" alt=""><span>Facebook</span></a>
                        <a class="btn" href=""><img src="../../images/social icons/vkontakte.svg" alt=""><span>Vkontakte</span></a>
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
            next(vm => vm.changeTitle('МЫ ВСЕГДА НА СВЯЗИ!'));
        },
        methods: {
            ...mapActions('header', {
                changeTitle: 'setTitle'
            })
        }
    }
</script>
