<template>
    <section class="discount-info">
        <div class="section-img">
            <div class="img">
                <img :src="'/images/' + action($route.params.action_id).image" alt="">
                <div class="discount">
                    <p>{{  action($route.params.action_id).name }}</p>
                </div>
            </div>
            <div class="wrapper-16">
                <div class="items">
                    <div class="item" v-html="action($route.params.action_id).description"></div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
    import {mapActions} from 'vuex';
    import {mapGetters} from 'vuex';
    export default {
        beforeRouteEnter(to, from, next) {
            next(vm => vm.changeTitle('АКЦИЯ'));
        },
        computed: {
            ...mapGetters('promotions', {
                action: 'getSpecificAction'
            }),
        },
        methods: {
            ...mapActions('header', {
                changeTitle: 'setTitle'
            })
        }
    }
</script>
