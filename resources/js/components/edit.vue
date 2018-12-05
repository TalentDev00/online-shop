<template>
    <section class="settings-edit">
        <div class="items">
            <ul>
                <li v-for="(item, index) in info" :key="item.name + '_' + index">
                    <div class="wrapper-16">
                        <div class="inputfield">
                            <label class="inputfield__label" :for="'input_' + (index + 1)">{{ item.name }}</label>
                            <span v-if="errors.has(item.request_name)" class="inputfield__error">{{ errors.first(item.request_name) }}</span>
                            <input class="inputfield__input"
                                   :class="fieldHasError(item)"
                                   :id="'input_' + (index + 1)"
                                   :name="item.request_name"
                                   :type="item.type"
                                   :placeholder="item.placeholder"
                                   v-validate="item.rules"
                                   data-vv-delay="1000"
                                   v-model="item.value"
                            >
                        </div>
                    </div>
                </li>
                <li>
                    <div class="wrapper-16">
                        <div class="inputfield">
                            <div v-for="(pwd, index) in pwd_reset" :key="pwd.name + '_' + index">
                                <label v-if="index === 0" class="inputfield__label" :for="'pwd_input_' + (index + 1)">Сменить пароль</label>
                                <span v-if="errors.has(pwd.request_name)" class="inputfield__error">{{ errors.first(pwd.request_name) }}</span>
                                <input
                                       class="inputfield__input"
                                       :class="fieldHasError(pwd)"
                                       :id="'pwd_input_' + (index + 1)"
                                       :name="pwd.request_name"
                                       :type="pwd.type"
                                       :placeholder="pwd.placeholder"
                                       v-validate="pwd.rules"
                                       data-vv-delay="1000"
                                       v-model="pwd.value"
                                >
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            <button class="btn btn__fixed"
                    @click="saveValues()"
                    :disabled="errors.items.length !== 0"
            >сохранить</button>
        </div>
    </section>
</template>
<script>
    import {mapGetters} from 'vuex';
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
                user: '',
                info: [
                    {
                        name: 'Имя',
                        request_name: 'name',
                        value: this.$auth.user().name,
                        type: 'text',
                        placeholder: 'введите имя',
                        rules: 'alpha_spaces|max:255',
                    },
                    {
                        name: 'Почта',
                        request_name: 'email',
                        value: this.$auth.user().email,
                        type: 'email',
                        placeholder: 'введите e-mail',
                        rules: 'required|email',
                    },
                    {
                        name: 'Телефон',
                        request_name: 'phone',
                        value: this.$auth.user().phone,
                        type: 'tel',
                        placeholder: 'введите телефон',
                        rules: { regex: /^[0-9-_+)(\s]{7,30}$/ },
                    },
                    {
                        name: 'Адрес доставки',
                        request_name: 'address',
                        value: this.$auth.user().address,
                        type: 'text',
                        placeholder: 'введите индекс, город, улица, дом, квартира...',
                        rules: 'max:255',
                    },

                ],
                pwd_reset: [
                    {
                        value: '',
                        request_name: 'new_password',
                        placeholder: 'введите новый пароль',
                        type: 'password',
                        rules: 'min:6|max:255'
                    },
                    {
                        value: '',
                        request_name: 'confirm_password',
                        placeholder: 'повторите новый пароль',
                        type: 'password',
                        rules: 'confirmed:new_password'
                    }
                ]
            }
        },
        computed: {
            ...mapGetters('user', {
                backErrors: 'getErrors'
            }),
            fieldHasError() {
                return (item) => this.errors.items.find(elem => elem.field === item.request_name)
                                ? 'inputfield__input-error'
                                : 'inputfield__input-success';
            },
        },
        methods: {
            ...mapActions('header', {
                changeTitle: 'setTitle'
            }),
            ...mapActions('user', {
                saveChanges: 'changeUserData',
                clearBackErrors: 'clearBackEndErrors'
            }),
            setData(data) {
                this.user = data;
            },
            saveValues() {
                this.clearBackErrors();
                this.saveChanges({
                    name: this.info[0].value,
                    email: this.info[1].value,
                    phone: this.info[2].value,
                    address: this.info[3].value,
                    password: this.pwd_reset[0].value,
                    confirm_password: this.pwd_reset[1].value
                });
            },
        }
    }
</script>
