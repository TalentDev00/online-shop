<template>
    <div>
        <label :for="'slct_' + variant.name">{{ variant.name }}</label>
        <div class=select>
            <select class="select__slct"
                    :value="value"
                    :name="'slct_' + variant.name"
                    :id="'slct_' + variant.name"
                    @change="onSelect($event)"
            >

                <option v-for="(option, index) in variant.values" :key="index"
                        class="select__slct__opt"
                        :selected="variant.selected === option"
                        :value="option"
                >{{ option }}</option>
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
                    name: this.value,
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
