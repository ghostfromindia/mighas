<template>
    <div class="product__content">
            <div class="product-gallery">
                <div class="product-gallery__featured">
                    <button class="product-gallery__zoom">
                        <svg width="24px" height="24px">
                            <use xlink:href="images/sprite.svg#zoom-in-24"></use>
                        </svg>
                    </button>
                    <div class="owl-carousel  owl-loaded owl-drag" id="product-image">
                        <div class="owl-stage-outer">
                            <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1880px;">
                                <div class="owl-item active" style="width: 376px;"><a :href="image" target="_blank" style="">
                                    <img :src="image" alt="" style="height: 250px;
                        width: 100%;
                        object-fit: contain;">
                                </a>
                                </div>
                                <div class="owl-item" style="width: 376px;"><a :href="image"  target="_blank">
                                    <img :src="image" alt="">
                                </a>
                                </div>
                                <div class="owl-item" style="width: 376px;"><a href="images/products/product-16-2.jpg" target="_blank">
                                    <img src="images/products/product-16-2.jpg" alt="">
                                </a>
                                </div>
                                <div class="owl-item" style="width: 376px;"><a href="images/products/product-16-3.jpg" target="_blank">
                                    <img src="images/products/product-16-3.jpg" alt="">
                                </a>
                                </div>
                                <div class="owl-item" style="width: 376px;"><a href="images/products/product-16-4.jpg" target="_blank">
                                    <img src="images/products/product-16-4.jpg" alt="">
                                </a>
                                </div>
                            </div>
                        </div>
                        <div class="owl-nav disabled"><button type="button" role="presentation" class="owl-prev"><span aria-label="Previous">‹</span></button><button type="button" role="presentation" class="owl-next"><span aria-label="Next">›</span></button></div>
                        <div class="owl-dots disabled"></div>
                    </div>
                </div>
                <div class="product-gallery__carousel">
                    <div class="owl-carousel owl-loaded owl-drag" id="product-carousel">
                        <div class="owl-stage-outer">
                            <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 488px;">
                                <div class="owl-item active" style="width: 87.5px; margin-right: 10px;"><a href="images/products/product-16.jpg" class="product-gallery__carousel-item product-gallery__carousel-item--active">
                                    <img class="product-gallery__carousel-image" src="images/products/product-16.jpg" alt="">
                                </a>
                                </div>
                                <div class="owl-item active" style="width: 87.5px; margin-right: 10px;"><a href="images/products/product-16-1.jpg" class="product-gallery__carousel-item">
                                    <img class="product-gallery__carousel-image" src="images/products/product-16-1.jpg" alt="">
                                </a>
                                </div>
                                <div class="owl-item active" style="width: 87.5px; margin-right: 10px;"><a href="images/products/product-16-2.jpg" class="product-gallery__carousel-item">
                                    <img class="product-gallery__carousel-image" src="images/products/product-16-2.jpg" alt="">
                                </a>
                                </div>
                                <div class="owl-item active" style="width: 87.5px; margin-right: 10px;"><a href="images/products/product-16-3.jpg" class="product-gallery__carousel-item">
                                    <img class="product-gallery__carousel-image" src="images/products/product-16-3.jpg" alt="">
                                </a>
                                </div>
                                <div class="owl-item" style="width: 87.5px; margin-right: 10px;"><a href="images/products/product-16-4.jpg" class="product-gallery__carousel-item">
                                    <img class="product-gallery__carousel-image" src="images/products/product-16-4.jpg" alt="">
                                </a>
                                </div>
                            </div>
                        </div>
                        <div class="owl-nav disabled"><button type="button" role="presentation" class="owl-prev"><span aria-label="Previous">‹</span></button><button type="button" role="presentation" class="owl-next"><span aria-label="Next">›</span></button></div>
                        <div class="owl-dots disabled"></div>
                    </div>
                </div>
            </div>
        <!-- .product__gallery / end -->
        <!-- .product__info -->
        <div class="product__info">
            <div class="product__wishlist-compare">
                <button type="button" class="btn btn-sm btn-light btn-svg-icon" data-toggle="tooltip" data-placement="right" title="Wishlist">
                    <svg width="16px" height="16px">
                        <use xlink:href="images/sprite.svg#wishlist-16"></use>
                    </svg>
                </button>
                <button type="button" class="btn btn-sm btn-light btn-svg-icon" data-toggle="tooltip" data-placement="right" title="Compare">
                    <svg width="16px" height="16px">
                        <use xlink:href="images/sprite.svg#compare-16"></use>
                    </svg>
                </button>
            </div>
            <h1 class="product__name">{{product.product_name}}</h1>
            <div class="product__rating">
                <div class="product__rating-stars">
                    <div class="rating">
                        <div class="rating__body">
                            <svg class="rating__star rating__star--active" width="13px" height="12px">
                                <g class="rating__fill">
                                    <use xlink:href="images/sprite.svg#star-normal"></use>
                                </g>
                                <g class="rating__stroke">
                                    <use xlink:href="images/sprite.svg#star-normal-stroke"></use>
                                </g>
                            </svg>
                            <div class="rating__star rating__star--only-edge rating__star--active">
                                <div class="rating__fill">
                                    <div class="fake-svg-icon"></div>
                                </div>
                                <div class="rating__stroke">
                                    <div class="fake-svg-icon"></div>
                                </div>
                            </div>
                            <svg class="rating__star rating__star--active" width="13px" height="12px">
                                <g class="rating__fill">
                                    <use xlink:href="images/sprite.svg#star-normal"></use>
                                </g>
                                <g class="rating__stroke">
                                    <use xlink:href="images/sprite.svg#star-normal-stroke"></use>
                                </g>
                            </svg>
                            <div class="rating__star rating__star--only-edge rating__star--active">
                                <div class="rating__fill">
                                    <div class="fake-svg-icon"></div>
                                </div>
                                <div class="rating__stroke">
                                    <div class="fake-svg-icon"></div>
                                </div>
                            </div>
                            <svg class="rating__star rating__star--active" width="13px" height="12px">
                                <g class="rating__fill">
                                    <use xlink:href="images/sprite.svg#star-normal"></use>
                                </g>
                                <g class="rating__stroke">
                                    <use xlink:href="images/sprite.svg#star-normal-stroke"></use>
                                </g>
                            </svg>
                            <div class="rating__star rating__star--only-edge rating__star--active">
                                <div class="rating__fill">
                                    <div class="fake-svg-icon"></div>
                                </div>
                                <div class="rating__stroke">
                                    <div class="fake-svg-icon"></div>
                                </div>
                            </div>
                            <svg class="rating__star rating__star--active" width="13px" height="12px">
                                <g class="rating__fill">
                                    <use xlink:href="images/sprite.svg#star-normal"></use>
                                </g>
                                <g class="rating__stroke">
                                    <use xlink:href="images/sprite.svg#star-normal-stroke"></use>
                                </g>
                            </svg>
                            <div class="rating__star rating__star--only-edge rating__star--active">
                                <div class="rating__fill">
                                    <div class="fake-svg-icon"></div>
                                </div>
                                <div class="rating__stroke">
                                    <div class="fake-svg-icon"></div>
                                </div>
                            </div>
                            <svg class="rating__star rating__star--active" width="13px" height="12px">
                                <g class="rating__fill">
                                    <use xlink:href="images/sprite.svg#star-normal"></use>
                                </g>
                                <g class="rating__stroke">
                                    <use xlink:href="images/sprite.svg#star-normal-stroke"></use>
                                </g>
                            </svg>
                            <div class="rating__star rating__star--only-edge rating__star--active">
                                <div class="rating__fill">
                                    <div class="fake-svg-icon"></div>
                                </div>
                                <div class="rating__stroke">
                                    <div class="fake-svg-icon"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product__rating-legend">
                    <a href="">7 Reviews</a><span>/</span><a href="">Write A Review</a>
                </div>
            </div>
            <div class="product__description" v-html="product.short_description">
            </div>
            <ul class="product__meta">
                <li class="product__meta-availability">Availability: <span class="text-success">In Stock</span></li>
                <li>Brand: <a href="">Wakita</a></li>
                <li>SKU: 83690/32</li>
            </ul>
        </div>
        <!-- .product__info / end -->
        <!-- .product__sidebar -->
        <div class="product__sidebar">
            <div class="product__availability">
                Availability: <span class="text-success">In Stock</span>
            </div>
            <div class="product__prices">
                {{product.sale_price}}
            </div>
            <!-- .product__options -->
            <form class="product__options">



                <div class="form-group product__option" v-if="levels_1">
                    <label class="product__option-label">{{levels_1[0].level}}</label>
                    <div class="input-radio-label">
                        <div class="input-radio-label__list">
                            <label v-for="level_ in levels_1" >
                                <input type="radio" name="level_1">
                                <span>{{level_.value}}</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group product__option" v-if="levels_2">
                    <label class="product__option-label">{{levels_2[0].level}}</label>
                    <div class="input-radio-label">
                        <div class="input-radio-label__list">
                            <label v-for="level_ in levels_2" >
                                <input type="radio" name="level_2">
                                <span>{{level_.value}}</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group product__option" v-if="levels_3">
                    <label class="product__option-label">{{levels_3[0].level}}</label>
                    <div class="input-radio-label">
                        <div class="input-radio-label__list">
                            <label v-for="level_ in levels_3" >
                                <input type="radio" name="level_3">
                                <span>{{level_.value}}</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group product__option">
                    <label class="product__option-label" for="product-quantity">Quantity</label>
                    <div class="product__actions">
                        <div class="product__actions-item">
                            <div class="input-number product__quantity">
                                <input id="product-quantity" class="input-number__input form-control form-control-lg" type="number" min="1" value="1">
                                <div class="input-number__add"></div>
                                <div class="input-number__sub"></div>
                            </div>
                        </div>
                        <div class="product__actions-item product__actions-item--addtocart">
                            <button class="btn btn-primary btn-lg">Add to cart</button>
                        </div>
                        <div class="product__actions-item product__actions-item--wishlist">
                            <button type="button" class="btn btn-secondary btn-svg-icon btn-lg" data-toggle="tooltip" title="Wishlist">
                                <svg width="16px" height="16px">
                                    <use xlink:href="images/sprite.svg#wishlist-16"></use>
                                </svg>
                            </button>
                        </div>
                        <div class="product__actions-item product__actions-item--compare">
                            <button type="button" class="btn btn-secondary btn-svg-icon btn-lg" data-toggle="tooltip" title="Compare">
                                <svg width="16px" height="16px">
                                    <use xlink:href="images/sprite.svg#compare-16"></use>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- .product__options / end -->
        </div>
        <!-- .product__end -->
        <div class="product__footer">
            <div class="product__tags tags">
                <div class="tags__list">
                    <a href="">Mounts</a>
                    <a href="">Electrodes</a>
                    <a href="">Chainsaws</a>
                </div>
            </div>
           <!-- <div class="product__share-links share-links">
                <ul class="share-links__list">
                    <li class="share-links__item share-links__item&#45;&#45;type&#45;&#45;like"><a href="">Like</a></li>
                    <li class="share-links__item share-links__item&#45;&#45;type&#45;&#45;tweet"><a href="">Tweet</a></li>
                    <li class="share-links__item share-links__item&#45;&#45;type&#45;&#45;pin"><a href="">Pin It</a></li>
                    <li class="share-links__item share-links__item&#45;&#45;type&#45;&#45;counter"><a href="">4K</a></li>
                </ul>
            </div>-->
        </div>
    </div>
