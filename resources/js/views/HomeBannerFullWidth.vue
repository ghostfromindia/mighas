<template>
    <div class="block block-banner">
        <div class="container">
            <div  v-for="obj in banners" class="col-md-12 mb-3  ads-all">

                <a :href="obj.link" class="banner-anchor">
                    <img :src="obj.image_url" alt="" class="img-fluid">
                </a>

            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data(){
            return{
                base_url: baseUrl,
                banners: [],
            }
        },
        created(){
            this.fetchFeatures()
        },
        methods: {
            fetchFeatures() {
                fetch(baseUrl+'/banners/home-banner-full-width')
                    .then(res => res.json())
                    .then(res =>{
                        this.banners = res.data;
                    });

            }
        },
        mounted() {
        },
    }
</script>