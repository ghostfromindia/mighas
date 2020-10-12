<template>
    <div class="product__content">
        <!-- .product__gallery -->
        <div class="product__gallery">
            <div class="product-gallery">
                <div class="product-gallery__featured">
                    <button class="product-gallery__zoom">
                        <svg width="24px" height="24px">
                            <use xlink:href="images/sprite.svg#zoom-in-24"></use>
                        </svg>
                    </button>
                    <div class="owl-carousel owl-loaded owl-drag" id="product-image">
                        <div class="owl-stage-outer">
                            <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1885px;">
                                <div class="owl-item active" style="width: 377px;"><a :href="image" target="_blank">
                                    <img :src="image" alt="" style="height: 250px;object-fit: contain;">
                                </a>
                                </div>
                                <div class="owl-item" style="width: 377px;"  v-for="obj in gallery"><a :href="base+'/'+obj.file_path" target="_blank">
                                    <img :src="base+'/'+obj.file_path" alt="">
                                </a>
                                </div>


                                <!-- <div class="owl-item" style="width: 377px;"><a href="images/products/product-16-4.jpg" target="_blank">
                                     <img src="images/products/product-16-4.jpg" alt="">
                                 </a>
                                 </div>-->



                            </div>
                        </div>
                        <div class="owl-nav disabled"><button type="button" role="presentation" class="owl-prev"><span aria-label="Previous">‹</span></button><button type="button" role="presentation" class="owl-next"><span aria-label="Next">›</span></button></div>
                        <div class="owl-dots disabled"></div>
                    </div>
                </div>
                <!--FOOTER GALLERY-->
                <div class="product-gallery__carousel">
                    <div class="owl-carousel owl-loaded owl-drag" id="product-carousel">
                        <div class="owl-stage-outer">
                            <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 489px;">
                                <div class="owl-item active" style="width: 87.75px; margin-right: 10px;"><a :href="image" class="product-gallery__carousel-item product-gallery__carousel-item--active">
                                    <img class="product-gallery__carousel-image" :src="image" alt="" >
                                </a>
                                </div>
                                <div class="owl-item active" style="width: 87.75px; margin-right: 10px;"  v-for="obj in gallery"><a :href="base+'/'+obj.file_path" class="product-gallery__carousel-item">
                                    <img class="product-gallery__carousel-image" :src="base+'/'+obj.file_path" alt="">
                                </a>
                                </div>

                           <!--     <div class="owl-item" style="width: 87.75px; margin-right: 10px;"><a href="images/products/product-16-4.jpg" class="product-gallery__carousel-item">
                                    <img class="product-gallery__carousel-image" src="images/products/product-16-4.jpg" alt="">
                                </a>
                                </div>-->
                            </div>
                        </div>
                        <div class="owl-nav disabled"><button type="button" role="presentation" class="owl-prev"><span aria-label="Previous">‹</span></button><button type="button" role="presentation" class="owl-next"><span aria-label="Next">›</span></button></div>
                        <div class="owl-dots disabled"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- .product__gallery / end -->
        <!-- .product__info -->
        <div class="product__info">
            <div class="product__wishlist-compare">
                <button type="button" class="btn btn-sm btn-light btn-svg-icon" data-toggle="tooltip" data-placement="right" title="" data-original-title="Wishlist">
                    <svg width="16px" height="16px">
                        <use xlink:href="images/sprite.svg#wishlist-16"></use>
                    </svg>
                </button>

            </div>
            <h1 class="product__name">{{product.product_name}}</h1>
            <div class="product__description" v-html="product.summary">
            </div>
            <a :href="base+'/company/shipping-and-delivery-charges'" target="_blank">Delivery policies</a>

            <div>
                <div class="add-to-wishlist" :data-wishlist="product.id" style="text-decoration: underline;cursor: pointer" v-if="wishlist_show" v-on:click="wishlist('add')"><i class="fa fa-heart"></i> Add to wishlist</div>
                <div class="remove-from-wishlist" :data-wishlist="product.id" style="text-decoration: underline;cursor: pointer" v-else v-on:click="wishlist('remove')"><span style="color:red"> <i class="fa fa-heart"></i></span> Remove from wishlist</div>
            </div>

