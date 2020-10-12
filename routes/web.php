<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('category_slug', 'Client\HomeController@category_slug_generator');
Route::get('update-payment-receive-status', 'Client\HomeController@get_payment_staus_response');
Route::get('rundbops','Client\HomeController@DBops');

Route::get('testmail','Client\HomeController@testmail');
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Clear Config cleared</h1>';
});

Route::get('add-landmarks-1-0-20-20',function (){
   $prices = \App\Models\Pincode::all();
   foreach ($prices as $obj){
       $price = new \App\Models\BranchLandmark;
       $price->landmark = $obj->place;
       $price->district_id =  $obj->district_id;
       $price->save();
   }
});
Route::get('round-pric-20-00-20',function (){
   $prices = \App\Models\Products\Variants\Inventory::all();
   foreach ($prices as $obj){
       $price = \App\Models\Products\Variants\Inventory::find($obj->id);
       $price->retail_price = round($obj->retail_price);
       $price->sale_price = round($obj->sale_price);
       $price->landing_price = round($obj->landing_price);
       $price->save();
   }
});



Auth::routes();

Route::match(['get', 'post'], 'api', ['uses' => 'WingsApiController@index', 'as' => 'api']);

Route::get('/select2/country', 'PluginsController@select2_countries')->name('select2.country');
Route::get('/select2/state/{country_id?}', 'PluginsController@select2_states')->name('select2.state');
Route::get('/select2/categories', 'PluginsController@select2_categories')->name('select2.categories');
Route::get('/select2/brands', 'PluginsController@select2_brands')->name('select2.brands');
Route::get('/select2/venders', 'PluginsController@select2_venders')->name('select2.venders');
Route::get('/select2/groups', 'PluginsController@select2_groups')->name('select2.groups');
Route::get('/select2/products', 'PluginsController@select2_products')->name('select2.products');
Route::get('/select2/order-status', 'PluginsController@select2_order_status')->name('select2.order-status');
Route::get('select2/pages', 'PluginsController@select2_pages')->name('select2.pages');

Route::get('/ajax/locations/{district_id}', 'PluginsController@ajax_locations')->name('select2.ajax-locations');

Route::get('/validation/user', 'PluginsController@unique_user')->name('validate.unique_user');
Route::get('/validation/customer-phone', 'PluginsController@unique_customer_phone')->name('validate.unique_customer_phone');
Route::get('/validation/attribute-slug', 'PluginsController@unique_attribute_slug')->name('validate.unique_attribute_slug');
Route::get('/validation/attribute-value-slug', 'PluginsController@unique_attribute_value_slug')->name('validate.unique_attribute_value_slug');
Route::get('/validation/product-slug', 'PluginsController@unique_product_slug')->name('validate.unique_product_slug');
Route::get('/validation/product-variant-slug', 'PluginsController@unique_product_variant_slug')->name('validate.unique_product_variant_slug');
Route::get('unique/page-slug', 'PluginsController@unique_page_slug')->name('validate.unique.page-slug');
Route::get('/validation/user-email', 'PluginsController@unique_user_email')->name('validate.unique.user-email');
Route::get('/validation/user-phone', 'PluginsController@unique_user_phone')->name('validate.unique.user-phone');
Route::get('/validate.unique.coupon-code', 'PluginsController@unique_coupon_code')->name('validate.unique.coupon-code');

include 'admin.php';

Route::get('/home', function(){ 
    return Redirect::to(url('account/dashboard'), 301); 
});

Route::get('/login', function(){ 
    return Redirect::to(url('/'), 301); 
})->name('login');


Route::group(['prefix' => 'account', 'middleware' => ['isCustomer'], 'namespace' => 'Hykon'], function() {
    Route::get('/dashboard', 'CustomerController@index')->name('account');
    Route::get('/edit-profile', 'CustomerController@edit_profile')->name('account.edit-profile');
    Route::post('/save-profile', 'CustomerController@save_profile')->name('account.save-profile');
    Route::get('/orders', 'AccountOrderController@index')->name('account.orders');
    Route::get('/order/{order_id}', 'AccountOrderController@order_details')->name('account.orders-details');

    Route::get('/order/invoice/{order_id}', 'AccountOrderController@invoice')->name('account.invoice');

    Route::post('/cancel-order/save', 'AccountOrderController@cancel_order_save')->name('account.orders.cancel-order-save');
    Route::get('/cancel-order/{order_id}', 'AccountOrderController@cancel_order')->name('account.orders.cancel-order');

    Route::get('/default-address', 'ApiController@default_address')->name('account.default-addresses');

    Route::get('/addresses', 'CustomerController@addresses')->name('account.addresses');
    Route::get('/address-remove/{id}', 'CustomerController@remove_address')->name('account.addresses.remove');
    Route::get('/address-make-default/{id}', 'CustomerController@make_default_address')->name('account.addresses.make-default');
    Route::post('/address/save', 'CustomerController@save_address')->name('account.addresses.save');

    Route::get('/address/add-delivery-instructions/{address_id}', 'CustomerController@add_delivery_instructions')->name('account.address.add-delivery-instructions');
    Route::post('/address/save-delivery-instructions', 'CustomerController@save_delivery_instructions')->name('account.address.save-delivery-instructions');

    Route::get('/address/{location}/{address_id?}', 'CustomerController@get_address')->name('account.addresses.view');
    Route::post('/address/update', 'CustomerController@update_address')->name('account.addresses.update');
    Route::post('/address/delete/{address_id}', 'CustomerController@delete_address')->name('account.addresses.delete');

    Route::get('/change-password', 'CustomerController@change_password')->name('account.change-password');
    Route::post('/update-password', 'CustomerController@changePassword')->name('account.update-password');
});

