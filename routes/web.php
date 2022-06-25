<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use \App\Http\Middleware\CheckSubdomain;
use \App\Http\Middleware\PlanCheck;


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

/*
  |--------------------------------------------------------------------------
  | Public Side Routes
  |--------------------------------------------------------------------------
 */
//video roots
//Route::get('video/chat', "ChatController@video")->name('video.chat')->middleware(['auth']);
//Route::prefix('room')->middleware('auth')->group(function() {
//   Route::get('join/{roomName}', 'ChatController@joinRoom')->name('video.chat.join.room');
//   Route::post('create', 'ChatController@createRoom')->name('video.chat.create.room');
//});

Route::any('place/video/call', 'ChatController@place_video_call')->name('place.video.call')->middleware(['auth']);

Route::middleware(['checksubdomain'])->group(function () {

    Route::group(['middleware' => ['auth']], function () {
    Route::get('/agora-chat', 'AgoraVideoController@index');
    Route::post('/agora/token', 'AgoraVideoController@token');
    Route::post('/agora/call-user', 'AgoraVideoController@callUser');

	});



Route::get('/test', function () {
    return view('search');
})->name('page');

Route::get('/','FrontendController@index');
Route::get('home1/','FrontendController@home1');
Route::get('home2/','FrontendController@home2');
Route::get('home3/','FrontendController@home3');
Route::get('home4/','FrontendController@home4');
Route::get('/signup','Auth\\RegisterController@regclient')->name('signup.mentee');

Route::post('contact-us', 'FrontendController@contact_us')->name('contact_us');
Route::get('/index', function () {
    return view('frontend.mentoringtheme.index');
})->name('page');

Route::get('/auth_code', 'Auth\\LoginController@showCodeForm');
Route::get('/signup/verify', 'Auth\\RegisterController@showCodeForm');
Route::post('/auth_code', 'Auth\\LoginController@storeCodeForm');
Route::post('/logout', 'Auth\\LoginController@logout')->name('logout');
Route::post('/signup/auth_code/verify', 'Auth\\RegisterController@storeCodeForm');
Route::post('/otp', 'Auth\\ForgotPasswordController@otp')->name('password.sendotp');
Route::get('/enterotp', 'Auth\\ForgotPasswordController@enterotp')->name('enterotp');
Route::post('/reset', 'Auth\\ForgotPasswordController@reset')->name('password.reset_byotp');
Route::get('/reset_password/{email}/{token}', 'Auth\\ForgotPasswordController@resetPasswordForm')->name('resetPasswordForm');

Route::get('/blank-page', function () {
    return view('blank-page');
})->name('blank-page');

Route::post('/subscribe', 'FrontendController@subscribe');
Route::get('/unsubscribe', 'FrontendController@unsubscribe');
Route::get('/verify/newsletter', 'FrontendController@verifynewsletter');
Route::post('course/syndicate/stripe', 'FrontendController@courseSyndicateStripe')->name('course.syndicate.stripe');
Route::get('{id}/requestfile', 'FrontendController@requestfile')->name('requestfile');
Route::post('/request/file/post', 'FrontendController@requestfilepost')->name('requestfilepost');
Route::get('{id}/moreinfo', 'FrontendController@moreinfo')->name('moreinfo');
Route::post('/more/info/post', 'FrontendController@moreinfopost')->name('moreinfopost');

//testingg

Route::get('/testt', ['as' => 'frontend.index', 'uses' => 'FrontendController@index']);
Route::get('/program', ['as' => 'frontend.program', 'uses' => 'FrontendController@program']);
Route::get('/program/details/{id}', ['as' => 'frontend.programdetails', 'uses' => 'FrontendController@programdetails']);
Route::any('/program/details/graph', ['as' => 'frontend.programdetails.graph', 'uses' => 'FrontendController@programdetailsgraph']);
Route::get('/program/comparison-tool', ['as' => 'frontend.programcomparisons', 'uses' => 'FrontendController@programcomparisons']);

Route::post('/program/filter', 'FrontendController@programfilter')->name('program.filter');

Route::get('/page/{slug}', 'FrontendController@page');

Route::get('/search/courses', ['as' => 'search.courses', 'uses' => 'FrontendController@learn']);
Route::post('/courses/filter', ['as' => 'search.courses.filter', 'uses' => 'FrontendController@learnFilter']);
Route::get('/course/details/{id}', ['as' => 'course.details', 'uses' => 'FrontendController@learnDetail']);
Route::post('learn/company/find', 'FrontendController@learnCompanyFind')->name('learn.company.find');
Route::post('assistence/request/create', 'FrontendController@assistenceRequestCreate');
Route::post('wallet_payment', 'FrontendController@wallet_payment')->name('wallet_payment');



Route::get('/search/blogs', ['as' => 'search.blogs', 'uses' => 'FrontendController@blogs']);
Route::get('/blog/details/{id}', 'FrontendController@blogs_detail')->name('blog.details');
Route::post('/blogs/filter', 'FrontendController@blogfilter')->name('blogs.filter');

Route::get('/search/profiles', ['as' => 'search.profile', 'uses' => 'FrontendController@profiles']);
Route::post('/profiles/review/post', 'FrontendController@profilereviewpost')->name('profiles.review.post');
Route::post('/profiles/filter', 'FrontendController@profilefilter')->name('profiles.filter');
Route::post('/profiles/reviews', 'FrontendController@profilereviews')->name('profiles.reviews');
Route::post('/profile/booking/filter', 'FrontendController@Schedulebookingfilter')->name('profile.booking.filter');
Route::post('/certify/enroll', 'FrontendController@strip_payment')->name('strip_payment');
Route::get('/profile/booking/{id}', ['as' => 'profile.booking', 'uses' => 'FrontendController@UserProfileBooking'])->middleware('auth');
Route::any('/profile/booking/checkout/form', ['as' => 'booking.checkout', 'uses' => 'FrontendController@ProfileBookingCheckout'])->middleware('auth');
Route::any('/stripe/profile/slot/booking', ['as' => 'stripe.ProfileSlotBooking', 'uses' => 'StripePaymentController@stripeProfileBookingOrderPost'])->middleware(['auth']);




Route::get('/booking/success', function () {
    return view('frontend.mentoringtheme.bookingsuccess');
})->name('booking.success');




//Route::get('/booking/invoice', function () {
//    return view('frontend.mentoringtheme.invoice-view');
//})->name('payment.invoices');


/*Books routes frontend*/
Route::get('/books', ['as' => 'books', 'uses' => 'FrontendController@books']);
Route::post('/books/filter', 'FrontendController@bookfilter')->name('book.filter');
Route::get('/books/details/{id}', 'FrontendController@books_detail');
Route::post('/books/trending', ['as' => 'book.trending', 'uses' => 'FrontendController@book_trending']);



/*

/*Pricing plan*/
Route::get('/pricing', ['as' => 'pricing', 'uses' => 'FrontendController@pricing']);
Route::get('/payment/plan/{code}/{type}', ['as' => 'payment.owner', 'uses' => 'FrontendController@ownerplanpayment'])->middleware(['auth', 'checksubdomain']);
Route::post('/register/client', 'Auth\RegisterController@registerClient')->name('register.client');
Route::post('/price/checkout', 'FrontendController@planForm')->name('price.checkout');
Route::post('/stripe/owner/plan',['as' => 'stripe.post.owner', 'uses' => 'FrontendController@ownerstripePost'])->middleware(['auth']);
Route::post('/stripe/plan',['as' => 'stripe.post.plan', 'uses' => 'FrontendController@stripePost'])->middleware(['auth']);
Route::post('/stripe/plan/upgrade',['as' => 'stripe.post.upgrade', 'uses' => 'FrontendController@planupdte'])->middleware(['auth']);
Route::any('profile/plan/cancel', ['as' => 'profile.plan.cancel', 'uses' => 'UserController@profilePlanCancel'])->middleware(['auth']);
Route::post('show/package/modules', ['as' => 'show.package.modules', 'uses' => 'UserController@showPackageModules']);
Route::post('strip_payment/backend', 'WalletController@stripe_payment')->name('strip_payment.backend')->middleware(['auth']);
/*end Pricing plan*/


/*Chat bot*/


Route::get('/chat', 'UserController@chat')->name('chat')->middleware(['auth']);
Route::post('send/message', 'UserController@sendMessage')->name('send.message')->middleware(['auth']);
//Route::any('testphotobooth', 'UserController@testphotobooth')->name('send.message')->middleware(['auth']);
Route::post('get/message', 'UserController@getMentorMessage')->name('get.message')->middleware(['auth']);
Route::post('get/group/message', 'UserController@getgroupMessage')->name('get.group.message')->middleware(['auth']);
Route::post('get/message/user/list', 'UserController@getMessageUserList')->name('get.message.user.list');
Route::any('get/chat/mentor/list', 'UserController@getchatMentorsList')->name('get.chat.mentor.list');
Route::post('get/mentor/message', 'UserController@getMessage')->name('get.mentor.message')->middleware(['auth']);
Route::get('mentors/SST/token', ['as' => 'mentors.SST***token', 'uses' => 'UserController@SSTtoken'])->middleware(['auth']);
Route::post('get/bot/reply', 'UserController@getBotReply')->name('get.bot.reply');

Route::get('chat/groups', 'ChatController@chatGroups')->name('chat.groups.list');
Route::get('chat/groups/create', 'ChatController@chatGroupCreate')->name('chat.group.create');
Route::post('chat/groups/store', 'ChatController@chatGroupStore')->name('chat.group.store');
 Route::get('chat/group/edit/{id}', ['as' => 'chat.group.edit', 'uses' => 'ChatController@chatGroupEdit'])->middleware(['auth']);
 Route::get('chat/group/view/{id}', ['as' => 'chat.group.view', 'uses' => 'ChatController@chatGroupView'])->middleware(['auth']);
 Route::any('chat/group/destroy/{id}', ['as' => 'chat.group.destroy', 'uses' => 'ChatController@destroygroup'])->middleware(['auth']);
 Route::any('get/chat/user/list', 'ChatController@getchatUsersList')->name('get.chat.user.list')->middleware(['auth']);

/*end Chat bot*/

/*Photobooth*/
Route::get('photo/{id}', 'FrontendController@finalphoto')->name('photoboothfinalphoto');
Route::get('photobooths/', 'FrontendController@photobooths')->name('photobooths');
Route::get('photobooth/webcamera/{id}', 'FrontendController@photoboothwebcamera')->name('photoboothwebcamera');
Route::post('photobooth/insert', 'FrontendController@create_photo')->name('photoboothphoto');
Route::get('photobooth/webcam', 'FrontendController@photoboothwebcam')->name('photoboothwebcam');

Route::get('photobooth', 'FrontendController@photobooth')->name('photobooth');
Route::get('photoboothsharecount', 'FrontendController@photoboothsharecount')->name('photobooth.sharecount');

Route::get('photobooth/create/photo/{id}', ['as' => 'photobooth.continue', 'uses' => 'FrontendController@continue']);
	Route::post('photobooth/guest/upload', 'FrontendController@photoboothupload')->name('photobooth.photoboothupload');

Route::middleware(['auth', 'checksubdomain'])->group(function () {
	Route::get('photo-booth', 'PhotoboothController@index')->name('photobooth.get');
	Route::get('photobooth/create', ['as' => 'photobooth.create', 'uses' => 'PhotoboothController@create']);
	Route::post('photobooth/upload', 'PhotoboothController@store')->name('photobooth.upload');
    Route::get('/photobooth/status/{id}', 'PhotoboothController@approval_listing_edit')->name('photobooth.edit');
    Route::post('/photobooth/store', 'PhotoboothController@approval_change_status')->name('photobooth.store');

	Route::any('photobooth/destroy/{id}', 'PhotoboothController@destroy')->name('photobooth.destroy');
	Route::get('photobooth/dashboard', 'PhotoboothController@boothdashboard')->name('photobooth.boothdashboard');

    Route::get('admin/boothdata', 'PhotoboothController@boothdata')->name('admin.boothdata');
    Route::get('photobooth/listing/{id}', 'PhotoboothController@photoboothdatalisting')->name('photoboothdata.listing');
    Route::get('admin/boothdatasingle', 'PhotoboothController@boothdatasingle')->name('admin.boothdatasingle');

});
/*end Photobooth*/

/*FAQ*/
Route::middleware(['auth', 'checksubdomain'])->group(function () {
   Route::get('faq', ['as' => 'faq.index', 'uses' => 'FaqController@index']);
   Route::get('faq/create', ['as' => 'faq.create', 'uses' => 'FaqController@create']);
    Route::any('faq/destroy/{id}', ['as' => 'faq.destroy', 'uses' => 'FaqController@destroy']);
    Route::get('faq/view', ['as' => 'faq.view', 'uses' => 'FaqController@view']);
    Route::get('faq/edit/{id}', ['as' => 'faq.edit', 'uses' => 'FaqController@edit']);
    Route::post('faq/store', 'FaqController@store')->name('faq.store');
    Route::get('faq/settings', ['as' => 'faq.settings', 'uses' => 'FaqController@settings']);
    Route::post('faq/update/settings', ['as' => 'faq.updatesettings', 'uses' => 'FaqController@updatesettings']);


	 Route::get('faq/categories', 'FaqCategoryController@index')->name('faqCategory.index');
    Route::get('faq/categories/show', 'FaqCategoryController@show')->name('faqCategory.show');
    Route::get('faq/category/create', 'FaqCategoryController@create')->name('faq.category.create');
    Route::post('faq/category/store', 'FaqCategoryController@store')->name('faq.category.store');
    Route::get('faq/category/edit/{id}', 'FaqCategoryController@edit')->name('faqCategory.edit');
    Route::post('faq/category/update', 'FaqCategoryController@update')->name('faq.category.update');
    Route::any('faq/category/destroy/{id}', 'FaqCategoryController@destroy')->name('faqCategory.destroy');

	});
/*end FAQ*/


/*
  |--------------------------------------------------------------------------
  | End Public Side Routes
  |--------------------------------------------------------------------------
 */


/*
  |--------------------------------------------------------------------------
  | Auth Routes
  |--------------------------------------------------------------------------
 */
Auth::routes();
Route::view('forgot_password', 'auth.passwords.api_password_reset')->name('password.reset');
/*
  |--------------------------------------------------------------------------
  | End Auth Routes
  |--------------------------------------------------------------------------
 */
});

