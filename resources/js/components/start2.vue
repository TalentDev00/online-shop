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
                                @click="switchTab()"
                        >Вход</button>
                        <button class="sign-up"
                                :class=" !showLogin ? 'active' : '' "
                                @click="switchTab()"
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
                                           :class="fieldHasError('email')"
                                           data-vv-delay="500"
                                           v-validate="'required|email'"
                                           v-model="email"
                                           @input="clearBackErrors('email')"
                                    >
                                    <span v-if="errors.has('email') || backErrors.email" class="validation-alert">{{ errors.first('email') ? errors.first('email') : backErrors.email[0] }}</span>
                                    <input type="password" placeholder="пароль" name="password"
                                           :class="fieldHasError('password')"
                                           data-vv-delay="500"
                                           v-validate="'required|min:6'"
                                           v-model="password"
                                           @input="clearBackErrors('password')"
                                    >
                                    <span v-if="errors.has('password') || backErrors.password" class="validation-alert">{{ errors.first('password') ? errors.first('password') : backErrors.password[0] }}</span>
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
                                           :class="fieldHasError('email')"
                                           data-vv-delay="500"
                                           v-validate="'required|email'"
                                           v-model="email"
                                           @input="clearBackErrors('email')"
                                    >
                                    <span v-if="errors.has('email') || backErrors.email" class="validation-alert">{{ errors.first('email') ? errors.first('email') : backErrors.email[0]  }}</span>
                                    <input type="password" placeholder="пароль" name="password"
                                           :class="fieldHasError('password')"
                                           data-vv-delay="500"
                                           v-validate="'required|min:6'"
                                           v-model="password"
                                           @input="clearBackErrors('password')"
                                    >
                                    <span v-if="errors.has('password') || backErrors.password" class="validation-alert">{{ errors.first('password') ? errors.first('password') : backErrors.password[0] }}</span>
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
    import {mapGetters} from 'vuex';
    import {mapActions} from 'vuex';

    export default {
        name: 'app',
        components: {
        },
        beforeRouteEnter(to, from, next) {
            next(vm => {
                if (vm.$auth.check()) {
                    vm.loadFavorites(vm.$auth.user().favorites);
                    vm.loadCart(vm.$auth.user().cart.cart_items)
                }
            });
        },
        data(){
            return {
                showLogin: true,
                email: '',
                password: '',
                success: false,
                error: false,
                backErrors: {}
            }
        },
        computed: {
            ...mapGetters('favorites', {
                favoriteItems: 'allFavoriteItems',
            }),
            isFormDirty() {
                return Object.keys(this.fields).some(key => this.fields[key].dirty);
            },
            fieldHasError() {
                return (item) => this.errors.items.find(elem => elem.field === item) || Object.keys(this.backErrors).some(key => key === item)
                    ? 'border-alert'
                    : 'border-success';
            },
        },
        methods: {
            ...mapActions('favorites', {
                loadFavorites: 'setItems'
            }),
            ...mapActions('cart', {
                loadCart: 'setCartItems'
            }),
            clearBackErrors(fieldName) {
                if (Object.keys(this.backErrors).some(key => key === fieldName)) {
                    Object.keys(this.backErrors).forEach(item => {
                        if (item === fieldName) {
                            delete this.backErrors[item]
                        }
                    })
                }
            },
            login() {
                this.$auth.login({
                    params: {
                        email: this.email,
                        password: this.password
                    },
                    success: () => {
                        this.loadFavorites(this.$auth.user().favorites);
                        this.loadCart(this.$auth.user().cart.cart_items)
                    },
                    error: (res) => {
                        this.error = true;
                        this.backErrors = res.response.data.errors;
                    },
                    fetchUser: true,
                });
            },
            register() {
                this.$auth.register({
                    data: {
                        email: this.email,
                        password: this.password
                    },
                    success: () => {
                        this.success = true;
                    },
                    error: (resp) => {
                        this.error = true;
                        this.backErrors = resp.response.data.errors;
                    },
                    autoLogin: true,
                    rememberMe: true,
                    redirect: {path: '/start3'}
                });
            },
            switchTab() {
                this.showLogin = !this.showLogin;
                this.email = '';
                this.password = '';
                this.$validator.reset();
                this.$validator.errors.remove();
            }
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