<div class="compare-spot">
                <div class="add-to-compare" :data-compare="product.id"  style="text-decoration: underline;cursor: pointer" v-if="compare_show"> <!-- v-on:click="compare('add')" -->
                    <i class="fa fa-clone"></i> Add to compare
                </div>

                    <div class="remove-from-compare " :data-compare="product.id"  style="text-decoration: underline;cursor: pointer" v-else><span style="color:red">
                        <i class="fa fa-clone"></i></span> Remove from compare
                    </div>

</div>

            <div class="product__description" v-html="product.policies">
            </div>


            <hr>

            <div class="product__actions-item">
                <div class="input-number product__quantity">
                    <label for="delivery"><b>Check your pincode for delivery availablity</b></label>
                    <input id="delivery" class="input-number__input form-control form-control-lg pincode-input" type="number" min="100000" max="999999" v-on:keyup="pincode_check($event)" v-model="pincode" >
                    <small><b class="green" v-bind:class="[pincodestyle]" id="pin_msg">Note : A pin code must consist of 6 digits</b></small>
                </div>
            </div>
            <hr>

            <offer-list :variant_id="variant_id"></offer-list>


            <ul class="product__meta">
                <li v-if="product.brand">Brand: {{product.brand}}</li>
                <li v-if="product.sku">SKU: {{product.sku}}</li>
            </ul>



        </div>
        <!-- .product__info / end -->
        <!-- .product__sidebar -->
        <div class="product__sidebar">
            <div style="margin: 10px 0px">
                <price-tag :mrp="product.mrp" :selling="product.sale_price" v-if="showprice"></price-tag>
            </div>

            <div id="rate_star" class="rating-box" style="width: 100%;border-radius: 5px;
    border: 1px dotted lightgray;" v-if="star"><div class="myrating" :data-rating="star"></div>{{star_count}} Ratings</div>






            <!-- .product__options -->

            <form class="product__options">
                <div class="form-group product__option" v-if="levels_1">
                    <label class="product__option-label" v-if="levels_1[0]">{{levels_1[0].level}}</label>
                    <div class="input-radio-label">
                        <div class="input-radio-label__list">
                            <label v-for="lev_ in levels_1" >
                                <input type="radio" name="level_1"  :value="lev_.value" :checked="lev_.value == product.level1 ? true : false"  v-on:change="levelChange(product.pid,1)">
                                <span v-on:click="levelChange(product.pid,1)"  id="lvl1" :data-level="lev_.value">{{lev_.value}}</span>
                            </label>

                        </div>
                    </div>
                </div>

                <div class="form-group product__option" v-if="levels_2">
                    <label class="product__option-label" v-if="levels_2[0]" >{{levels_2[0].level}}</label>
                    <div class="input-radio-label">
                        <div class="input-radio-label__list">
                            <label v-for="lev_ in levels_2" >
                                <input type="radio" name="level_2"   :value="lev_.value" :checked="lev_.value == product.level2 ? true : false"  v-on:change="levelChange(product.pid,2)">
                                <span v-on:click="levelChange(product.pid,2)" id="lvl2" :data-level="lev_.value">{{lev_.value}}</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group product__option" v-if="levels_3">
                    <label class="product__option-label" v-if="levels_3[0]">{{levels_3[0].level}}</label>
                    <div class="input-radio-lab">
                        <div class="input-radio-label__list">
                            <label v-for="lev_ in levels_3" >
                                <input type="radio" name="level_3" :value="lev_.value" :checked="lev_.value == product.level3 ? true : false" v-on:change="levelChange(product.pid,3)"  >
                                <span id="lvl3" :data-level="lev_.value">{{lev_.value}}</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group product__option">

                    <div class="product__actions">

                        <div class="product__actions-item product__actions-item--addtocart" v-if="!oos" style="margin-top: 20px">
                            <button type="button" class="btn btn-primary btn-lg btn-block" ref="myBtn" v-on:click="offersModal()">Add to cart</button>
                        </div>

                        <div class="product__actions-item product__actions-item--addtocart" v-else>
                            <button type="button" class="btn btn-dark btn-lg" ref="myBtn" >OUT OF STOCK</button>
                        </div>


                    </div>
                </div>
            </form>
            <!-- .product__options / end -->
        </div>
        <!-- .product__end -->




        <!-- The Modal -->
        <div id="myModal" class="modal" ref="myModal">

            <!-- Modal content -->
            <div class="modal-content mc">
                <span class="close" ref="close" style="float:right">&times;</span>
                <h3 class="block-header__title p_grad" style="font-size: 25px;">Choose an offer and continue</h3>
                <hr>
                <offer :variant_id="variant_id"></offer>
            </div>

        </div>




    </div>
