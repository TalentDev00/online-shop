<template>
        <input class="promocode__item promocode__input"
               :type="type"
               :name="name"
               :placeholder="placeholder"
               :value="value"
               @input="updateValue($event)"
        >
</template>
<script>
    export default {
        props: ['type', 'name', 'placeholder', 'value'],
        data() {
            return {

            }
        },
        computed: {

        },
        methods: {
            updateValue(e) {
                this.$emit('changeValue', e.target.value);
            }
        },
        watch: {

        }
    }

</script>
