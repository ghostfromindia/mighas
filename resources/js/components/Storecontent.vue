<template>

    <div class="shop-layout__content" id="store">
        <div class="block" v-if="isopen">
            <div class="products-view">
                <div class="products-view__options">
                    <div class="view-options view-options--offcanvas--mobile">
                        <div class="view-options__filters-button">
                            <button type="button" class="filters-button">
                               <!-- <svg class="filters-button__icon" width="16px" height="16px">
                                    <use xlink:href="http://localhost/p/client/images/sprite.svg#filters-16"></use>
                                </svg>-->
                                <span class="filters-button__title">Filters</span>
                                <!--<span class="filters-button__counter">3</span>-->
                            </button>
                        </div>
                        <div class="view-options__layout">
                            <div class="layout-switcher">
                                <div class="layout-switcher__list">
                                    <button data-layout="grid-3-sidebar" data-with-features="true" title="Grid" type="button" class="layout-switcher__button  layout-switcher__button--active ">
                                        <svg width="16px" height="16px"><use :xlink:href="base+'/client/images/sprite.svg#layout-grid-with-details-16x16'"></use></svg>
                                    </button>
                                    <button data-layout="grid-3-sidebar" data-with-features="false" title="Grid With Features" type="button" class="layout-switcher__button ">
                                        <svg width="16px" height="16px"><use :xlink:href="base+'/client/images/sprite.svg#layout-grid-16x16'"></use></svg>
                                    </button>
                                    <button data-layout="list" data-with-features="false" title="List" type="button" class="layout-switcher__button ">
                                        <svg width="16px" height="16px"><use :xlink:href="base+'/client/images/sprite.svg#layout-list-16x16'"></use></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="view-options__legend">Showing {{per_page}} of {{total}} products</div>
                        <div class="view-options__divider"></div>
                        <div class="view-options__control">
                            <label for="">Sort By</label>
                            <div>
                                <select class="form-control form-control-sm" @change="sort($event)"  v-model="key1" >
                                    <option value="">Default</option>
                                    <option value="1">Name (A-Z)</option>
                                    <option value="2">Name (Z-A)</option>
                                    <option value="3">Price (Low-High)</option>
                                    <option value="4">Price (High-Low)</option>
                                </select>
                            </div>
                        </div>
                        <div class="view-options__control">
                            <label for="">Show</label>
                            <div>
                                <select class="form-control form-control-sm"  @change="limit($event)"  v-model="key2">
                                    <option value="">12</option>
                                    <option value="24">24</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="products-view__list products-list" data-layout="grid-3-sidebar" data-with-features="true">
                    <div class="products-list__body">
                        <product-for-list
                                v-for="p in products" :key="p.id"
                                :product="p.product_name"
                                :price="p.sale_price"
                                :slug="p.slug"
                                :image="p.url"
                                :stock_="p.stock"
                                :category ="p.category"
                                :mrp = "p.mrp"
                                >
                        </product-for-list>
                    </div>
                </div>

                <div class="products-view__pagination">

                    <ul class="pagination justify-content-center">

                        <li class="page-item" v-on:click="prev()" v-bind:class="{ disabled: isPrevActive}">
                            <a class="page-link page-link--with-arrow" href="javascript:void(0)" aria-label="Previous">
                               <!-- <svg class="page-link__arrow page-link__arrow&#45;&#45;left" aria-hidden="true" width="8px" height="13px">
                                    <use xlink:href="http://localhost/p/client/images/sprite.svg#arrow-rounded-left-8x13"></use>
                                </svg>-->
                            </a>
                        </li>

                        <li v-for="n in pagin" class="page-item" :class="{active:current_page === n}">

                            <span class="sr-only">(current)</span>
                            <span class="page-link" @click="change_page(n)">{{n}}</span>

                        </li>


                        <li class="page-item" v-on:click="next()" v-bind:class="{ disabled: isNextActive}">
                            <a href="" aria-label="Next" href="javascript:void(0)" class="page-link page-link--with-arrow">
                                <!--<svg class="page-link__arrow page-link__arrow&#45;&#45;right" aria-hidden="true" width="8px" height="13px">
                                    <use xlink:href="http://localhost/p/client/images/sprite.svg#arrow-rounded-right-8x13"></use>
                                </svg>-->
                            </a>
                        </li>

                    </ul>

                </div>
            </div>
        </div>

        <div class="container text-center" style="padding: 100px 0;" v-if="nores">

            <img :src="base+'/images/404.png'" class="responsive-img" width="300">

            <p><b>No results.</b></p>
            <span>Try checking your spelling or use more general terms</span>


        </div>


    </div>



</template>