</template>


<script>

    import axios from "axios";

    require('../../../public/client/vendor/owl-carousel-2.3.4/owl.carousel.min.js')
    require('../../../public/js/spiderworks.js')

    export default {
        data: function(){
            return {
                showprice:false,
                product:{
                    product_name:'',
                    short_description:'',
                    summary:'',
                    sale_price:'',
                    mrp:'',
                    brand:'',
                    sku:'',
                    image_url:'',
                    slug:'',
                    level1:'',
                    level2:'',
                    level3:'',
                    pid:'',
                    stock:'',
                    policies:''
                },
                wishlist_show:true,
                compare_show:true,
                base:baseUrl,
                star:'',
                star_count:'',
                image:'',
                levels_1:[],
                levels_2:[],
                levels_3:[],
                level_:{
                  value:'',
                  id:'',
                  level:''
                },
                gallery:[],
                mrp_status:false,
                pincode:'',
                pincodestyle:'green',
                oos:''
            }
        },
        beforeCreate(){
            this.image = baseUrl+'/client/images/no_product_image.png';
        },
        created(){
            this.fetchlevels(this.product_id);
            this.fetchProduct(this.variant_id);
            this.star = this.rating;
            this.star_count = this.rating_count;
            this.pincode = this.pincode_;
            this.pincode_check();
            this.wishlist('check');
            this.compare('check');

        },
        mounted() {
            this.getGallery();
        },
        methods:{
            encodeQueryData(data) {
                const ret = [];
                for (let d in data)
                    ret.push(encodeURIComponent(d) + '=' + encodeURIComponent(data[d]));
                return ret.join('&');
            },
            fetchlevels(id)
            {
                console.log('fetching product varaints from' + baseUrl + '/products/levels/' +id);
                fetch(baseUrl +'/products/levels/' +id)
                    .then(res => res.json())
                    .then(res => {
                        this.levels_1 = res.level1;
                        this.levels_2 = res.level2;
                        this.levels_3 = res.level3;


                    });
            },
            fetchProduct(id,data=null)
            {
                console.log('fetching varaints from ' + baseUrl + '/products/variant/' +id+'?'+data);
                fetch(baseUrl +'/products/variant/' +id+'?'+data)
                    .then(res => res.json())
                    .then(res => {
                        this.product = res;

                        $(".myrating").starRating({
                            starSize: 25,
                            readOnly:true
                        });

                        if(res.image_url){  this.image = baseUrl+'/'+this.product.image_url;}else{
                            this.image = 'https://i.imgur.com/GH3KcVO.png';
                        }
                        if(res.mrp > res.sale_price){
                            this.mrp_status = true;
                        }

                        this.showprice = true;
                        if(res.stock <=0){
                            this.oos = true;
                        }

                        $('.site__body').show();
                        $('.site__footer').show();
                    });
            },
            levelChange(val,level){

                $('.site__body').hide();
                $('.site__footer').hide();

                    let lvl1 = $('input[name=level_1]:checked').val();
                    let lvl2 = $('input[name=level_2]:checked').val();
                    let lvl3 = $('input[name=level_3]:checked').val();
                    let data = [];
                    if(lvl1){data['lvl1']=lvl1}
                    if(lvl2){data['lvl2']=lvl2}
                    if(lvl3){data['lvl3']=lvl3}
                    data['level']=level;

                    let querystring = this.encodeQueryData(data);

                    console.log(lvl1)
                    console.log(lvl2)
                    console.log(lvl3)


                this.fetchProduct(val,querystring)


            },
            encodeQueryData(data) {
                const ret = [];
                for (let d in data)
                    ret.push(encodeURIComponent(d) + '=' + encodeURIComponent(data[d]));
                return ret.join('&');
            },
            wishlist(type = null){
                let data = {
                    variant_id: this.variant_id,
                    type:type
                };
                axios.post(baseUrl + '/wishlist/add', data)
                    .then(function (res) {
                            return res;
                }).then(res =>{
                    $('.wishlistcount').html(res.data.total);
                    this.wishlist_show = res.data.status;
                });
            },
            compare(type = null){
                let data = {
                    variant_id: this.variant_id,
                    type:type
                };
                axios.post(baseUrl + '/compare', data)
                    .then(function (res) {
                        return res;
                    }).then(res =>{
                        console.log(res)
                    console.log('comparecount : '+res.data.total+' '+res.data.status+' '+res.data.message)
                    $('.comparecount').html(res.data.total);
                    this.compare_show = !res.data.status;
                });
            },
            offersModal(){
                var modal = this.$refs.myModal;
                var btn = this.$refs.myBtn;
                var span = this.$refs.close;

                fetch(baseUrl +'/variant/offers/' +this.variant_id)
                    .then(res => res.json())
                    .then(res => {
                        if(res.length<=0){
                            this.addToCart();
                        }else{
                            modal.style.display = "block";
                        }
                    });



                span.onclick = function() {
                    modal.style.display = "none";
                }

                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                }

            },
            addToCart() {
                let data = {
                    variant_id: this.variant_id,
                    offer_id: 0,
                    _token: csrf,
                };
                console.log(data)
                axios.post(baseUrl + '/cart/add/', data)
                    .then(function (res) {
                        console.log(res);
                        window.location.replace(baseUrl+'/cart');
                    })
                    .catch(function (error) {
                        console.log(error)
                    });


            },
            pincode_check(){
                let length = 0;
                if(this.pincode == null){
                    length = 0;
                }else{
                    length = this.pincode.length;

                }

                    let data = {
                        pincode: this.pincode ,
                    }

                if(length !== 6){ console.log(length)
                    if(length<6){
                        $('#pin_msg').html('Please enter 6 digits to validate..');
                        return false;
                    }
                    this.pincodestyle = 'red';
                    $('#pin_msg').html('Invalid pincode...');
                    return false;
                }else{
                    this.pincodestyle = 'green';
                    $('#pin_msg').html('Please wait.. Validating....');
                    data =this.encodeQueryData(data)
                    fetch(baseUrl+'/pincode/verify?'+data)
                        .then(res=>res.json())
                        .then(res =>{
                            if(res.status){
                                $('#pin_msg').html('This product is available at your location');
                            }else{
                                this.pincodestyle = 'red';
                                $('#pin_msg').html('This product is not available at your location');
                            }
                        });

                    return false;
                }
            },
            getGallery(){

                fetch(baseUrl +'/products/variant/gallery/' +this.variant_id)
                    .then(res => res.json())
                    .then(res => {
                        this.gallery = res;
                        return res;
                    }).then(res =>{

                    $(function() {
                        $('.block-products-carousel').each(function() {
                            const layout = $(this).data('layout');
                            const options = {
                                items: 4,
                                margin: 14,
                                nav: false,
                                dots: false,
                                loop: true,
                                stagePadding: 1
                            };
                            const layoutOptions = {
                                'grid-4': {
                                    responsive: {
                                        1200: {items: 4, margin: 14},
                                        992:  {items: 4, margin: 10},
                                        768:  {items: 3, margin: 10},
                                        576:  {items: 2, margin: 10},
                                        475:  {items: 2, margin: 10},
                                        0:    {items: 1}
                                    }
                                },
                                'grid-4-sm': {
                                    responsive: {
                                        1200: {items: 4, margin: 14},
                                        992:  {items: 3, margin: 10},
                                        768:  {items: 3, margin: 10},
                                        576:  {items: 2, margin: 10},
                                        475:  {items: 2, margin: 10},
                                        0:    {items: 1}
                                    }
                                },
                                'grid-5': {
                                    responsive: {
                                        1200: {items: 5, margin: 12},
                                        992:  {items: 4, margin: 10},
                                        768:  {items: 3, margin: 10},
                                        576:  {items: 2, margin: 10},
                                        475:  {items: 2, margin: 10},
                                        0:    {items: 1}
                                    }
                                },
                                'horizontal': {
                                    items: 3,
                                    responsive: {
                                        1200: {items: 3, margin: 14},
                                        992:  {items: 3, margin: 10},
                                        768:  {items: 2, margin: 10},
                                        576:  {items: 1},
                                        475:  {items: 1},
                                        0:    {items: 1}
                                    }
                                },
                            };
                            const owl = $('.owl-carousell', this);
                            let cancelPreviousTabChange = function() {};

                            owl.owlCarousel($.extend({}, options, layoutOptions[layout]));

                            $(this).find('.block-header__group').on('click', function(event) {
                                const block = $(this).closest('.block-products-carousel');

                                event.preventDefault();

                                if ($(this).is('.block-header__group--active')) {
                                    return;
                                }

                                cancelPreviousTabChange();

                                block.addClass('block-products-carousel--loading');
                                $(this).closest('.block-header__groups-list').find('.block-header__group--active').removeClass('block-header__group--active');
                                $(this).addClass('block-header__group--active');

                                // timeout ONLY_FOR_DEMO! you can replace it with an ajax request
                                let timer;
                                timer = setTimeout(function() {
                                    let items = block.find('.owl-carousel .owl-item:not(".cloned") .block-products-carousel__column');

                                    /*** this is ONLY_FOR_DEMO! / start */
                                    /**/ const itemsArray = items.get();
                                    /**/ const newItemsArray = [];
                                    /**/
                                    /**/ while (itemsArray.length > 0) {
                                        /**/     const randomIndex = Math.floor(Math.random() * itemsArray.length);
                                        /**/     const randomItem = itemsArray.splice(randomIndex, 1)[0];
                                        /**/
                                        /**/     newItemsArray.push(randomItem);
                                        /**/ }
                                    /**/ items = $(newItemsArray);
                                    /*** this is ONLY_FOR_DEMO! / end */

                                    block.find('.owl-carousel')
                                        .trigger('replace.owl.carousel', [items])
                                        .trigger('refresh.owl.carousel')
                                        .trigger('to.owl.carousel', [0, 0]);

                                    $('.product-card__quickview', block).on('click', function() {
                                        quickview.clickHandler.apply(this, arguments);
                                    });

                                    block.removeClass('block-products-carousel--loading');
                                }, 1000);
                                cancelPreviousTabChange = function() {
                                    // timeout ONLY_FOR_DEMO!
                                    clearTimeout(timer);
                                    cancelPreviousTabChange = function() {};
                                };
                            });

                            $(this).find('.block-header__arrow--left').on('click', function() {
                                owl.trigger('prev.owl.carousel', [500]);
                            });
                            $(this).find('.block-header__arrow--right').on('click', function() {
                                owl.trigger('next.owl.carousel', [500]);
                            });
                        });
                    });

                    const initProductGallery = function(element, layout) {
                        layout = layout !== undefined ? layout : 'standard';

                        const options = {
                            dots: false,
                            margin: 10
                        };
                        const layoutOptions = {
                            standard: {
                                responsive: {
                                    1200: {items: 5},
                                    992: {items: 4},
                                    768: {items: 3},
                                    480: {items: 5},
                                    380: {items: 4},
                                    0: {items: 3}
                                }
                            },
                            sidebar: {
                                responsive: {
                                    768: {items: 4},
                                    480: {items: 5},
                                    380: {items: 4},
                                    0: {items: 3}
                                }
                            },
                            columnar: {
                                responsive: {
                                    768: {items: 4},
                                    480: {items: 5},
                                    380: {items: 4},
                                    0: {items: 3}
                                }
                            },
                            quickview: {
                                responsive: {
                                    1200: {items: 5},
                                    768: {items: 4},
                                    480: {items: 5},
                                    380: {items: 4},
                                    0: {items: 3}
                                }
                            }
                        };

                        const gallery = $(element);

                        const image = gallery.find('.product-gallery__featured .owl-carousel');
                        const carousel = gallery.find('.product-gallery__carousel .owl-carousel');

                        image
                            .owlCarousel({items: 1, dots: false})
                            .on('changed.owl.carousel', syncPosition);

                        carousel
                            .on('initialized.owl.carousel', function () {
                                carousel.find('.product-gallery__carousel-item').eq(0).addClass('product-gallery__carousel-item--active');
                            })
                            .owlCarousel($.extend({}, options, layoutOptions[layout]));

                        carousel.on('click', '.owl-item', function(e){
                            e.preventDefault();

                            image.data('owl.carousel').to($(this).index(), 300, true);
                        });

                        gallery.find('.product-gallery__zoom').on('click', function() {
                            openPhotoSwipe(image.find('.owl-item.active').index());
                        });

                        image.on('click', '.owl-item > a', function(event) {
                            event.preventDefault();

                            openPhotoSwipe($(this).closest('.owl-item').index());
                        });

                        function openPhotoSwipe(index) {
                            const photoSwipeImages = image.find('.owl-item > a').toArray().map(function(element) {
                                return {
                                    src: element.href,
                                    msrc: element.href,
                                    w: 700,
                                    h: 700
                                };
                            });

                            const photoSwipeOptions = {
                                getThumbBoundsFn: function(index) {
                                    const imageElement = image.find('.owl-item img')[index];
                                    const pageYScroll = window.pageYOffset || document.documentElement.scrollTop;
                                    const rect = imageElement.getBoundingClientRect();

                                    return {x: rect.left, y: rect.top + pageYScroll, w: rect.width};
                                },
                                index: index,
                                bgOpacity: .9,
                                history: false
                            };

                            const photoSwipeGallery = new PhotoSwipe($('.pswp')[0], PhotoSwipeUI_Default, photoSwipeImages, photoSwipeOptions);

                            photoSwipeGallery.listen('beforeChange', function() {
                                image.data('owl.carousel').to(photoSwipeGallery.getCurrentIndex(), 0, true);
                            });

                            photoSwipeGallery.init();
                        }

                        function syncPosition (el) {
                            let current = el.item.index;

                            carousel
                                .find('.product-gallery__carousel-item')
                                .removeClass('product-gallery__carousel-item--active')
                                .eq(current)
                                .addClass('product-gallery__carousel-item--active');
                            const onscreen = carousel.find('.owl-item.active').length - 1;
                            const start = carousel.find('.owl-item.active').first().index();
                            const end = carousel.find('.owl-item.active').last().index();

                            if (current > end) {
                                carousel.data('owl.carousel').to(current, 100, true);
                            }
                            if (current < start) {
                                carousel.data('owl.carousel').to(current - onscreen, 100, true);
                            }
                        }
                    };

                    $(function() {
                        $('.product').each(function () {
                            const gallery = $(this).find('.product-gallery');

                            if (gallery.length > 0) {
                                initProductGallery(gallery[0], $(this).data('layout'));
                            }
                        });
                    });





                });
            }
        },
        props: [
            'variant_id','product_id','rating','rating_count','pincode_'
        ]
    }


