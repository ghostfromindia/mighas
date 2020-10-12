<template>
	<div class="block block-brands">
            <div class="container">
                <div class="block-brands__slider">
                    <div class="owl-carousel">
                        <div class="block-brands__item" v-for="brand in brands">
                            <a :href="brand.website" target="_blank"><img :src="brand.file_path ? base_url+'/'+brand.file_path : base_url+'/images/empty_logo.png' " @error="imgError"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>
<script>
	export default {
        data(){
            return{
                base_url: baseUrl,
                defaultImg: baseUrl+'/images/empty_logo.png',
                brands: []
            }
        },
        created(){
            this.fetchBrands()
        },
        methods: {
            fetchBrands() {
                fetch(baseUrl+'/home/featured-brands')
                    .then(res => res.json())
                    .then(res =>{
                        this.brands = res;
                        }).then(res =>{

                        $('.block-brands__slider .owl-carousel').owlCarousel({
				            nav: false,
				            dots: false,
				            loop: true,
				            responsive: {
				                1200: {items: 6},
				                992: {items: 5},
				                768: {items: 4},
				                576: {items: 3},
				                0: {items: 2}
				            }
				        });

            });

            },
            imgError(event){
              event.target.src = this.defaultImg;
            }

        },
        mounted() {
        },
    }
</script>