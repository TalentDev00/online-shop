<template>
    <section class="settings">
        <div class="wrapper-16">
            <div class="items">
                <ul class="list">
                    <li class="list__item">
                        <div class="list__item__name">
                            <div class="credentials">
                                <p class="credentials__field">Имя</p>
                                <p class="credentials__value">{{ user.name ? user.name : 'не указано' }}</p>
                            </div>
                        </div>
                    </li>
                    <li class="list__item">
                        <div class="list__item__name">
                            <div class="credentials">
                                <p class="credentials__field">Почта</p>
                                <p class="credentials__value">{{ user.email }}</p>
                            </div>
                        </div>
                    </li>
                    <li class="list__item">
                        <div class="list__item__name">
                            <div class="credentials">
                                <p class="credentials__field">Телефон</p>
                                <p class="credentials__value">{{ user.phone ? user.phone : 'не указан'}}</p>
                            </div>
                        </div>
                    </li>
                    <li class="list__item">
                        <div class="list__item__name">
                            <div class="credentials">
                                <p class="credentials__field">Адрес доставки</p>
                                <p class="credentials__value">{{ user.address ? user.address : 'не указан' }}</p>
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
<script>
    import {mapActions} from 'vuex';

    export default {
        beforeRouteEnter(to, from, next) {
            next(vm => {
                vm.changeTitle('НАСТРОЙКИ');
                vm.setData(vm.$auth.user());
            });
        },
        data() {
            return {
                user: ''
            }
        },
        methods: {
            ...mapActions('header', {
                changeTitle: 'setTitle'
            }),
            setData(data) {
                this.user = data;
            }
        }
    }
</script>