Route::middleware(['auth', 'checksubdomain'])->group(function () {
    /*     * *************Shop Categories Start**************** */
    Route::get('shop/categories', 'ShopCategoryController@index')->name('shopCategory.index');
    Route::get('shop/categories/show', 'ShopCategoryController@show')->name('shopCategory.show');
    Route::get('shop/category/create', 'ShopCategoryController@create')->name('shopCategory.create');
    Route::post('shop/category/store', 'ShopCategoryController@store')->name('shopCategory.store');
    Route::get('shop/category/edit/{id}', 'ShopCategoryController@edit')->name('shopCategory.edit');
    Route::post('shop/category/update', 'ShopCategoryController@update')->name('shopCategory.update');
    Route::any('shop/category/destroy/{id}', 'ShopCategoryController@destroy')->name('shopCategory.destroy');
    /*     * *************Shop Categories End**************** */
    /*     * *************shop Start**************** */
    Route::get('shop/dashboard', ['as' => 'shop.dashboard', 'uses' => 'ShopController@dashboard']);
    Route::get('shop/stripe/integration', ['as' => 'shop.stripe.integration', 'uses' => 'ShopController@stripe_integration']);
    Route::get('shop/products/list', ['as' => 'shop', 'uses' => 'ShopController@dashboard']);
    Route::get('shop/products', ['as' => 'shop.index', 'uses' => 'ShopController@index']);
    Route::get('shop/products/preview/{id}', ['as' => 'shop.preview', 'uses' => 'ShopController@preview']);
    Route::get('shop/create', ['as' => 'shop.create', 'uses' => 'ShopController@create']);
    Route::any('shop/order/confirmation', ['as' => 'shop.placeorder', 'uses' => 'ShopController@placeorder']);
    Route::any('shop/order/quick/buy/{id}', ['as' => 'shop.quickBuy', 'uses' => 'ShopController@quickbuy']);
    Route::get('shop/order/mark/shipped/{id}', ['as' => 'shop.markshipped', 'uses' => 'ShopController@markshipped']);
    Route::get('shop/order/mark/cancel/{id}', ['as' => 'shop.markcancel', 'uses' => 'ShopController@markcancel']);
    Route::post('shop/store', 'ShopController@store')->name('shop.store');
    Route::post('/shop/productImg/delete', 'ShopController@productdeleteimg')->name('shop.productdeleteimg');
//    Route::post('/shop/productImg/store', 'ShopController@productimgstore')->name('shop.productimgstore');
//    Route::get('/shop/product/image/add/{id}', 'ShopController@productimgadd')->name('shop.productimgadd');
    Route::get('shop/view', ['as' => 'shop.view', 'uses' => 'ShopController@view']);
    Route::get('shop/edit/{id}', ['as' => 'shop.edit', 'uses' => 'ShopController@edit']);
    Route::get('shop/public', ['as' => 'shop.public', 'uses' => 'ShopController@published']);
    Route::post('shop/orders', 'ShopController@orderList')->name('shop.orders');
    Route::post('shop/update', ['as' => 'shop.update', 'uses' => 'ShopController@update']);
    Route::any('shop/destroy/{id}', ['as' => 'shop.destroy', 'uses' => 'ShopController@destroy']);

    /* * *************Shop Brands Start**************** */
Route::get('shop/brands', 'ShopBrandController@index')->name('shopBrand.index')->middleware(['auth']);
Route::get('shop/brands/show', 'ShopBrandController@show')->name('shopBrand.show')->middleware(['auth']);
Route::get('shop/brand/create', 'ShopBrandController@create')->name('shopBrand.create')->middleware(['auth']);
Route::post('shop/brand/store', 'ShopBrandController@store')->name('shopBrand.store')->middleware(['auth']);
Route::get('shop/brand/edit/{id}', 'ShopBrandController@edit')->name('shopBrand.edit')->middleware(['auth']);
Route::post('shop/brand/update', 'ShopBrandController@update')->name('shopBrand.update')->middleware(['auth']);
Route::any('shop/brand/destroy/{id}', 'ShopBrandController@destroy')->name('shopBrand.destroy')->middleware(['auth']);
/* * *************Shop Brands End**************** */


Route::any('shop', 'ShopController@shop')->name('shop')->middleware(['auth']);
Route::any('/shop/product/quick/view', 'ShopController@productquickview')->name('shop.product.quick.view');
Route::get('/shop/product/details/{id}', 'ShopController@productdetails')->name('shop.product.details');


Route::get('/shop/products/cart', 'ShopController@productscart')->name('shop.products.cart');
Route::post('/shop/product/cart/add', 'ShopController@product_add_cart')->name('shop.product.cart.add');

Route::get('/shop/products/checkout', 'ShopController@productscheckout')->name('shop.products.checkout')->middleware(['auth']);;
Route::any('/shop/products/payment', 'ShopController@productspayment')->name('shop.products.payment')->middleware(['auth']);;
Route::any('/stripe/shop/product/order', ['as' => 'stripe.MarketplaceproductOrderPost', 'uses' => 'StripePaymentController@stripeMarketplaceProdcutOrderPost'])->middleware(['auth']);
Route::post('/shop/product/review/post', 'ShopController@productreviewpost')->name('shop.product.review.post');

});
/*
  |--------------------------------------------------------------------------
  | User Dashboard
  |--------------------------------------------------------------------------
 */
//Route::get('/dashboard', 'UserController@dashboard')->middleware('auth');

Route::get('/dashboard', 'HomeController@index')->name('dashboard')->middleware('auth', 'checksubdomain');
Route::get('/home', 'HomeController@index')->name('home')->middleware(['auth', 'checksubdomain']);;
Route::any('/users', 'UserController@domain_users')->name('users')->middleware('auth', 'checksubdomain');
Route::any('/users/followed', 'UserController@users_favurites')->name('users.favourites')->middleware('auth', 'checksubdomain');
Route::any('/users/liked', 'UserController@users_liked')->name('users.liked')->middleware('auth', 'checksubdomain');
Route::any('/user/change/favourite/status', 'UserController@change_favourite_user')->name('users.change.favourite');
Route::any('/user/change/like/status', 'UserController@change_like_user')->name('users.change.like');
Route::any('/contacts', 'UserController@domain_users')->name('contacts')->middleware('auth', 'checksubdomain');

;
Route::get('/courses', function () {
    return view('user.courses');
})->name('user.courses')->middleware('auth', 'checksubdomain');
;



//Route::get('/blog', function () {
//    return view('user.blog');
//})->name('user.blog')->middleware('auth', 'checksubdomain');;
//Route::get('/blog-details', function () {
//    return view('blog-details');
//})->name('blog-details')->middleware('auth', 'checksubdomain');;
//Route::get('/add-blog', function () {
//    return view('add-blog');
//})->name('add-blog')->middleware('auth', 'checksubdomain');;
//Route::get('/edit-blog', function () {
//    return view('edit-blog');
//})->name('edit-blog')->middleware('auth', 'checksubdomain');;
// Book page
Route::middleware(['auth', 'checksubdomain'])->group(function () {
    // review
    Route::get('events', 'VirtualboothController@events')->name('virtualbooth.events');
    Route::get('virtualboothEvents/create', 'VirtualboothController@create')->name('virtualboothEvents.create');
    Route::get('virtualboothEvents/eventcreate', 'VirtualboothController@eventcreate')->name('virtualboothEvents.eventcreate');
    Route::post('/virtualboothEvents/store', 'VirtualboothController@store')->name('virtualboothEvents.store');

    Route::get('reviews', 'ReviewController@index')->name('review.listing');
    Route::post('/reviews/post', 'ReviewController@addcomment')->name('review.post');
    Route::post('/reviews/update', 'ReviewController@updatecomment')->name('review.update');
    Route::post('/reviews/destroy', 'ReviewController@commentdestroy')->name('review.destroy');

    // pathways
    Route::get('pathway/testEmail', 'PathwayController@sendEmail')->name('pathway.sendEmail');
    Route::get('pathway/SendReminderPerDay', 'PathwayController@SendReminderPerDay')->name('pathway.SendReminderPerDay');
    Route::get('pathway/SendReminderPerMonth', 'PathwayController@SendReminderPerMonth')->name('pathway.SendReminderPerMonth');
    Route::get('pathway/SendReminderPerWeek', 'PathwayController@SendReminderPerWeek')->name('pathway.SendReminderPerWeek');
    Route::get('pathway/SendReminderMailPerDay', 'PathwayController@SendReminderMailPerDay')->name('pathway.SendReminderPerDay');
    Route::get('pathway/SendReminderMailPerMonth', 'PathwayController@SendReminderMailPerMonth')->name('pathway.SendReminderPerMonth');
    Route::get('pathway/SendReminderMailPerWeek', 'PathwayController@SendReminderMailPerWeek')->name('pathway.SendReminderPerWeek');

    Route::get('pathwayInvited', 'PathwayController@pathwayInvited')->name('pathway.pathwayInvited');
    Route::get('pathway', 'PathwayController@index')->name('pathway.get');
    Route::get('pathway/view', 'PathwayController@view')->name('pathway.view');
    Route::get('pathway/create', 'PathwayController@create')->name('pathway.create');
    Route::post('pathway/store', 'PathwayController@store')->name('pathway.store');
    Route::get('pathway/invite/{id}', 'PathwayController@invite')->name('pathway.invite');
    Route::post('pathway/updateinvitation', 'PathwayController@updateinvitation')->name('pathway.updateinvitation');
    Route::get('pathway/show/{id}', 'PathwayController@show')->name('pathway.show');
    Route::get('pathway/timeline/show/{id}', 'PathwayController@timelineshow')->name('pathwaytimeline.show');

    Route::get('pathway/edit/{id}', 'PathwayController@edit')->name('pathway.edit');
    Route::post('pathway/update', 'PathwayController@update')->name('pathway.update');
    Route::any('pathway/destroy/{id}', 'PathwayController@destroy')->name('pathway.destroy');
    Route::get('pathway/status/{id}', 'PathwayController@status')->name('pathway.status');
    Route::post('pathway/updatestatus', 'PathwayController@updatestatus')->name('pathway.updatestatus');
    Route::any('pathway/invitation/destroy/{id}', 'PathwayController@invitationdestroy')->name('pathway.invitationdestroy');
    Route::get('pathway/task/{id}', 'PathwayController@showtask')->name('pathway.showtask');
    Route::any('/pathwayinvitation/change/seen', 'PathwayController@change_status')->name('pathwayinvitation.change.seen');


Route::post('get/pathway/bot/reply', 'UserController@getPathwayBotReply')->name('get.pathway.bot.reply');
    //task
    Route::get('/task/create', function () {
        return view('task.create');
    })->name('task.create');
    Route::post('/task/post', 'TaskController@store')->name('task.post');
    Route::get('/task/show/{id}', 'TaskController@show')->name('task.show');
    Route::get('/task/show/task/{id}', 'TaskController@showtask')->name('task.showtask');
    Route::post('task/comment/update', 'TaskController@commentupdate')->name('comment.update');
    Route::post('/comment/post', 'TaskController@addcomment')->name('comment.post');
    Route::post('/comment/update', 'TaskController@updatecomment')->name('comment.update');
    Route::any('comment/destroy/{id}', 'TaskController@destroy')->name('comment.destroy');

    Route::get('task/edit/{id}', 'TaskController@edit')->name('task.edit');
    Route::post('task/update', 'TaskController@update')->name('task.update');
    Route::any('task/destroy/{id}', 'TaskController@destroytask')->name('task.destroy');

    //Book
    Route::get('book', 'BookController@index')->name('book.get');
    Route::get('book/view', 'BookController@view')->name('book.view');
    Route::get('book/create', 'BookController@create')->name('book.create');
    Route::post('book/store', 'BookController@store')->name('book.store');
    Route::get('book/edit/{id}', 'BookController@edit')->name('book.edit');
    Route::post('book/update', 'BookController@update')->name('book.update');
    Route::any('book/destroy{id}', 'BookController@destroy')->name('book.destroy');
    Route::any('book/ajax/view', ['as' => 'book.ajaxview', 'uses' => 'BookController@ajaxview'])->name('book.ajax.view');


    // IvrSeeting
    Route::get('ivrsetting', 'IvrSettingController@index')->name('ivrsetting.index');
    Route::get('ivr-numbers', 'IvrSettingController@twilio_numbers')->name('ivrsetting.twilio_numbers');
    Route::get('ivr-numbers/all', 'IvrSettingController@all_twilio_numbers')->name('ivrsetting.twilio_numbers.all');
    Route::post('migrate', 'IvrSettingController@migrate')->name('ivrsetting.migrate');
    Route::post('post-buy-number', 'IvrSettingController@post_buy_number')->name('ivrsetting.post_buy_number');
    Route::get('cancel-number/{id}', 'IvrSettingController@cancelNumber')->name('ivrsetting.cancelNumber');
    Route::get('buy-number', 'IvrSettingController@buy_ivr_number')->name('ivrsetting.buy_ivr_number');
    Route::resource('ivrsetting', 'IvrSettingController');
    Route::get('ivr/voice-notification', 'IvrSettingController@voiceNotificationIndex')->name('voice-notification');
    Route::post('ivr/voicemail/notification/post', 'IvrSettingController@voiceNotificationPost')->name('voice-notification-post');
    // Black Lists
    Route::get('ivr/black-list', 'IvrSettingController@blackList')->name('blackList');
    Route::match(['get', 'post'], 'ivr/black-list/create{id?}','IvrSettingController@createBlackList')->name('create.black.list');
    Route::post('ivr/black-list/destroy', 'IvrSettingController@ivrDestroyBlackList')->name('ivr.destroy.blacklist');
    Route::get('call-logs', 'IvrSettingController@call_logs')->name('ivr.call_logs');
    Route::get('voice-mail-logs', 'IvrSettingController@voice_mail_logs')->name('ivr.voice_mail_logs');
    Route::get('departments', 'IvrSettingController@department_list')->name('ivr.department_list');
    Route::match(['get','post'], 'departments/add', 'IvrSettingController@add_department')->name('ivr.add_department');
    Route::get('departments/edit/{id}','IvrSettingController@edit_department')->name('ivr.edit_department');
    Route::get('departments/destroy/{id?}','IvrSettingController@deleteDepartment')->name('ivr.delete_department');
    Route::get('ivr', 'IvrSettingController@ivr')->name('ivr');


    // After Hours
    // Route::get('ivr/after-hours', 'IvrSettingController@afterHoursList')->name('ivr.after.hours.list');
    Route::match(['get','post'], 'ivr/after-hours/{type?}/{id?}','IvrSettingController@afterHoursPost')->name('ivr.after.hours.post');

// Book category
    Route::get('book-category', 'BookCategoryController@index')->name('book.category');
    Route::get('book-category/create', 'BookCategoryController@create')->name('book.category.create');
    Route::post('book-category/store', 'BookCategoryController@store')->name('book.category.store');
    Route::get('book-category/view', 'BookCategoryController@view')->name('book.category.view');
    Route::get('book-category/edit/{id}', 'BookCategoryController@edit')->name('book.category.edit');
    Route::post('book-category/update', 'BookCategoryController@update')->name('book.category.update');
    Route::any('book-category/destroy{id}', 'BookCategoryController@destroy')->name('book.category.destroy');

// Bls industry
    Route::any('bls/industry', 'BlsIndustryController@index')->name('bls.category');
    Route::get('bls/industry/create', 'BlsIndustryController@create')->name('bls.category.create');
    Route::post('bls/industry/store', 'BlsIndustryController@store')->name('bls.category.store');
    Route::get('bls/industry/view', 'BlsIndustryController@view')->name('bls.category.view');
    Route::get('bls/industry/edit/{id}', 'BlsIndustryController@edit')->name('bls.category.edit');
    Route::post('bls/industry/update', 'BlsIndustryController@update')->name('bls.category.update');
    Route::any('bls/industry/destroy{id}', 'BlsIndustryController@destroy')->name('bls.category.destroy');

    Route::any('show/points', 'PointsController@showPoints')->name('points.show');
});
Route::middleware(['auth', 'checksubdomain'])->group(function () {
    Route::get('newsletter', ['as' => 'newsletter.index', 'uses' => 'NewsletterController@index']);
});
// Plans
Route::middleware(['auth', 'checksubdomain'])->group(function () {
    Route::get('plans', ['as' => 'plans.index', 'uses' => 'PlanController@index']);
    Route::get('plans/create', ['as' => 'plans.create', 'uses' => 'PlanController@create']);
    Route::post('plans/store', ['as' => 'plans.store', 'uses' => 'PlanController@store']);
    Route::get('plans/view', ['as' => 'plans.view', 'uses' => 'PlanController@view']);
    Route::get('plans/edit/{id}', ['as' => 'plans.edit', 'uses' => 'PlanController@edit']);
    Route::post('plans/update', ['as' => 'plans.update', 'uses' => 'PlanController@update']);
    Route::get('plans/destroy/{id}', ['as' => 'plans.destroy', 'uses' => 'PlanController@destroy']);
    Route::get('plans/category', ['as' => 'plans.category', 'uses' => 'PlanController@category']);
    Route::get('plans/category/create', ['as' => 'plans.category.create', 'uses' => 'PlanController@categorycreate']);
    Route::post('plans/category/store', ['as' => 'plans.category.store', 'uses' => 'PlanController@categorystore']);
    Route::any('plans/category/destroy/{id}', ['as' => 'plans.category.destroy', 'uses' => 'PlanController@categorydestroy']);
    Route::get('plans/category/view', ['as' => 'plans.category.view', 'uses' => 'PlanController@categoryview']);
    Route::get('plans/category/edit/{id}', ['as' => 'plans.category.edit', 'uses' => 'PlanController@categoryedit']);
    Route::post('plans/category/update', ['as' => 'plans.category.update', 'uses' => 'PlanController@categoryupdate']);
});
Route::get('plans/addons/category', 'PlanController@plansAddons_category')->name('plans.addons.category')->middleware(['auth', 'checksubdomain']);
Route::get('plans/addons', 'PlanController@plansAddons')->name('plans.addons')->middleware(['auth', 'checksubdomain']);
Route::get('plans/addons/category/create', 'PlanController@plansAddonsCreate_category')->name('plans.addons.category.create')->middleware(['auth', 'checksubdomain']);
Route::get('plans/addons/create', 'PlanController@plansAddonsCreate')->name('plans.addons.create')->middleware(['auth', 'checksubdomain']);
Route::post('plans/addons/category/store', 'PlanController@plansAddonsStore_category')->name('plans.addons.category.store')->middleware(['auth']);
Route::post('plans/addons/store', 'PlanController@plansAddonsStore')->name('plans.addons.store')->middleware(['auth']);
Route::get('plans/addons/keycheck', 'PlanController@plansAddonsKeycheck')->name('plans.addons.keycheck')->middleware(['auth', 'checksubdomain']);
Route::get('plans/addons/list', 'PlanController@plansAddonsList')->name('plans.addons.list')->middleware(['auth', 'checksubdomain']);
Route::get('plans/addons/edit{id}', 'PlanController@plansAddonsEdit')->name('plans.addons.edit')->middleware(['auth', 'checksubdomain']);
Route::get('plans/addons/category/edit/{id}', 'PlanController@plansAddonsEdit_category')->name('plans.addons.category.edit')->middleware(['auth', 'checksubdomain']);
Route::post('plans/addons/update', 'PlanController@plansAddonsUpdate')->name('plans.addons.update')->middleware(['auth']);
Route::post('plans/addons/category/update', 'PlanController@plansAddonsUpdate_category')->name('plans.addons.category.update')->middleware(['auth']);
Route::get('plans/addons/category/destroy/{id}', 'PlanController@plansAddonsdelete_category')->name('plans.addons.category.destroy')->middleware(['auth']);
Route::get('plans/addons/destroy/{id}', 'PlanController@plansAddonsDestroy')->name('plans.addons.destroy')->middleware(['auth']);
Route::get('plans/addmodules/{planId}', 'PlanController@plansModulesManager')->name('plans.modules.manager')->middleware(['auth', 'checksubdomain']);
Route::get('plans/modules/manager/{planId}', 'PlanController@plansaddmodules')->name('plans.addmodules')->middleware(['auth', 'checksubdomain']);
Route::post('plans/addons/add', 'PlanController@plansAddonsAdd')->name('plans.addons.add')->middleware(['auth']);


