<template>

        <div class="product-cat home-cube" style="display: none">
            <div class="product-data">
                <div class="block-header">
                    <h3 class="block-header__title">{{title}}</h3>
                </div>
                <div class="row">
                    <div class="col-md-4 col-4">
                        <i class="fas fa-percent"></i>
                        <p>Best<br>Deals</p>
                    </div>
                    <div class="col-md-4 col-4">
                        <i class="fas fa-exchange-alt"></i>
                        <p>Customer<br>Support</p>
                    </div>
                    <div class="col-md-4 col-4">
                        <i class="fas fa-truck"></i>
                        <p>Free <br>Installation</p>
                    </div>
                </div>
                <div class="product-list">
                    <banner-display v-for="obj in banner"  :photo_title="obj.child_name" :photo_src="base_url+'/'+obj.image_url" :key="obj.id+Math.random()"></banner-display>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

</template>
<script>
    export default {
        data(){
            return{
                base_url: baseUrl,
                banner: [],
                title:''
            }
        },
        created(){
            this.fetchFeatures()
        },
        methods: {
            fetchFeatures() {
                console.log(baseUrl+'/banners/'+this.type)
                fetch(baseUrl+'/banners/'+this.type)
                    .then(res => res.json())
                    .then(res =>{
                        this.banner = res.data;
                        this.title = res.title;
                    }).then(res =>{
                        $('.home-cube').fadeIn();
                })
            }
        },
        mounted() {
        },
        props: [
            'type'
        ]
    }
</script>
<style type="text/css">
    .product-cat .product-cat-inner a{
      float: left;
      width: 50%;
      background: #fff;
      font-size:14px; 
      text-align: left;
      padding: 5px;
      color: #000;
      font-weight: 600;
    }
    .product-cat .product-cat-inner a img{
      width: 100%;
    }
</style>