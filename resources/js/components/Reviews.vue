<template>

        <div class="reviews-list">
            <ol class="reviews-list__content">
                <li class="reviews-list__item" v-for="obj in reviews">
                    <div class="review">
                        <div class="review__content">
                            <div class="review__title">{{obj.title}}</div>
                            <div class="review__author">{{'by - '+obj.name}}</div>
                            <div class="review__rating">
                                <div class="my-rating" :data-rating="obj.rating"></div>
                            </div>
                            <div class="review__text">{{obj.review}}</div>
                            <div class="review__date">{{obj.time | moment("ddd , MMMM Do YYYY, ha")}}</div>
                        </div>
                    </div>
                </li>
            </ol>
            <div class="reviews-list__pagination">
                <ul class="pagination justify-content-center">

                    <li class="page-item" v-on:click="prev()" v-bind:class="{ disabled: isPrevActive}">
                        <a class="page-link page-link--with-arrow" href="javascript:void(0)" aria-label="Previous">
                            <!--<svg class="page-link__arrow page-link__arrow&#45;&#45;left" aria-hidden="true" width="8px" height="13px">
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
                         <!--   <svg class="page-link__arrow page-link__arrow&#45;&#45;right" aria-hidden="true" width="8px" height="13px">
                                <use xlink:href="http://localhost/p/client/images/sprite.svg#arrow-rounded-right-8x13"></use>
                            </svg>-->
                        </a>
                    </li>
                </ul>
            </div>
        </div>




</template>

<script>

    export default {
        data: function(){
            return {
                reviews:[],
                pagin:[],
                obj:{
                    title:'',
                    review:'',
                    rating:'',
                    name:'',
                    time:''
                },
                isNextActive:true,
                isPrevActive:false,
                last_page:'',
                current_page:'',
                total:'',
                per_page:'',
            }
        },
        created(){
            console.log('Review created');
        },
        mounted() {
            console.log('Review mounted');
            this.fetchReviews();
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
            fetchReviews(query) {
                console.log('creating review of a product from ' + baseUrl + '/fetch/review/' + this.id +'?'+query);
                fetch(baseUrl + '/fetch/review/' + this.id +'?'+query)
                    .then(res => res.json())
                    .then(res => {
                        this.reviews = res.data;
                        this.last_page = res.last_page;
                        this.current_page = res.current_page;
                        this.total = res.total;
                        this.per_page = res.data.length;

                        let pagination =[];


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

                    }).then(res =>{
                        $(".my-rating").starRating({
                        starSize: 20,
                        readOnly:true
                    });
                })
            },
            change_page(id){
                let data = {
                    page: id
                }


                let querystring = this.encodeQueryData(data);
                this.fetchReviews(querystring);
                window.scrollTo(0,0);
            }

        },
        props: [
            'id'
        ]
    }
</script>

<style>
    .review__author{
        font-size: 12px !important;
    }
    .review__title{
        font-size: 20px;
        font-weight: bold;
    }
    .review__text{
        margin-top: 0px;
    }
    .review__date{
        margin-top: 0px;
    }
</style>