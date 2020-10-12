/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');
window.Vue = require('vue');
Vue.use(require('vue-moment'));

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('examplecomponent', require('./components/ExampleComponent.vue').default);
Vue.component('product', require('./components/Product.vue').default);
Vue.component('productlist', require('./components/ProductList.vue').default);
Vue.component('productfloor', require('./components/ProductFloor.vue').default);
Vue.component('productsingle', require('./components/ProductSingle.vue').default);
Vue.component('offer', require('./components/Offer.vue').default);
Vue.component('offer-list', require('./components/OfferList.vue').default);
Vue.component('store', require('./components/Store.vue').default);
Vue.component('storecontent', require('./components/Storecontent.vue').default);
Vue.component('product-for-list', require('./components/Product_for_listing.vue').default);
Vue.component('specifications', require('./components/Specifications.vue').default);
Vue.component('reviews', require('./components/Reviews.vue').default);
Vue.component('related-products', require('./components/RelatedProducts.vue').default);
Vue.component('recommended-products', require('./components/RelatedProducts.vue').default);
Vue.component('price-tag', require('./components/PriceTag.vue').default);
Vue.component('product-block', require('./components/ProductBlock.vue').default);



Vue.component('home-slider', require('./views/HomeSlider.vue').default);
Vue.component('website-features', require('./views/WebsiteFeatures.vue').default);
Vue.component('home-banner', require('./views/HomeBanner.vue').default);
Vue.component('news-slider', require('./views/NewsSlider.vue').default);
Vue.component('featured-brands', require('./views/FeaturedBrands.vue').default);
Vue.component('home-product-box', require('./views/HomeBottomProductList.vue').default);
Vue.component('account-default-address', require('./views/AccountDefaultAddress.vue').default);
Vue.component('home-discount-banner', require('./views/HomeDiscountBanner.vue').default);
Vue.component('home-deals-banner', require('./views/HomeDealsBanner.vue').default);
Vue.component('home-popular-categories', require('./views/HomePopularCategories.vue').default);
Vue.component('home-cubed-banner', require('./views/HomeCubedBanners.vue').default);
Vue.component('home-banner-full-width', require('./views/HomeBannerFullWidth.vue').default);


Vue.component('grid-3', require('./views/Grid-3.vue').default);
Vue.component('grid-4', require('./views/Grid-4.vue').default);

Vue.component('user-address', require('./components/UserAddress.vue').default);
Vue.component('banner-display', require('./components/BannerDisplay.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
console.log(baseUrl)
const app = new Vue({
    el: '#app',
});
