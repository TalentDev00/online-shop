<template>
    <div>
        <label :for="'slct_' + variant.name">{{ variant.name }}</label>
        <div class=select>
            <select class="select__slct"
                    :value="value"
                    :name="'slct_' + variant.name"
                    :id="'slct_' + variant.name"
                    @input="onSelect($event)"
            >
                <option v-for="(name, index) in variant.values" :key="index"
                        class="select__slct__opt"
                        :selected="index == 0"
                        :value="name"
                >{{ name }}</option>
            </select>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['variant', 'value', 'product' ],
        methods: {
            onSelect(e) {
                this.$emit('onchange', {
                    product: this.product,
                    variant: this.variant,
                    selected: e.target.value
                });
            },
            console(name, index) {
                console.log(name);
                    console.log(index);
            }
        },
    }
</script>
