<template>
    <div class="block block-categories block-categories--layout--classic">
        <div class="container">
            <div class="block-categories__list">
                <div class="row m-0 w-100">
                    <div class="col-md-4 p-0" v-for="photo in banner.photos">                             
                        <div class="top-cat">
                            <div class="block-header">
                                <h3 class="block-header__title">{{photo.title}}</h3>                                   
                            </div>
                            <div class="product-card__image">                             
                                <banner-display :photo_src="base_url+'/uploads/banner/'+photo.media.file_name" ></banner-display>
                            </div>
                            <div class="clearfix"></div>    
                            <p v-if="photo.link"><a class="more-btn" href="base_url+'/'+photo.link">See more</a> </p>                               
                        </div>                      
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
                banner: [],
            }
        },
        created(){
            this.fetchFeatures()
        },
        methods: {
            fetchFeatures() {
                fetch(baseUrl+'/banners/home-deals-banner')
                    .then(res => res.json())
                    .then(res =>{
                        this.banner = res;
                    });

            }
        },
        mounted() {
        },
    }
</script>