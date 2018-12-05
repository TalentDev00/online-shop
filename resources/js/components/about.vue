{<template>
    <section class="about">
        <div class="section-img">
            <div class="img">
                <img src="../../images/about@3x.jpg" alt="">
            </div>
            <div class="wrapper-16">
                <div class="items">
                    <div class="item">
                        <h2>{{ name }}</h2>
                        <div v-html="aboutUs"></div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</template>
<script>
    import {mapActions} from 'vuex'
    import {mapGetters} from 'vuex';

    export default {
        beforeRouteEnter(to, from, next) {
            next(vm => vm.changeTitle('О КОМПАНИИ'));
        },
        computed: {
            ...mapGetters({
                aboutUs: 'shopDescription',
                name: 'shopName'
            })
        },
        methods: {
            ...mapActions('header', {
                changeTitle: 'setTitle'
            }),
        }
    }
</script>
