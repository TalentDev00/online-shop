<template>
    <section class="gallery">
        <div class="items">
            <button class="close"
                    @click="back"
            ><img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyB3aWR0aD0iMjRweCIgaGVpZ2h0PSIyNHB4IiB2aWV3Qm94PSIwIDAgMjQgMjQiIHZlcnNpb249IjEuMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+CiAgICA8IS0tIEdlbmVyYXRvcjogU2tldGNoIDUyLjIgKDY3MTQ1KSAtIGh0dHA6Ly93d3cuYm9oZW1pYW5jb2RpbmcuY29tL3NrZXRjaCAtLT4KICAgIDx0aXRsZT5pY29ucyAvIGNsb3NlPC90aXRsZT4KICAgIDxkZXNjPkNyZWF0ZWQgd2l0aCBTa2V0Y2guPC9kZXNjPgogICAgPGRlZnM+CiAgICAgICAgPHBhdGggZD0iTTMuMTA1NDE2NjcsNS4yMjY0MTY2NyBDMi41MjA0MTY2Nyw0LjY0MTQxNjY3IDIuNTIwNDE2NjcsMy42OTA0MTY2NyAzLjEwNTQxNjY3LDMuMTA1NDE2NjcgQzMuNjkwNDE2NjcsMi41MjA0MTY2NyA0LjY0MTQxNjY3LDIuNTIwNDE2NjcgNS4yMjY0MTY2NywzLjEwNTQxNjY3IEwxMS45OTkyNSw5Ljg3ODI1IEwxOC43NzIwODMzLDMuMTA1NDE2NjcgQzE5LjM1NzA4MzMsMi41MjA0MTY2NyAyMC4zMDgwODMzLDIuNTIwNDE2NjcgMjAuODkzMDgzMywzLjEwNTQxNjY3IEMyMS40NzgwODMzLDMuNjkwNDE2NjcgMjEuNDc4MDgzMyw0LjY0MTQxNjY3IDIwLjg5MzA4MzMsNS4yMjY0MTY2NyBMMTQuMTIwMjUsMTEuOTk5MjUgTDIwLjg5MzA4MzMsMTguNzcyMDgzMyBDMjEuNDc4MDgzMywxOS4zNTcwODMzIDIxLjQ3ODA4MzMsMjAuMzA4MDgzMyAyMC44OTMwODMzLDIwLjg5MzA4MzMgQzIwLjMwODA4MzMsMjEuNDc4MDgzMyAxOS4zNTcwODMzLDIxLjQ3ODA4MzMgMTguNzcyMDgzMywyMC44OTMwODMzIEwxMS45OTkyNSwxNC4xMjAyNSBMNS4yMjY0MTY2NywyMC44OTMwODMzIEM0LjY0MTQxNjY3LDIxLjQ3ODA4MzMgMy42OTA0MTY2NywyMS40NzgwODMzIDMuMTA1NDE2NjcsMjAuODkzMDgzMyBDMi41MjA0MTY2NywyMC4zMDgwODMzIDIuNTIwNDE2NjcsMTkuMzU3MDgzMyAzLjEwNTQxNjY3LDE4Ljc3MjA4MzMgTDkuODc4MjUsMTEuOTk5MjUgTDMuMTA1NDE2NjcsNS4yMjY0MTY2NyBaIiBpZD0icGF0aC0xIj48L3BhdGg+CiAgICA8L2RlZnM+CiAgICA8ZyBpZD0iaWNvbnMtLy1jbG9zZSIgc3Ryb2tlPSJub25lIiBzdHJva2Utd2lkdGg9IjEiIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+CiAgICAgICAgPG1hc2sgaWQ9Im1hc2stMiIgZmlsbD0id2hpdGUiPgogICAgICAgICAgICA8dXNlIHhsaW5rOmhyZWY9IiNwYXRoLTEiPjwvdXNlPgogICAgICAgIDwvbWFzaz4KICAgICAgICA8dXNlIGlkPSJTaGFwZSIgZmlsbD0iI0ZGRkZGRiIgeGxpbms6aHJlZj0iI3BhdGgtMSI+PC91c2U+CiAgICA8L2c+Cjwvc3ZnPg==" alt=""></button>
            <div class="owl-carousel">
                <div v-for="(name, value) in productById.product_photos"
                     :key="value"
                     class="carousel-item"
                >
                    <img :src="'/images/' + name" alt="">
                </div>
            </div>
        </div>
    </section>
</template>
<script>
    import Vue from 'vue';
    import {mapGetters} from 'vuex';
    import {mapActions} from 'vuex';
    export default {
        created() {
            Vue.nextTick(function() {
                this.installOwlCarousel();
            }.bind(this));
        },
        components:{
        },
        computed: {
            ...mapGetters('products', {
                allProducts: 'getItems'
            }),
            productById() {
                return this.allProducts.find(item => item.product_id === parseInt(this.$route.params.id));
            }
        },
        methods: {
            ...mapActions('products', {
                favoriteStatusChange: 'like'
            }),
            ...mapActions('cart', {
                add: 'addToCart',
                remove: 'removeFromCart'
            }),
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
