<template>
    <div class="checkbox">
        <label class="checkbox__container">{{ name }}
            <input class="checkbox__container__input" type="checkbox"
                   :value="value"
                   :name="name"
                   @change="updateValue($event)"
            >
            <span class="checkbox__container__checkmark"></span>
        </label>
    </div>
</template>
<script>
    export default {
        props: ['value', 'name', 'filter'],
        data() {
            return {
            }
        },
        computed: {

        },
        methods: {
            updateValue(e) {
                this.$emit('onchange', {
                    filter: this.filter.name,
                    name: this.name,
                    value: e.target.checked
                });
            }
        }
    }
</script>
