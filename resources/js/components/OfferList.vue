<template>
    <div v-if="show" >
        <ul class="widget-categories__list" data-collapse="" data-collapse-opened-class="widget-categories__item--open">

            <li class="widget-categories__item" data-collapse-item="" v-for="offer in offers" :key="offer.id">
                <div class="widget-categories__row" data-collapse-trigger="">

                    <p> <span style="color:green;font-weight: bold"> {{offer.title}}</span> <br>
                        <small>Offers is valid till {{offer.to}}</small>
                        <br>


                    </p>
                </div>
            </li>

        </ul>

    </div>
</template>


<script>
    import Swal from 'sweetalert2/dist/sweetalert2.min';
    import 'sweetalert2/src/sweetalert2.scss'
    import axios from 'axios'

    import VueAxios from 'vue-axios'
    export default {
        data: function(){
            return {
                offers:[],
                offer:{
                    id:'',
                    title:'',
                    from:'',
                    to:'',
                },
                show:false
            }
        },
        created(){
            this.fetchOffers(this.variant_id);
        },
        mounted() {


        },
        methods:{
            beforeCreate(){
                this.image = 'https://i.imgur.com/Ro1gspg.gif';
            },
            fetchOffers(id)
            {
                console.log('fetching offers from ' + baseUrl + '/variant/offers/' +id);
                fetch(baseUrl +'/variant/offers/' +id)
                    .then(res => res.json())
                    .then(res => {
                        this.offers = res;
                        console.log(this.offers)
                        if(this.offers.length > 0){
                            this.show = true;
                        }
                    });
            },addToCart(id) {
                let data = {
                    variant_id: this.variant_id,
                    offer_id: id,
                    _token: csrf,
                };
                console.log(data)
                axios.post(baseUrl + '/cart/add/', data)
                    .then(function (res) {
                        console.log(res)
                    })
                    .catch(function (error) {
                        console.log(error)
                    });

                alert(id)
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
    p{
        font-size: 16px !important;
    }
    .widget-categories__item {
        list-style: none;
        padding: 0;
        margin: 0;
        line-height: 18px;
        font-size: 16px;
        border: 1px solid #d6d6d6;
        background: linear-gradient(-45deg, #f1d6df, #fdfeff);
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 5px;
    }

    .offer_btn{
        display: block;
        margin-top: 15px;
    }
    .offer_btn_bottom{
        position: absolute;
        bottom: 0;
        width: 100%;
        padding: 0px;
        margin-left: -40px;
        height: 10%;
        border-top-left-radius: 0px;
        border-top-right-radius: 0px;
        font-size: 21px;
        background: linear-gradient(45deg, #15766f, #2e5674);
        border: none;
    }
    p {
        margin-top: 0;
        margin-bottom: 0px;
    }


</style>