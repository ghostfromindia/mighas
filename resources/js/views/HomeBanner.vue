<template>
    <div class="block block-banner">
            <div class="container">
                <a href="" class="block-banner__body">
                    <div class="block-banner__image block-banner__image--desktop" :style="{ backgroundImage: 'url('+base_url+'/'+ banner.file +')' }"></div>
                    <div class="block-banner__image block-banner__image--mobile" :style="{ backgroundImage: 'url('+base_url+'/'+ banner.mobile_file +')' }" ></div>
                    <div v-html="banner.banner_content"></div>
                </a>
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
                fetch(baseUrl+'/home/banner')
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