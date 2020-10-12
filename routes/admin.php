<?php

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware'=>'uam'], function(){
    Route::get('/', 'AdminController@login');
    Route::group(['middleware' => ['isAdmin']], function(){
        Route::get('/dashboard', ['as' => 'admin.dashboard.index', 'uses' => 'AdminController@index' ]);
        Route::get('/invoice/{id}', 'OrdersController@invoice');
        //users
        Route::get('/users/edit/{id}', 'UserController@edit')->name('admin.users.edit');
        Route::get('/users/destroy/{id}', 'UserController@destroy')->name('admin.users.destroy');
        Route::get('/users/create', 'UserController@create')->name('admin.users.create');
        Route::post('/users/update', 'UserController@update')->name('admin.users.update');
        Route::get('/users/change-status/{id}', 'UserController@changeStatus')->name('admin.users.change-status');
        Route::post('/users/store', 'UserController@store')->name('admin.users.store');
        Route::get('/users', 'UserController@index')->name('admin.users.index');

        //customers
        Route::get('/customers/edit/{id}', 'CustomerController@edit')->name('admin.customers.edit');
        Route::get('/customers/destroy/{id}', 'CustomerController@destroy')->name('admin.customers.destroy');
        Route::get('/customers/create', 'CustomerController@create')->name('admin.customers.create');
        Route::post('/customers/update', 'CustomerController@update')->name('admin.customers.update');
        Route::get('/customers/change-status/{id}', 'CustomerController@changeStatus')->name('admin.customers.change-status');
        Route::post('/customers/store', 'CustomerController@store')->name('admin.customers.store');
        Route::get('/customers', 'CustomerController@index')->name('admin.customers.index');


        //settings
        Route::get('/search/', 'SearchController@home');
        Route::get('/search/sync', 'SearchController@sync');
        Route::get('/search/create', 'SearchController@edit');
        Route::get('/search/edit/{id}', 'SearchController@edit')->name('admin.search.edit');
        Route::get('/search/destroy/{id}', 'SearchController@destroy')->name('admin.search.destroy');

        Route::post('/search/product/save', 'SearchController@products_save');
        Route::post('/search/category/save', 'SearchController@categories_save');


        // Landing page
        Route::post('landing-page-blocks', 'LandingPageController@add');
        Route::post('landing-page-blocks/get', 'LandingPageController@get');
        Route::post('landing-page-blocks/destroy', 'LandingPageController@destroy');

        //settings
        Route::get('/settings/edit/{id}', 'SettingsController@edit')->name('admin.settings.edit');
        Route::get('/settings/create', 'SettingsController@create')->name('admin.settings.create');
        Route::post('/settings/update', 'SettingsController@update')->name('admin.settings.update');
        Route::post('/settings/store', 'SettingsController@store')->name('admin.settings.store');
        Route::get('/settings', 'SettingsController@index')->name('admin.settings.index');
        Route::get('/settings/destroy/{id}', 'SettingsController@destroy')->name('admin.settings.destroy');

        //image settings
        Route::get('/image-settings/edit/{id}', 'ImageSettingsController@edit')->name('admin.image-settings.edit');
        Route::get('/image-settings/create', 'ImageSettingsController@create')->name('admin.image-settings.create');
        Route::post('/image-settings/update', 'ImageSettingsController@update')->name('admin.image-settings.update');
        Route::post('/image-settings/store', 'ImageSettingsController@store')->name('admin.image-settings.store');
        Route::get('/image-settings', 'ImageSettingsController@index')->name('admin.image-settings.index');
        Route::get('/image-settings/destroy/{id}', 'ImageSettingsController@destroy')->name('admin.image-settings.destroy');

        //products
        Route::get('/products/edit/{id}/{tab?}', 'ProductsController@edit')->name('admin.products.edit');
        Route::get('/products/destroy/{id}', 'ProductsController@destroy')->name('admin.products.destroy');
        Route::get('/products/create', 'ProductsController@create')->name('admin.products.create');
        Route::post('/products/update', 'ProductsController@update')->name('admin.products.update');
        Route::get('/products/change-status/{id}', 'ProductsController@changeStatus')->name('admin.products.change-status');
        Route::get('/products/set-psp-as-price/{id}', 'ProductsController@setPriceAsPsp')->name('admin.products.set-psp-as-price');
        Route::post('/products/store', 'ProductsController@store')->name('admin.products.store');
        Route::get('/products', 'ProductsController@index')->name('admin.products.index');
        Route::post('/products/media-save', 'ProductsController@mediaSave')->name('admin.products.media-save');

        Route::get('/products/export', 'ProductsController@export')->name('admin.products.export');
        Route::post('/products/export-save', 'ProductsController@export_save')->name('admin.products.export-save');
        Route::get('/products/import', 'ProductsController@import')->name('admin.products.import');
        Route::post('/products/import-save', 'ProductsController@import_save')->name('admin.products.import-save');

        Route::get('/products/attribute-import', 'ProductsController@attribute_import')->name('admin.products.attribute-import');
        Route::post('/products/attribute-import-save', 'ProductsController@attribute_import_save')->name('admin.products.attribute-import-save');

        Route::group(['prefix' => 'products', 'namespace' => 'Products'], function(){
            Route::get('/variants/edit/{id}', 'VariantsController@edit')->name('admin.products.variants.edit');
            Route::get('/variants/destroy/{id}', 'VariantsController@destroy')->name('admin.products.variants.destroy');
            Route::get('/variants/create/{pid}', 'VariantsController@create')->name('admin.products.variants.create');
            Route::post('/variants/update', 'VariantsController@update')->name('admin.products.variants.update');
            Route::get('/variants/change-status/{id}', 'VariantsController@changeStatus')->name('admin.products.variants.change-status');
            Route::post('/variants/store', 'VariantsController@store')->name('admin.products.variants.store');
            Route::get('/variants/{pid}', 'VariantsController@index')->name('admin.products.variants.index');
            Route::get('/variants/change-offer-status/{id}', 'VariantsController@changeOfferStatus')->name('admin.products.variants.change-offer-status');
        });

        //roles
        Route::get('/roles/edit/{id}', 'RolesController@edit')->name('admin.roles.edit');
        Route::get('/roles/destroy/{id}', 'RolesController@destroy')->name('admin.roles.destroy');
        Route::get('/roles/create', 'RolesController@create')->name('admin.roles.create');
        Route::post('/roles/update', 'RolesController@update')->name('admin.roles.update');
        Route::get('/roles/change-status/{id}', 'RolesController@changeStatus')->name('admin.roles.change-status');
        Route::post('/roles/store', 'RolesController@store')->name('admin.roles.store');
        Route::get('/roles', 'RolesController@index')->name('admin.roles.index');

        //groups
        Route::get('/groups/edit/{id}', 'GroupsController@edit')->name('admin.groups.edit');
        Route::get('/groups/destroy/{id}', 'GroupsController@destroy')->name('admin.groups.destroy');
        Route::get('/groups/create', 'GroupsController@create')->name('admin.groups.create');
        Route::post('/groups/update', 'GroupsController@update')->name('admin.groups.update');
        Route::get('/groups/change-status/{id}', 'GroupsController@changeStatus')->name('admin.groups.change-status');
        Route::post('/groups/store', 'GroupsController@store')->name('admin.groups.store');
        Route::get('/groups', 'GroupsController@index')->name('admin.groups.index');

        //media
        Route::get('/media', 'MediaController@index')->name('admin.media.index');
        Route::get('/media/popup/{popup_type?}/{type?}/{holder_attr?}/{related_id?}', 'MediaController@popup')->name('admin.media.popup');
        Route::post('/media/save', 'MediaController@save')->name('admin.media.save');
        Route::get('/media/edit/{id}', 'MediaController@edit')->name('admin.media.edit');
        Route::post('/media/store-extra/{id}', 'MediaController@storeExtra')->name('admin.media.store-extra');

        //offers
        Route::get('/offers/edit/{id}', 'OfferController@edit')->name('admin.offers.edit');
        Route::get('/offers/destroy/{id}', 'OfferController@destroy')->name('admin.offers.destroy');
        Route::get('/offers/create', 'OfferController@create')->name('admin.offers.create');
        Route::post('/offers/update', 'OfferController@update')->name('admin.offers.update');
        Route::get('/offers/change-status/{id}', 'OfferController@changeStatus')->name('admin.offers.change-status');
        Route::post('/offers/store', 'OfferController@store')->name('admin.offers.store');
        Route::get('/offers', 'OfferController@index')->name('admin.offers.index');

        Route::post('/offers/ajax-list', 'OfferController@ajax_list')->name('admin.offers.ajax-list');

        Route::get('vendor', 'VendorController@home');
        Route::get('vendor/home', 'VendorController@home')->name('admin.vendor.home');
        Route::get('vendor/create', 'VendorController@create')->name('admin.vendor.create');
        Route::get('vendor/edit/{id}', 'VendorController@edit')->name('admin.vendor.edit');
        Route::get('vendor/destroy/{id}', 'VendorController@destroy')->name('admin.vendor.destroy');
        Route::post('vendor/save', 'VendorController@save')->name('admin.vendor.save');
        Route::post('vendor/update', 'VendorController@update')->name('admin.vendor.update');

        Route::get('brand', 'BrandController@home')->name('admin.brand.home');
        Route::get('brand/create', 'BrandController@create')->name('admin.brand.create');
        Route::get('brand/edit/{id}', 'BrandController@edit')->name('admin.brand.edit');
        Route::get('brand/destroy/{id}', 'BrandController@destroy')->name('admin.brand.destroy');
        Route::post('brand/save', 'BrandController@save')->name('admin.brand.save');
        Route::post('brand/update', 'BrandController@update')->name('admin.brand.update');

        Route::get('category', 'CategoryController@home')->name('admin.category.home');
        Route::get('category/create', 'CategoryController@create')->name('admin.category.create');
        Route::get('category/edit/{id}', 'CategoryController@edit')->name('admin.category.edit');
        Route::get('category/destroy/{id}', 'CategoryController@destroy')->name('admin.category.destroy');
        Route::get('category/select2', 'CategoryController@category_select2')->name('admin.category.select2');
        Route::get('category/brochure/{slug}', 'CategoryController@remove_brochure');

        Route::post('category/save', 'CategoryController@save')->name('admin.category.save');
        Route::post('category/update', 'CategoryController@update')->name('admin.category.update');

        Route::get('/category/export', 'CategoryController@export')->name('admin.category.export');
        Route::post('/category/export-save', 'CategoryController@export_save')->name('admin.category.export-save');
        Route::get('/category/import', 'CategoryController@import')->name('admin.category.import');
        Route::post('/category/import-save', 'CategoryController@import_save')->name('admin.category.import-save');

        Route::get('/reports/abandoned-carts', 'ReportsController@abandoned_carts')->name('admin.reports.abandoned-carts');
        Route::get('/reports/abandoned-carts/destroy/{id}', 'ReportsController@abandoned_cart_destroy')->name('admin.reports.abandoned-carts.destroy');
        Route::post('/reports/abandoned-carts/export', 'ReportsController@abandoned_cart_export')->name('admin.reports.abandoned-carts.export');

        Route::get('/reports/order-history', 'ReportsController@order_history')->name('admin.reports.order-history');
        Route::post('/reports/order-history/export', 'ReportsController@order_history_export')->name('admin.reports.order-history.export');

        Route::get('/reports/sales-history', 'ReportsController@sales_history')->name('admin.reports.sales-history');
        Route::post('/reports/sales-history/export', 'ReportsController@sales_history_export')->name('admin.reports.sales-history.export');

        Route::get('/reports/customer-details', 'ReportsController@customer_details')->name('admin.reports.customer-details');
        Route::post('/reports/customer-details/export', 'ReportsController@customer_details_export')->name('admin.reports.customer-details.export');

        //Category attributes
        Route::group(['prefix' => 'category', 'namespace' => 'Category'], function(){
            Route::get('/attributes/edit/{id}', 'AttributesController@edit')->name('admin.category.attribute.edit');
            Route::get('/attributes/create/{category_id?}', 'AttributesController@create')->name('admin.category.attribute.create');
            Route::post('/attributes/update', 'AttributesController@update')->name('admin.category.attribute.update');
            Route::post('/attributes/store', 'AttributesController@store')->name('admin.category.attribute.store');
            Route::get('/attributes/{category_id?}', 'AttributesController@index')->name('admin.category.attribute.index');
            Route::get('/attributes/destroy/{id}', 'AttributesController@destroy')->name('admin.category.attribute.destroy');

            Route::group(['prefix' => 'attribute', 'namespace' => 'Attribute'], function(){
                Route::get('/groups/edit/{id}', 'GroupsController@edit')->name('admin.category.attribute.groups.edit');
                Route::get('/groups/create/{category_id?}', 'GroupsController@create')->name('admin.category.attribute.groups.create');
                Route::post('/groups/update', 'GroupsController@update')->name('admin.category.attribute.groups.update');
                Route::post('/groups/store', 'GroupsController@store')->name('admin.category.attribute.groups.store');
                Route::get('/groups/{category_id?}', 'GroupsController@index')->name('admin.category.attribute.groups.index');
                Route::get('/groups/destroy/{id}', 'GroupsController@destroy')->name('admin.category.attribute.groups.destroy');

                Route::get('/values/edit/{id}', 'ValuesController@edit')->name('admin.category.attribute.value.edit');
                Route::get('/values/create/{attribute}', 'ValuesController@create')->name('admin.category.attribute.value.create');
                Route::post('/values/update', 'ValuesController@update')->name('admin.category.attribute.value.update');
                Route::post('/values/store', 'ValuesController@store')->name('admin.category.attribute.value.store');
                Route::get('/{attribute}', 'ValuesController@index')->name('admin.category.attribute.value.index');
                Route::get('/values/destroy/{id}', 'ValuesController@destroy')->name('admin.category.attribute.value.destroy');
            });
        });

        Route::get('newsletter', 'NewsLetterController@index')->name('admin.newsletter.index');
        Route::get('newsletter/create', function(){
            echo "No permission";exit;
        })->name('admin.newsletter.create');
        Route::get('newsletter/edit', function(){
            echo "No permission";exit;
        })->name('admin.newsletter.edit');
        Route::post('newsletter/store', function(){
            echo "No permission";exit;
        })->name('admin.newsletter.store');
        Route::post('newsletter/update', function(){
            echo "No permission";exit;
        })->name('admin.newsletter.update');
        Route::get('/newsletter/change-status/{id}', 'NewsLetterController@changeStatus')->name('admin.newsletter.change-status');
        Route::get('/newsletter/destroy/{id}', 'NewsLetterController@destroy')->name('admin.newsletter.destroy');

        Route::get('support', 'SupportController@index')->name('admin.support.index');
        Route::get('support/create', function(){
            echo "No permission";exit;
        })->name('admin.support.create');
        Route::get('support/edit', function(){
            echo "No permission";exit;
        })->name('admin.support.edit');
        Route::post('support/store', function(){
            echo "No permission";exit;
        })->name('admin.support.store');
        Route::post('support/update', function(){
            echo "No permission";exit;
        })->name('admin.support.update');
        Route::get('/support/destroy/{id}', 'SupportController@destroy')->name('admin.support.destroy');
        Route::get('/support/view/{id}', 'SupportController@show')->name('admin.support.view');


        Route::get('static/home', 'StaticPageController@home_page_data');
        Route::get('static/site', 'StaticPageController@site');
        Route::post('static/save', 'StaticPageController@save');
        Route::post('static/home/cmd', 'StaticPageController@save_cmd_message');
        Route::post('static/home/popular', 'StaticPageController@save_popular');
        Route::post('static/home/domestic', 'StaticPageController@save_domestic');
        Route::post('static/home/corporate', 'StaticPageController@save_corporate');
        Route::post('static/home/highlights', 'StaticPageController@save_highlights');
        Route::post('static/about', 'StaticPageController@save_about');
        Route::get('static/home/cmd/delete/{id}', 'StaticPageController@remove_cmd_image');
        Route::get('static/home/popular/remove/{id}', 'StaticPageController@remove_popular');
        Route::get('static/home/domestic/remove/{id}', 'StaticPageController@remove_domestic');
        Route::get('static/home/corporate/remove/{id}', 'StaticPageController@remove_corporate');
        Route::get('static/about', 'StaticPageController@about_page_data');



        Route::get('branch', 'BranchController@home')->name('admin.branch.home');
        Route::get('branch/create', 'BranchController@create')->name('admin.branch.create');
        Route::get('branch/edit/{id}', 'BranchController@edit')->name('admin.branch.edit');
        Route::get('branch/destroy/{id}', 'BranchController@destroy')->name('admin.branch.destroy');
        Route::get('branch/select2', 'BranchController@category_select2')->name('admin.branch.select2');

        Route::post('branch/save', 'BranchController@save')->name('admin.branch.save');
        Route::post('branch/update', 'BranchController@update')->name('admin.branch.update');

        Route::post('summernote/image', 'PluginController@summernote_image_upload')->name('admin.summernote.image');

        //orders
        Route::get('/orders/edit/{id}', 'OrdersController@edit')->name('admin.orders.edit');
        Route::get('/orders/view/{id}', 'OrdersController@view')->name('admin.orders.view');
        Route::get('/orders/destroy/{id}', function(){
            echo "Cannot access this path";exit;
        })->name('admin.orders.destroy');
        Route::get('/orders/create', 'OrdersController@create')->name('admin.orders.create');
        Route::post('/orders/update', 'OrdersController@update')->name('admin.orders.update');
        Route::post('/orders/change-status', 'OrdersController@changeStatus')->name('admin.orders.change-status');
        Route::post('/orders/store', 'OrdersController@store')->name('admin.orders.store');
        Route::get('/orders/{status?}', 'OrdersController@index')->name('admin.orders.index');

        //menus
        Route::get('/menus/edit/{id}', 'MenuController@edit')->name('admin.menus.edit');
        Route::get('/menus/destroy/{id}', 'MenuController@destroy')->name('admin.menus.destroy');
        Route::get('/menus/create', 'MenuController@create')->name('admin.menus.create');
        Route::post('/menus/update', 'MenuController@update')->name('admin.menus.update');
        Route::post('/menus/store', 'MenuController@store')->name('admin.menus.store');
        Route::get('/menus/change-status/{id}', 'MenuController@changeStatus')->name('admin.menus.change-status');
        Route::get('/menus', 'MenuController@index')->name('admin.menus.index');

        //page
        Route::get('pages', 'PageController@index')->name('admin.pages.index');
        Route::get('pages/create', 'PageController@create')->name('admin.pages.create');
        Route::get('pages/edit/{id}', 'PageController@edit')->name('admin.pages.edit');
        Route::get('pages/destroy/{id}', 'PageController@destroy')->name('admin.pages.destroy');
        Route::get('pages/change-status/{id}', 'PageController@changeStatus')->name('admin.pages.change-status');
        Route::post('pages/store', 'PageController@store')->name('admin.pages.store');
        Route::post('pages/update', 'PageController@update')->name('admin.pages.update');

        //coupons
        Route::get('coupons', 'CouponController@index')->name('admin.coupons.index');
        Route::get('coupons/create', 'CouponController@create')->name('admin.coupons.create');
        Route::get('coupons/edit/{id}', 'CouponController@edit')->name('admin.coupons.edit');
        Route::get('coupons/destroy/{id}', 'CouponController@destroy')->name('admin.coupons.destroy');
        Route::get('coupons/change-status/{id}', 'CouponController@changeStatus')->name('admin.coupons.change-status');
        Route::post('coupons/store', 'CouponController@store')->name('admin.coupons.store');
        Route::post('coupons/update', 'CouponController@update')->name('admin.coupons.update');

        //extended warranty
        Route::get('extended-warranty', 'ExtendedWarrantyController@index')->name('admin.extended-warranty.index');
        Route::get('extended-warranty/create', 'ExtendedWarrantyController@create')->name('admin.extended-warranty.create');
        Route::get('extended-warranty/edit/{id}', 'ExtendedWarrantyController@edit')->name('admin.extended-warranty.edit');
        Route::get('extended-warranty/destroy/{id}', 'ExtendedWarrantyController@destroy')->name('admin.extended-warranty.destroy');
        Route::get('extended-warranty/change-status/{id}/{status}', 'ExtendedWarrantyController@changeStatus')->name('admin.extended-warranty.change-status');
        Route::post('extended-warranty/store', 'ExtendedWarrantyController@store')->name('admin.extended-warranty.store');
        Route::post('extended-warranty/update', 'ExtendedWarrantyController@update')->name('admin.extended-warranty.update');

        //frontend page
        Route::get('frontend-pages', 'FrontendPageController@index')->name('admin.frontend-pages.index');
        Route::get('frontend-pages/destroy/{id}', function(){
            echo "Not possible";
        })->name('admin.frontend-pages.destroy');
        Route::get('frontend-pages/edit/{id}', 'FrontendPageController@edit')->name('admin.frontend-pages.edit');
        Route::post('frontend-pages/update', 'FrontendPageController@update')->name('admin.frontend-pages.update');

        //reviews
        Route::get('/reviews/edit/{id}/{tab?}', 'ReviewController@edit')->name('admin.reviews.edit');
        Route::get('/reviews/destroy/{id}', 'ReviewController@destroy')->name('admin.reviews.destroy');
        Route::get('/reviews/create', 'ReviewController@create')->name('admin.reviews.create');
        Route::post('/reviews/update', 'ReviewController@update')->name('admin.reviews.update');
        Route::get('/reviews/change-status/{id}/{status}', 'ReviewController@changeStatus')->name('admin.reviews.change-status');
        Route::post('/reviews/store', 'ReviewController@store')->name('admin.reviews.store');
        Route::get('/reviews', 'ReviewController@index')->name('admin.reviews.index');
        Route::post('/reviews/media-save', 'ReviewController@mediaSave')->name('admin.reviews.media-save');

        //sliders
        Route::get('/sliders/edit/{id}/{type?}', 'SliderController@edit')->name('admin.sliders.edit');
        Route::get('/sliders/destroy/{id}', 'SliderController@destroy')->name('admin.sliders.destroy');
        Route::get('/sliders/create', 'SliderController@create')->name('admin.sliders.create');
        Route::post('/sliders/update/{id}', 'SliderController@update')->name('admin.sliders.update');
        Route::post('/sliders/update-photo/{id}', 'SliderController@updatePhoto')->name('admin.sliders.update-photo');
        Route::post('/sliders/store', 'SliderController@store')->name('admin.sliders.store');
        Route::get('/sliders/photo-edit/{id}/{slider_id}/{type}', 'SliderController@photo_edit')->name('admin.sliders.photo_edit');
        Route::get('/sliders/photo-delete/{slider_id}/{id}/{type}', 'SliderController@photo_delete')->name('admin.sliders.photo_delete');
        Route::get('/sliders', 'SliderController@index')->name('admin.sliders.index');

        //home settings
        Route::get('home-settings', 'HomeSettingsController@index')->name('admin.home-settings.index');
        Route::post('/home-settings/store', 'HomeSettingsController@store')->name('admin.home-settings.store');

        //banners
        Route::get('/banners/edit/{id}/{type?}', 'BannerController@edit')->name('admin.banners.edit');
        Route::get('/banners/destroy/{id}', 'BannerController@destroy')->name('admin.banners.destroy');
        Route::get('/banners/create', 'BannerController@create')->name('admin.banners.create');
        Route::post('/banners/update/{id}', 'BannerController@update')->name('admin.banners.update');
        Route::post('/banners/update-photo/{id}', 'BannerController@updatePhoto')->name('admin.banners.update-photo');
        Route::post('/banners/store', 'BannerController@store')->name('admin.banners.store');
        Route::get('/banners/photo-edit/{id}/{slider_id}/{type}', 'BannerController@photo_edit')->name('admin.banners.photo_edit');
        Route::get('/banners/photo-delete/{slider_id}/{id}/{type}', 'BannerController@photo_delete')->name('admin.banners.photo_delete');
        Route::get('/banners', 'BannerController@index')->name('admin.banners.index');

        Route::get('/switch/out-of-stock/{type}','ProductsController@no_stock_switch');

        Route::get('browse-images/{category?}', 'ProductsController@browse_images')->name('admin.products.browse-images');
        Route::post('browse-images-save', 'ProductsController@browse_images_save')->name('admin.products.browse-images-save');

        Route::get('bulk-image-upload', 'ProductsController@bulk_image_upload')->name('admin.products.bulk-image-upload');
        Route::post('bulk-image-upload-save', 'ProductsController@bulk_image_upload_save')->name('admin.products.bulk-image-upload-save');

        Route::get('search-history', 'SearchHistoryController@index')->name('admin.search-history.index');
        Route::get('search-history/create', 'SearchHistoryController@create')->name('admin.search-history.create');
        Route::get('search-history/edit', function(){
            echo "No permission";exit;
        })->name('admin.search-history.edit');
        Route::post('/search-history/store', 'SearchHistoryController@store')->name('admin.search-history.store');
        Route::post('search-history/update', function(){
            echo "No permission";exit;
        })->name('admin.search-history.update');
        Route::get('/search-history/destroy/{id}', 'SearchHistoryController@destroy')->name('admin.search-history.destroy');
        Route::get('/search-history/export', 'SearchHistoryController@export')->name('admin.search-history.export');
    });
});