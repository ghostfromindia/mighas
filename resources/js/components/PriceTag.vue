<template>
    <div style="width: 100%">


        <div class="container"  v-if="discount">
               M.R.P.:	₹ <strike>{{Math.round(retail_price)}} </strike><br>
            <div v-if="small">
            <div><span >Price:</span> <span style="font-size: 25px;font-weight: bold">₹ {{Math.round(selling_price)}} </span> </div>
            <span style="font-size:15px;font-weight: bold;color:green">You Save:	₹ {{Math.round(discount_price)}} ({{discount_percentage}}%)</span> <br>
            </div>
            <div v-else>
                <div><span >Price:</span> <span style="font-size: 30px;font-weight: bold">₹ {{selling_price}} </span> </div>
                <span style="font-size:18px;font-weight: bold;color:green">You Save:	₹ {{Math.round(discount_price)}} ({{discount_percentage}}%)</span> <br>
            </div>

        </div>
        <div class="container"  v-else>
            
              <div><span >Price:</span> <span style="font-size: 25px;font-weight: bold">₹ {{Math.round(selling_price)}} </span> </div>
       </div>

        <div class="container">
        Inclusive of all taxes
        </div>



    </div>
</template>


<script>

    export default {

        data: function(){
            return {
                retail_price:'',
                selling_price:'',
                discount_percentage:'',
                discount_price:'',
                discount:''
            }
        },
        mounted() {
            this.retail_price = this.mrp;
            this.selling_price = this.selling;

            this.discount_price = this.mrp-this.selling;
            if(this.discount_price>0){
                this.discount = true;
            }

            console.log(this.mrp+'---'+this.selling);

            this.discount_percentage = parseInt((100 * (this.retail_price - this.selling_price))/this.retail_price);

        },
        props: [
            'mrp','selling','small'
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