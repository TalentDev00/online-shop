<template>
    <div class="search">
        <form class="search__form" :class="formPosition" action="">
            <input class="search__form__input" type="text" placeholder="поиск по каталогу"
                   :value="value"
                   :class="searchStyle"
                   v-delayed:input.300="updateValue"
            >
            <a v-show="!emptyInput" class="search__form__cancel" href=""
               @click.prevent="clearInput"
            >
                <img v-if="routeHasKeywords && value !== '' && value === $route.params.keywords" src="../../../images/icons/close_white.svg" alt="">
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
                if (this.$route.params.keywords && this.value === '')  {
                    this.$emit('onclear');
                }
            }
        },
        computed: {
            emptyInput() {
                return this.value == null || this.value === '' || this.value === ' ';
            },
            routeHasKeywords() {
                return this.$route.params.keywords;
            },
            formPosition() {
                return this.routeHasKeywords
                    && this.value !==''
                    && this.value === this.$route.params.keywords
                    ? 'search__form-fixed'
                    : 'search__form-static';
            },
            searchStyle() {
                return this.routeHasKeywords
                    && this.value !==''
                    && this.value === this.$route.params.keywords
                    ? 'search__form__input-green'
                    : 'search__form__input-gray';
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