</template>


<script>
    export default {
        data: function(){
            return {
                product:{
                    product_name:'',
                    short_description:'',
                    sale_price:'',
                    mrp:'',
                    brand:'',
                    sku:'',
                    image_url:'',
                    slug:'',
                    level1:'',
                    level2:'',
                    level3:'',
                },
                image:'',
                levels_1:[],
                levels_2:[],
                levels_3:[],
                level:{
                  value:'',
                  id:'',
                  level:''
                },
            }
        },
        beforeCreate(){
            this.image = 'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSYzcIyNmd36YGpJaGwPhj8DjQ0hZbPN-OD-kmU7kdpwpggd1Sp';
        },
        created(){
            this.fetchlevels(this.product_id);
            this.fetchProduct(this.variant_id);
        },
        mounted() {


        },
        methods:{
            fetchlevels(id)
            {
                console.log('fetching product varaints from' + baseUrl + '/products/levels/' +id);
                fetch(baseUrl +'/products/levels/' +id)
                    .then(res => res.json())
                    .then(res => {
                        this.levels_1 = res.level1;
                        this.levels_2 = res.level2;
                        this.levels_3 = res.level3;
                        console.log(res.level1);
                    })
                    .then(res => {

                        console.log(res.level1);

                    });
            },
            fetchProduct(id)
            {
                console.log('fetching varaints from ' + baseUrl + '/products/variant/' +id);
                fetch(baseUrl +'/products/variant/' +id)
                    .then(res => res.json())
                    .then(res => {
                        this.product = res;
                        this.image = baseUrl+'/'+this.product.image_url;
                    });
            }
        },
        props: [
            'variant_id','product_id'
        ]
    }
</script>

<style>
    .product_active{
        background-color: #f36 !important;
    }
</style>