Route::group(['middleware' => ['isGuest']], function() {
    Route::get('/','Migas\HomeController@home');

    //Errors
    Route::get('error/404','Migas\ErrorController@error_404')->name('404');

    Route::get('xxx','Migas\ApiController@dream11');

    //DB changes
    Route::get('alter/menu','Migas\ApiController@menu_domain_change');


    Route::get('alter/category/meta','Migas\ApiController@category_meta_auto');
    Route::get('alter/branch','Migas\ApiController@brach_data');

    //Wishlist
    Route::get('wishlist','Migas\WishListController@show_wishlist');
    Route::post('wishlist','Migas\WishListController@add_wishlist');

    //Branch - Search
    Route::get('branch/states','Migas\BrachController@states');
    Route::get('branch/list','Migas\BrachController@list');
    Route::get('branch/states/{state_id}','Migas\BrachController@district');
    Route::get('branch/states/branch/{district_id}','Migas\BrachController@branch');


    Route::get('dev/category-without-products','Migas\MyController@category_without_products');


    Route::get('products/','Migas\HomeController@products');
    Route::get('products/{slug}','Migas\HomeController@singe_product');
    Route::get('search','Migas\SearchController@make_search');
    Route::get('search/{slug}','Migas\SearchController@search');

    //Pages
    Route::get('company/career','Migas\PageController@career');
    Route::get('company/history','Migas\PageController@history');
    Route::get('company/leadership','Migas\PageController@leadership');
    Route::get('company/contact','Migas\PageController@contact');
    Route::get('company/about-us','Migas\PageController@about');
    Route::get('company/delivery-polices','Migas\PageController@delivery_polices');
    Route::get('company/buying-guide','Migas\PageController@buying_guide');
    Route::get('company/warranty','Migas\PageController@warranty');

    //Pages post
    Route::post('company/warranty','Migas\PageController@warranty_save');
    Route::post('company/career','Migas\PageController@career_save');

    //Blogs
    Route::get('blog','Migas\PageController@blog');
    Route::get('blog/{slug}','Migas\PageController@blog_details');

    //News
    Route::get('news','Migas\PageController@news');
    Route::get('news/{slug}','Migas\PageController@news_details');

    //Event
    Route::get('event','Migas\PageController@event');
    Route::get('event/{slug}','Migas\PageController@event_details');

    //Cart related
    Route::get('cart','Migas\CartController@cart');
    Route::post('cart/save','Migas\CartController@add_to_cart'); // variant_id,quantity

    //Checkout related
    Route::get('checkout/address','Migas\CheckOutController@address');
    Route::get('checkout/overview','Migas\CheckOutController@overview');
    Route::post('checkout/create','Migas\OrderController@order_create');
    Route::post('checkout/address/save','Migas\CheckOutController@save_address');
    Route::post('checkout/summary','Migas\CheckOutController@summary');
    Route::post('checkout/payment/initiate','Migas\OrderController@order_create');
    Route::post('checkout/payment/response','Migas\OrderController@payment_response');
    Route::post('newsletter/save', 'Migas\ContactController@newsletter_save');


    //Store locator
    Route::match(['get', 'post'], 'store-locator', ['uses' => 'BranchController@index', 'as' => 'store-locator']);
    Route::get('store-locator/{branch}', 'BranchController@view');
    Route::get('/ajax/branch-locations/{district_id}', 'BranchController@ajax_branch_locations')->name('select2.ajax-branch-locations');

    //OTP
    Route::post('/send/otp', 'Migas\ApiController@sendotp')->name('sendotp');
    Route::post('/otp/verify', 'Migas\ApiController@otpverify')->name('otpverify');

    //Popups and leads
    Route::post('lead','Migas\LeadsController@common_popup');

    Route::get('/{slug}/{type}','Migas\HomeController@category_by_type');
    Route::get('/{slug}','Migas\HomeController@category');





});





Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback','Auth\LoginController@handleProviderCallback');
Route::post('login/save-callback','Auth\LoginController@handleProviderAjaxCallback');


