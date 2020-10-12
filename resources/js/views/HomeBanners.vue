<template>
    <div class="product-cat">
        <div class="block-header">
            <h3 class="block-header__title">{{banner.banner_name}}</h3>                                   
        </div>                             
        <banner-display v-for="image in banner.photos" :link="image.link"></banner-display>
        <div class="clearfix"></div>    
        <p><a class="more-btn" href="#">See more</a> </p>                                               
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
            this.fetchBanner()
        },
        methods: {
            fetchBanner() {
                fetch(baseUrl+'/account/get-banner/'+this.banner_code)
                    .then(res => res.json())
                    .then(res =>{
                        if(res)
                            this.banner = res;
                    });

            }
        },
        mounted() {
        },
        props: [
            'banner_code'
        ]
    }
</script>