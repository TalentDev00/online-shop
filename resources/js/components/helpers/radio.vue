<template>
    <div class="radiobutton">
        <label class="radiobutton__container">{{ variant.name }}
            <input class="radiobutton__container__input" type="radio"
                   name="radio"
                   :checked="variant.value === sort"
                   :value="variant.value"
                   @change="update($event)"
            >
            <span class="radiobutton__container__checkmark"></span>
        </label>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex';
    export default {
        props:['variant'],
        computed: {
          ...mapGetters('products', {
              sort:'getSort'
          })
        },
        methods: {
            update(e) {
                this.$emit('onchange', e.target.value);
            }
        }
    }
</script>
