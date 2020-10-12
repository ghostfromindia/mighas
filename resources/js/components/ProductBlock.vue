<template>
    <div class="block-products-carousel__column">
        <div class="block-products-carousel__cell">
            <div class="product-card ">
                <div class="product-card__image">
                    <a :href="base+'/'+product.slug">
                        <img :src="base+'/'+product.media.file_path" alt="" class="product-fit-image" v-if="product.media">
                        <img :src="base+'/images/default.png'" alt="" class="product-fit-image" v-else>
                    </a>
                </div>
                <div class="product-card__info">
                    <div class="product-card__name">
                        <a :href="product.slug">{{product.name}}</a>
                    </div>

                </div>
                <div class="product-card__actions">
                    <price-tag :mrp="product.inventory.retail_price" :selling="product.inventory.sale_price" :key="product.id" :small="true"></price-tag>
                </div>
            </div>
        </div>
    </div>
</template>


<script>

    export default {
        data: function(){
            return {
                oos:false,
                vid:'',
                base:baseUrl,
                product:{
                    name:'',
                    slug:'',
                    media:[],
                    inventory:[]
                }
            }
        },
        created(){
            this.vid = this.variant_id;

        },
        mounted() {
            this.getDetails();
        },
        methods:{
            getDetails(){
                fetch(baseUrl+'/variant/'+this.vid).then(res => res.json()).then(res =>{
                    this.product = res;
                    console.log(this.product)
                })
            }
        },
        props: [
            'variant_id'
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