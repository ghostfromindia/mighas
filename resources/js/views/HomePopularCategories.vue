<template>
<div class="block-categories__list">
                        <div class="block-categories__item category-card category-card--layout--classic" v-for="category in categories">
                            <div class="category-card__body">
                                <div class="category-card__image">
                                    <a :href="base_url"><img :src="category.primary ? base_url+'/'+category.primary.thumb_file_path : base_url+'/images/default.png' " @error="imgError"></a>
                                </div>
                                <div class="category-card__content">
                                    <div class="category-card__name">
                                        <a :href="base_url+'/stores/'+category.slug">{{category.category_name}}</a>
                                    </div>
                                    <ul class="category-card__links" v-if="category.sub_categories">
                                        <li v-for="sub_category in category.sub_categories"><a :href="base_url+'/stores/'+sub_category.slug">{{sub_category.category_name}}</a></li>
                                    </ul>
                                    <!--<div class="category-card__all">
                                        <a href="">Show All</a>
                                    </div>-->
                                </div>
                            </div>
                        </div>
                    </div>
</template>
<script>
    export default {
        data(){
            return{
                base_url: baseUrl,
                defaultImg: baseUrl+'/images/default.png',
                categories: [],
            }
        },
        created(){
            this.fetchCategories()
        },
        methods: {
            fetchCategories() {
                fetch(baseUrl+'/home/popular-categories')
                    .then(res => res.json())
                    .then(res =>{
                        this.categories = res;
                    });

            },
            imgError(event){
              event.target.src = this.defaultImg;
            }
        },
        mounted() {
        },
    }
</script>