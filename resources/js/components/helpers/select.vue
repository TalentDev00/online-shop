<template>
    <div>
        <label :for="'slct_' + variant.name">{{ variant.name }}</label>
        <div class=select>
            <select class="select__slct"
                    :value="value"
                    :name="'slct_' + variant.name"
                    :id="'slct_' + variant.name"
                    v-model="selected"
                    @change="onSelect($event)"
            >
                <option v-for="(option, index) in variant.values" :key="index"
                        class="select__slct__opt"
                        :value="option"
                >{{ option }}</option>
            </select>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['variant', 'value', 'product' ],
        data() {
            return {
                selected: this.variant.selected ? this.variant.selected : this.variant.values[0]
            }
        },
        methods: {
            onSelect(e) {
                this.$emit('onchange', {
                    product: this.product,
                    variant: this.variant,
                    value: e.target.value
                });
            },
            console(name, index) {
                console.log(name);
                    console.log(index);
            },
        },
        computed: {
            indexVal() {
                return (index) => index === 0;
            }
        }
    }
</script>
