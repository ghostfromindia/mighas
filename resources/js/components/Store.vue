<template>
    <div class="shop-layout shop-layout--sidebar--start" style="min-height: 1400px;">
        <div class="shop-layout__sidebar"  v-if="isopen">
            <div class="block block-sidebar block-sidebar--offcanvas--mobile">
                <div class="block-sidebar__backdrop"></div>
                <div class="block-sidebar__body">
                    <div class="block-sidebar__header">
                        <div class="block-sidebar__title">Filters</div>
                        <button class="block-sidebar__close" type="button">
                            <svg width="20px" height="20px">
                                <use :xlink:href="base+'/client/images/sprite.svg#cross-20'"></use>
                            </svg>
                        </button>
                    </div>
                    <div class="block-sidebar__item">
                        <div class="widget-filters widget widget-filters--offcanvas--mobile" data-collapse data-collapse-opened-class="filter--opened">
                            <h4 class="widget-filters__title widget__title">Filters</h4>
                            <div class="widget-filters__list">
                                <div class="widget-filters__item">
                                    <div class="filter filter--opened" data-collapse-item>
                                        <button type="button" class="filter__title" data-collapse-trigger>
                                            Categories
                                          <!--  <svg class="filter__arrow" width="12px" height="7px">
                                                <use xlink:href="http://localhost/p/client/images/sprite.svg#arrow-rounded-down-12x7"></use>
                                            </svg>-->
                                        </button>
                                        <div class="filter__body" data-collapse-content>
                                            <div class="filter__container">
                                                <div class="filter-categories-alt">
                                                    <ul class="filter-categories-alt__list" data-collapse-opened-class="filter-categories-alt__item--open">

                                                        <li class="filter-categories-alt__item" data-collapse-item v-for="c in categories">
                                                            <span style="cursor: pointer" @click="getCategories(c.id)">{{c.name}}</span>
                                                        </li>

                                                       <!-- <li class="filter-categories-alt__item" data-collapse-item v-if="category_back != 0">
                                                            <span style="cursor: pointer" @click="getCategories(0)"><< back</span>
                                                        </li>-->

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="widget-filters__item">
                                    <div class="filter filter--opened" data-collapse-item>
                                        <button type="button" class="filter__title" data-collapse-trigger>
                                            Price
                                           <!-- <svg class="filter__arrow" width="12px" height="7px">
                                                <use xlink:href="http://localhost/p/client/images/sprite.svg#arrow-rounded-down-12x7"></use>
                                            </svg>-->
                                        </button>
                                        <div class="filter__body" data-collapse-content>
                                            <div class="filter__container">
                                                <div class="filter-price" :data-min="minmax.min" :data-max="minmax.max" :data-from="price_from" :data-to="price_to" id="filter-price_0001">
                                                    <div class="filter-price__slider"></div>
                                                    <div class="filter-price__title">Price: ₹<span class="filter-price__min-value_"></span> – ₹<span class="filter-price__max-value_" ></span></div>
                                                    <input type="hidden" id="price_from">
                                                    <input type="hidden" id="price_to">
                                                </div>
                                                <br>


                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="widget-filters__item">
                                    <div class="filter filter--opened" data-collapse-item>
                                        <button type="button" class="filter__title" data-collapse-trigger>
                                            Brand
                                            <svg class="filter__arrow" width="12px" height="7px">
                                                <use xlink:href="images/sprite.svg#arrow-rounded-down-12x7"></use>
                                            </svg>
                                        </button>
                                        <div class="filter__body" data-collapse-content>
                                            <div class="filter__container">
                                                <div class="filter-list">
                                                    <div class="filter-list__list">

                                                        <label class="filter-list__item " v-for="brand in brands" v-if="brand.id">
                                                                        <span class="filter-list__input input-check">
                                                                            <span class="input-check__body">
                                                                                <input class="input-check__input" name="brn" type="checkbox" v-on:change="updateBrands()" :value="brand.id" :checked="brand.status">
                                                                                <span class="input-check__box"></span>
                                                                                <svg class="input-check__icon" width="9px" height="7px">
                                                                                    <use xlink:href="images/sprite.svg#check-9x7"></use>
                                                                                </svg>
                                                                            </span>
                                                                        </span>
                                                            <span class="filter-list__title">
                                                                            {{brand.name}}
                                                            </span>
                                                            <!--<span class="filter-list__counter">7</span>-->
                                                        </label>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="widget-filters__item" v-for="(obj, index) in attributes">
                                    <div class="filter filter--opened" data-collapse-item>
                                        <button type="button" class="filter__title" data-collapse-trigger>
                                            {{index}}
                                            <svg class="filter__arrow" width="12px" height="7px">
                                                <use xlink:href="images/sprite.svg#arrow-rounded-down-12x7"></use>
                                            </svg>
                                        </button>
                                        <div class="filter__body" data-collapse-content>
                                            <div class="filter__container">
                                                <div class="filter-list">
                                                    <div class="filter-list__list">

                                                        <label class="filter-list__item " v-for="o in obj" v-if="o.id">
                                                                        <span class="filter-list__input input-check">
                                                                            <span class="input-check__body">
                                                                                <input class="input-check__input" name="attributes" type="checkbox" v-on:change="updateAttributes()" :value="o.id" :checked="o.status">
                                                                                <span class="input-check__box"></span>
                                                                                <svg class="input-check__icon" width="9px" height="7px">
                                                                                    <use xlink:href="images/sprite.svg#check-9x7"></use>
                                                                                </svg>
                                                                            </span>
                                                                        </span>
                                                            <span class="filter-list__title">
                                                                            {{o.value}}
                                                            </span>

                                                            </label>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


            <storecontent  :page_="cp" :slug="slug_" :keyword="keyword" :price_from="price_from" :price_to="price_to" :category="category_back" :brand="brands_selected" :attributes="attributes_selected" :key="kee" v-if="start"></storecontent>


        <div class="container text-center" style="padding: 100px 0;" v-if="nores">

            <img :src="base+'/images/404.png'" class="responsive-img" width="300">

            <p><b>No results.</b></p>
            <span>Try checking your spelling or use more general terms</span>


        </div>

    </div>
