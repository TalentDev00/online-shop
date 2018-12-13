<template>
    <section class="gallery">
        <div class="items">
            <button class="close"
                    @click="back"
            ><img src="../../images/icons/close_snow.svg" alt=""></button>
            <div class="owl-carousel">
                <div v-for="(image, index) in item.images"
                     :key="index"
                     class="carousel-item"
                >
                    <img :src="'/images/' + image.large" alt="">
                </div>
            </div>
        </div>
    </section>
</template>
<script>
    import {mapGetters} from 'vuex';
    import {get as getData} from '../api';

    export default {
        beforeRouteEnter(to, from, next) {
            next(vm => {
                let params = {
                    item_id: to.params.item_id
                };
                getData(
                    '/store/catalog/items',
                    params,
                    (data) => {
                        vm.setData(data);
                        vm.$nextTick(() => {
                            vm.installOwlCarousel();
                        });
                    }
                );
            });
        },
        data() {
            return {
                item: ''
            }
        },
        computed: {
            ...mapGetters('products', {
                product: 'getProductById'
            }),
        },
        methods: {
            back() {
                this.$router.go(-1);
            },
            installOwlCarousel() {
                $('section.gallery>.items>.owl-carousel').owlCarousel({
                    loop: true,
                    items: 1,
                    center: true,
                    nav: false,
                    dots: true,
                    dotsEach: true
                });
            },
            setData(data) {
                this.item = data;
            }
        }
    }
</script>
<style lang="scss">
    section.gallery {
        .owl-dots {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            bottom: -129px;
            min-width: 40px;
            display:flex;
            justify-content: space-between;
            .owl-dot {
                width: 8px;
                height: 8px;
                border: solid 1px #FFFFFF;
                background-color: #000000;
                border-radius: 50%;
                span {
                    display:none;
                }
            }
            .active {
                width: 8px;
                height: 8px;
                border: solid 1px #FFFFFF;
                background-color: #FFFFFF;
                border-radius: 50%;
            }
        }
    }
</style>
