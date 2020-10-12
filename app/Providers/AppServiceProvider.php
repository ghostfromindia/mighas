<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Models\Settings;
use App\Models\HomePageSettings;
use Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        \Illuminate\Support\Facades\URL::forceScheme('http');
        $common_settings = ['logo_img'=>null, 'cs_number'=>null, 'search_placeholder'=>null, 'customer-service-text', 'latest-news-text', 'top-rated-products-text', 'special-offers', 'best-sellers', 'footer-links-group1'=>null, 'footer-links-group2'=>null, 'footer-contact'=>null, 'social-media'=>null, 'footer-links'=>null, 'newsletter-content'=>null, 'newsletter-head'=>null];
        if(Session::has('settings_session'))
        {
            $common_settings = Session::get('settings_session');
        }
        else{
            $settings = Settings::All();
            foreach ($settings as $key => $value) {
                if($value->type != 'Image')
                    $common_settings[$value->code] = $value->value;
                else
                    if($value->media)
                        $common_settings[$value->code] = $value->media->file_path;
            }

            $footer_settings = HomePageSettings::whereIn('section', ['footer-contact', 'social-media', 'footer'])->get();
            foreach ($footer_settings as $key => $fsetting) {
                $common_settings[$fsetting->section] = json_decode($fsetting->content);
            }
            Session::put('settings_session', $common_settings);
        }
        view()->share(['common_settings'=>$common_settings]);
        View::composer('client.includes.site_header', function ($view) {
            $view->with('categories', Category::get());
        });

    }
}
