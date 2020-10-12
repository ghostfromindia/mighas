<template>
    <div class="block-product-columns__column">
        <div class="block-product-columns__item" v-for="product in products">
                                <div class="product-card product-card--layout--horizontal">
                                    <div class="product-card__image">
                                        <a :href="base_url+'/'+product.slug"><img :src="product.file_name ? base_url+'/uploads/products/200X200/'+product.file_name : base_url+'/images/default.png' " @error="imgError"></a>
                                    </div>
                                    <div class="product-card__info">
                                        <div class="product-card__name">
                                            <a :href="base_url+'/'+product.slug">{{product.name}}</a>
                                        </div>
                                        <div class="product-card__rating">
                                            <div class="ratings" :data-rating="product.rating"></div>
                                            <div class="product-card__rating-legend" v-if="product.reviews">{{product.reviews}} Reviews</div>
                                        </div>
                                    </div>
                                    <div class="product-card__actions">
                                        <div class="product-card__prices">
                                            <span class="product-card__new-price">{{'₹ '+product.sale_price}}</span>
                                            <span class="product-card__old-price" v-if="product.sale_price != product.mrp">{{'₹ '+product.mrp}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
    </div>
</template>
<script>
    require('../../../public/assets/js/jquery.star-rating-svg.min.js')

    export default {
        data(){
            return{
                base_url: baseUrl,
                defaultImg: baseUrl+'/images/default.png',
                products: []
            }
        },
        created(){
            this.fetchNews()
        },
        methods: {
            fetchNews() {
                fetch(baseUrl+'/home/bottom-product-list/'+this.type)
                    .then(res => res.json())
                    .then(res =>{
                        this.products = res;
                        }).then(res =>{
                            $(".ratings").starRating({
                                starSize: 16,
                                readOnly: true,
                                ratedColor: '#ffd333'
                            });
                        });

            },
            imgError(event){
              event.target.src = this.defaultImg;
            }

        },
        mounted() {
        },
        props:['type']
    }
</script>