//urlIdentifiers route
Route::middleware(['auth', 'checksubdomain'])->group(function () {
    Route::get('url/identifiers', ['as' => 'url.identifiers.index', 'uses' => 'UrlIdentifierController@index']);
    Route::get('url/identifiers/create', ['as' => 'url.identifiers.create', 'uses' => 'UrlIdentifierController@create']);
    Route::get('url/identifiers/featchData', ['as' => 'url.identifiers.featchData', 'uses' => 'UrlIdentifierController@featchData']);
    Route::get('url/identifiers/checkTableName', ['as' => 'url.identifiers.checkTableName', 'uses' => 'UrlIdentifierController@checkTableName']);
    Route::get('url/identifiers/edit/{id}', ['as' => 'url.identifiers.edit', 'uses' => 'UrlIdentifierController@edit']);
    Route::post('url/identifiers/store', ['as' => 'url.identifiers.store', 'uses' => 'UrlIdentifierController@store']);
    Route::post('url/identifiers/update', ['as' => 'url.identifiers.update', 'uses' => 'UrlIdentifierController@update']);
    Route::get('url/identifiers/delete/{id}', ['as' => 'url.identifiers.delete', 'uses' => 'UrlIdentifierController@delete']);
});

Route::middleware(['auth', 'checksubdomain'])->group(function () {
    Route::resource('cms', 'PageController');
    Route::get('cms/view', 'PageController@view');
    Route::get('/page/destroy/{id}', ['as'=>'page.destroy', 'uses'=>'PageController@destroy']);
});
// blog page
Route::middleware(['auth', 'checksubdomain'])->group(function () {
    Route::get('blog', ['as' => 'blog.index', 'uses' => 'BlogController@index']);
    Route::get('blog/create', ['as' => 'blog.create', 'uses' => 'BlogController@create']);
    Route::post('blog/store', ['as' => 'blog.store', 'uses' => 'BlogController@store']);
    Route::get('blog/view', ['as' => 'blog.view', 'uses' => 'BlogController@view']);
    Route::get('blog/edit/{id}', ['as' => 'blog.edit', 'uses' => 'BlogController@edit']);
    Route::post('blog/update', ['as' => 'blog.update', 'uses' => 'BlogController@update']);
    Route::get('blog/destroy/{id}', ['as' => 'blog.destroy', 'uses' => 'BlogController@destroy']);
    Route::get('blog/category', ['as' => 'blog.category', 'uses' => 'BlogController@category']);
    Route::get('blog/category/create', ['as' => 'blog.category.create', 'uses' => 'BlogController@categorycreate']);
    Route::post('blog/category/store', ['as' => 'blog.category.store', 'uses' => 'BlogController@categorystore']);
    Route::any('blog/category/destroy/{id}', ['as' => 'blog.category.destroy', 'uses' => 'BlogController@categorydestroy']);
    Route::get('blog/category/view', ['as' => 'blog.category.view', 'uses' => 'BlogController@categoryview']);
    Route::get('blog/category/edit/{id}', ['as' => 'blog.category.edit', 'uses' => 'BlogController@categoryedit']);
    Route::post('blog/category/update', ['as' => 'blog.category.update', 'uses' => 'BlogController@categoryupdate']);
});

// schedule timing

Route::middleware(['auth', 'checksubdomain'])->group(function () {
    Route::get('leads/list', ['as' => 'lead.index', 'uses' => 'LeadController@index']);
    Route::get('leads/{name}/{collegeId}/user', ['as' => 'lead.subList', 'uses' => 'LeadController@subList']);
    Route::get('leads/college/list', ['as' => 'lead.collegelist', 'uses' => 'LeadController@collegelist']);
    Route::get('leads/military/list', ['as' => 'lead.militarylist', 'uses' => 'LeadController@militarylist']);
    Route::get('leads/veteran/list', ['as' => 'lead.veteranlist', 'uses' => 'LeadController@veteranlist']);
    Route::get('leads/justice/list', ['as' => 'lead.justicelist', 'uses' => 'LeadController@justicelist']);

    Route::get('leads/school/list', ['as' => 'lead.schoollist', 'uses' => 'LeadController@schoollist']);
    Route::get('leads/military/user', ['as' => 'lead.militaryuser', 'uses' => 'LeadController@militaryuser']);
    Route::get('leads/veteran/user', ['as' => 'lead.veteranuser', 'uses' => 'LeadController@veteranuser']);
    Route::get('leads/justice/user', ['as' => 'lead.justiceuser', 'uses' => 'LeadController@justiceuser']);
    Route::get('my-lead', ['as' => 'lead.mylead', 'uses' => 'LeadController@mylead']);
    Route::get('my-lead/{name}/{id}/user', ['as' => 'lead.myleadstudent', 'uses' => 'LeadController@myleadstudent']);
    Route::get('my-lead/{name}/{id}/user/grid-view', ['as' => 'lead.myleadgrid', 'uses' => 'LeadController@myleadgrid']);
    Route::get('my-lead/{name}/{id}/user/map-view', ['as' => 'lead.myleadmap', 'uses' => 'LeadController@myleadmap']);
    Route::get('my-lead/user/profile/{id}', ['as' => 'lead.myleaduserprofile', 'uses' => 'LeadController@myleaduserprofile']);

    Route::any('/lead/change/status', 'LeadController@change_status')->name('lead.change.status');

    //program
    Route::get('program/create', ['as' => 'program.create', 'uses' => 'template\ProgramController@create']);
    Route::get('program/listing', ['as' => 'program.list', 'uses' =>  'template\ProgramController@index']);
    Route::post('program/store', ['as' => 'program.store', 'uses' => 'template\ProgramController@store']);
    Route::get('program/show/{id}', ['as' => 'program.show', 'uses' => 'template\ProgramController@show']);
    Route::get('program/edit/{id}', ['as' => 'program.edit', 'uses' => 'template\ProgramController@edit']);

    Route::get('program/audit/request/{id}', ['as' => 'audit.report', 'uses' => 'template\ProgramController@auditRequest']);
    Route::post('pay/insert', 'template\ProgramController@create_pay');
    Route::get('program/destroy/{id}',  ['as' => 'program.destroy', 'uses' => 'template\ProgramController@destroy']);
    Route::post('audit/import_csv', 'template\ProgramController@import_audit')->name('audit.import');
    Route::get('program/audit/update/{id}', ['as' => 'audit.update', 'uses' => 'template\ProgramController@updateaudit']);
    Route::post('program/audit/update', ['as' => 'auditreport.update', 'uses' => 'template\ProgramController@updateauditreport']);
    // Route::post('program/listing', ['as' => 'program.listing', 'uses' => 'template\ProgramController@programList']);

    //apply for program
    Route::get('apply/program', ['as' => 'program.apply', 'uses' =>  'template\ProgramableController@apply']);
    Route::post('approval_form/store', ['as' => 'approval_form.store', 'uses' => 'template\ProgramableController@store']);

    Route::get('meeting/schedules', ['as' => 'meeting.schedules.index', 'uses' =>  'MeetingSchedulesController@index']);

    Route::get('meeting/schedule/create',['as' => 'meeting.schedule.create', 'uses' =>  'MeetingSchedulesController@create']);
    Route::post('meeting/schedule/store', ['as' => 'meeting.schedule.store', 'uses' => 'MeetingSchedulesController@store']);
     Route::get('meeting/schedule/edit/{id}',  ['as' => 'meeting.schedule.edit', 'uses' => 'MeetingSchedulesController@edit']);
    Route::any('meeting/schedule/update',  ['as' => 'meeting.schedule.update', 'uses' => 'MeetingSchedulesController@update']);
    Route::get('meeting/schedule/destroy/{id}',  ['as' => 'meeting.schedule.destroy', 'uses' => 'MeetingSchedulesController@destroy']);

    Route::get('meeting/schedules/timings', ['as' => 'meeting.schedules.timings', 'uses' =>  'MeetingSchedulesController@slot_index']);
    Route::get('meeting/schedule/slot/create/{id}',['as' => 'meeting.schedule.slot.create', 'uses' =>  'MeetingSchedulesController@slot_create']);
    Route::post('meeting/schedule/slot/store', ['as' => 'meeting.schedule.slot.store', 'uses' => 'MeetingSchedulesController@slot_store']);
    Route::post('meeting/schedule/slot/update', ['as' => 'meeting.schedule.slot.update', 'uses' => 'MeetingSchedulesController@slot_update']);
    Route::get('meeting/schedule/slot/destroy/{id}',  ['as' => 'meeting.schedule.slot.destroy', 'uses' => 'MeetingSchedulesController@slot_destroy']);
   Route::get('meeting/schedule/slot/edit/{id}',  ['as' => 'meeting.schedule.slot.edit', 'uses' => 'MeetingSchedulesController@slot_edit']);
   Route::get('meeting/schedule/slot/booking/destroy/{id}',  ['as' => 'meeting.schedule.slot.booking.destroy', 'uses' => 'MeetingSchedulesController@slot_booking_destroy']);

   Route::get('meeting/schedules/bookings', ['as' => 'meeting.schedules.bookings', 'uses' =>  'MeetingSchedulesController@bookings_index']);
   Route::get('meeting/schedules/bookings/canceled', ['as' => 'meeting.schedules.bookings.canceled', 'uses' =>  'MeetingSchedulesController@canceled_bookings_index']);
   Route::get('schedule/bookings', ['as' => 'meeting.schedules.booked', 'uses' =>  'MeetingSchedulesController@bookings_schedule']);
   Route::get('schedule/bookings/canceled', ['as' => 'meeting.schedules.canceled', 'uses' =>  'MeetingSchedulesController@bookings_schedule_canceled']);
   Route::get('meeting/schedules/booking/reschedule/{id}', ['as' => 'meeting.schedules.booking.reschedule', 'uses' => 'MeetingSchedulesController@booking_reschedule']);
    Route::post('meeting/schedules/booking/reschedule/post', ['as' => 'meeting.schedules.booking.reschedule.post', 'uses' => 'MeetingSchedulesController@booking_reschedule_post']);
   Route::any('meeting/schedules/booking/status', 'MeetingSchedulesController@change_accomplished_status')->name('meeting.schedules.bookings.accomplished');

Route::get('meeting/schedule/bookings/calendar', ['as' => 'bookings.calendar', 'uses' => 'MeetingSchedulesController@calendarView'])->middleware(['auth']);
Route::get('meeting/schedule/booked/calendar', ['as' => 'bookings.calendar.booked', 'uses' => 'MeetingSchedulesController@calendarViewbooked'])->middleware(['auth']);
});

   // Email Templates
