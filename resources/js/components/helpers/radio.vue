<template>
    <div class="radiobutton">
        <label class="radiobutton__container">{{ label }}
            <input class="radiobutton__container__input" type="radio"
                   :name="name"
                   :checked="checked(value)"
                   :value="value"
                   @change="update($event)"
            >
            <span class="radiobutton__container__checkmark"></span>
        </label>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex';
    export default {
        props:['label', 'index', 'name', 'value'],
        data() {
            return {
            }
        },
        computed: {
            ...mapGetters('products', {
                  sort:'getSort'
            }),
            ...mapGetters('cart', {
                paymentMethod: 'getPaymentMethod',
                deliveryMethod: 'getDeliveryMethod',
            }),
            checked() {
                return (value) => this.routeSort
                    ? this.sort === value
                    : this.paymentMethod === value || this.deliveryMethod === value;
            },
            routeSort() {
                return this.$route.name === 'sort'
            }

        },
        methods: {
            update(e) {
                this.$emit('onchange', e.target.value);
            }
        }
    }
</script>
