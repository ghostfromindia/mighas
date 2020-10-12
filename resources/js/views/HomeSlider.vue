<template>
        <div class="block-slideshow__body">
                            <div class="owl-carousel">
                                <a class="block-slideshow__slide" :href="photo.button_link" v-for="photo in photos" :key="photo.id">
                                    <div class="block-slideshow__slide-image block-slideshow__slide-image--desktop" :style="{ backgroundImage: 'url('+ photo.file_name +'?data='+(new Date()).getTime()+')' }"></div>
                                    <div class="block-slideshow__slide-image block-slideshow__slide-image--mobile" :style="{ backgroundImage: 'url('+ photo.file_name +'?data='+(new Date()).getTime()+')' }"></div>
                                    <div class="block-slideshow__slide-content">
                                        <div class="block-slideshow__slide-title">{{photo.title}}</div>
                                        <div class="block-slideshow__slide-text" v-html="photo.description"></div>
                                        <div class="block-slideshow__slide-button">
                                            <a v-bind:href="photo.button_link" class="btn btn-primary btn-lg" v-if="photo.button_text" :target="photo.button_link_target ? '_blank' : ''" >{{photo.button_text}}</a>
                                            <a v-bind:href="photo.button2_link" class="btn btn-primary btn-lg" v-if="photo.button2_text" :target="photo.button_link_target ? '_blank' : ''">{{photo.button2_text}}</a>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
</template>
<script>
    export default {
        data(){
            return{
                photos: [],
            }
        },
        created(){
            this.fetchSlides()
        },
        methods: {
            fetchSlides() {
                console.log('screen width is: '+screen.width);
                let url = baseUrl+'/slides/home-slider';
                if( screen.width <= 760 )
                    url = baseUrl+'/slides/home-slider-mobile';

                fetch(url)
                    .then(res => res.json())
                    .then(res =>{
                        console.log(res);
                        this.photos = res;
                        })
                    .then(res =>{

                        $('.block-slideshow .owl-carousel').owlCarousel({
                                items: 1,
                                nav: false,
                                dots: true,
                                loop: true,
                                autoplay:true,
    autoplayTimeout:7000,
                        });

            });

            }
        },
        mounted() {
        },
    }
</script>
<style>
</style>