Route::middleware(['auth', 'checksubdomain'])->group(function () {
Route::get('email/template/{id}', 'EmailTemplateController@manageEmailLang')->name('manage.email.language');
Route::put('email/template/store/{pid}', 'EmailTemplateController@storeEmailLang')->name('store.email.language');
Route::put('email/template/status/{id}/{pid}', 'EmailTemplateController@updateStatus')->name('status.email.language');
Route::get('email/templates', 'EmailTemplateController@index')->name('email_template.index');
Route::get('email/template/create/new', 'EmailTemplateController@create')->name('email_template.create');
Route::post('email/template', 'EmailTemplateController@store')->name('email_template.store');
Route::put('email/template/update/{id}', 'EmailTemplateController@update')->name('email_template.update');
});

Route::any('send/email/{id}', 'EmailTemplateController@emailform')->name('send.email.form')->middleware('auth', 'checksubdomain');
Route::post('send/email', 'EmailTemplateController@sendemail')->name('send.email')->middleware('auth', 'checksubdomain');;
Route::any('send/sms/{id}', 'EmailTemplateController@smsform')->name('send.sms.form')->middleware('auth', 'checksubdomain');
Route::post('send/sms', 'EmailTemplateController@sendsms')->name('send.sms')->middleware('auth', 'checksubdomain');;
// End Email Templates

Route::middleware(['auth', 'checksubdomain'])->group(function () {
    Route::get('contacts/', ['as' => 'contacts', 'uses' =>  'ContactController@connection_index']);
    Route::get('contacts/unsbuscribers', ['as' => 'contact.unsubscribers', 'uses' => 'ContactController@unsubscriber_index']);
    Route::get('contacts/create',['as' => 'contact.create', 'uses' =>  'ContactController@connection_create']);
    Route::post('contacts/store', ['as' => 'contact.store', 'uses' => 'ContactController@connection_store']);
     Route::get('contacts/edit/{id}',  ['as' => 'contact.edit', 'uses' => 'ContactController@connections_edit']);
     Route::any('contacts/view/{id}',  ['as' => 'contact.view', 'uses' => 'ContactController@connections_view']);
    Route::any('contacts/update',  ['as' => 'contact.update', 'uses' => 'ContactController@connections_update']);
    Route::get('contacts/destroy/{id}',  ['as' => 'contact.destroy', 'uses' => 'ContactController@connections_destroy']);

     Route::get('contacts/folder', 'ContactController@folder_index');
    Route::get('contacts/folder/create', 'ContactController@folder_create');
    Route::post('contacts/folder/store', 'ContactController@folder_store');
    Route::get('contacts/folder/destroy/{id}', 'ContactController@folder_destroy')->name('contact.folder.destroy');
    Route::get('contacts/folder/edit/{id}', 'ContactController@folder_edit');
    Route::put('contacts/folder/update/{id}', 'ContactController@folder_update');

        //auto responder
     Route::get('autoresponder', 'AutoresponderController@index')->name('autoresponder.index');
    Route::get('autoresponder/create', 'AutoresponderController@create')->name('autoresponder.create');
    Route::post('autoresponder/store', 'AutoresponderController@store')->name('autoresponder.store');
    Route::any('autoresponder/destroy/{id}', 'AutoresponderController@destroy')->name('autoresponder.destroy');
    Route::get('autoresponder/edit/{id}', 'AutoresponderController@edit')->name('autoresponder.edit');
    Route::any('autoresponder/statistics/{id}', 'AutoresponderController@statistics')->name('autoresponder.statistics');
    Route::put('autoresponder/update/{id}', 'AutoresponderController@update')->name('autoresponder.update');
    Route::get('contacts/view/details/email/send', 'ContactController@connection_view_send_email')->name('connection_view_send_contact_email');
    Route::get('contacts/view/details/sms/send', 'ContactController@connection_view_send_sms')->name('connection_view_send_sms');
/* * *************Twilio SMS Thread Start**************** */
Route::get('contact/sms/thread/view/{id}', 'ContactController@sms_thread')->name('sms.thread.view');
/* * *************Twilio SMS Thread End**************** */

/* * *************Twilio Call  Initiate Start**************** */
Route::get('twilio/call/initiate', 'ContactController@twilio_call_initiate')->name('twilio.call.initiate');
/* * *************Twilio Call  Initiate  End**************** */
});

/* * *************Twilio SMS Webhook Start**************** */
Route::any('twilio/sms/webhook', 'FrontendController@sms_web_hook')->name('twilio.sms.webhook');
/* * *************Twilio SMS Webhook End**************** */


/* * *************Crm Categories Start**************** */
Route::middleware(['auth', 'checksubdomain'])->group(function () { //, "plancheck:crm_custom_forms"

    /*     * *************Custom Form Start**************** */
    Route::get('survey/custom/forms/dashboard', ['as' => 'crmcustom.dashboard', 'uses' => 'CrmController@dashboard']);
    Route::get('survey/custom/forms', ['as' => 'crmcustom.index', 'uses' => 'CrmController@index']);
     Route::get('survey/custom/form/create', ['as' => 'crmcustom.create', 'uses' => 'CrmController@form_create']);
      Route::post('survey/custom/store', 'CrmController@store')->name('crmcustom.store');
    Route::post('survey/custom/form/update', ['as' => 'crmcustom.update', 'uses' => 'CrmController@update']);
    Route::any('survey/custom/form/destroy/{id}', ['as' => 'crmcustom.destroy', 'uses' => 'CrmController@destroy']);
     Route::get('survey/custom/form/edit/{id}', ['as' => 'crmcustom.edit', 'uses' => 'CrmController@edit']);
    Route::get('survey/custom/questions/{id}', ['as' => 'crmcustomQuestion', 'uses' => 'CrmController@questions']);
     Route::get('survey/custom/form/sidebar/{id}', ['as' => 'crmcustomForm.sidebar', 'uses' => 'CrmController@form_sidebar']);
    Route::get('survey/custom/form/{id}', ['as' => 'crmcustomForm', 'uses' => 'CrmController@form']);
     Route::get('survey/custom/question/add/{id}', ['as' => 'crmcustomQuestion.create', 'uses' => 'CrmController@question_create']);
    Route::get('survey/custom/question/edit/{form_id}/{id}', ['as' => 'crmcustomQuestion.edit', 'uses' => 'CrmController@question_edit']);
    Route::post('survey/custom/questions/store', ['as' => 'crmcustomQuestion.store', 'uses' => 'CrmController@question_store']);
    Route::any('survey/custom/question/destroy/{id}', ['as' => 'crmcustomQuestion.destroy', 'uses' => 'CrmController@question_destroy']);
    Route::post('survey/custom/question/indexing', ['as' => 'crmcustomQuestion@indexing', 'uses' => 'CrmController@indexing']);

    Route::get('survey/custom/form/users/responses/{id}', ['as' => 'crmcustomForm.responseUsers', 'uses' => 'CrmController@form_users_responses']);
    Route::get('survey/custom/form/users/responses/exportcsv/{id}', ['as' => 'crmcustomForm.responsesexportcsv', 'uses' => 'CrmController@form_users_responses_export_csv']);

Route::get('survey/custom/form/response/{id}/{user_id}', ['as' => 'crmcustomForm.response', 'uses' => 'CrmController@form_response']);
 Route::post('survey/custom/form/store', ['as' => 'crmcustomForm.store', 'uses' => 'CrmController@form_response_store']);
   Route::any('survey/custom/form/user/response/destroy/{id}', ['as' => 'crmcustomResponse.destroy', 'uses' => 'CrmController@form_users_responses_destroy']);
   Route::get('survey/custom/form/user/response/view/{id}', ['as' => 'crmcustomResponse.user', 'uses' => 'CrmController@form_user_response']);


   //frontend
//Route::get('survey/shared/form/{id}', ['as' => 'crmshared.form', 'uses' => 'FrontendController@crm_public_form']);
Route::post('survey/shared/form/store', ['as' => 'crmshared.formstore', 'uses' => 'CrmController@crm_public_form_store']);
Route::get('survey/shared/form/{id}', ['as' => 'crmshared.form', 'uses' => 'CrmController@public_form_view']);

Route::get('survey/custom/dashboard/public', ['as' => 'crmcustom.public', 'uses' => 'CrmController@published']);

Route::get('survey/form/users/assign/{id}', ['as' => 'crmForm.assign', 'uses' => 'CrmController@form_assign']);
    Route::post('survey/form/users/assign/store', ['as' => 'crmAssign.store', 'uses' => 'CrmController@assign_store']);

});
 Route::any('state/map/data', ['as' => 'state.map.data', 'uses' => 'UserController@statemap']);
 Route::any('state/map/dot/data', ['as' => 'state.map.dot.data', 'uses' => 'UserController@statemapdots']);

 Route::post('get/user/info', function (\Illuminate\Http\Request $Request) {
     $res=\App\User::select('id','name','type','avatar','address1','mobile','email','company')->where('id',$Request->id)->first();
     $res->baseurl=url('/');
     return json_encode($res);
})->name('getUserinfo');

Route::middleware(['auth', 'checksubdomain'])->group(function () {
	  Route::any('wallet', ['as' => 'wallet', 'uses' => 'WalletController@index']);
          Route::get('wallet/deposit', 'WalletController@deposit')->name('wallet.deposit');
          Route::get('wallet/transfer', 'WalletController@transfer')->name('wallet.transfer');
          Route::post('wallet/transfer/post', 'WalletController@transferpost')->name('wallet.transfer.post');
           Route::any('wallet/deposit/post', ['as' => 'stripe.wallet.deposit', 'uses' => 'StripePaymentController@wallet_deposit'])->middleware(['auth']);
});

 /* * *************petition Start**************** */
