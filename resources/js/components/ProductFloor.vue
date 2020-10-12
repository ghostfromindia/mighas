<template>
    <div class="block block-products-carousel active-button-addcart" :id="loader" data-layout="grid-4">
        <div class="container-fluid content">
            <div class="block-header">
                <h3 class="block-header__title p_grad" style="font-size:25px;">{{module_title}}</h3>
                <div class="block-header__divider"></div>
                <ul class="block-header__groups-list">
                    <li v-for="category in categories" :key="category.id"><button type="button" class="block-header__group" @click=select(category.id)>{{category.name}}</button></li>

                </ul>
                <div class="block-header__arrows-list">
                   <!-- <button class="block-header__arrow block-header__arrow&#45;&#45;left" type="button">
                        <svg width="7px" height="11px">
                            <use xlink:href="http://localhost/pittappillil/client/images/sprite.svg#arrow-rounded-left-7x11"></use>
                        </svg>
                    </button>
                    <button class="block-header__arrow block-header__arrow&#45;&#45;right" type="button">
                        <svg width="7px" height="11px">
                            <use xlink:href="http://localhost/pittappillil/client/images/sprite.svg#arrow-rounded-right-7x11"></use>
                        </svg>
                    </button>-->
                </div>
            </div>
            <div class="block-products-carousel__slider" style="min-height: 370px;">
                    <productlist  :type="type" :category="id" :key="key" :loader="loader"></productlist>
            </div>
        </div>
    </div>
</template>

<script>

    export default {

        data() {
            return{
                categories:[],
                module_title:'',
                category:{
                    id:'',
                    name:''
                },
                isMostViewed: false,
                id : 0,
                type:'',
                key : 1,
                loader:''
            }
        },
        created(){
            this.type = this.api;
            this.fetchProducts();
            this.module_title = this.title;
        },
        methods:{
            fetchProducts() {
                console.log('generating product list from ' + baseUrl + '/products/' + this.type + '/'+this.id);
                fetch(baseUrl + '/products/' + this.type+ '/'+this.id)
                    .then(res => res.json())
                    .then(res => {
                        this.categories = res.categories;
                        this.categories.unshift({id:0,name:'All'})
                        console.log(res);
                    });
            },
            select: function(val){
                this.id = val;
                this.key++;
                console.log(this.id )
            }
        },
        props:['api','title']


    }
</script>

<style scoped>

    .block{
        padding-bottom: 0px !important;
    }

</style>