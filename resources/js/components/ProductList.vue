<template>
    <div class="owl-carousel " :id="owl">
        <product v-for="product in products" :key="product.id"
                 :product_name ="product.product_name"
                 :url = "'uploads/products/200X200/'+product.url"
                 :slug = "product.slug"
                 :sale_price = "product.sale_price"
                 :mrp = "product.mrp"
                 :stock_ = "product.stock"
        ></product>
    </div>
</template>

<script>
    require('../../../public/client/vendor/owl-carousel-2.3.4/owl.carousel.min.js')
    require('../../../public/js/spiderworks.js')
    function guidGenerator() {
        var S4 = function() {
            return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
        };
        return (S4()+S4()+"-"+S4()+"-"+S4()+"-"+S4()+"-"+S4()+S4()+S4());
    }
    export default {
        data(){
            return{
                products: [],
                product: {
                    id: '',
                    mrp: '',
                    sale_price: '',
                    product_name: '',
                    url: '',
                    slug: '',
                    category:'',
                    stock:''
                },owl:''

            }
        },
        created(){
            this.fetchProducts()
            this.owl = 'owl-'+guidGenerator()
        },
        methods: {
            fetchProducts() {
                console.log('creating product list from '+ baseUrl+'/products/'+this.type+'/'+this.category);
                fetch(baseUrl+'/products/'+this.type+'/'+this.category)
                    .then(res => res.json())
                    .then(res =>{
                        this.products = res.products;
                        })
                    .then(res =>{

                            var $owl = $('#'+this.owl).owlCarousel({
                                items: 7,
                                margin: 14,
                                nav: false,
                                dots: false,
                                loop: false,
                                stagePadding: 1,
                                responsive:{
                                    0:{
                                        items:2,
                                        nav:true
                                    },
                                    600:{
                                        items:3,
                                        nav:false
                                    },
                                    1000:{
                                        items:5,
                                        nav:true,
                                        loop:false
                                    }
                                }

                            });


                        $(".block-products-carousel").find('.block-header__arrow--right').on('click', function() {
                            $owl.trigger('next.owl.carousel', [500]);
                        });
                        $(".block-products-carousel").find('.block-header__arrow--left').on('click', function() {
                            $owl.trigger('prev.owl.carousel', [500]);
                        });
                        $owl.trigger('refresh.owl.carousel');



            });

            }
        },
        mounted() {
        },
        props:['type','category','loader']
    }
</script>

<style >
    .product-item-opt-1 .product-item-label.label-price {
        width: 50px;
        padding: 7px 0 0;
        height: 50px;
        z-index:40;
    }
</style>