Route::middleware(['auth', 'checksubdomain'])->group(function () {

    /*     * *************petition Form Start**************** */
    Route::get('petition/forms/dashboard', ['as' => 'petitioncustom.dashboard', 'uses' => 'PetitionController@dashboard']);
    Route::get('petition/forms', ['as' => 'petitioncustom.index', 'uses' => 'PetitionController@index']);
    Route::get('petition/forms/updates', ['as' => 'petitioncustom.updates', 'uses' => 'PetitionController@updates']);
     Route::get('petition/form/create', ['as' => 'petitioncustom.create', 'uses' => 'PetitionController@form_create']);
      Route::post('petition/store', 'PetitionController@store')->name('petitioncustom.store');
    Route::post('petition/form/update', ['as' => 'petitioncustom.update', 'uses' => 'PetitionController@update']);
    Route::any('petition/form/destroy/{id}', ['as' => 'petitioncustom.destroy', 'uses' => 'PetitionController@destroy']);
     Route::get('petition/form/edit/{id}', ['as' => 'petitioncustom.edit', 'uses' => 'PetitionController@edit']);
    Route::get('petition/questions/{id}', ['as' => 'petitioncustomQuestion', 'uses' => 'PetitionController@questions']);
     Route::get('petition/form/sidebar/{id}', ['as' => 'petitioncustomForm.sidebar', 'uses' => 'PetitionController@form_sidebar']);
    Route::get('petition/form/{id}', ['as' => 'petitioncustomForm', 'uses' => 'PetitionController@form']);
     Route::get('petition/question/add/{id}', ['as' => 'petitioncustomQuestion.create', 'uses' => 'PetitionController@question_create']);
    Route::get('petition/question/edit/{form_id}/{id}', ['as' => 'petitioncustomQuestion.edit', 'uses' => 'PetitionController@question_edit']);
    Route::post('petition/questions/store', ['as' => 'petitioncustomQuestion.store', 'uses' => 'PetitionController@question_store']);
    Route::any('petition/question/destroy/{id}', ['as' => 'petitioncustomQuestion.destroy', 'uses' => 'PetitionController@question_destroy']);
    Route::post('petition/question/indexing', ['as' => 'petitioncustomQuestion@indexing', 'uses' => 'PetitionController@indexing']);

    Route::get('petition/form/users/responses/{id}', ['as' => 'petitioncustomForm.responseUsers', 'uses' => 'PetitionController@form_users_responses']);
    Route::get('petition/form/users/responses/exportcsv/{id}', ['as' => 'petitioncustomForm.responsesexportcsv', 'uses' => 'PetitionController@form_users_responses_export_csv']);

Route::get('petition/form/response/{id}/{user_id}', ['as' => 'petitioncustomForm.response', 'uses' => 'PetitionController@form_response']);
 Route::post('petition/form/store', ['as' => 'petitioncustomForm.store', 'uses' => 'PetitionController@form_response_store']);
   Route::any('petition/form/user/response/destroy/{id}', ['as' => 'petitioncustomResponse.destroy', 'uses' => 'PetitionController@form_users_responses_destroy']);
   Route::get('petition/form/user/response/view/{id}', ['as' => 'petitioncustomResponse.user', 'uses' => 'PetitionController@form_user_response']);


   //frontend
//Route::get('petition/shared/form/{id}', ['as' => 'petitionshared.form', 'uses' => 'FrontendController@petition_public_form']);


Route::get('petition/dashboard/public', ['as' => 'petitioncustom.public', 'uses' => 'PetitionController@published']);

Route::get('petition/form/users/assign/{id}', ['as' => 'petitionForm.assign', 'uses' => 'PetitionController@form_assign']);
    Route::post('petition/form/users/assign/store', ['as' => 'petitionAssign.store', 'uses' => 'PetitionController@assign_store']);
Route::get('petition/support/{id}', ['as' => 'petitionsupport', 'uses' => 'PetitionController@public_form_support']);
Route::get('petition/promote/{id}', ['as' => 'petitionpromote', 'uses' => 'PetitionController@public_form_promote']);
Route::any('/petition/donation/promote', ['as' => 'stripe.petition.donation', 'uses' => 'StripePaymentController@PetitionPaymentPost'])->middleware(['auth']);

  Route::get('petition/update/create', 'PetitionController@update_create')->name('petitionupdate.create');
    Route::post('petition/update/store', 'PetitionController@update_store')->name('petitionupdate.store');
    Route::get('petition/update/destroy/{id}', 'PetitionController@update_destroy')->name('petitionupdate.destroy');
    Route::get('petition/update/edit/{id}', 'PetitionController@update_edit')->name('petitionupdate.edit');

    Route::any('petition/donation/payments', ['as' => 'user.petition.invoices', 'uses' => 'PetitionController@donations'])->middleware('auth', 'checksubdomain');
});
 Route::any('petition/shared/form/store', ['as' => 'petitionshared.formstore', 'uses' => 'PetitionController@form_response_store']);
Route::get('petition/shared/form/{id}', ['as' => 'petitionshared.form', 'uses' => 'PetitionController@public_form_view']);
Route::get('petition/share/{id}', ['as' => 'petitionshare', 'uses' => 'PetitionController@public_form_share']);
Route::post('/petition/reviews', 'PetitionController@profilereviews')->name('petition.reviews');
 /* * *************Assessment Categories Start**************** */
Route::middleware(['auth', 'checksubdomain'])->group(function () {
    Route::get('assessment/category', 'AssessmentCategoryController@index')->name('assessmentCategory.index');
    Route::get('assessment/category/create', 'AssessmentCategoryController@create')->name('assessmentCategory.create');
    Route::post('assessment/category/store', 'AssessmentCategoryController@store')->name('assessmentCategory.store');
    Route::get('assessment/category/view', 'AssessmentCategoryController@view')->name('assessmentCategory.view');
    Route::get('assessment/category/edit/{id}', 'AssessmentCategoryController@edit')->name('assessmentCategory.edit');
    Route::post('assessment/category/update', 'AssessmentCategoryController@update')->name('assessmentCategory.update');
    Route::any('assessment/category/destroy/{id}', 'AssessmentCategoryController@destroy')->name('assessmentCategory.destroy');
    /*     * *************Assessment Categories End**************** */
    /*     * *************Assessment Start**************** */
    Route::get('assessments/dashboard', ['as' => 'assessment.dashboard', 'uses' => 'AssessmentController@dashboard']);
    Route::get('assessment', ['as' => 'assessment.index', 'uses' => 'AssessmentController@index']);
    Route::get('assessment/view', ['as' => 'assessment.view', 'uses' => 'AssessmentController@view']);
    Route::get('assessment/form/edit/{id}', ['as' => 'assessment.edit', 'uses' => 'AssessmentController@edit']);
    Route::get('assessment/public', ['as' => 'assessment.public', 'uses' => 'AssessmentController@published']);
    Route::get('assessment/form/create', ['as' => 'assessment.create', 'uses' => 'AssessmentController@form_create']);
    Route::post('assessment/store', 'AssessmentController@store')->name('assessment.store');
    Route::post('assessment/form/update', ['as' => 'assessment.update', 'uses' => 'AssessmentController@update']);
    Route::any('assessment/form/destroy/{id}', ['as' => 'assessment.destroy', 'uses' => 'AssessmentController@destroy']);
    Route::get('assessment/questions/{id}', ['as' => 'assessmentQuestion', 'uses' => 'AssessmentController@questions']);
    Route::get('assessment/question/add/{id}', ['as' => 'assessmentQuestion.create', 'uses' => 'AssessmentController@question_create']);
    Route::get('assessment/question/edit/{form_id}/{id}', ['as' => 'assessmentQuestion.edit', 'uses' => 'AssessmentController@question_edit']);
    Route::post('assessment/questions/store', ['as' => 'assessmentQuestion.store', 'uses' => 'AssessmentController@question_store']);
    Route::any('assessment/question/destroy/{id}', ['as' => 'assessmentQuestion.destroy', 'uses' => 'AssessmentController@question_destroy']);
    Route::post('assessment/question/indexing', ['as' => 'assessmentQuestion@indexing', 'uses' => 'AssessmentController@indexing']);
    Route::get('assessment/form/{id}', ['as' => 'assessmentForm', 'uses' => 'AssessmentController@form']);
    Route::get('assessment/form/response/{id}/{user_id}', ['as' => 'assessmentForm.response', 'uses' => 'AssessmentController@form_response']);
    Route::get('assessment/form/show/response/{id}/{user_id}', ['as' => 'assessmentFormshow.response', 'uses' => 'AssessmentController@form_show_response']);
    Route::post('assessment/form/store', ['as' => 'assessmentForm.store', 'uses' => 'AssessmentController@form_store']);
    Route::get('assessment/form/sidebar/{id}', ['as' => 'assessmentForm.sidebar', 'uses' => 'AssessmentController@form_sidebar']);
    Route::get('assessment/form/users/responses/{id}', ['as' => 'assessmentForm.responseUsers', 'uses' => 'AssessmentController@form_users_responses']);
    Route::any('assessment/form/user/response/destroy/{id}', ['as' => 'assessmentResponse.destroy', 'uses' => 'AssessmentController@form_users_responses_destroy']);

    Route::get('assessment/form/users/assign/{id}', ['as' => 'assessmentForm.assign', 'uses' => 'AssessmentController@form_assign']);
    Route::post('assessment/form/users/assign/store', ['as' => 'assessmentAssign.store', 'uses' => 'AssessmentController@assign_store']);
    Route::any('assessment/payment/confirmation', ['as' => 'assessmentForm.paymentConfirmation', 'uses' => 'AssessmentController@payment_confirmation']);
    Route::post('/stripe/assessment/form/payment', ['as' => 'stripe.assessmentFormPaymentPost', 'uses' => 'StripePaymentController@assessmentFormPaymentPost'])->middleware(['auth']);
});
/* * *************Assessment End**************** */


/* * *************Podcast Start**************** */
Route::middleware(['auth', 'checksubdomain'])->group(function () {


//Route::middleware(['auth', "plancheck:podcasts"])->group(function () {
    Route::get('podcast/dashboard', ['as' => 'podcast.dashboard', 'uses' => 'PodcastController@dashboard']);
    Route::get('podcast/create', ['as' => 'podcast.create', 'uses' => 'PodcastController@create'])->middleware(['auth']);
    Route::get('podcast/files/upload', ['as' => 'podcast.files_upload', 'uses' => 'PodcastController@podcast_files'])->middleware(['auth']);
    Route::get('podcast/add/episode/{id}', ['as' => 'podcast.addEpisode', 'uses' => 'PodcastController@addepisode'])->middleware(['auth']);
    Route::post('podcast/store', 'PodcastController@store')->name('podcast.store')->middleware(['auth']);
    Route::post('podcast/store/file', 'PodcastController@storefile')->name('podcast.storefile')->middleware(['auth']);
    Route::any('podcast/view', ['as' => 'podcast.view', 'uses' => 'PodcastController@view'])->middleware(['auth']);
    Route::get('podcast/edit/{id}', ['as' => 'podcast.edit', 'uses' => 'PodcastController@edit'])->middleware(['auth']);
Route::get('podcast/destroy/{id}', ['as' => 'podcast.destroy', 'uses' => 'PodcastController@destroy']);
    Route::get('podcast/file/destroy/{id}', ['as' => 'podcast.destroyfile', 'uses' => 'PodcastController@destroyfile']);
});
/* * *************Podcast End**************** */
/* * *************Frontend Podcast Start**************** */
Route::get('/podcasts/{id}', 'FrontendController@podcasts')->name('podcasts');
Route::any('/podcasts/filter', 'FrontendController@podcastsfilter')->name('podcasts.filter');
Route::get('/podcast/details/{id?}', 'FrontendController@podcast_detail')->name('podcast_detail');
/* * *************Frontend Podcast End**************** */
/* * *************Donation Start**************** */
Route::middleware(['auth', 'checksubdomain'])->group(function () {
Route::get('donation/page', 'DonationController@index');
Route::put('donation/page/store', 'DonationController@store');
Route::get('donation/qrcode/{id}', 'DonationController@qrcode');
Route::get('/donation/dashboard', 'DonationController@donation_dashboard')->name('donation.dashboard');
Route::get('/donation/view', 'DonationController@view');
Route::get('/donation/destroy/{id}', 'DonationController@destroy')->name('donation.destroy');
Route::get('/donation/resend/letter/{id}', 'DonationController@resendletter')->name('donation.resend.letter');
Route::get('/donation/history', 'DonationController@donation_history');
Route::get('sendbasicemail', 'DonationController@basic_email');
});

/* * *************Podcast End**************** */
/* * *************Frontend Podcast Start**************** */
Route::post('/donation/insert', 'DonationController@create_donation');
Route::get('{id}/donation', 'DonationController@public_index')->name('donation.public.page');
/* * *************Frontend Podcast End**************** */
/* * *************Swag Start**************** */
Route::middleware(['auth', "checksubdomain"])->group(function () {
    /*     * *************swag options Start**************** */
    Route::get('swag/options', 'SwagOptionController@index')->name('swagOption.index');
    Route::get('swag/options/show', 'SwagOptionController@show')->name('swagOption.show');
    Route::get('swag/option/create', 'SwagOptionController@create')->name('swagOption.create');
    Route::post('swag/option/store', 'SwagOptionController@store')->name('swagOption.store');
    Route::get('swag/option/edit/{id}', 'SwagOptionController@edit')->name('swagOption.edit');
    Route::post('swag/option/update', 'SwagOptionController@update')->name('swagOption.update');
    Route::post('swag/option/destroy', 'SwagOptionController@destroy')->name('swagOption.destroy');
    /*     * *************swag options End**************** */
    Route::get('swag/dashboard', ['as' => 'swag.dashboard', 'uses' => 'SwagController@dashboard'])->middleware(['auth']);
    Route::get('swag/create', ['as' => 'swag.create', 'uses' => 'SwagController@create'])->middleware(['auth']);
    Route::post('swag/store', 'SwagController@store')->name('swag.store')->middleware(['auth']);
    Route::any('swag/view', ['as' => 'swag.view', 'uses' => 'SwagController@view'])->middleware(['auth']);
    Route::get('swag/edit/{id}', ['as' => 'swag.edit', 'uses' => 'SwagController@edit'])->middleware(['auth']);
    Route::post('swag/destroy', ['as' => 'swag.destroy', 'uses' => 'SwagController@destroy'])->middleware(['auth']);
});
/* * *************Swag End**************** */
/* * *************Frontend Swag Start**************** */
Route::get('/swag', 'FrontendController@swags')->name('swags');
Route::any('/swags/filter', 'FrontendController@swagsfilter')->name('swags.filter');
Route::get('/swag/details/{id}', ['as' => 'swag.details', 'uses' => 'FrontendController@swagdetail']);
/* * *************Frontend Swag End**************** */
Route::middleware(['auth', "checksubdomain"])->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Partner
    |--------------------------------------------------------------------------
    */
    Route::get('partner',  ['as' => 'partner.index', 'uses' => 'PartnerController@index']);
    Route::get('partner/create', 'PartnerController@create');
    Route::post('partner/store', 'PartnerController@store');
    Route::get('partner/edit/{id}', 'PartnerController@edit');
    Route::post('partner/update', 'PartnerController@update');
    Route::get('partner/destroy/{id}', ['as' => 'partner.destroy', 'uses' => 'PartnerController@destroy']);
    /*
    |--------------------------------------------------------------------------
    | Partner End
    |--------------------------------------------------------------------------
    */
});

// verifyCert
Route::get('verifycert', ['as' => 'verify.cert', 'uses' => 'CertifyController@verifycertview']);
Route::post('verify/cert/', ['as' => 'verify.cert.post', 'uses' => 'CertifyController@verifycert']);
Route::post('verify/cert/ivr', ['as' => 'verify.cert.ivr', 'uses' => 'CertifyController@verifycertivr']);
Route::get('verify/certificate/call', ['as' => 'verify.certificate.call', 'uses' => 'CertifyController@certificateivrcall']);
// certify
Route::middleware(['auth', 'checksubdomain' , "plancheck:syndicatepayments"])->group(function () {
	  Route::get('certify/syndicate', ['as' => 'certify.syndicate', 'uses' => 'CertifyController@syndicate']);
	Route::get('certify/syndicate/pending/list', ['as' => 'certify.syndicate.pending.list', 'uses' => 'CertifyController@pending_syndicate']);
    Route::get('certify/syndicate/stripe', ['as' => 'certify.syndicate.stripe', 'uses' => 'CertifyController@syndicateStripe']);
    Route::get('certify/syndicate/disable', ['as' => 'certify.syndicate.disable', 'uses' => 'CertifyController@syndicateStripeDisable']);
	  Route::get('certify/syndicate/approve', ['as' => 'certify.syndicate.approve', 'uses' => 'CertifyController@syndicateApprove']);
	  Route::get('certify/syndicate/frontendview', ['as' => 'certify.syndicate.frontendview', 'uses' => 'CertifyController@frontendview']);
	  Route::get('certify/syndicate/deletefrontendview', ['as' => 'certify.syndicate.deletefrontendview', 'uses' => 'CertifyController@deletefrontendview']);
    Route::get('certify/syndicate/pending', ['as' => 'certify.syndicate.pending', 'uses' => 'CertifyController@syndicatePending']);
    Route::get('certify/syndicate/revenue', ['as' => 'certify.syndicate.revenue', 'uses' => 'CertifyController@syndicateRevenue']);
});
  Route::get('tution/request', ['as' => 'wallet.tutionrequest', 'uses' => 'CertifyController@tutionrequest'])->middleware(['auth']);
  Route::post('get/certfy/price', 'CertifyController@getCertfyPrice')->name('get.certfy.price');


