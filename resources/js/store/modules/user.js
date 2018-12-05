import {post as sendData} from '../../api';
import Vue from 'vue';
export default {
    namespaced: true,
    state: {
        user: {
            name: '',
            email: '',
            phone: '',
            address: '',
            password: '',
            confirm_password: ''
        },
        backEndErrors: []
    },
    getters: {
        getUser(state) {
            return state.user;
        },
        getErrors(state) {
            return state.backEndErrors;
        }
    },
    mutations: {
        setErrors(state, errors) {
            state.backEndErrors = errors;
        },
        clearErrors(state) {
            state.backEndErrors = [];
        },
        setUserName(state, name) {
            state.user.name = name;
        },
        setUserEmail(state, email) {
            state.user.email = email;
        },
        setUserPhone(state, phone) {
            state.user.phone = phone;
        },
        setUserAddress(state, address) {
            state.user.address = address;
        },
        setUserPassword(state, password) {
            state.user.password = password;
        },
        setUserConfirmPassword(state, confirm_password) {
            state.user.confirm_password = confirm_password;
        }
    },
    actions: {
        changeUserData({state, commit}, user) {
            commit('setUserName', user.name);
            commit('setUserEmail', user.email);
            commit('setUserPhone', user.phone);
            commit('setUserAddress', user.address);
            commit('setUserPassword', user.password);
            commit('setUserConfirmPassword', user.confirm_password);

            sendData(
                '/menu/settings',
                {
                    name: user.name,
                    email: user.email,
                    phone: user.phone,
                    address: user.address,
                    password: user.password,
                    confirm_password: user.confirm_password
                },
                () => {
                    Vue.auth.fetch({
                        params: {},
                        success: () => {
                            Vue.router.go(-1);
                        }
                    });
                },
                ({errors}) => {
                    commit('setErrors', errors)
                }
            );
        },
        clearBackEndErrors({commit, state}) {
            console.log(1);
            commit('clearErrors');
        }
    }
}