<script>
    export default {
        data: function(){
            return {
                show:false,
                nores:false,
                isopen:true,
                base:baseUrl,
                items:[],
                products:[],
                product:{
                    product_name:'',
                    sale_price:'',
                    category:'',
                    url:'',
                    slug:'',
                    stock:'',
                    mrp:''
                },
                isNextActive:true,
                isPrevActive:false,
                current_page:'',
                per_page:'',
                from:'',
                last_page:'',
                current_page:'',
                page:0,
                products_image:'',
                total:'',
                per_page:'',
                layout1:'',
                layout2:'',
                layout3:'',
                brands:[],
                pagin:[],
                key1:'',
                key2:'',
                sort_alphabets:'',
                sort_price:'asc',
                limit_value:12

            }
        },
        created(){
            this.layout1 = baseUrl+'/client/images/ag1.png';
            this.layout2 = baseUrl+'/client/images/ag2.png';
            this.layout3 = baseUrl+'/client/images/ag3.png';
            console.log(":::::::PAGE CREATED:::::::"+this.page_)
        },
        mounted() {
            if(this.brand != null){
                this.brands = this.brand;
            }

            this.change_page(this.page_);

        },
        methods:{
            encodeQueryData(data) {
                const ret = [];
                for (let d in data)
                    ret.push(encodeURIComponent(d) + '=' + encodeURIComponent(data[d]));
                return ret.join('&');
            },
            prev(){
                if(this.current_page-1 > 0){
                    this.change_page(this.current_page-1);
                }else{
                    return false;
                }
            },
            next(){
                if(this.current_page < this.last_page){
                    this.change_page(this.current_page+1);
                }else{
                    return false;
                }
            },
            sort(event){
                switch (parseInt(event.target.value)) {
                    case 1: this.sort_alphabets = 'asc'; this.sort_price =''; break;
                    case 2: this.sort_alphabets = 'desc'; this.sort_price =''; break;
                    case 3: this.sort_price = 'asc'; this.sort_alphabets = ''; break;
                    case 4: this.sort_price = 'desc'; this.sort_alphabets = ''; break;
                }
                this.change_page(this.id)
            },
            limit(event){
                switch (parseInt(event.target.value)) {
                    case 12: this.limit_value = 12; break;
                    case 24: this.limit_value = 24; break;
                    default: this.limit_value = 12; break;
                }
                this.change_page(this.id)
            },
            fetchProductList(data){
                $('#store').hide()
                this.products = this.last_page =  this.current_page = this.total =  this.per_page = '';
                console.log(baseUrl+'/products_list?'+data)
                fetch(baseUrl+'/products_list?'+data)
                    .then(res=>res.json())
                    .then(res =>{
                        this.products = res.data;
                        this.last_page = res.last_page;
                        this.current_page = res.current_page;
                        this.total = res.total;
                        this.per_page = res.data.length;

                        let pagination =[];
console.log(res)
                        if(this.total > 0){
                            this.nores = false;
                            this.isopen = true;
                        }else{
                            this.isopen = false;
                            this.nores = true;
                        }


                        if(this.last_page == 1){
                            pagination[0] = 1;
                        }else{
                            pagination[0] = 1;
                            if(this.current_page !== 1){
                                pagination[5] = this.current_page;
                            }

                            let cp = this.current_page;
                            let ccp = this.current_page;
                            for (let i=4;(cp>1) && (i<5 && i>0);i--){
                                pagination[i] = --cp;
                            }
                            for (let i=6;(this.last_page>ccp) && (i<10) && (ccp<this.last_page-1);i++){
                                pagination[i] = ++ccp;
                            }
                            if (this.current_page != this.last_page){
                                pagination[10] = this.last_page;
                            }

                            pagination = [...new Set(pagination)];
                            if(this.current_page == 1){
                                this.isPrevActive = true;
                            }else{
                                this.isPrevActive = false;
                            }

                            if(this.current_page == this.last_page){
                                this.isNextActive = true;
                            }else{
                                this.isNextActive = false;
                            }




                        }
                        this.pagin = pagination.filter(function (el) {
                            return el != null;
                        });



                        window.history.pushState({"html":baseUrl+'/stores/'+this.slug+'/?'+data,"pageTitle":'The great'},"", baseUrl+'/stores/'+this.slug+'?'+data);


                }).then(res =>{
                    $('#store').show()
                }).then(res =>{
                       $(function () {
        const body = $('body');
        const blockSidebar = $('.block-sidebar');
        const mobileMedia = matchMedia('(max-width: 991px)');

        if (blockSidebar.length) {
            const open = function() {
                if (blockSidebar.is('.block-sidebar--offcanvas--mobile') && !mobileMedia.matches) {
                    return;
                }

                const bodyWidth = body.width();
                body.css('overflow', 'hidden');
                body.css('paddingRight', (body.width() - bodyWidth) + 'px');

                blockSidebar.addClass('block-sidebar--open');
            };
            const close = function() {
                body.css('overflow', 'auto');
                body.css('paddingRight', '');

                blockSidebar.removeClass('block-sidebar--open');
            };
            const onChangeMedia = function() {
                if (blockSidebar.is('.block-sidebar--open.block-sidebar--offcanvas--mobile') && !mobileMedia.matches) {
                    close();
                }
            };

            $('.filters-button').on('click', function() {
                open();
            });


            if (mobileMedia.addEventListener) {
                mobileMedia.addEventListener('change', onChangeMedia);
            } else {
                mobileMedia.addListener(onChangeMedia);
            }
        }
        
        return true;
    });
    }).then(res =>{
         
                })
            },
            change_page(id){
                let data = {
                    page: id,
                    from: this.price_from,
                    to: this.price_to,
                    category: this.category,
                    brand: this.brands,
                    attributes: this.attributes,
                    keyword:this.keyword,
                    sort_alphabets:this.sort_alphabets,
                    sort_price:this.sort_price,
                    limit:this.limit_value
                }


                let querystring = this.encodeQueryData(data);
                this.fetchProductList(querystring);
                window.scrollTo(0,0);
            }

        },
        props: [
            'price_from','price_to','category','brand','slug','page_','keyword','attributes'
        ]
    }
</script>

<style>
    .product_active{
        background-color: #f36 !important;
    }
</style>