<template>
        <div class="block-posts__slider">
                    <div class="owl-carousel">
                        <div class="post-card" v-for="item in news">
                            <div class="post-card__image">
                                <a :href="base_url+'/news/'+item.slug">
                                    <img :src="item.file_path ? base_url+'/'+item.file_path : base_url+'/images/default.png' " @error="imgError">
                                </a>
                            </div>
                            <div class="post-card__info">
                                <div class="post-card__name">
                                    <a :href="base_url+'/news/'+item.slug">{{item.name}}</a>
                                </div>
                                <div class="post-card__date">{{item.updated_at | formatDate}}</div>
                                <div class="post-card__content" v-html="item.short_description">
                                    
                                </div>
                                <div class="post-card__read-more">
                                    <a :href="base_url+'/news/'+item.slug" class="btn btn-secondary btn-sm">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
</template>
<script>
    import moment from 'moment'

    export default {
        data(){
            return{
                base_url: baseUrl,
                defaultImg: baseUrl+'/images/default.png',
                news: []
            }
        },
        created(){
            this.fetchNews()
        },
        methods: {
            fetchNews() {
                fetch(baseUrl+'/home/news-slider')
                    .then(res => res.json())
                    .then(res =>{
                        this.news = res;
                        }).then(res =>{

                        $('.block-posts').each(function() {
                            const layout = $(this).data('layout');
                            const options = {
                                margin: 30,
                                nav: false,
                                dots: false,
                                loop: false,
                            };
                            const layoutOptions = {
                                'grid-nl': {

                                    responsive: {
                                        992: {items: 3},
                                        768: {items: 2},
                                        0: {items: 1}
                                    }
                                },
                                'list-sm': {
                                    responsive: {
                                        992: {items: 2},
                                        0: {items: 1}
                                    }
                                }
                            };
                            const owl = $('.block-posts__slider .owl-carousel');

                            owl.owlCarousel($.extend({}, options, layoutOptions[layout]));

                            $(this).find('.block-header__arrow--left').on('click', function() {
                                owl.trigger('prev.owl.carousel', [500]);
                            });
                            $(this).find('.block-header__arrow--right').on('click', function() {
                                owl.trigger('next.owl.carousel', [500]);
                            });
                        });

            });

            },
            imgError(event){
              event.target.src = this.defaultImg;
            }

        },
        filters: {
          formatDate: function (value) {
            if (value) {
                return moment(String(value)).format('MMMM DD, YYYY')
            }
          }
        },
        mounted() {
        },
    }
</script>