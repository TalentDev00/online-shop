<template>
        <input :class="styleClasses"
               :type="type"
               :name="name"
               :placeholder="placeholder"
               :value="value"
               @input="updateValue($event)"
        >
</template>
<script>
    export default {
        props: ['value', 'type', 'name', 'placeholder', 'styleClasses'],
        data() {
            return {
            }
        },
        computed: {
        },
        methods: {
            updateValue(e) {
                this.$emit('oninput', e.target.value)
            }
        },
    }

</script>
<style scoped lang="scss">

</style>