</script>

<style>
    .product_active{
        background-color: #f36 !important;
    }
    .mc {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 30%;
        height: 80%;
    }
    .close{
        float: right;
        position: absolute;
        right: 20px;
        font-size: 40px;
    }
    .modal{
        background-color: rgba(0,0,0,0.4) !important;
    }

    .rating-box{
        padding: 5px 19px;
        width: fit-content;
        border-radius: 10px;
        background-image: linear-gradient(-90deg, #fffcfc, #ffffff);
        text-align: center;
        margin-bottom:10px;
    }
    .product__prices{
        margin-top:0px !important;
    }

    .input-number__input {
        -moz-appearance: textfield;
        display: block;
        width: 100%;
        min-width: 130px;
        padding: 5px;
        text-align: left;
    }

    @media (min-width: 992px){
        .product--layout--columnar .product__quantity {
            width: unset;
        }
    }

        .product__quantity {
            width: unset;
        }
    .green{
        color: green;
    }
    .red{
        color: red;
    }
    .form-control-lg {
        height: 32px;
        line-height: 10px;
    }

    .pincode-input{
        border: unset;
        border-bottom: 1px solid black;
        border-radius: 0px;
        width: 100px;
    }

    .add-to-wishlist{
        cursor: pointer;
    }

    .product__description p{
        font-size: 15px !important;
        font-family: Roboto,"sans-serif" !important;
    }
</style>