<?php

use Illuminate\Support\Facades\Route;

Route::get('/clear', function(){
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::namespace('Gateway')->prefix('ipn')->name('ipn.')->group(function () {
    Route::post('paypal', 'paypal\ProcessController@ipn')->name('paypal');
    Route::get('paypal_sdk', 'paypal_sdk\ProcessController@ipn')->name('paypal_sdk');
    Route::post('perfect_money', 'perfect_money\ProcessController@ipn')->name('perfect_money');
    Route::post('stripe', 'stripe\ProcessController@ipn')->name('stripe');
    Route::post('stripe_js', 'stripe_js\ProcessController@ipn')->name('stripe_js');
    Route::post('stripe_v3', 'stripe_v3\ProcessController@ipn')->name('stripe_v3');
    Route::post('skrill', 'skrill\ProcessController@ipn')->name('skrill');
    Route::post('paytm', 'paytm\ProcessController@ipn')->name('paytm');
    Route::post('payeer', 'payeer\ProcessController@ipn')->name('payeer');
    Route::post('paystack', 'paystack\ProcessController@ipn')->name('paystack');
    Route::post('voguepay', 'voguepay\ProcessController@ipn')->name('voguepay');
    Route::get('flutterwave/{trx}/{type}', 'flutterwave\ProcessController@ipn')->name('flutterwave');
    Route::post('razorpay', 'razorpay\ProcessController@ipn')->name('razorpay');
    Route::post('instamojo', 'instamojo\ProcessController@ipn')->name('instamojo');
    Route::get('blockchain', 'blockchain\ProcessController@ipn')->name('blockchain');
    Route::get('blockio', 'blockio\ProcessController@ipn')->name('blockio');
    Route::post('coinpayments', 'coinpayments\ProcessController@ipn')->name('coinpayments');
    Route::post('coinpayments_fiat', 'coinpayments_fiat\ProcessController@ipn')->name('coinpayments_fiat');
    Route::post('coingate', 'coingate\ProcessController@ipn')->name('coingate');
    Route::post('coinbase_commerce', 'coinbase_commerce\ProcessController@ipn')->name('coinbase_commerce');
    Route::get('mollie', 'mollie\ProcessController@ipn')->name('mollie');
    Route::post('cashmaal', 'cashmaal\ProcessController@ipn')->name('cashmaal');
});

// User Support Ticket
Route::prefix('ticket')->group(function () {
    Route::get('/', 'TicketController@supportTicket')->name('ticket');
    Route::get('/new', 'TicketController@openSupportTicket')->name('ticket.open');
    Route::post('/create', 'TicketController@storeSupportTicket')->name('ticket.store');
    Route::get('/view/{ticket}', 'TicketController@viewTicket')->name('ticket.view');
    Route::post('/reply/{ticket}', 'TicketController@replyTicket')->name('ticket.reply');
    Route::get('/download/{ticket}', 'TicketController@ticketDownload')->name('ticket.download');
});


/*
|--------------------------------------------------------------------------
| Start Admin Area
|--------------------------------------------------------------------------
*/

Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {
    Route::namespace('Auth')->group(function () {
        Route::get('/', 'LoginController@showLoginForm')->name('login');
        Route::post('/', 'LoginController@login')->name('login');
        Route::get('logout', 'LoginController@logout')->name('logout');
        // Admin Password Reset
        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
        Route::post('password/reset', 'ForgotPasswordController@sendResetLinkEmail');
        Route::post('password/verify-code', 'ForgotPasswordController@verifyCode')->name('password.verify-code');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.change-link');
        Route::post('password/reset/change', 'ResetPasswordController@reset')->name('password.change');
    });

    Route::middleware(['admin','access'])->group(function () {
        Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');
        Route::get('profile', 'AdminController@profile')->name('profile');
        Route::post('profile', 'AdminController@profileUpdate')->name('profile.update');
        Route::get('password', 'AdminController@password')->name('password');
        Route::post('password', 'AdminController@passwordUpdate')->name('password.update');

        //System Info
        Route::get('request-report','AdminController@requestReport')->name('request.report');
        Route::post('request-report','AdminController@reportSubmit');

        //Report Bugs
        Route::get('system-info','AdminController@systemInfo')->name('system.info');
        Route::get('optimize', 'GeneralSettingController@optimize')->name('setting.optimize');

        //Custom CSS
        Route::get('custom-css','GeneralSettingController@customCss')->name('setting.custom.css');
        Route::post('custom-css','GeneralSettingController@customCssSubmit');

        //Cookie
        Route::get('cookie','GeneralSettingController@cookie')->name('setting.cookie');
        Route::post('cookie','GeneralSettingController@cookieSubmit');

        //Manage Category
        Route::get('category', 'CategoryController@categories')->name('category');
        Route::post('category/new', 'CategoryController@storeCategory')->name('category.store');
        Route::post('category/update/{id}', 'CategoryController@updateCategory')->name('category.update');
        Route::get('category/search', 'CategoryController@searchCategory')->name('category.search');
        Route::post('category/activate', 'CategoryController@activate')->name('category.activate');
        Route::post('category/deactivate', 'CategoryController@deactivate')->name('category.deactivate');

        //Manage Subcategory
        Route::get('subcategory/{id}/search', 'CategoryController@searchSubcategory')->name('category.sub.search');
        Route::get('subcategory/{id}', 'CategoryController@subcategories')->name('category.sub');
        Route::post('subcategory/new/{id}', 'CategoryController@storeSubcategory')->name('category.sub.store');
        Route::post('subcategory/update/{id}', 'CategoryController@updateSubcategory')->name('category.sub.update');
        Route::post('subcategory/activate', 'CategoryController@subcategoryActivate')->name('category.sub.activate');
        Route::post('subcategory/deactivate', 'CategoryController@subcategoryDeactivate')->name('category.sub.deactivate');

        //Manage Category Details
        Route::get('category-details/new/{id}', 'CategoryController@categoryDetailsNew')->name('category.details.new');
        Route::get('category-details/{id}', 'CategoryController@categoryDetails')->name('category.details');
        Route::post('category-details/store', 'CategoryController@categoryDetailsStore')->name('category.details.store');
        Route::get('category-details/edit/{c_id}/{c_d_id}', 'CategoryController@CategoryDetailsEdit')->name('category.details.edit');
        Route::post('category-details/update/{c_d_id}', 'CategoryController@CategoryDetailsUpdate')->name('category.details.update');

        //Manage Category
        Route::get('level', 'LevelController@levels')->name('level');
        Route::post('level/new', 'LevelController@storeLevel')->name('level.store');
        Route::post('level/update/{id}', 'LevelController@updateLevel')->name('level.update');
        Route::get('level/search', 'LevelController@searchLevel')->name('level.search');

        //Reviewer Manager
        Route::get('reviewers', 'ManageReviewersController@allReviewers')->name('reviewers.all');
        Route::get('reviewers/new', 'ManageReviewersController@newReviewer')->name('reviewers.new');
        Route::post('reviewers/store', 'ManageReviewersController@storeReviewer')->name('reviewers.store');
        Route::get('reviewer/detail/{id}', 'ManageReviewersController@detail')->name('reviewers.detail');
        Route::post('reviewer/update/{id}', 'ManageReviewersController@update')->name('reviewers.update');

        Route::get('reviewers/active', 'ManageReviewersController@activeReviewers')->name('reviewers.active');
        Route::get('reviewers/banned', 'ManageReviewersController@bannedReviewers')->name('reviewers.banned');
        Route::get('reviewers/email-verified', 'ManageReviewersController@emailVerifiedReviewers')->name('reviewers.emailVerified');
        Route::get('reviewers/email-unverified', 'ManageReviewersController@emailUnverifiedReviewers')->name('reviewers.emailUnverified');
        Route::get('reviewers/sms-unverified', 'ManageReviewersController@smsUnverifiedReviewers')->name('reviewers.smsUnverified');
        Route::get('reviewers/sms-verified', 'ManageReviewersController@smsVerifiedReviewers')->name('reviewers.smsVerified');
        Route::get('reviewers/{scope}/search', 'ManageReviewersController@search')->name('reviewers.search');

        //Reviewer Login History
        Route::get('reviewers/login/history/{id}', 'ManageReviewersController@reviewerLoginHistory')->name('reviewers.login.history.single');
        Route::get('reviewers/login/history', 'ManageReviewersController@loginHistory')->name('reviewers.login.history');
        Route::get('reviewers/login/ipHistory/{ip}', 'ManageReviewersController@loginIpHistory')->name('reviewers.login.ipHistory');

        Route::get('reviewers/send-email', 'ManageReviewersController@showEmailAllForm')->name('reviewers.email.all');
        Route::post('reviewers/send-email', 'ManageReviewersController@sendEmailAll')->name('reviewers.email.send');
        Route::get('reviewer/send-email/{id}', 'ManageReviewersController@showEmailSingleForm')->name('reviewers.email.single');
        Route::post('reviewer/send-email/{id}', 'ManageReviewersController@sendEmailSingle')->name('reviewers.email.single');

        //Manage Products
        Route::get('pending/products', 'ProductController@pending')->name('product.pending');
        Route::get('approved/products', 'ProductController@approved')->name('product.approved');
        Route::get('soft-rejected/products', 'ProductController@softRejected')->name('product.softrejected');
        Route::get('hard-rejected/products', 'ProductController@hardRejected')->name('product.hardrejected');
        Route::get('update-pending/products', 'ProductController@updatePending')->name('product.update.pending');
        Route::get('products/view/{id}', 'ProductController@view')->name('product.view');
        Route::get('update-pending/product/view/{id}', 'ProductController@updatePendingView')->name('product.update.pending.view');
        Route::get('products/download/{id}', 'ProductController@download')->name('product.download');
        Route::get('update-pending/product/download/{id}', 'ProductController@updatePendingDownload')->name('product.update.pending.download');
        Route::get('resubmitted/products', 'ProductController@resubmit')->name('product.resubmit');
        Route::get('resubmitted/product/view/{id}', 'ProductController@resubmitView')->name('product.resubmit.view');
        Route::get('resubmitted/product/download/{id}', 'ProductController@resubmitDownload')->name('product.resubmit.download');

        //Product Decession
        Route::post('approve/product', 'ProductController@approveProduct')->name('approve.product');
        Route::post('soft-reject/product', 'ProductController@softRejectProduct')->name('softreject.product');
        Route::post('hard-reject/product', 'ProductController@hardRejectProduct')->name('hardreject.product');
        Route::post('approve/resubmit-product', 'ProductController@resubmitApprove')->name('resubmit.approve.product');
        Route::post('soft-reject/resubmit-product', 'ProductController@resubmitSoftReject')->name('resubmit.softreject.product');
        Route::post('hard-reject/resubmit-product', 'ProductController@resubmitHardReject')->name('resubmit.hardreject.product');
        Route::post('approve/update-pending/product', 'ProductController@updatePendingApprove')->name('approve.product.update.pending');
        Route::post('reject/update-pending/product', 'ProductController@updatePendingReject')->name('reject.product.update.pending');
        Route::post('featured/product', 'ProductController@featuredProduct')->name('featured.product');
        Route::post('unfeatured/product', 'ProductController@unFeaturedProduct')->name('unfeatured.product');

        //Sells Log
        Route::get('sell-log', 'ProductController@sellLog')->name('sell.log');
        Route::get('sell-search', 'ProductController@sellSearch')->name('sell.log.search');

        //Manage Comments
        Route::get('comments', 'CommentController@products')->name('comment');
        Route::get('comments/view/{id}', 'CommentController@comments')->name('comment.view');
        Route::post('comment/delete', 'CommentController@commentDelete')->name('comment.delete');
        Route::post('reply/delete', 'CommentController@replyDelete')->name('comment.reply.delete');

        // Users Manager
        Route::get('users', 'ManageUsersController@allUsers')->name('users.all');
        Route::get('users/active', 'ManageUsersController@activeUsers')->name('users.active');
        Route::get('users/banned', 'ManageUsersController@bannedUsers')->name('users.banned');
        Route::get('users/email-verified', 'ManageUsersController@emailVerifiedUsers')->name('users.emailVerified');
        Route::get('users/email-unverified', 'ManageUsersController@emailUnverifiedUsers')->name('users.emailUnverified');
        Route::get('users/sms-unverified', 'ManageUsersController@smsUnverifiedUsers')->name('users.smsUnverified');
        Route::get('users/sms-verified', 'ManageUsersController@smsVerifiedUsers')->name('users.smsVerified');

        Route::get('users/{scope}/search', 'ManageUsersController@search')->name('users.search');
        Route::get('user/detail/{id}', 'ManageUsersController@detail')->name('users.detail');
        Route::post('user/update/{id}', 'ManageUsersController@update')->name('users.update');
        Route::post('user/add-sub-balance/{id}', 'ManageUsersController@addSubBalance')->name('users.addSubBalance');
        Route::get('user/send-email/{id}', 'ManageUsersController@showEmailSingleForm')->name('users.email.single');
        Route::post('user/send-email/{id}', 'ManageUsersController@sendEmailSingle')->name('users.email.single');
        Route::get('user/transactions/{id}', 'ManageUsersController@transactions')->name('users.transactions');
        Route::get('user/deposits/{id}', 'ManageUsersController@deposits')->name('users.deposits');
        Route::get('user/deposits/via/{method}/{type?}/{userId}', 'ManageUsersController@depViaMethod')->name('users.deposits.method');
        Route::get('user/withdrawals/{id}', 'ManageUsersController@withdrawals')->name('users.withdrawals');
        Route::get('user/withdrawals/via/{method}/{type?}/{userId}', 'ManageUsersController@withdrawalsViaMethod')->name('users.withdrawals.method');

        // Login History
        Route::get('users/login/history/{id}', 'ManageUsersController@userLoginHistory')->name('users.login.history.single');

        Route::get('users/send-email', 'ManageUsersController@showEmailAllForm')->name('users.email.all');
        Route::post('users/send-email', 'ManageUsersController@sendEmailAll')->name('users.email.send');

        //Featured Author
        Route::get('featured-author', 'ManageUsersController@featured')->name('users.featured.all');
        Route::post('make/featured-author', 'ManageUsersController@makeFeatured')->name('users.make.featured');

        // Subscriber
        Route::get('subscriber', 'SubscriberController@index')->name('subscriber.index');
        Route::get('subscriber/send-email', 'SubscriberController@sendEmailForm')->name('subscriber.sendEmail');
        Route::post('subscriber/remove', 'SubscriberController@remove')->name('subscriber.remove');
        Route::post('subscriber/send-email', 'SubscriberController@sendEmail')->name('subscriber.sendEmail');

        // Deposit Gateway
        Route::name('gateway.')->prefix('gateway')->group(function(){
            // Automatic Gateway
            Route::get('automatic', 'GatewayController@index')->name('automatic.index');
            Route::get('automatic/edit/{alias}', 'GatewayController@edit')->name('automatic.edit');
            Route::post('automatic/update/{code}', 'GatewayController@update')->name('automatic.update');
            Route::post('automatic/remove/{code}', 'GatewayController@remove')->name('automatic.remove');
            Route::post('automatic/activate', 'GatewayController@activate')->name('automatic.activate');
            Route::post('automatic/deactivate', 'GatewayController@deactivate')->name('automatic.deactivate');



            // Manual Methods
            Route::get('manual', 'ManualGatewayController@index')->name('manual.index');
            Route::get('manual/new', 'ManualGatewayController@create')->name('manual.create');
            Route::post('manual/new', 'ManualGatewayController@store')->name('manual.store');
            Route::get('manual/edit/{alias}', 'ManualGatewayController@edit')->name('manual.edit');
            Route::post('manual/update/{id}', 'ManualGatewayController@update')->name('manual.update');
            Route::post('manual/activate', 'ManualGatewayController@activate')->name('manual.activate');
            Route::post('manual/deactivate', 'ManualGatewayController@deactivate')->name('manual.deactivate');
        });


        // DEPOSIT SYSTEM
        Route::name('deposit.')->prefix('deposit')->group(function(){
            Route::get('/', 'DepositController@deposit')->name('list');
            Route::get('pending', 'DepositController@pending')->name('pending');
            Route::get('rejected', 'DepositController@rejected')->name('rejected');
            Route::get('approved', 'DepositController@approved')->name('approved');
            Route::get('successful', 'DepositController@successful')->name('successful');
            Route::get('details/{id}', 'DepositController@details')->name('details');

            Route::post('reject', 'DepositController@reject')->name('reject');
            Route::post('approve', 'DepositController@approve')->name('approve');
            Route::get('via/{method}/{type?}', 'DepositController@depViaMethod')->name('method');
            Route::get('/{scope}/search', 'DepositController@search')->name('search');
            Route::get('date-search/{scope}', 'DepositController@dateSearch')->name('dateSearch');

        });

        // PAYMENT SYSTEM
        Route::name('payment.')->prefix('payment')->group(function(){
            Route::get('/', 'PaymentController@payment')->name('list');
            Route::get('pending', 'PaymentController@pending')->name('pending');
            Route::get('rejected', 'PaymentController@rejected')->name('rejected');
            Route::get('approved', 'PaymentController@approved')->name('approved');
            Route::get('successful', 'PaymentController@successful')->name('successful');
            Route::get('details/{id}', 'PaymentController@details')->name('details');

            Route::post('reject', 'PaymentController@reject')->name('reject');
            Route::post('approve', 'PaymentController@approve')->name('approve');
            Route::get('via/{method}/{type?}', 'PaymentController@paymentViaMethod')->name('method');
            Route::get('/{scope}/search', 'PaymentController@search')->name('search');
            Route::get('date-search/{scope}', 'PaymentController@dateSearch')->name('dateSearch');
        });


        // WITHDRAW SYSTEM
        Route::name('withdraw.')->prefix('withdraw')->group(function(){
            Route::get('pending', 'WithdrawalController@pending')->name('pending');
            Route::get('approved', 'WithdrawalController@approved')->name('approved');
            Route::get('rejected', 'WithdrawalController@rejected')->name('rejected');
            Route::get('log', 'WithdrawalController@log')->name('log');
            Route::get('via/{method_id}/{type?}', 'WithdrawalController@logViaMethod')->name('method');
            Route::get('{scope}/search', 'WithdrawalController@search')->name('search');
            Route::get('date-search/{scope}', 'WithdrawalController@dateSearch')->name('dateSearch');
            Route::get('details/{id}', 'WithdrawalController@details')->name('details');
            Route::post('approve', 'WithdrawalController@approve')->name('approve');
            Route::post('reject', 'WithdrawalController@reject')->name('reject');


            // Withdraw Method
            Route::get('method/', 'WithdrawMethodController@methods')->name('method.index');
            Route::get('method/create', 'WithdrawMethodController@create')->name('method.create');
            Route::post('method/create', 'WithdrawMethodController@store')->name('method.store');
            Route::get('method/edit/{id}', 'WithdrawMethodController@edit')->name('method.edit');
            Route::post('method/edit/{id}', 'WithdrawMethodController@update')->name('method.update');
            Route::post('method/activate', 'WithdrawMethodController@activate')->name('method.activate');
            Route::post('method/deactivate', 'WithdrawMethodController@deactivate')->name('method.deactivate');
        });

        // Report
        Route::get('report/transaction', 'ReportController@transaction')->name('report.transaction');
        Route::get('report/transaction/search', 'ReportController@transactionSearch')->name('report.transaction.search');
        Route::get('report/login/history', 'ReportController@loginHistory')->name('report.login.history');
        Route::get('report/login/ipHistory/{ip}', 'ReportController@loginIpHistory')->name('report.login.ipHistory');


        // Admin Support
        Route::get('tickets', 'SupportTicketController@tickets')->name('ticket');
        Route::get('tickets/pending', 'SupportTicketController@pendingTicket')->name('ticket.pending');
        Route::get('tickets/closed', 'SupportTicketController@closedTicket')->name('ticket.closed');
        Route::get('tickets/answered', 'SupportTicketController@answeredTicket')->name('ticket.answered');
        Route::get('tickets/view/{id}', 'SupportTicketController@ticketReply')->name('ticket.view');
        Route::post('ticket/reply/{id}', 'SupportTicketController@ticketReplySend')->name('ticket.reply');
        Route::get('ticket/download/{ticket}', 'SupportTicketController@ticketDownload')->name('ticket.download');
        Route::post('ticket/delete', 'SupportTicketController@ticketDelete')->name('ticket.delete');


        // Language Manager
        Route::get('/language', 'LanguageController@langManage')->name('language.manage');
        Route::post('/language', 'LanguageController@langStore')->name('language.manage.store');
        Route::post('/language/delete/{id}', 'LanguageController@langDel')->name('language.manage.del');
        Route::post('/language/update/{id}', 'LanguageController@langUpdatepp')->name('language.manage.update');
        Route::get('/language/edit/{id}', 'LanguageController@langEdit')->name('language.key');
        Route::post('/language/import', 'LanguageController@langImport')->name('language.import_lang');

        Route::post('language/store/key/{id}', 'LanguageController@storeLanguageJson')->name('language.store.key');
        Route::post('language/delete/key/{id}', 'LanguageController@deleteLanguageJson')->name('language.delete.key');
        Route::post('language/update/key/{id}', 'LanguageController@updateLanguageJson')->name('language.update.key');

        // General Setting
        Route::get('general-setting', 'GeneralSettingController@index')->name('setting.index');
        Route::post('general-setting', 'GeneralSettingController@update')->name('setting.update');

        // Logo-Icon
        Route::get('setting/logo-icon', 'GeneralSettingController@logoIcon')->name('setting.logo_icon');
        Route::post('setting/logo-icon', 'GeneralSettingController@logoIconUpdate')->name('setting.logo_icon');

        // Plugin
        Route::get('extensions', 'ExtensionController@index')->name('extensions.index');
        Route::post('extensions/update/{id}', 'ExtensionController@update')->name('extensions.update');
        Route::post('extensions/activate', 'ExtensionController@activate')->name('extensions.activate');
        Route::post('extensions/deactivate', 'ExtensionController@deactivate')->name('extensions.deactivate');


        // Email Setting
        Route::get('email-template/global', 'EmailTemplateController@emailTemplate')->name('email.template.global');
        Route::post('email-template/global', 'EmailTemplateController@emailTemplateUpdate')->name('email.template.global');
        Route::get('email-template/setting', 'EmailTemplateController@emailSetting')->name('email.template.setting');
        Route::post('email-template/setting', 'EmailTemplateController@emailSettingUpdate')->name('email.template.setting');
        Route::get('email-template/index', 'EmailTemplateController@index')->name('email.template.index');
        Route::get('email-template/{id}/edit', 'EmailTemplateController@edit')->name('email.template.edit');
        Route::post('email-template/{id}/update', 'EmailTemplateController@update')->name('email.template.update');
        Route::post('email-template/send-test-mail', 'EmailTemplateController@sendTestMail')->name('email.template.sendTestMail');


        // SMS Setting
        Route::get('sms-template/global', 'SmsTemplateController@smsSetting')->name('sms.template.global');
        Route::post('sms-template/global', 'SmsTemplateController@smsSettingUpdate')->name('sms.template.global');
        Route::get('sms-template/index', 'SmsTemplateController@index')->name('sms.template.index');
        Route::get('sms-template/edit/{id}', 'SmsTemplateController@edit')->name('sms.template.edit');
        Route::post('sms-template/update/{id}', 'SmsTemplateController@update')->name('sms.template.update');
        Route::post('email-template/send-test-sms', 'SmsTemplateController@sendTestSMS')->name('sms.template.sendTestSMS');

        // SEO
        Route::get('seo', 'FrontendController@seoEdit')->name('seo');


        // Frontend
        Route::name('frontend.')->prefix('frontend')->group(function () {

            Route::get('templates', 'FrontendController@templates')->name('templates');
            Route::post('templates', 'FrontendController@templatesActive')->name('templates.active');

            Route::get('frontend-sections/{key}', 'FrontendController@frontendSections')->name('sections');
            Route::post('frontend-content/{key}', 'FrontendController@frontendContent')->name('sections.content');
            Route::get('frontend-element/{key}/{id?}', 'FrontendController@frontendElement')->name('sections.element');
            Route::post('remove', 'FrontendController@remove')->name('remove');

            // Page Builder
            Route::get('manage-pages', 'PageBuilderController@managePages')->name('manage.pages');
            Route::post('manage-pages', 'PageBuilderController@managePagesSave')->name('manage.pages.save');
            Route::post('manage-pages/update', 'PageBuilderController@managePagesUpdate')->name('manage.pages.update');
            Route::post('manage-pages/delete', 'PageBuilderController@managePagesDelete')->name('manage.pages.delete');
            Route::get('manage-section/{id}', 'PageBuilderController@manageSection')->name('manage.section');
            Route::post('manage-section/{id}', 'PageBuilderController@manageSectionUpdate')->name('manage.section.update');
        });
    });
});

/*
|--------------------------------------------------------------------------
| Start Reviewer Area
|--------------------------------------------------------------------------
*/

Route::namespace('Reviewer')->prefix('reviewer')->name('reviewer.')->group(function () {
    Route::namespace('Auth')->group(function () {
        Route::get('/', 'LoginController@showLoginForm')->name('login');
        Route::post('/', 'LoginController@login')->name('login');
        Route::get('logout', 'LoginController@logout')->name('logout');

        // surveyor Password Reset
        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
        Route::post('password/reset', 'ForgotPasswordController@sendResetLinkEmail');
        Route::post('password/verify-code', 'ForgotPasswordController@verifyCode')->name('password.verify-code');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.change-link');
        Route::post('password/reset/change', 'ResetPasswordController@reset')->name('password.change');
    });
});

Route::namespace('Reviewer')->name('reviewer.')->prefix('reviewer')->group(function () {

    Route::middleware('reviewer')->group(function () {

        Route::get('authorization', 'ReviewerAuthorizationController@authorizeForm')->name('authorization');
        Route::get('resend-verify', 'ReviewerAuthorizationController@sendVerifyCode')->name('send_verify_code');
        Route::post('verify-email', 'ReviewerAuthorizationController@emailVerification')->name('verify_email');
        Route::post('verify-sms', 'ReviewerAuthorizationController@smsVerification')->name('verify_sms');
        Route::post('verify-g2fa', 'ReviewerAuthorizationController@g2faVerification')->name('go2fa.verify');

        Route::middleware(['checkReviewerStatus'])->group(function () {
            Route::get('dashboard', 'ReviewerController@dashboard')->name('dashboard');
            Route::get('profile', 'ReviewerController@profile')->name('profile');
            Route::post('profile/update', 'ReviewerController@profileUpdate')->name('profile.update');
            Route::get('password', 'ReviewerController@password')->name('password');
            Route::post('password/update', 'ReviewerController@passwordUpdate')->name('password.update');

            //2FA
            Route::get('twofactor', 'ReviewerController@show2faForm')->name('twofactor');
            Route::post('twofactor/enable', 'ReviewerController@create2fa')->name('twofactor.enable');
            Route::post('twofactor/disable', 'ReviewerController@disable2fa')->name('twofactor.disable');

            //Products
            Route::get('pending/products', 'ReviewerController@pending')->name('product.pending');
            Route::get('products/view/{id}', 'ReviewerController@view')->name('product.view');
            Route::get('products/download/{id}', 'ReviewerController@download')->name('product.download');
            Route::get('approved/products', 'ReviewerController@approved')->name('product.approved');
            Route::get('soft-rejected/products', 'ReviewerController@softRejected')->name('product.softrejected');
            Route::get('hard-rejected/products', 'ReviewerController@hardRejected')->name('product.hardrejected');
            Route::get('update-pending/products', 'ReviewerController@updatePending')->name('product.update.pending');
            Route::get('update-pending/product/view/{id}', 'ReviewerController@updatePendingView')->name('product.update.pending.view');
            Route::get('update-pending/product/download/{id}', 'ReviewerController@updatePendingDownload')->name('product.update.pending.download');
            Route::get('resubmitted/products', 'ReviewerController@resubmit')->name('product.resubmit');
            Route::get('resubmitted/product/view/{id}', 'ReviewerController@resubmitView')->name('product.resubmit.view');
            Route::get('resubmitted/product/download/{id}', 'ReviewerController@resubmitDownload')->name('product.resubmit.download');


            //Product Decession
            Route::post('approve/product', 'ReviewerController@approveProduct')->name('approve.product');
            Route::post('soft-reject/product', 'ReviewerController@softRejectProduct')->name('softreject.product');
            Route::post('hard-reject/product', 'ReviewerController@hardRejectProduct')->name('hardreject.product');
            Route::post('approve/resubmit-product', 'ReviewerController@resubmitApprove')->name('resubmit.approve.product');
            Route::post('soft-reject/resubmit-product', 'ReviewerController@resubmitSoftReject')->name('resubmit.softreject.product');
            Route::post('hard-reject/resubmit-product', 'ReviewerController@resubmitHardReject')->name('resubmit.hardreject.product');
            Route::post('approve/update-pending/product', 'ReviewerController@updatePendingApprove')->name('approve.product.update.pending');
            Route::post('reject/update-pending/product', 'ReviewerController@updatePendingReject')->name('reject.product.update.pending');
        });
    });
});


/*
|--------------------------------------------------------------------------
| Start User Area
|--------------------------------------------------------------------------
*/

Route::name('user.')->group(function () {
    Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'Auth\LoginController@login');
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register')->middleware('regStatus');

    Route::group(['middleware' => ['guest']], function () {
        Route::get('register/{reference}', 'Auth\RegisterController@referralRegister')->name('refer.register');
    });
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/code-verify', 'Auth\ForgotPasswordController@codeVerify')->name('password.code_verify');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/verify-code', 'Auth\ForgotPasswordController@verifyCode')->name('password.verify-code');
});

