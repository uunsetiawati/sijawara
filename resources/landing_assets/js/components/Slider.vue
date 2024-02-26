<template>
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div v-for="slider in sliders" class="swiper-slide">
                <img :data-src="slider.image_url" class="swiper-lazy img-fluid w-100">
                <div class="swiper-lazy-preloader"></div>
            </div>
        </div>
        <div class="swiper-pagination swiper-pagination-white"></div>
        <!-- <div class="swiper-button-next swiper-button-white"></div>
        <div class="swiper-button-prev swiper-button-white"></div> -->
    </div>
</template>

<script>    
    import Swiper from 'swiper/swiper-bundle.min.js'
    import 'swiper/swiper-bundle.min.css'

    export default {
        data() {
            return {
                sliders: [],
            }
        },
        methods: {
            loadSlider() {
                var swiper = new Swiper('.swiper-container', {
                    spaceBetween: 30,
                    effect: 'fade',
                    centeredSlides: true,
                    autoplay: {
                        delay: 5000,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    // navigation: {
                    //     nextEl: '.swiper-button-next',
                    //     prevEl: '.swiper-button-prev',
                    // },
                    preloadImages: true,
                    lazy: true
                });
            },
            getSlider() {
                var vm = this;
                vm.$http({
                    url: '../front/slider/show',
                    method: 'GET',
                }).then((res) => {
                    vm.sliders = res.data.data;
                    setTimeout(function() {
                        vm.loadSlider();
                    });
                }).catch((error) => {
                    
                });
            }
        },
        mounted() {
            var vm = this;
            vm.getSlider()
        }
    }
</script>

<style lang="scss" scoped>
    @media (max-width: 991.98px) {
        .swiper-container {
            height: 220px!important;
        }
    }

    .swiper-container {
        height: 640px;
        border-radius: 8px;

        .swiper-slide {
          background-position: center;
          background-size: cover;
        }
    }
</style>