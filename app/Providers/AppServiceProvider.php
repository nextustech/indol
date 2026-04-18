<?php

namespace App\Providers;

use App\Models\BlogPost;
use App\Models\Option;
use App\Observers\BlogPostObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        BlogPost::observe(BlogPostObserver::class);

        try {
            DB::connection()->getPdo();

            $GLOBALS['is_db_connected'] = true;

            if (auth()->check()) {
                $optionsQuery = Option::all('option_key', 'option_value');
                $options = [];
                if ($optionsQuery->count()) {
                    foreach ($optionsQuery as $option) {
                        $options[$option->option_key] = $option->option_value;
                    }
                }
                $GLOBALS['options'] = $options;
            }

            /**
             * Set dynamic configuration for third party services
             */
            // $facebookConfig = [
            //     'services.facebook' =>
            //         [
            //             'client_id' => get_option('fb_app_id'),
            //             'client_secret' => get_option('fb_app_secret'),
            //             'redirect' => url('callback/facebook'),
            //         ]
            // ];
            // $googleConfig = [
            //     'services.google' =>
            //         [
            //             'client_id' => get_option('google_client_id'),
            //             'client_secret' => get_option('google_client_secret'),
            //             'redirect' => url('callback/google'),
            //         ]
            // ];
            // $twitterConfig = [
            //     'services.twitter' =>
            //         [
            //             'client_id' => get_option('twitter_consumer_key'),
            //             'client_secret' => get_option('twitter_consumer_secret'),
            //             'redirect' => url('callback/twitter'),
            //         ]
            // ];
            // $mailChimpConfig = [
            //     'newsletter.apiKey' =>
            //         get_option('mailchimp_apiKey'),
            //     'newsletter.lists.subscribers'=>
            //         [
            //             'id' => get_option('mailchimp_listId'),
            //         ],

            // ];

            // config($facebookConfig);
            // config($googleConfig);
            // config($twitterConfig);
            // config($mailChimpConfig);

            // /**
            //  * Email from name
            //  */

            // $emailConfig = [
            //     'mail.from' =>
            //         [
            //             'address' => get_option('email_address'),
            //             'name' => get_option('site_name'),
            //         ]
            // ];
            // config($emailConfig);

            view()->composer('*', function ($view) {

                $view->with(['testing_variable' => true]);
            });

        } catch (\Exception $e) {
            $GLOBALS['is_db_connected'] = false;

            //die("Could not connect to the database.  Please check your configuration.");
        }
        Paginator::useBootstrap(); // For Bootstrap 5

    }
}
