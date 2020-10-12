<template>



    <div class="block block-products-carousel" data-layout="grid-5">
        <div class="container">
            <div class="block-header">
                <h3 class="block-header__title">Recommended products</h3>
                <div class="block-header__divider"></div>
                <div class="block-header__arrows-list">
                    <button class="block-header__arrow block-header__arrow--left" type="button">
                        <svg width="7px" height="11px">
                            <use xlink:href="images/sprite.svg#arrow-rounded-left-7x11"></use>
                        </svg>
                    </button>
                    <button class="block-header__arrow block-header__arrow--right" type="button">
                        <svg width="7px" height="11px">
                            <use xlink:href="images/sprite.svg#arrow-rounded-right-7x11"></use>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="block-products-carousel__slider">
                <div class="block-products-carousel__preloader"></div>
                <div class="owl-carousel" :id="owl">

                    <div class="block-products-carousel__column" v-for="row in data">
                        <div class="block-products-carousel__cell">
                            <div class="product-card ">
                                <button class="product-card__quickview" type="button">
                                    <svg width="16px" height="16px">
                                        <use xlink:href="images/sprite.svg#quickview-16"></use>
                                    </svg>
                                    <span class="fake-svg-icon"></span>
                                </button>
                                <div class="product-card__image">
                                    <a :href="base+row.slug"><img :src="base+row.file_path" alt=""></a>
                                </div>
                                <div class="product-card__info">
                                    <div class="product-card__name">
                                        <a :href="base+row.slug">{{row.name}}</a>
                                    </div>
                                </div>
                                <div class="product-card__actions">
                                    <div class="product-card__availability">
                                        Availability: <span class="text-success">In Stock</span>
                                    </div>
                                    <div class="product-card__prices">
                                        ₹{{row.sale_price}}
                                    </div>
                                    <div class="product-card__buttons">
                                        <button class="btn btn-primary product-card__addtocart" type="button">Add To Cart</button>
                                        <button class="btn btn-secondary product-card__addtocart product-card__addtocart--list" type="button">Add To Cart</button>
                                        <button class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__wishlist" type="button">
                                            <svg width="16px" height="16px">
                                                <use xlink:href="images/sprite.svg#wishlist-16"></use>
                                            </svg>
                                            <span class="fake-svg-icon fake-svg-icon--wishlist-16"></span>
                                        </button>
                                        <button class="btn btn-light btn-svg-icon btn-svg-icon--fake-svg product-card__compare" type="button">
                                            <svg width="16px" height="16px">
                                                <use xlink:href="images/sprite.svg#compare-16"></use>
                                            </svg>
                                            <span class="fake-svg-icon fake-svg-icon--compare-16"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


</template>

<script>
    require('../../../public/client/vendor/owl-carousel-2.3.4/owl.carousel.min.js')
    require('../../../public/js/spiderworks.js')
    function guidGenerator() { //to create a random id for owl carousel
        var S4 = function() {
            return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
        };
        return (S4()+S4()+"-"+S4()+"-"+S4()+"-"+S4()+"-"+S4()+S4()+S4());
    }
    export default {
        data: function(){
            return {
                data:[],
                row:{
                    name:'',
                    sale_price:'',
                    file_path:'',
                    slug:''
                },
                owl:'',
                base:''
            }
        },
        created(){
            this.fetchSpecification(this.id)
            this.owl = 'owl-'+guidGenerator()
            this.base = baseUrl+'/';
        },
        methods:{
            fetchSpecification(id) {
                console.log('fetching relatedproducts  from ' + baseUrl + '/fetch/relatedproducts/' + id);
                fetch(baseUrl + '/fetch/relatedproducts/' + id)
                    .then(res => res.json())
                    .then(res => {
                        this.data = res;
                    }).then(res => {

                    var $owl = $('#'+this.owl).owlCarousel({
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
                            800:{
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

                })
            }

        },
        props: [
            'id'
        ]
    }
</script>

<style>
    .owl-nav{
        display: none;
    }
</style>