Route::name('user.')->prefix('user')->group(function () {
    Route::middleware('auth')->group(function () {

        Route::get('authorization', 'AuthorizationController@authorizeForm')->name('authorization');
        Route::get('resend-verify', 'AuthorizationController@sendVerifyCode')->name('send_verify_code');
        Route::post('verify-email', 'AuthorizationController@emailVerification')->name('verify_email');
        Route::post('verify-sms', 'AuthorizationController@smsVerification')->name('verify_sms');
        Route::post('verify-g2fa', 'AuthorizationController@g2faVerification')->name('go2fa.verify');

        Route::middleware(['checkStatus'])->group(function () {
            Route::get('dashboard', 'UserController@home')->name('home');

            Route::get('profile-setting', 'UserController@profile')->name('profile-setting');
            Route::post('profile-setting', 'UserController@submitProfile');
            Route::get('change-password', 'UserController@changePassword')->name('change-password');
            Route::post('change-password', 'UserController@submitPassword');

            //2FA
            Route::get('twofactor', 'UserController@show2faForm')->name('twofactor');
            Route::post('twofactor/enable', 'UserController@create2fa')->name('twofactor.enable');
            Route::post('twofactor/disable', 'UserController@disable2fa')->name('twofactor.disable');


            // Deposit
            Route::any('/deposit', 'Gateway\PaymentController@deposit')->name('deposit');
            Route::post('deposit/insert', 'Gateway\PaymentController@depositInsert')->name('deposit.insert');
            Route::get('deposit/preview', 'Gateway\PaymentController@depositPreview')->name('deposit.preview');
            Route::get('deposit/confirm', 'Gateway\PaymentController@depositConfirm')->name('deposit.confirm');
            Route::get('deposit/manual', 'Gateway\PaymentController@manualDepositConfirm')->name('deposit.manual.confirm');
            Route::post('deposit/manual', 'Gateway\PaymentController@manualDepositUpdate')->name('deposit.manual.update');
            Route::get('deposit/history', 'UserController@depositHistory')->name('deposit.history');

            // Payment
            Route::any('/payment', 'Gateway\PaymentController@payment')->name('payment');
            Route::post('payment/insert', 'Gateway\PaymentController@paymentInsert')->name('payment.insert');
            Route::get('payment/preview', 'Gateway\PaymentController@paymentPreview')->name('payment.preview');
            Route::get('payment/manual', 'Gateway\PaymentController@manualPaymentConfirm')->name('payment.manual.confirm');
            Route::post('payment/manual', 'Gateway\PaymentController@manualPaymentUpdate')->name('payment.manual.update');


            // Withdraw
            Route::get('/withdraw', 'UserController@withdrawMoney')->name('withdraw');
            Route::post('/withdraw', 'UserController@withdrawStore')->name('withdraw.money');
            Route::get('/withdraw/preview', 'UserController@withdrawPreview')->name('withdraw.preview');
            Route::post('/withdraw/preview', 'UserController@withdrawSubmit')->name('withdraw.submit');
            Route::get('/withdraw/history', 'UserController@withdrawLog')->name('withdraw.history');

            // Product
            Route::get('product/all', 'ProductController@allProduct')->name('product.all');
            Route::get('product/new', 'ProductController@newProduct')->name('product.new');
            Route::post('product/store', 'ProductController@storeProduct')->name('product.store');
            Route::get('product/edit/{id}', 'ProductController@editProduct')->name('product.edit');
            Route::post('product/update/{id}', 'ProductController@updateProduct')->name('product.update');
            Route::get('product/resubmit/{id}', 'ProductController@resubmitProduct')->name('product.resubmit');
            Route::post('product/resubmit/store/{id}', 'ProductController@resubmitProductStore')->name('product.resubmit.store');
            Route::post('product/delete', 'ProductController@deleteProduct')->name('product.delete');

            //Comment Store
            Route::post('comment/store', 'ProductController@commentStore')->name('comment.store');
            Route::post('reply/store', 'ProductController@replyStore')->name('reply.store');

            //Payment
            Route::post('checkout-payment', 'SellController@checkoutPayment')->name('checkout.payment');

            //Purchased Product List
            Route::get('purchased-product/list', 'UserController@purchasedProduct')->name('purchased.product');

            //Rating
            Route::post('rating', 'UserController@rating')->name('rating');

            //Product Download
            Route::get('download/{id}', 'UserController@download')->name('download');

            //Ivoice Download
            Route::get('invoice/{id}', 'UserController@invoice')->name('invoice');

            //Transactions
            Route::get('transaction', 'UserController@transaction')->name('transaction');

            //Sells log
            Route::get('sells-log', 'UserController@sellLog')->name('sell.log');

            //Track Sell
            Route::get('track-sell', 'UserController@trackSell')->name('track.sell');
            Route::post('track-sell-search', 'UserController@trackSellSearch')->name('track.sell.search');

            //Email To Author
            Route::post('email-author', 'UserController@emailAuthor')->name('email.author');
        });
    });
});


