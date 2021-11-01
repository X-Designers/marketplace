<?php

namespace App\Providers;

use App\Category;
use App\Deposit;
use App\GeneralSetting;
use App\Language;
use App\Page;
use App\Extension;
use App\User;
use App\Frontend;
use App\Order;
use App\Product;
use App\Reviewer;
use App\Sell;
use App\SupportTicket;
use App\TempProduct;
use App\Withdrawal;
use Illuminate\Support\ServiceProvider;

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
        paginateMacro();
        $activeTemplate = activeTemplate();

        $viewShare['general'] = GeneralSetting::first();
        $viewShare['categories'] = Category::where('status',1)->get();
        $viewShare['activeTemplate'] = $activeTemplate;
        $viewShare['activeTemplateTrue'] = activeTemplate(true);
        $viewShare['language'] = Language::all();
        $viewShare['pages'] = Page::where('tempname',$activeTemplate)->where('slug','!=','home')->get();

        view()->share($viewShare);

        view()->composer('admin.partials.sidenav', function ($view) {
            $view->with([
                'banned_users_count' => User::banned()->count(),
                'email_unverified_users_count' => User::emailUnverified()->count(),
                'sms_unverified_users_count' => User::smsUnverified()->count(),
                'pending_ticket_count' => SupportTicket::whereIN('status', [0,2])->count(),
                'pending_deposits_count' => Deposit::pending()->count(),
                'pending_withdraw_count' => Withdrawal::pending()->count(),
                'pending_payment_count' => Deposit::pendingPayment()->count(),
                'banned_reviewers_count' => Reviewer::banned()->count(),
                'email_unverified_reviewers_count' => Reviewer::emailUnverified()->count(),
                'sms_unverified_reviewers_count' => Reviewer::smsUnverified()->count(),

                'pending_product_count' => Product::where('status',0)->whereHas('user', function ($query) {
                    $query->where('status',1);
                })->count(),

                'soft_product_count' => Product::where('status',2)->whereHas('user', function ($query) {
                    $query->where('status',1);
                })->count(),

                'hard_product_count' => Product::where('status',3)->whereHas('user', function ($query) {
                    $query->where('status',1);
                })->count(),

                'update_pending_product_count' => TempProduct::where('type',2)->whereHas('user', function ($query) {
                    $query->where('status',1);
                })->count(),

                'resubmit_product_count' => TempProduct::where('type',1)->whereHas('user', function ($query) {
                    $query->where('status',1);
                })->count(),
            ]);
        });

        view()->composer('reviewer.partials.sidenav', function ($view) {
            $view->with([
                'pending_product_count' => Product::where('status',0)->whereHas('user', function ($query) {
                    $query->where('status',1);
                })->count(),

                'soft_product_count' => Product::where('status',2)->whereHas('user', function ($query) {
                    $query->where('status',1);
                })->count(),

                'hard_product_count' => Product::where('status',3)->whereHas('user', function ($query) {
                    $query->where('status',1);
                })->count(),

                'update_pending_product_count' => TempProduct::where('type',2)->whereHas('user', function ($query) {
                    $query->where('status',1);
                })->count(),

                'resubmit_product_count' => TempProduct::where('type',1)->whereHas('user', function ($query) {
                    $query->where('status',1);
                })->count(),
            ]);
        });

        view()->composer('partials.seo', function ($view) {
            $seo = Frontend::where('data_keys', 'seo.data')->first();
            $view->with([
                'seo' => $seo ? $seo->data_values : $seo,
            ]);
        });

    }
}
