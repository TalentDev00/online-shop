<template>
    <section class="start2">
        <div class="wrapper">
            <div class="items">
                <p class="greetings">
                    Авторизуйтесь, используя ваш аккаунт на&nbsp;нашем сайте или зарегистрируйтесь, чтобы добавлять в&nbsp;избранное, отслеживать заказы!
                </p>
                <div class="auth">
                    <div class="tabs">
                        <button class="sign-in"
                                :class=" showLogin ? 'active' : '' "
                                @click="showLogin = true"
                        >Вход</button>
                        <button class="sign-up"
                                :class=" !showLogin ? 'active' : '' "
                                @click="showLogin = false"
                        >Регистрация</button>

                    </div>
                    <div class="line">
                        <transition name="tab-login">
                            <div v-show="showLogin === true" class="line__left line__left-active"></div>
                        </transition>
                        <transition name="tab-register">
                            <div v-show="showLogin === false" class="line__right line__right-active"></div>
                        </transition>


                    </div>

                        <div class="form">
                            <transition name="form-login">
                                <form class="login" action="" method="post"
                                      v-show="showLogin === true"
                                >
                                    <input type="email" placeholder="e-mail" name="email"
                                           v-model="email"
                                    >
                                    <input type="password" placeholder="пароль" name="password"
                                           v-model="password"
                                    >
                                    <button class="submit"
                                            @click.prevent="login"
                                    >войти</button>
                                </form>
                            </transition>
                            <transition name="form-register">
                                <form class="login register" action="" method="post"
                                      v-show="showLogin === false"
                                >
                                    <input type="email" placeholder="e-mail" name="email"
                                           v-model="email"
                                    >
                                    <input type="password" placeholder="пароль" name="password"
                                           v-model="password"
                                    >
                                    <button class="submit"
                                            @click.prevent="register"
                                    >зарегистрироваться</button>
                                </form>
                            </transition>
                        </div>

                </div>
            </div>
        </div>
    </section>
</template>


<script>
    import axios from "axios";

    export default {
        name: 'app',
        components: {
        },
        data(){
            return {
                showLogin: true,
                email: '',
                password: '',
                success: false,
                error: false,
                errors: {}
            }
        },
        methods: {
            login() {
                this.$auth.login({
                    params: {
                        email: this.email,
                        password: this.password
                    },
                    success: function () {},
                    error: function () {},
                    fetchUser: true,
                });
            },
            register() {
                this.$auth.register({
                    data: {
                        email: this.email,
                        password: this.password
                    },
                    success: function() {
                        this.success = true;
                    },
                    error: function(resp) {
                        this.error = true;
                        this.errors = resp.response.data.errors;
                    },
                    autoLogin: true,
                    rememberMe: true,
                    redirect: {path: '/start3'}
                });
            }
        },
        computed: {
            ///

        }
    }
</script>

<style scoped lang="scss">

// tabs animation
    .tab-register-enter{
        transform: translateX(-100%);
        transition: all 0.4s;
    }
    .tab-register-enter-to{
        transform: translateX(0);
        transition: all 0.4s;
    }
    .tab-register-leave-to{
        opacity: 0;
        transform: translateX(-100%);
    }

    .tab-login-enter{
        transform: translateX(100%);
        transition: all 0.4s;
    }
    .tab-login-enter-to{
        transform: translateX(0);
        transition: all 0.4s;
    }
    .tab-login-leave-to{
        opacity: 0;
        transform: translateX(100%);
    }


// form animation
    .form-register-enter{
        transform: translateX(-100%);
        transition: all 0.4s;
    }
    .form-register-enter-to{
        transform: translateX(0);
        transition: all 0.4s;
    }
    .form-register-leave-to{
        opacity: 0;
        transform: translateX(-100%);
    }

    .form-login-enter{
        transform: translateX(100%);
        transition: all 0.4s;
    }
    .form-login-enter-to{
        transform: translateX(0);
        transition: all 0.4s;
    }
    .form-login-leave-to{
        opacity: 0;
        transform: translateX(100%);
    }



</style>