</template>

<script>

    window.noUiSlider = require('nouislider');


    export default {
        data: function(){
            return {
                isopen:false,
                nores:false,
                show:false,
                base:baseUrl,
                items:[],
                price_from:'',
                price_to:'',
                kee:1,
                category_back:0,
                brand:0,
                categories: {
                    id: '',
                    name: ''
                },
                minmax:{
                    min:200,
                    max:500
                },
                brands_selected:[],
                brands:[],
                brand:{
                    id:'',
                    name:'',
                    status:false
                },
                per_page:10000,
                element:'',
                slider:'',
                data:[],
                slug_:'',
                cp:'',
                keyword:'',
                start:false,
                attributes:[],
                attribute_values:[],
                attributes_selected:''

            }
        },
        created: function(){
            this.cp = this.page;


        },
        mounted: function () {
            if(this.from_){
                this.price_from = this.from_;

            }

            if(this.to_){
                this.price_to = this.to_;
            }
            if(this.keyword_){
                this.keyword = this.keyword_;
            }


            this.slug_ = this.slug;



            this.items = [1, 2, 3, 4, 5];






            $(document.body).on('click', '#price_from', function () {
                this.update_store();
            }.bind(this));
            $(document.body).on('click', '#price_to', function () {
                this.update_store();
            }.bind(this));
            
            $(document).on('click', '.block-sidebar__close', function(){
                this.isopen = true;
                $('body').css('overflow', 'auto');
                $('body').css('paddingRight', '');
                $('.block-sidebar').removeClass('block-sidebar--open');
            })

            this.getCategories(this.category);



        },
        methods:{
            update_store(){
                this.price_from = $('#price_from').val();
                this.price_to = $('#price_to').val();
                this.kee =this.kee+1;

            },
            selectedBrands(){
                let d =[];
                d['brands']='';
                $('[name=brn]:checkbox:checked').each(function(i){
                    if(i==0){
                        d['brands'] = $(this).val();
                    }else{
                        d['brands'] = d['brands']+","+$(this).val();
                    }
                });
                return d['brands'];
            },
            selectedAttributes(){
                let d =[];
                d['attributes']='';
                $('[name=attributes]:checkbox:checked').each(function(i){
                    if(i==0){
                        d['attributes'] = $(this).val();
                    }else{
                        d['attributes'] = d['attributes']+","+$(this).val();
                    }
                });
                return d['attributes'];
            },
            updateBrands(){
                this.data = [];
                this.data['from'] = this.price_from;
                this.data['to'] = this.price_to; this.data['brands']='';
                this.data['brands'] =  this.selectedBrands();
                this.brands_selected =  this.selectedBrands();
                this.data['attributes'] =  this.selectedAttributes();
                this.cp = 1;
                this.kee++;
                this.data = this.encodeQueryData(this.data);
                console.log( this.data);
            },
            updateAttributes(){
                let d = [];
                d['attributes']='';
                this.data = [];
                this.data['brands'] =  this.selectedBrands();
                this.data['attributes'] =  this.selectedAttributes();
                this.attributes_selected =  this.selectedAttributes();
                this.cp = 1;
                this.kee++;


                this.data = this.encodeQueryData(this.data);
                console.log( this.data);
            },
            getCategories(id){

                this.brands_selected = null;
                this.brands = null;
                this.data = [];
                this.data['brands'] = this.brands_;
                this.data['attributes'] = this.attributes_;
                this.data['keyword'] =this.keyword;
                if(id==null || id ==0){
                    id = 0;
                    this.data['brands'] = '';
                    this.data['from'] = '';
                    this.data['to'] = '';
                    this.data['attributes'] = '';
                    this.slug = null;
                }

                this.data = this.encodeQueryData(this.data);
                console.log(baseUrl + '/categories/'+id+'?'+this.data)
                fetch(baseUrl + '/categories/'+id+'?'+this.data).then(res => res.json()).then(res=>{
                    if(res.categories.length > 0){

                        this.nores = false;//hide 404
                        this.isopen = true;//show sidebar
                        this.category_back = id;
                        this.categories = res.categories;
                        this.minmax = res.minmax;
                        this.brands = res.brands;
                        this.attributes = res.attributes;
                        this.brands_selected = res.brands_selected;
                        this.attributes_selected = res.attributes_selected;
                        this.getAttributes();


                        if(this.minmax.min == this.minmax.max){
                            this.minmax.min = 0;
                            this.minmax.max = this.minmax.max;
                        }

                        if(id==null || id ==0) {
                            this.price_from = this.minmax.min;
                            this.price_to = this.minmax.max;
                        }

                        this.start = true;



                        $('.filter-price__min-value_').html(this.minmax.min);
                        $('.filter-price__max-value_').html(this.minmax.max);

                        this.kee++;

                    }else{
                        this.category_back = id;this.kee++;
                        this.nores = true;//hide 404
                        this.isopen = false;//show sidebar
                    }

return res;
                }).then(res=>{
                        this.minmax = res.minmax;
                        $('.filter-price__min-value_').html(this.minmax.min);
                        $('.filter-price__max-value_').html(this.minmax.max);
                        this.element = document.getElementById('filter-price_0001');
                        this.slider = this.element.querySelector('.filter-price__slider');
                        noUiSlider.create(this.slider, {
                            start: [this.minmax.min, this.minmax.max],
                            connect: true,
                            direction: 'ltr',
                            range: {
                                'min': this.minmax.min,
                                'max': this.minmax.max
                            }
                        });

                    const titleValues = [
                        $(this.element).find('.filter-price__min-value_')[0],
                        $(this.element).find('.filter-price__max-value_')[0]
                    ];


                    this.slider.noUiSlider.on('end', function (values, handle) {
                            this.page_ = 1;
                            titleValues[handle].innerHTML = values[handle];
                            $('#price_from').val(values[0]).trigger("click");
                            $('#price_to').val(values[1]).trigger("click");
                        });
                })
            },encodeQueryData(data) {
                const ret = [];
                for (let d in data)
                    ret.push(encodeURIComponent(d) + '=' + encodeURIComponent(data[d]));
                return ret.join('&');
            },
            getAttributes(){
                console.log(baseUrl+'/category/attributes/'+this.category+'?selected='+this.attributes_selected)
                fetch(baseUrl+'/category/attributes/'+this.category+'?selected='+this.attributes_selected).then(res => res.json()).then(res=>{
                    this.attributes = res;
                    console.log('response : '+ res)

                })
            }
        },
        props:['category','slug','brands_','page','from_','to_','keyword_','attributes_']
    }
</script>

<style>
    .product_active{
        background-color: #f36 !important;
    }
    .widget-filters {
        border: 2px solid #f0f0f0;
        border-radius: 2px;
        padding: 20px;
        border-bottom: none;
        padding-bottom: 0px;
    }
</style>