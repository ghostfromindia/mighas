<template>
    <div class="products-list__item" >
        <div class="product-card m-0">

            <div class="product-card__image">
                <a :href="product_url"><img :src="product_image" alt="" style="height:100%;
    object-fit: contain;"></a>
            </div>
            <div class="product-card__info">
                <div class="product-card__name">
                    <a :href="product_url">{{product}}</a>
                </div>
                <ul class="product-card__features-list">
                    <li>Category : {{category_name}}</li>
                    <li>MRP : {{mrp}}</li>
                    <li v-if="discount_show">Discount : {{discount}}</li>
                </ul>
            </div>
            <div class="product-card__actions">
                <div class="product-card__availability">
                    Availability: <span class="text-success">In Stock</span>
                </div>
                <div class="product-card__prices">
                    ₹ {{price}}
                </div>
                <div class="product-card__prices outofstock" v-if="oos">
                    <span class="product-card__new-price">OUT OF STOCK</span>
                </div>
              <!--  <div class="product-card__buttons">
                    <button class="btn btn-primary product-card__addtocart" type="button">Add To Cart</button>
                    <button class="btn btn-secondary product-card__addtocart product-card__addtocart&#45;&#45;list" type="button">Add To Cart</button>
                    <button class="btn btn-light btn-svg-icon btn-svg-icon&#45;&#45;fake-svg product-card__wishlist" type="button">
                        <svg width="16px" height="16px">
                            <use xlink:href="images/sprite.svg#wishlist-16"></use>
                        </svg>
                        <span class="fake-svg-icon fake-svg-icon&#45;&#45;wishlist-16"></span>
                    </button>
                    <button class="btn btn-light btn-svg-icon btn-svg-icon&#45;&#45;fake-svg product-card__compare" type="button">
                        <svg width="16px" height="16px">
                            <use xlink:href="images/sprite.svg#compare-16"></use>
                        </svg>
                        <span class="fake-svg-icon fake-svg-icon&#45;&#45;compare-16"></span>
                    </button>
                </div>-->
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        data: function(){
            return {
                show:false,
                product_url:'',
                product_image:'',
                oos:'',
                category_name:'',
                mrp_:'',
                discount:'',
                discount_show:true
            }
        },
        created(){

        },
        mounted() {
            this.mrp_ = this.mrp;
            this.discount = this.mrp_ - this.price;
            if(this.discount <= 0){
                this.discount_show = false
            }else{this.discount_show = true}
            this.product_url = baseUrl+'/'+this.slug;
            this.product_image = this.image;
            console.log(">>>> "+this.product_image)
            if(this.product_image != null){
                this.product_image = baseUrl+'/'+this.image;
            }else{
                this.product_image = 'https://i.imgur.com/GH3KcVO.png';
            }
            this.category_name = this.category;
            if(this.stock_ <= 0){
                this.oos = true;
            }

        },
        props: [
            'product','price','slug','image','stock_','category','mrp'
        ]
    }
</script>
<style>
    .product_active{
        background-color: #f36 !important;
    }

    .product-card__prices {
        margin-top: 14px;
        line-height: 1;
        font-weight: 700;
        color: #e00715;
        font-size: 22px;
    }
    .outofstock{
        background: beige;
        font-size: 12px !important;
        padding: 5px;
        border-radius: 5px;
        text-align: center;
    }

</style>
