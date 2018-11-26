<template>
    <div class="search">
        <form class="search__form" :class="formClass" action="">
            <input class="search__form__input" type="text" placeholder="поиск по каталогу"
                   :value="value"
                   :class="inputClass"
                   v-delayed:input.300="updateValue"
            >
            <a v-show="!emptyInput" class="search__form__cancel" href=""
               @click.prevent="clearInput"
            >
                <img v-if="$route.name === 'result'" src="../../../images/icons/close_white.svg" alt="">
                <img v-else src="../../../images/icons/close.svg" alt="">

            </a>
        </form>
    </div>
</template>
<script>
    import {mapActions} from 'vuex';
    export default {
        props: ['value', 'inputClass', 'formClass'],
        data() {
            return {
            }
        },
        watch: {
            value(after, before) {
                this.results(this.value);
            }
        },
        computed: {
            emptyInput() {
                return this.value == null || this.value === '' || this.value === ' ';
            }
        },
        methods: {
            ...mapActions('search', {
                results: 'loadData'
            }),
            updateValue(e) {
                this.$emit('onchange', e.target.value);
            },
            clearInput() {
                this.$emit('onclear');
            }
        }
    }
</script>