Route::post('/tution/assistance/opportunity', 'CertifyController@checkOpportunity')->name('tution.assistance.opportunity')->middleware(['auth']);
Route::post('/tution/assistance/pathways', 'CertifyController@checkPathways')->name('tution.assistance.pathways')->middleware(['auth']);
Route::post('/tution/assistance/readiness', 'CertifyController@checkReadiness')->name('tution.assistance.readiness')->middleware(['auth']);
Route::post('/tution/assistance/linkedin', 'CertifyController@checkLinkedin')->name('tution.assistance.linkedin')->middleware(['auth']);
Route::post('/tution/assistance/certify/approve', 'CertifyController@certifyApprove')->name('tution.assistance.certify_approve')->middleware(['auth']);
Route::post('/tution/assistance/history', 'CertifyController@certifyhistory')->name('tution.assistance.history')->middleware(['auth']);
Route::post('/tution/assistance/mymentors', 'CertifyController@mymentors')->name('tution.assistance.mymentors')->middleware(['auth']);
Route::post('/tution/assistance/checkScore', 'CertifyController@checkScore')->name('tution.assistance.checkScore')->middleware(['auth']);
Route::post('/tution/assistance/impact', 'CertifyController@impact')->name('tution.assistance.impact')->middleware(['auth']);
Route::post('/tution/assistance/blsState', 'CertifyController@blsState')->name('tution.assistance.blsState')->middleware(['auth']);
Route::post('/tution/assistance/getIndustry', 'CertifyController@getIndustry')->name('tution.assistance.getIndustry')->middleware(['auth']);

Route::middleware(['auth', 'checksubdomain' , "plancheck:certifies"])->group(function () {
	 Route::get('corporate/certify', ['as' => 'corporate.certify.index', 'uses' => 'CertifyController@Corporateindex']);
    Route::get('certify', ['as' => 'certify.index', 'uses' => 'CertifyController@index']);
    Route::get('certify/inactive', ['as' => 'certify.inactive', 'uses' => 'CertifyController@certifyUnpublished']);
    Route::get('certify/mystudents', ['as' => 'certify.mystudents', 'uses' => 'CertifyController@mystudents']);
    Route::get('certify/test/catalog', ['as' => 'certify.testcatalog', 'uses' => 'CertifyController@testcatalog']);
    Route::get('certify/active', ['as' => 'certify.active', 'uses' => 'CertifyController@certifypublished']);
    Route::get('certify/marketplace', ['as' => 'certify.marketplace', 'uses' => 'CertifyController@marketplace']);
    Route::get('certificate/addcertificate', ['as' => 'certificate.addcertificate', 'uses' => 'CertifyController@addcertificate']);
    Route::post('certificate/createcertificate', 'CertifyController@createcertificate')->name('certify.createcertificate');
    Route::post('certificate/test/email/catalog', 'CertifyController@sendCatalogTestEmail')->name('certify.testemailcatalog');
    Route::post('certify/marketplace/adddata', ['as' => 'certify.marketplace.adddata', 'uses' => 'CertifyController@activeMarketplace']);
    Route::get('certify/certificate/{id}', ['as' => 'certify.certificate', 'uses' => 'CertifyController@certificate']);
    Route::get('certify/learnview/updateCompletedDate', ['as' => 'updateCompletedDate', 'uses' => 'CertifyController@updateCompletedDate']);
    Route::get('certify/download', ['as' => 'certify.download', 'uses' => 'CertifyController@download']);
    Route::get('certify/create', ['as' => 'certify.create', 'uses' => 'CertifyController@create']);
    Route::get('certify/masterclass/create', ['as' => 'certify.masterclass.create', 'uses' => 'CertifyController@masterCreate']);
    Route::get('certify/featchData', ['as' => 'certify.featchData', 'uses' => 'CertifyController@featchData']);
    Route::get('certify/edit/{id}', ['as' => 'certify.edit', 'uses' => 'CertifyController@edit']);
    Route::get('certify/show/{id}', ['as' => 'certify.show', 'uses' => 'CertifyController@show']);
    Route::get('certify/student/list/', ['as' => 'certify.student_enroll', 'uses' => 'CertifyController@student_enroll']);
    Route::get('certify/show/exam/{id}', ['as' => 'certify.ExamShow', 'uses' => 'CertifyController@ExamShow']);
    Route::get('certify/corporate/mycourses', ['as' => 'certify.corpurate.mycourses', 'uses' => 'CertifyController@mycourses']);
    Route::post('certify/corpurate/add/certify', ['as' => 'certify.corpurate.add.certify', 'uses' => 'CertifyController@certifyCorpurateAddCertify']);
    Route::post('certify/corporate/remove/certify', ['as' => 'certify.corpurate.remove.certify', 'uses' => 'CertifyController@certifyCorpurateRemoveCertify']);
    Route::get('certify/learnview/featchDatalearnview', ['as' => 'certify.learnview.featchDatalearnview', 'uses' => 'CertifyController@featchDatalearnview']);
    Route::get('certify/learnview/lernLecturedata', ['as' => 'certify.learnview.lernLecturedata', 'uses' => 'CertifyController@lernLecturedata']);
    Route::get('certify/learnview/{id}', ['as' => 'certify.learnview', 'uses' => 'CertifyController@learnview']);

    Route::get('certify/featchDataSyndicate', ['as' => 'certify.featchDataSyndicate', 'uses' => 'CertifyController@featchDataSyndicate']);
    Route::get('certify/curriculum/{id}', ['as' => 'certify.curriculum', 'uses' => 'CertifyController@certifyCurriculum']);
    Route::get('certify/curriculumCreate/{id}', ['as' => 'certify.curriculumCreate', 'uses' => 'CertifyController@certifyCurriculumCreate']);
    Route::get('certify/examCreate/{id}', ['as' => 'certify.examCreate', 'uses' => 'CertifyController@examCreate']);
    Route::get('certify/exam/build/{id}', ['as' => 'certify.exam.build', 'uses' => 'CertifyController@examBuilder']);
    Route::get('certify/exam/question/create/{id}', ['as' => 'certify.exam.question.create', 'uses' => 'CertifyController@examQuestionCreate']);
    Route::get('certify/payments', ['as' => 'certify.payments', 'uses' => 'CertifyController@payments']);
    Route::get('certify/learnview/student/learn/status', ['as' => 'certify.learnview.student.learn.status', 'uses' => 'CertifyController@studentLearnStatus']);
    Route::post('certify/exam/question/store', 'CertifyController@examQuestionStore')->name('certify.exam.question.store');
    Route::post('certify/exam/question/update', 'CertifyController@examQuestionUpdate')->name('certify.exam.question.update');
    Route::post('certify/exam/question/distroy', 'CertifyController@examQuestionDistroy')->name('certify.exam.question.distroy');
    Route::post('certify/exam/store', 'CertifyController@examStore')->name('certify.exam.store');
    Route::post('certify/exam/update', 'CertifyController@examUpdate')->name('certify.exam.update');
    Route::post('certify/exam/destroy', 'CertifyController@ExamDestroy')->name('certify.exam.destroy');
    Route::post('certify/curriculum/distroy', 'CertifyController@curriculumDestroy')->name('certify.curriculum.destroy');
    Route::post('certify/curriculumStore', 'CertifyController@curriculumStore')->name('certify.curriculumStore');
    Route::post('certify/curriculumSave', 'CertifyController@curriculumSave')->name('certify.curriculumSave');
    Route::post('certify/lectureSave', 'CertifyController@lectureSave')->name('certify.lectureSave');
    Route::get('certify/destroy/{id}', 'CertifyController@destroy')->name('certify.destroy');
    Route::post('certify/store', 'CertifyController@store')->name('certify.store');
    Route::post('certify/lectureFileSave', 'CertifyController@lectureFileSave')->name('certify.lectureFileSave');
    Route::post('certify/update', 'CertifyController@update')->name('certify.update');
    Route::get('certify/categories', ['as' => 'certify.categories', 'uses' => 'CertifyController@CertifyCategoriesIndex']);
    Route::get('certify/categories/create', ['as' => 'certify.categories.create', 'uses' => 'CertifyController@CertifyCategoriesCreate']);
    Route::get('certify/categories/featchdata', ['as' => 'certify.categories.featchdata', 'uses' => 'CertifyController@CertifyCategoriesFeatchdata']);
    Route::get('certify/category/edit/{id}', ['as' => 'certify.category.edit', 'uses' => 'CertifyController@CertifyCategoriesEdit']);
    Route::get('certify/category/destroy/{id}', 'CertifyController@CertifyCategoriesDestroy')->name('certify.category.destroy');
    Route::post('certify/categories/store', 'CertifyController@CertifyCategoriesStore')->name('certify.categories.store');
    Route::post('certify/category/update', 'CertifyController@CertifyCategoriesUpdate')->name('certify.categories.update');
    Route::get('certify/exam/perview/save', ['as' => 'certify.exam.perview.save', 'uses' => 'CertifyController@CertifyExamPerviewSave']);
    Route::get('certify/exam/students/{id}', ['as' => 'certify.exam.students', 'uses' => 'CertifyController@CertifyExamStudents']);
    Route::get('certify/exam/examperview/{id}', ['as' => 'certify.exam.examperview', 'uses' => 'CertifyController@CertifyExamPerview']);
    Route::post('certify/exam/perview/save', 'CertifyController@CertifyExamPerviewSave')->name('certify.exam.perview.save');
    Route::post('certify/exam/status', 'CertifyController@CertifyExamStatus')->name('certify.exam.status');

    Route::get('scorm/file/data', ['as' => 'scorm.file.data', 'uses' => 'CertifyController@scromFileData']);
// Instructor routes
    Route::get('instructor', ['as' => 'instructor.index', 'uses' => 'CertifyController@instructor']);
    Route::get('certify/fetch/instructor', ['as' => 'certify.fetch.instructor', 'uses' => 'CertifyController@FeatchDataInstructor']);
    Route::get('instructor/create', ['as' => 'instructor.create', 'uses' => 'CertifyController@InstructorCreate']);
    Route::any('instructor/store', ['as' => 'instructor.store', 'uses' => 'CertifyController@InstructorStore']);
    Route::get('instructor/edit/{id}', ['as' => 'instructor.edit', 'uses' => 'CertifyController@InstructorEdit']);
    Route::post('instructor/update', ['as' => 'instructor.update', 'uses' => 'CertifyController@InstructorUpdate']);
    Route::get('instructor/destroy/{id}', ['as' => 'instructor.destroy', 'uses' => 'CertifyController@InstructorDestroy']);
	Route::post('wallet/debit/delete', ['as' => 'wallet.debit.delete', 'uses' => 'CertifyController@walletdebitDelete'])->middleware(['auth']);
	 Route::resource('certify', 'CertifyController')->middleware(['auth']);
});
//end certify routes
  Route::get('tution/assistance/request', ['as' => 'wallet.clienttutionrequest', 'uses' => 'CertifyController@clienttutionrequest'])->middleware(['auth']);
	Route::get('tution/coupon/history', ['as' => 'tution.coupon.history', 'uses' => 'CertifyController@tutionCouponHistory'])->middleware(['auth']);
	Route::post('tution/coupon/history/delete', ['as' => 'tution.coupon.history.delete', 'uses' => 'CertifyController@tutionCouponHistoryDelete'])->middleware(['auth']);
	Route::post('tution/request/send/request', ['as' => 'wallet.tutionrequest.send.request', 'uses' => 'CertifyController@SendRequestController'])->middleware(['auth']);
	Route::get('tution/request/status/change/{id}/{status}', ['as' => 'wallet.tutionrequest.status.change', 'uses' => 'CertifyController@tutionrequestStatusChange'])->middleware(['auth']);
	Route::post('tution/request/delete', ['as' => 'wallet.tutionrequest.delete', 'uses' => 'CertifyController@tutionrequestDelete'])->middleware(['auth']);
	Route::post('check/coupon', ['as' => 'check.coupon', 'uses' => 'CertifyController@checkCoupon'])->middleware(['auth']);
	Route::post('apply/coupon', ['as' => 'apply.coupon', 'uses' => 'CertifyController@applyCoupon'])->middleware(['auth']);
	Route::post('tution/request/status/approve', ['as' => 'wallet.tutionrequest.status.approve', 'uses' => 'CertifyController@tutionrequestStatusChangeApprove'])->middleware(['auth']);
	Route::post('check/wallet/price', 'CertifyController@checkWalletPrice')->name('check.wallet.price');
	Route::get('corporate/dashboard', 'CertifyController@dashboard')->name('corporate.dashboard')->middleware('auth', 'checksubdomain');
Route::get('site/settings', 'SettingController@site_settings')->name('site.settings')->middleware('auth', 'checksubdomain');
;
/*
  |--------------------------------------------------------------------------
  | End User Dashboard
  |--------------------------------------------------------------------------
 */

/*
  |--------------------------------------------------------------------------
  | Profile
  |--------------------------------------------------------------------------
 */

