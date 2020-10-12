<template>
	<a :href="photo_link" class="product-btn">
		<img :src="photo_src" style="max-height:80px;width:auto;">
        <span v-if="photo_title">{{photo_title}}</span>
	</a>
</template>
<script>
    export default {
        mounted() {
        
        },
        data: function(){
            return {
            	base_url: baseUrl,
            }
        },
        methods:{

        },
        props: [
            'photo_title','photo_src','photo_link'
        ]
    }
</script>