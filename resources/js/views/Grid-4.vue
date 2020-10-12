<template>

    <div class="block block-categories block-categories--layout--classic">
        <div class="container">

            <div class="block-categories__list">

                <div class="row m-0 w-100 ">

                    <div  v-for="obj in banners" class="col-md-3 col-6 mb-3  ads-all">

                        <a :href="obj.link" class="banner-anchor">
                            <img :src="obj.image_url" alt="" class="img-fluid">
                        </a>

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
                banners: [],
            }
        },
        created(){
            this.fetchFeatures()
        },
        methods: {
            fetchFeatures() {
                fetch(baseUrl+'/banners/front-page-top-4-grid')
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