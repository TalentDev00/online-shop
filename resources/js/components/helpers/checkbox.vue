<template>
    <div class="checkbox">
        <label class="checkbox__container">{{ name }}
            <input class="checkbox__container__input" type="checkbox"
                   :checked="value"
                   :filter="filter"
                   @change="updateValue($event)"
            >
            <span class="checkbox__container__checkmark"></span>
        </label>
    </div>
</template>
<script>
    export default {
        props: ['name', 'filter', 'value'],
        data() {
            return {

            }
        },
        computed: {

        },
        methods: {
            updateValue(e) {
                this.$emit('onchange', {
                    filter: this.filter,
                    name: this.name,
                    value: e.target.checked
                });
            }
        }
    }
</script>