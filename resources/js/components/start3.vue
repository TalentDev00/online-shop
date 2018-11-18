<template>
    <section class="start3">
        <div class="items">
            <h2 class="done">Готово!</h2>
            <div class="img">
                <img src="../../images/like_box@1x.svg" alt="">
            </div>
            <div class="buttons">
                <button class="btn btn-stock"
                        @click="toDiscounts"
                >акции и скидки</button>
                <button class="btn btn-catalog"
                        @click="toCatalog"
                >каталог</button>
            </div>
        </div>
    </section>
</template>
<script>
    export default {
        name: 'app',
        components: {
        },
        data(){
            return {

            }
        },
        methods: {
            toDiscounts(){
                this.$router.push('/discounts');
            },
            toCatalog(){
                this.$router.push('/catalog');
            }
        },
        computed: {
            ///

        }
    }
</script>
<style lang="scss">

</style>
