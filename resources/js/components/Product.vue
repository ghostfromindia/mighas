<template>
    <div class="block-products-carousel__column">
        <div class="block-products-carousel__cell">
            <div class="product-card ">
               <!-- <button class="product-card__quickview" type="button">
                    <svg width="16px" height="16px">
                        <use xlink:href="http://localhost/pittappillil/client/images/sprite.svg#quickview-16"></use>
                    </svg>
                    <span class="fake-svg-icon"></span>
                </button>-->
                <!--<div class="product-card__badges-list">-->
                    <!--<div class="product-card__badge product-card__badge&#45;&#45;sale">Sale</div>-->
                <!--</div>-->
                <div class="product-card__image">
                    <a :href="product_slug"><img :src="image_url" alt="" class="product-fit-image"></a>
                </div>
                <div class="product-card__info">
                    <div class="product-card__name">
                        <a :href="product_slug">{{name}}</a>
                    </div>

                </div>
                <div class="product-card__actions">
                    <div class="product-card__availability">
                        Availability: <span class="text-success">In Stock</span>
                    </div>
                    <div class="product-card__prices" >
                        <span class="product-card__new-price">{{'₹ '+s_price}}</span>
                        <span class="product-card__old-price">{{'₹ '+cost}}</span>
                    </div>
                    <div class="product-card__prices outofstock" v-if="oos">
                        <span class="product-card__new-price">OUT OF STOCK</span>
                    </div>

                    <!--<div class="product-card__buttons">-->
                        <!--<button class="btn btn-primary product-card__addtocart" type="button">Add To Cart</button>-->
                        <!--<button class="btn btn-secondary product-card__addtocart product-card__addtocart&#45;&#45;list" type="button">Add To Cart</button>-->
                        <!--&lt;!&ndash;<button class="btn btn-light btn-svg-icon btn-svg-icon&#45;&#45;fake-svg product-card__wishlist" type="button">-->
                            <!--<svg width="16px" height="16px">-->
                                <!--<use xlink:href="http://localhost/pittappillil/client/images/sprite.svg#wishlist-16"></use>-->
                            <!--</svg>-->
                            <!--<span class="fake-svg-icon fake-svg-icon&#45;&#45;wishlist-16"></span>-->
                        <!--</button>-->
                        <!--<button class="btn btn-light btn-svg-icon btn-svg-icon&#45;&#45;fake-svg product-card__compare" type="button">-->
                            <!--<svg width="16px" height="16px">-->
                                <!--<use xlink:href="http://localhost/pittappillil/client/images/sprite.svg#compare-16"></use>-->
                            <!--</svg>-->
                            <!--<span class="fake-svg-icon fake-svg-icon&#45;&#45;compare-16"></span>-->
                        <!--</button>&ndash;&gt;-->
                    <!--</div>-->
                </div>
            </div>
        </div>
    </div>
</template>


<script>

    export default {
        mounted() {
            if(this.url){
                this.image_url = baseUrl+'/'+this.url;
            }else{
                this.image_url = baseUrl+'/client/images/no_product_image.png';
            }
            this.product_slug = baseUrl+'/'+this.slug;this.cost = this.mrp;
            if(!this.sale_price || !this.cost){this.s_price = 'NA';this.cost = 'NA'}else{this.s_price  = this.sale_price;}

            this.name = this.truncateWithEllipses(this.product_name,30);
            this.old = this.mrp;

            this.stock =  this.stock_;

            if(this.stock <=0){
                this.oos = true;
            }

        },
        data: function(){
            return {
                image_url:'',
                product_slug:'',
                s_price:'',
                cost:'',
                name:'',
                stock:'',
                oos:false
            }
        },
        methods:{
            truncateWithEllipses(text, max)
            {
                return text.substr(0,max-1)+(text.length>max?'...':'');
            }
        },
        props: [
            'product_name','url','slug','sale_price','mrp','stock_'
        ]
    }
</script>

<style>
    .product_active{
        background-color: #f36 !important;
    }
    .block-products-carousel[data-layout="grid-4"] .product-card .product-card__buttons .btn {
        font-size: 10px;
        height: calc(1.875rem + 2px);
        line-height: 1.25;
        padding: .375rem 1rem;
        font-weight: 500;
    }
    .outofstock{
        background: beige;
        font-size: 12px !important;
        padding: 5px;
        border-radius: 5px;
        text-align: center;
    }
</style>