Route::get('/profile/settings', 'UserController@profile_edit')->name('profile-settings')->middleware('auth', 'checksubdomain');
Route::get('/profile/get/orders', ['as' => 'get.plan.orders', 'uses' => 'UserController@get_orders']);
Route::post('/profile-settings/update', ['as' => 'update.profile', 'uses' => 'UserController@updateProfile'])->middleware('auth', 'checksubdomain');
Route::any('/profile-settings/delete/picture', ['as' => 'delete.profile.pic', 'uses' => 'UserController@deleteprofilepic'])->middleware('auth', 'checksubdomain');
Route::post('/check-subdomain', ['as' => 'update.check_subdomain', 'uses' => 'UserController@check_subdomain'])->middleware('auth', 'checksubdomain');
Route::get('/lookup-domain', ['as' => 'lookup_domain', 'uses' => 'UserController@lookup_domain'])->middleware(['auth', 'checksubdomain']);
Route::post('/check-domain', ['as' => 'update.check_domain', 'uses' => 'UserController@check_domain'])->middleware('auth', 'checksubdomain');
Route::get('/delete-domain', ['as' => 'update.delete_domain', 'uses' => 'UserController@delete_domain'])->middleware('auth', 'checksubdomain');
Route::post('/profile-settings/backgroundimageupdate', ['as' => 'update.backgroundimageprofile', 'uses' => 'UserController@backgroundimageprofile'])->middleware('auth', 'checksubdomain');

Route::post('/profile-settings/update/qualification', ['as' => 'update.profile.qualification', 'uses' => 'UserController@updateProfileQualification'])->middleware('auth', 'checksubdomain');
Route::get('/profile', ['as' => 'profile', 'uses' => 'UserController@profile']);
Route::post('/profile/tab', ['as' => 'users.profile.tab', 'uses' => 'UserController@profile_tab'])->middleware('auth', 'checksubdomain');
Route::any('/invoices', ['as' => 'user.invoices', 'uses' => 'UserController@invoices'])->middleware('auth', 'checksubdomain');
Route::any('invoice/{id}', ['as' => 'payment.invoice', 'uses' => 'UserController@invoicedetails'])->middleware('auth', 'checksubdomain');
Route::get('profile/subdomain/check', ['as' => 'profile.subdomain.check', 'uses' => 'SettingController@subdomainCheck'])->middleware(['auth', 'checksubdomain']);

/*
  |--------------------------------------------------------------------------
  | End Profile
  |--------------------------------------------------------------------------
 *
 */

/*
  |--------------------------------------------------------------------------
  | Site Settings
  |--------------------------------------------------------------------------
 */


Route::any('/site/settings/store', ['as' => 'site.settings.store', 'uses' => 'SettingController@site_settings_store'])->middleware('auth', 'checksubdomain');
Route::get('site/mailer/settings/create',['as' => 'mailer.settings.create', 'uses' =>  'SettingController@mailer_create']);
Route::get('site/mailer/settings/destroy/{id}', ['as' => 'mailer.settings.destroy', 'uses' => 'SettingController@mailer_destroy']);
// Send Test Email
Route::post('/test', ['as' => 'test.email', 'uses' => 'SettingController@testEmail'])->middleware(['auth']);
Route::post('/test/send', ['as' => 'test.email.send', 'uses' => 'SettingController@testEmailSend'])->middleware(['auth']);
// Email Templates
/*
  |--------------------------------------------------------------------------
  | End Site Settings
  |--------------------------------------------------------------------------
 */


Route::middleware(['auth', 'checksubdomain'])->group(function () {
    /*     * *************Support Categories Start**************** */
    Route::get('support/categories', 'SupportCategoryController@index')->name('supportCategory.index');
    Route::get('support/categories/show', 'SupportCategoryController@show')->name('supportCategory.show');
    Route::get('support/category/create', 'SupportCategoryController@create')->name('supportCategory.create');
    Route::post('support/category/store', 'SupportCategoryController@store')->name('supportCategory.store');
    Route::get('support/category/edit/{id}', 'SupportCategoryController@edit')->name('supportCategory.edit');
    Route::post('support/category/update', 'SupportCategoryController@update')->name('supportCategory.update');
    Route::any('support/category/destroy/{id}', 'SupportCategoryController@destroy')->name('supportCategory.destroy');
    /*     * *************Support Categories End**************** */
    /*     * *************Support Start**************** */
    Route::get('support', ['as' => 'support.index', 'uses' => 'SupportController@index']);
    Route::get('support/ticket/create', ['as' => 'support.create', 'uses' => 'SupportController@create']);
    Route::get('support/view', ['as' => 'support.view', 'uses' => 'SupportController@view']);
    Route::get('support/ticket/preview/{id}', ['as' => 'support.preview', 'uses' => 'SupportController@preview']);
    Route::post('support/store', 'SupportController@store')->name('support.store');
    Route::post('support/reply/store', 'SupportController@replystore')->name('support.replystore');
    Route::any('support/ticket/close/{id}', 'SupportController@close')->name('support.close');
    Route::get('support/ticket/reopen/{id}', 'SupportController@reopen')->name('support.reopen');
    Route::get('support/settings', ['as' => 'support.settings', 'uses' => 'SupportController@settings']);
    Route::post('support/update/settings', ['as' => 'support.updatesettings', 'uses' => 'SupportController@updatesettings']);
    Route::post('support/matching/faqs', ['as' => 'support.matching.faqs', 'uses' => 'SupportController@matchingfaqs']);
    /*     * *************Support End**************** */
});
//this is for cronejob so no need to add in plan check or auth funtions
Route::get('support/ticket/autoclose', 'SupportController@autoclose')->name('support.autoclose');



