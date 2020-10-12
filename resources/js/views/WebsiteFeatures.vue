<template>
    <div class="block block-features block-features--layout--classic">
            <div class="container">
                <div class="block-features__list">
                    <div class="block-features__item" v-html="features.content1"></div>
                    <div class="block-features__divider"></div>
                    <div class="block-features__item" v-html="features.content2"></div>
                    <div class="block-features__divider"></div>
                    <div class="block-features__item" v-html="features.content3"></div>
                    <div class="block-features__divider"></div>
                    <div class="block-features__item" v-html="features.content4"></div>
                </div>
            </div>
    </div>
</template>
<script>
    export default {
        data(){
            return{
                features: [],
            }
        },
        created(){
            this.fetchFeatures()

        },
        methods: {
            fetchFeatures() {
                fetch(baseUrl+'/home/features')
                    .then(res => res.json())
                    .then(res =>{
                        this.features = res;
                        });

            }
        },
        mounted() {
        },
    }
</script>