Route::get('/contact', 'SiteController@contact')->name('contact');
Route::post('/contact', 'SiteController@contactSubmit')->name('contact.send');
Route::get('/change/{lang?}', 'SiteController@changeLanguage')->name('lang');

Route::get('/cookie/accept', 'SiteController@cookieAccept')->name('cookie.accept');

//Blog
Route::get('blogs', 'SiteController@blogs')->name('blogs');
Route::get('blog/{id}/{slug}', 'SiteController@blogDetails')->name('blog.details');

//Subscriber Store
Route::post('subscriber', 'SiteController@subscriberStore')->name('subscriber.store');

//Company Policy
Route::get('company-policy/{id}/{heading}', 'SiteController@policy')->name('policy');

//Company Policy
Route::get('support-details', 'SiteController@suppotDetails')->name('support.details');

//Products
Route::get('featured-products', 'SiteController@featured')->name('featured');
Route::get('all-products', 'SiteController@allProducts')->name('all.products');
Route::get('best-selling-products', 'SiteController@bestSell')->name('best.sell.products');
Route::get('best-author-products', 'SiteController@bestAuthor')->name('best.author.products');
Route::get('author-products/{username}', 'SiteController@authorProducts')->name('author.products');

//Products Details
Route::get('product-details/{slug}/{id}', 'SiteController@productDetails')->name('product.details');
Route::get('product-reviews/{slug}/{id}', 'SiteController@productReviews')->name('product.reviews');
Route::get('product-comments/{slug}/{id}', 'SiteController@productComments')->name('product.comments');

//Search Products
Route::get('product/search', 'SiteController@productSearch')->name('product.search');
Route::get('product/filtred', 'SiteController@productFilter')->name('product.filtered');
Route::get('category/search/{id}/{slug}', 'SiteController@categorySearch')->name('category.search');
Route::get('subcategory/search/{id}/{slug}', 'SiteController@subcategorySearch')->name('subcategory.search');
Route::get('author-profile/{username}', 'SiteController@usernameSearch')->name('username.search');
Route::get('tag/search/{tag}', 'SiteController@tagSearch')->name('tag.search');

//Add To Cart
Route::post('product/add-to-cart', 'SellController@addToCart')->name('addtocart');
Route::get('product/remove-cart/{id}', 'SellController@removeCart')->name('remove.cart');
Route::get('product/cart', 'SellController@carts')->name('carts');

Route::get('placeholder-image/{size}', 'SiteController@placeholderImage')->name('placeholderImage');

Route::get('/{slug}', 'SiteController@pages')->name('pages');
Route::get('/', 'SiteController@index')->name('home');