Route::middleware(['auth', 'checksubdomain'])->group(function () {
    /*     * *************Chore Categories Start**************** */
    Route::get('chore/categories', 'ChoreCategoryController@index')->name('choreCategory.index');
    Route::get('chore/categories/show', 'ChoreCategoryController@show')->name('choreCategory.show');
    Route::get('chore/category/create', 'ChoreCategoryController@create')->name('choreCategory.create');
    Route::post('chore/category/store', 'ChoreCategoryController@store')->name('choreCategory.store');
    Route::get('chore/category/edit/{id}', 'ChoreCategoryController@edit')->name('choreCategory.edit');
    Route::post('chore/category/update', 'ChoreCategoryController@update')->name('choreCategory.update');
    Route::any('chore/category/destroy/{id}', 'ChoreCategoryController@destroy')->name('choreCategory.destroy');
    /*     * *************Chore Categories End**************** */
    /*     * *************Chore Start**************** */
   Route::get('chore/dashboard', ['as' => 'chore.dashboard', 'uses' => 'ChoreController@dashboard'])->middleware(['auth']);
    Route::get('chore/mydashboard', ['as' => 'chore.mydashboard', 'uses' => 'ChoreController@mydashboard'])->middleware(['auth']);
    Route::get('chore/members', ['as' => 'chore.members', 'uses' => 'ChoreController@members'])->middleware(['auth']);
    Route::get('chore/members/manage', ['as' => 'chore.members.manage', 'uses' => 'ChoreController@manage_members']);
    Route::post('chore/members/store', ['as' => 'chore.members.store', 'uses' => 'ChoreController@manage_members_store']);
    Route::get('chore/create', ['as' => 'chore.create', 'uses' => 'ChoreController@create'])->middleware(['auth']);
    Route::post('chore/store', 'ChoreController@store')->name('chore.store')->middleware(['auth']);
    Route::get('chore/{id}', ['as' => 'chore.details', 'uses' => 'ChoreController@details'])->middleware(['auth']);
Route::get('chore/edit/{id}', ['as' => 'chore.edit', 'uses' => 'ChoreController@edit'])->middleware(['auth']);
Route::any('chore/destroy/{id}', ['as' => 'chore.destroy', 'uses' => 'ChoreController@destroy'])->middleware(['auth']);
Route::get('chore/calendar/{task}', ['as' => 'chore.calendar', 'uses' => 'ChoreController@calendarView'])->middleware(['auth']);
Route::get('chore/status/{action}/{id}', ['as' => 'chore.action', 'uses' => 'ChoreController@choreaction'])->middleware(['auth']);


    Route::get('chore/comments/{id}', ['as' => 'chore.comments', 'uses' => 'ChoreController@chore_comments'])->middleware(['auth']);
    Route::post('chore/comment/update', 'ChoreController@commentupdate')->name('chore.comment.update');
    Route::post('chore/comment/post', 'ChoreController@addcomment')->name('chore.comment.post');
    Route::post('chores/comment/update', 'ChoreController@updatecomment')->name('chores.comment.update');
    Route::any('chore/comment/destroy/{id}', 'ChoreController@destroycommment')->name('chore.comment.destroy');

    Route::post('chore/todo','ChoreController@toDoUpdate')->name('chore.todo.type');
});
//career route
Route::get('job/career','CareerController@career')->name('job.career');
Route::get('job/preview/{id}','JobpointDashboardController@jobpreview')->name('job.preview');
Route::get('jobpost/apply/{id}', 'JobpointDashboardController@jobapply')->name('jobpost.apply');
Route::post('jobpost/appform/save', 'JobpointDashboardController@saveApplicationForm')->name('jobpost.appform.save');
Route::get('jobpost/appform/preview', 'JobpointDashboardController@previewApplicationForm')->name('jobpost.appform.preview');
/* * ***************ADMIN ROUTES****************** */
Route::Group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
	//Menus
	 Route::post('add-site-settings', 'SettingController@add_site_menu')->name('admin.menu.add');
    Route::get('get-menu-id/{id}', 'SettingController@get_menu_by_id')->name('admin.Getmenu');
    Route::post('/store-menu', 'SettingController@storeMenu')->name('admin.storeMenu');
    Route::any('/menu/destroy', 'SettingController@menu_destroy')->name('admin.deleteMenu');

    // Request Audit Price
    Route::any('/audit/price', 'AuditController@index')->name('audit');
    Route::get('/audit/price/edit/{id}', 'AuditController@edit')->name('audit.edit');
    Route::get('/audit/price/show/{id}', 'AuditController@show')->name('audit.show');
    Route::post('/audit/price/store', 'AuditControllerr@store')->name('audit.store');
    Route::get('/audit/price/destroy/{id}', 'AuditController@destroy')->name('audit.destroy');

   // Admin education control
   Route::any('/education', 'EducationController@index')->name('educations');
   Route::get('/education/create', function () {
      return view('education.create');
  })->name('educations.create');
   Route::get('/education/edit/{id}', 'EducationController@edit')->name('educations.edit');
   Route::get('/education/show/{id}', 'EducationController@show')->name('educations.show');
   Route::post('/education/store', 'EducationController@store')->name('educations.store');
   Route::get('/education/destroy/{id}', 'EducationController@destroy')->name('educations.destroy');

     // Admin quotes control
     Route::any('/quotes', 'QuoteController@index')->name('quotes');
     Route::get('/quotes/create', function () {
        return view('quotes.create');
    })->name('quotes.create');
     Route::get('/quotes/edit/{id}', 'QuoteController@edit')->name('quotes.edit');
     Route::get('/quotes/show/{id}', 'QuoteController@show')->name('quotes.show');
     Route::post('/quotes/store', 'QuoteController@store')->name('quotes.store');
     Route::get('/quotes/destroy/{id}', 'QuoteController@destroy')->name('quotes.destroy');
     Route::post('quotes/import_csv', 'QuoteController@import_quote')->name('quotes.import');
      // Admin institution control
      Route::any('/institutions', 'InstitutionController@adminindex')->name('institutions');
      Route::any('/school', 'InstitutionController@adminschoolindex')->name('institutions');
      Route::any('/college', 'InstitutionController@admincollegeindex')->name('institutions');
      Route::any('/pathway/entities', 'InstitutionController@entityindex')->name('pathway.entities');
      Route::get('/institutions/create', function () {
         return view('institution.create');
     })->name('institutions.create');
     Route::get('/institutions/insert', function () {
        return view('institution.add_institution');
    })->name('institutions.create');

      Route::get('/pathway/entity/insert', 'InstitutionController@create')->name('pathway.entity.create');
      Route::get('/institutions/edit/{id}', 'InstitutionController@adminedit')->name('institutions.edit');
      Route::get('/institutions/show/{id}', 'InstitutionController@adminshow')->name('institutions.show');
      Route::post('/institutions/store', 'InstitutionController@adminstore')->name('institutions.store');
      Route::get('/institutions/destroy/{id}', 'InstitutionController@admindestroy')->name('institutions.destroy');
      Route::post('institutions/import_csv', 'InstitutionController@import_institute')->name('institutions.import');


      // Admin company control
      Route::any('/employer', 'EmployerController@adminindex')->name('employer');
       Route::get('/employer/create', function () {
         return view('employer.add_employer');
     })->name('employer.create');

      Route::get('/employer/edit/{id}', 'EmployerController@adminedit')->name('employer.edit');
      Route::get('/employer/show/{id}', 'EmployerController@adminshow')->name('employer.show');
      Route::post('/employer/store', 'EmployerController@adminstore')->name('employer.store');
      Route::get('/employer/destroy/{id}', 'EmployerController@admindestroy')->name('employer.destroy');
      Route::post('employer/import_csv', 'EmployerController@import_employer')->name('employer.import');
      Route::post('/employer/post', 'EmployerController@store')->name('employer.post');

      // Admin Gamify control start
      Route::any('/badges', 'RewardPointController@index')->name('badges');
      Route::match(['get','post'], 'create/badges', 'RewardPointController@create')->name('create.badges');
      Route::get('badges/edit/{id?}', 'RewardPointController@edit')->name('badges.edit');


      Route::any('/gamify_group', 'RewardPointController@gamifyindex')->name('gamify_group');
      Route::match(['get','post'],'create/gamify-groups','RewardPointController@createGamifyGroup')->name('create.gamify_groups');
      Route::any('edit/gamify-groups/{id?}', 'RewardPointController@editGamifyGroup')->name('edit.gamify_groups');


      Route::any('/points', 'RewardPointController@pointindex')->name('points');
      Route::match(['get','post'], 'create/points', 'RewardPointController@createPoints')->name('create.points');
      Route::any('/edit/points/{id?}', 'RewardPointController@editPoints')->name('edit.points');

      // Admin Gamify control end

      // Admin program control
     Route::any('/program', 'template\ProgramController@adminProgramlisting')->name('adminProgramlisting');
     Route::get('/program/edit/{id}', 'template\ProgramController@adminProgramlistingEdit')->name('adminProgramlisting.edit');
     Route::get('/program/show/{id}', 'template\ProgramController@adminProgramlistingShow')->name('adminProgramlisting.show');
     Route::post('/program/store', 'template\ProgramController@adminProgramlisting_change_status')->name('adminProgramlisting.store');
     Route::get('/program/destroy/{id}', 'template\ProgramController@adminProgramlisting_destroy')->name('adminProgramlisting.destroy');
    // Approval Status
    Route::any('/approval_listing', 'template\ProgramableController@approval_listing')->name('approval_listing');
    Route::get('/approval_listing/edit/{id}', 'template\ProgramableController@approval_listing_edit')->name('approval_listing.edit');
    Route::get('/approval_listing/show/{id}', 'template\ProgramableController@approval_listing_show')->name('approval_listing.show');
    Route::post('/approval_listing/store', 'template\ProgramableController@approval_change_status')->name('approval_listing.store');
    Route::get('/approval_listing/destroy/{id}', 'template\ProgramableController@approval_destroy')->name('approval_listing.destroy');

   // Approval Question
    Route::any('/question', 'template\TemplateController@questions')->name('questions');
    Route::get('/question/edit/{id}', 'template\TemplateController@question_edit')->name('question.edit');
    Route::get('/question/destroy/{id}', 'template\TemplateController@question_destroy')->name('question.destroy');
    Route::get('/question/create', function () {
        return view('admin.template.role_form');
    })->name('question.create');
    Route::post('/question/post', 'template\TemplateController@role_update')->name('question.post');

     // customfield
     Route::any('/customfield', 'CustomfieldController@questions')->name('customfields');
     Route::get('/customfield/edit/{id}', 'CustomfieldController@question_edit')->name('customfield.edit');
     Route::get('/customfield/destroy/{id}', 'CustomfieldController@question_destroy')->name('customfield.destroy');
     Route::get('/customfield/create', function () {
         return view('customfield.role_form');
     })->name('customfield.create');
     Route::post('/customfield/post', 'CustomfieldController@role_update')->name('customfield.post');

    // Institution
    Route::any('/institution', 'InstitutionController@index')->name('institution');
    Route::get('/institution/edit/{id}', 'InstitutionController@question_edit')->name('institution.edit');
    Route::get('/institution/destroy/{id}', 'InstitutionController@question_destroy')->name('institution.destroy');
    Route::get('/school/create', function () {
        return view('institution.add_school_form');
    })->name('school.create');
    Route::get('/college/create', function () {
        return view('institution.add_college_form');
    })->name('college.create');
    Route::post('/institution/post', 'InstitutionController@store')->name('institution.post');

    // request audit price
    Route::post('/request/audit/price', 'template\TemplateController@request_audit_price')->name('auditprice.create');
    Route::get('/request/audit/price/show/{id}', 'template\TemplateController@audit_price_show')->name('auditprice.show');



    // Programable Question  auditprice
    Route::any('/programable_question', 'template\TemplateController@programable_questions')->name('programable_questions');
    Route::get('/programable_question/edit/{id}', 'template\TemplateController@programable_question_edit')->name('programable_question.edit');
    Route::get('/programable_question/destroy/{id}', 'template\TemplateController@programable_question_destroy')->name('programable_question.destroy');
    Route::get('/programable_question/create', function () {
        return view('admin.template.programable.role_form');
    })->name('programable_question.create');
    Route::post('/programable_question/post', 'template\TemplateController@programable_update')->name('programable_question.post');

    // Program category

    Route::any('/program/category', 'template\TemplateController@program_category')->name('program_category');
    Route::get('/program/category/edit/{id}', 'template\TemplateController@program_category_edit')->name('program_category.edit');
    Route::get('/program/category/destroy/{id}', 'template\TemplateController@program_category_destroy')->name('program_category.destroy');
    Route::get('/program/category/create', function () {
        return view('admin.template.program.category.role_form');
    })->name('program_category.create');
    Route::post('/program/category/post', 'template\TemplateController@program_category_update')->name('program_category.post');

    //task category
    Route::get('task/categories', ['as' => 'task.categories', 'uses' => 'TaskController@TaskCategoriesIndex']);
    Route::get('task/categories/create', ['as' => 'task.categories.create', 'uses' => 'TaskController@TaskCategoriesCreate']);
    Route::get('task/categories/featchdata', ['as' => 'task.categories.featchdata', 'uses' => 'TaskController@TaskCategoriesFeatchdata']);
    Route::get('task/category/edit/{id}', ['as' => 'task.category.edit', 'uses' => 'TaskController@TaskCategoriesEdit']);
    Route::get('task/category/destroy/{id}', 'TaskController@TaskCategoriesDestroy')->name('task.category.destroy');
    Route::post('task/categories/store', 'TaskController@TaskCategoriesStore')->name('task.categories.store');
    Route::post('task/category/update', 'TaskController@TaskCategoriesUpdate')->name('task.categories.update');

    Route::get('/profile', 'UserController@admin_profile')->name('admin.profile');
    Route::any('/roles', 'UserController@roles')->name('roles');

    Route::get('/role/create', function () {
        return view('admin.role_form');
    })->name('role.create');

    Route::get('/role/edit/{id}', 'UserController@role_edit')->name('role.edit');
    Route::get('/role/destroy/{id}', 'UserController@role_destroy')->name('role.destroy');
    Route::post('/role/post', 'UserController@role_update')->name('role.post');
    Route::any('/users', 'UserController@admin_users')->name('admin.users');
    Route::any('/user/delete', 'UserController@delete_users')->name('users.delete.users');
    Route::any('/contacts/delete', 'UserController@delete_contacts')->name('users.delete.contacts');

    Route::any('/user/change/member', 'UserController@change_member')->name('users.change.member');

    Route::any('/user/notifications', 'ContactController@notifications_settings')->name('users.notifications');
    Route::any('/user/notification/change/status', 'ContactController@change_notification_status')->name('notification.change.status');
    Route::any('/user/change/theme', 'UserController@change_theme')->name('users.change.theme');
    Route::any('/user/change/status', 'UserController@change_status')->name('users.change.status');
    Route::get('site/settings', 'SettingController@site_settings')->name('admin.site.settings');
    Route::post('add-site-settings', 'SettingController@add_site_menu')->name('admin.menu.add');
    Route::get('get-menu-id/{id}', 'SettingController@get_menu_by_id')->name('admin.Getmenu');
    Route::post('/store-menu', 'SettingController@storeMenu')->name('admin.storeMenu');
    Route::any('/menu/destroy', 'SettingController@menu_destroy')->name('admin.deleteMenu');


    //job Point
    Route::get('appsetting' , 'JobPointController@appSetting')->name('app.setting');
    Route::post('appsetting/save' , 'JobPointController@appSettingSave')->name('app.setting.save');
    Route::get('changeJobNotificationStatus' , 'JobPointController@changeNotificationStatus')->name('change.jobnotification.status');
    //jobForm
    Route::get('basicinfo/{id}' , 'JobPointController@basicinfo')->name('basicinfo');
    Route::get('jobformsetting' , 'JobPointController@jobFormSetting')->name('job.jobformsetting');
    Route::get('form/field/edit' , 'JobPointController@formFieldEdit')->name('field.edit.form');
    Route::get('form/field/save' , 'JobPointController@formFieldSave')->name('save.custom.field');
    Route::get('form/field/delete/{id}' , 'JobPointController@formFieldDelete')->name('delete.form.field');
    Route::get('form/field/update' , 'JobPointController@formFieldUpdate')->name('update.form.field');
    Route::get('form/status/update' , 'JobPointController@formStatusUpdate')->name('update.form.status');
    Route::get('form/section/add' , 'JobPointController@addCustomFormSection')->name('add.form.section');
    Route::get('form/section/delete/{id}' , 'JobPointController@deleteCustomFormSection')->name('delete.form.section');
    //hiring stage
    Route::get('jobsetting' , 'JobPointController@jobSetting')->name('job.setting');
    Route::get('jobsetting/jobpost/{id}' , 'JobPointController@jobSetting')->name('jobpost.jobsetting');

    Route::get('addhiringstage','JobPointController@addHiringStage')->name('addhiringstage');
    Route::post('hiring/store', ['as' => 'admin.hiring.store', 'uses' => 'JobPointController@store']);
    Route::get('hiring/destroy/{id}',['as' => 'admin.hiring.destroy', 'uses' => 'JobPointController@destroy']);
    //Add Event
    route::get('event/list','AddEventController@eventlist')->name('event.list');
    route::get('addeventcreate','AddEventController@addeventcreate')->name('addevent.create');
    Route::post('addEvent/store', ['as' => 'admin.event.store', 'uses' => 'AddEventController@store']);
    Route::get('addEvent/destroy/{id}',['as' => 'admin.event.destroy', 'uses' => 'AddEventController@destroy']);
    //Add JobType
    route::get('jobtype/list','JobTypeController@jobtypelist')->name('jobtype.list');
    route::get('jobtype/create','JobTypeController@jobtypecreate')->name('jobtype.create');
    Route::post('jobType/store',['as' => 'admin.jobType.store' , 'uses' => 'JobTypeController@jobTypeStore']);
    Route::get('jobType/destroy/{id}',['as' => 'admin.jobType.destroy', 'uses' => 'JobTypeController@destroy']);
    //Add Department
    route::get('department/list','DepartmentController@departmentlist')->name('department.list');
    route::get('department/create','DepartmentController@departmentcreate')->name('department.create');
    Route::post('department/store',['as' => 'admin.department.store' , 'uses' => 'DepartmentController@Store']);
    Route::get('department/destroy/{id}',['as' => 'admin.department.destroy', 'uses' => 'DepartmentController@destroy']);
    //Add Location
    route::get('location/list','LocationController@locationlist')->name('location.list');
    route::get('location/create','LocationController@locationcreate')->name('location.create');
    Route::post('location/store',['as' => 'admin.location.store' , 'uses' => 'LocationController@Store']);
    Route::get('location/destroy/{id}',['as' => 'admin.location.destroy', 'uses' => 'LocationController@destroy']);

    //Candidates routes here
    Route::get('/candidates', 'CandidateController@index')->name('admin.candidates');
    Route::get('/candidate/create', 'CandidateController@form')->name('candidate.form');
    Route::post('/candidates/create', 'CandidateController@create')->name('admin.candidates.create');
    Route::get('/candidate/edit/{id}', 'CandidateController@candidateEdit')->name('candidate.edit');
    Route::get('/candidate/destroy/{id}', 'CandidateController@candidateDestroy')->name('candidate.destroy');
    Route::get('/assignjob/create/{id}', 'CandidateController@jobForm')->name('assign.job.form');
    Route::post('/assignjob/create', 'CandidateController@createJob')->name('assign.job');
    Route::get('/unassignjob/job/{id}/candidate_id/{candidate_id}', 'CandidateController@unassignJob')->name('unassign.job');
    Route::get('/candidate/details', 'CandidateController@showDetail')->name('candidate.details');
    Route::get('/candidate/get/notes', 'CandidateController@getNotes')->name('candidate.get.notes');
    Route::get('/candidate/update/notes', 'CandidateController@updateNotes')->name('candidate.update.notes');
    Route::get('/candidate/delete/notes', 'CandidateController@deleteNotes')->name('candidate.delete.notes');
    Route::get('/candidate/save/notes', 'CandidateController@saveNotes')->name('candidate.notes');
    Route::get('/candidate/event', 'CandidateController@eventForm')->name('event.form');
    Route::post('/candidate/event/create', 'CandidateController@createEvent')->name('candidate.event.save');
    Route::get('/candidate/event/get', 'CandidateController@getEvent')->name('candidate.get.events');
    Route::get('/candidate/event/edit', 'CandidateController@editEvent')->name('candidate.edit.events');
    Route::get('/candidate/event/delete', 'CandidateController@deleteEvent')->name('candidate.delete.events');
    Route::get('/candidate/event/view', 'CandidateController@viewEvent')->name('candidate.view.events');
    Route::get('/candidate/stage/update', 'CandidateController@stageUpdate')->name('candidate.stage.update');
    Route::get('/candidate/get/timeline', 'CandidateController@getTimeline')->name('candidate.get.timeline');
    Route::get('/candidate/save/review', 'CandidateController@saveReview')->name('candidate.save.review');
    Route::get('/candidate/get/questions', 'CandidateController@getQuestions')->name('candidate.questions');
    Route::get('/candidate/get/attachment', 'CandidateController@getAttachment')->name('candidate.attachment');
    Route::get('/candidate/filter', 'CandidateController@filter')->name('candidate.filter');
    Route::get('/candidate/disqualify', 'CandidateController@disqualifyForm')->name('disqualify.form');
    Route::get('/candidate/mail', 'CandidateController@mailForm')->name('mail.form');
    Route::get('/candidate/mail/send', 'CandidateController@sendMail')->name('send.mail');

    //jobpoint dashboard
    Route::get('jobpoint/dashboard', 'JobpointDashboardController@dashboard')->name('jobpoint.dashboard');
    route::get('jobpoint/dashboard/create','JobpointDashboardController@createnewjob')->name('jobpoint.create');
    Route::post('jobpoint/dashboard/store',['as' => 'admin.jobpoint.store', 'uses'=>'JobpointDashboardController@store']);
    Route::post('jobpoint/update',['as' => 'admin.jobpoint.update', 'uses'=>'JobpointDashboardController@jobPointUpdate']);
    Route::get('jobpoint/destroy/{id}',['as' => 'admin.jobpoint.destroy', 'uses'=>'JobpointDashboardController@destroy']);
    Route::get('allevent',['as' => 'admin.jobpoint.allevent', 'uses' => 'JobpointDashboardController@allevent']);
    Route::get('job/sharablelink','JobpointDashboardController@sharableLink')->name('job.sharablelink');

    Route::get('jobpost/editjobpost/{id}','JobpointDashboardController@editJobPost')->name('jobpost.editjobpost');
    Route::post('jobpost/editjobpost/save','JobpointDashboardController@jobPostSave')->name('jobpost.save');
    Route::get('jobpost/overview','JobpointDashboardController@overview')->name('jobpost.overview');

    //JobPoint_ToDo
    Route::post('jobpost/todo','JobpointDashboardController@toDoUpdate')->name('admin.todo.type');

    //career page route here
    Route::get('job/career-page','CareerController@careerPage')->name('job.careerpage');
    Route::post('job/career/save','CareerController@save')->name('job.career.save');


});
/********************ADMIN ROUTES END******************************/
