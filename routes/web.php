<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Admin\AdLoginController;
use App\Http\Controllers\Admin\DealsController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\SubCategoriesController;
use App\Http\Controllers\Admin\KeywordsController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\EmailTemplatesController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\DatatablesCustomController;



use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ArticlesController  as AdminArticleController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PlacesController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FavouritesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController as CustomLoginController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\testController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;





// Home Route
Route::get('/', [HomeController::class, 'index']);

// Terms & Static Pages
Route::view('/terms', 'terms_conditions');
Route::view('terms-conditions', 'terms_conditions');
Route::view('privacy-policy', 'privacy_policy');
Route::view('cancellation-policy', 'cancellation_policy');

// Checkout Routes
Route::get('remove-booking/{sessionId}/{id}', [CheckoutController::class, 'remove_booking']);
Route::get('booking-success/{id}', [CheckoutController::class, 'booking_success']);
Route::resource('checkout', CheckoutController::class);

// Activity Routes
Route::get('/activities/add-cart', [ActivityController::class, 'add_cart']);
Route::get('/cart/', [ActivityController::class, 'cart']);
Route::get('/activities/remove-cart', [ActivityController::class, 'remove_cart']);

// Test Route
Route::get('/any', [TestController::class, 'index']);

// Authentication Routes
Auth::routes();
Route::get('activities/search', [LoginController::class, 'redirectToProvider']);
Route::post('/user_registration', [RegisterController::class, 'register']);
Route::post('/news-letter-register', [RegisterController::class, 'news_letter_register']);
Route::post('check-email-register', [RegisterController::class, 'check_email_register']);
Route::post('userlogin', [RegisterController::class, 'auth']);
Route::post('loginVerfi', [RegisterController::class, 'loginVerfi']);
Route::post('send-forget-email', [RegisterController::class, 'send_forget_email']);
Route::get('forget-password', [RegisterController::class, 'forget_password']);
Route::post('password-reset', [RegisterController::class, 'reset_password']);
Route::post('password-reset-change', [RegisterController::class, 'password_reset_change']);
Route::get('logout', [LoginController::class, 'logout']);
Route::get('admin', [AdLoginController::class, 'index']);
Route::get('change-password', [LoginController::class, 'change_password']);

// Profile Routes
Route::post('changepassword', [ProfileController::class, 'changepassword']);
Route::post('update-profile', [ProfileController::class, 'update_profile']);
Route::get('edit-profile', [ProfileController::class, 'index']);

// Gallery Routes
Route::get('explore-gallery', [HomeController::class, 'more_gallery']);
Route::get('featured-images', [HomeController::class, 'images']);

// Favorites Routes
Route::get('/favourites/add-favorite', [FavouritesController::class, 'add_favorite']);
Route::get('/favourites/remove-favorite', [FavouritesController::class, 'remove_favorite']);
Route::get('/favourites/removefavorite', [FavouritesController::class, 'removefavorite']);
Route::get('/favourites-listing', [FavouritesController::class, 'index']);

// Articles Routes
Route::get('article/detail/{id}', [ArticlesController::class, 'detail']);
Route::get('article', [ArticlesController::class, 'index']);
Route::get('arttours/all-toursicle/detail/{id}', [ArticlesController::class, 'detail']);

// Activities Routes
Route::get('activities/search', [ActivityController::class, 'searchAct']);
Route::get('book-your-adventures', [ActivityController::class, 'allActivities']);
Route::get('activities/detail/{id}', [ActivityController::class, 'detail']);
Route::get('tours/{slug}', [ActivityController::class, 'getActivitiesBySubCat']);

// Search Routes
Route::get('search', [SearchController::class, 'searchPage']);
Route::get('search/SearchPlcAutoName', [SearchController::class, 'SearchPlcAutoName']);
Route::get('places/SearchPlcAutoName', [SearchController::class, 'SearchPlcAutoName']);
Route::get('search/searchAutoRestName', [SearchController::class, 'searchRstAutoName']);
Route::get('search/SearchActAutoName', [SearchController::class, 'SearchActAutoName']);

// Places Routes
Route::get('places/search', [PlaceController::class, 'search']);
Route::get('places/detail/{id}', [PlaceController::class, 'detail']);
Route::get('places/{slug}', [PlaceController::class, 'get_places_bySubCat']);
Route::get('place/subcategory', [PlaceController::class, 'get_subcategories']);

// Restaurants Routes
Route::get('restaurants/search', [RestaurantController::class, 'search']);
Route::get('restaurants/detail/{id}', [RestaurantController::class, 'detail']);
Route::get('restaurants/{slug}', [RestaurantController::class, 'get_restaurants_bySubCat']);
Route::get('restaurant/subcategory', [RestaurantController::class, 'get_subcategories']);

// Review Routes
Route::post('review/store', [ReviewController::class, 'store']);

// Admin Activity Search Route
Route::get('getSearch', [ActivityController::class, 'getSearch']);
// Admin Activity Search Route

// use App\Http\Controllers\Admin\AdLoginController;
// use App\Http\Controllers\Admin\AdminController;
// use App\Http\Controllers\Admin\ArticlesController;
// use App\Http\Controllers\Admin\CategoriesController;
// use App\Http\Controllers\Admin\CustomerController;
// use App\Http\Controllers\Admin\DashboardController;
// use App\Http\Controllers\Admin\DealsController;
// use App\Http\Controllers\Admin\EmailTemplatesController;
// use App\Http\Controllers\Admin\KeywordsController;
// use App\Http\Controllers\Admin\PermissionController;
// use App\Http\Controllers\Admin\PlacesController;
// use App\Http\Controllers\Admin\ProfileController;
// use App\Http\Controllers\Admin\RestaurantController;
// use App\Http\Controllers\Admin\RoleController;
// use App\Http\Controllers\Admin\SettingController;
// use App\Http\Controllers\Admin\SubCategoriesController;
// use App\Http\Controllers\Admin\SupplierController;
// use App\Http\Controllers\Admin\UserController;
// use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::get('signup', [AdLoginController::class, 'signup']);
    Route::post('register', [AdLoginController::class, 'register']);
    Route::get('test', [AdLoginController::class, 'test']);
    Route::post('auth', [AdLoginController::class, 'auth']);
    Route::get('logout', [AdLoginController::class, 'logout']);
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('ausers/api', [UserController::class, 'apiUsers'])->name('api.users');
    Route::get('users-lisitng', [UserController::class, 'users_lisitng'])->name('users-lisitng');
    Route::resource('users', UserController::class);

    Route::get('administrator-listing', [AdminController::class, 'administrator_listing'])->name('administratorListing');
    Route::resource('administrator', AdminController::class);

    ////////////////////// Customers Listing //////////////////////
    Route::resource('customers', CustomerController::class);

    Route::get('placesListing', [PlacesController::class, 'placesListing'])->name('placesListing');
    Route::get('places/remove_image', [PlacesController::class, 'remove_image']);
    Route::get('places-listing', [PlacesController::class, 'places_listing'])->name('places_listing');

    Route::get('places/import-excel', [PlacesController::class, 'import_excel']);
    Route::post('places/import-places', [PlacesController::class, 'store_excel']);
    Route::get('places/import-rcg-plc', [PlacesController::class, 'import_rcg_plc']);
    Route::get('places/import-idiscover-plc', [PlacesController::class, 'import_idiscover_plc']);
    Route::resource('/places', PlacesController::class);

    //////////////////////// Activities ////////////////////////
    Route::get('activities/remove_image', [ActivityController::class, 'remove_image']);
    Route::get('activities/geocodes', [ActivityController::class, 'geo_codes']);
    Route::get('activity/availability', [ActivityController::class, 'activity_availability']);
    Route::get('activities/api', [ActivityController::class, 'api']);
    Route::get('activities/api_old', [ActivityController::class, 'api_old']);
    Route::get('activities-listing', [ActivityController::class, 'activities_listing'])->name('activities_listing');
    Route::resource('/activities', ActivityController::class);

    ////////////////////////////// Articles //////////////////////////////
    Route::get('articles/remove-image/{id}', [ArticlesController::class, 'remove_image']);
    Route::get('articles-listing', [ArticlesController::class, 'articles_listing'])->name('articles_listing');
    Route::resource('/articles', ArticlesController::class);

    ////////////// Restaurants ////////////////////////////
    Route::get('restaurants/import-rcg-places', [RestaurantController::class, 'import_rcg_rst']);
    Route::get('restaurants/import-idiscover-rst', [RestaurantController::class, 'import_idiscover_rst']);
    Route::get('/restaurants/address_delete/{id}', [RestaurantController::class, 'address_delete']);
    Route::get('/restaurants/address/{id}', [RestaurantController::class, 'address']);
    Route::post('/restaurants/address_store/{id}', [RestaurantController::class, 'address_store']);
    Route::get('/restaurants/remove_image/{id}', [RestaurantController::class, 'remove_image']);
    Route::post('/restaurants/edit_address', [RestaurantController::class, 'edit_address']);
    Route::get('/restaurant-listing', [RestaurantController::class, 'restaurant_listing']);
    Route::resource('/restaurants', RestaurantController::class);

    Route::get('categoriesListing', [CategoriesController::class, 'categoryListing'])->name('categoryListing');
    Route::resource('/categories', CategoriesController::class);

    Route::get('subcategories/subcategoriesListing', [SubCategoriesController::class, 'subcategoriesListing'])->name('subcategoriesListing');
    Route::resource('/subcategories', SubCategoriesController::class);

    ////////////// Keyword ///////////////
    Route::get('keyword-listing', [KeywordsController::class, 'keyword_listing'])->name('keyword-listing');
    Route::resource('keywords', KeywordsController::class);

    ////////////// Supplier ///////////////
    Route::get('supplier-listing', [SupplierController::class, 'supplier_listing'])->name('supplier-listing');
    Route::resource('suppliers', SupplierController::class);

    ////////////// Deals ///////////////
    Route::get('/deals/get_places/{id}', [DealsController::class, 'get_places']);
    Route::get('dealsListing', [DealsController::class, 'dealsListing'])->name('dealsListing');
    Route::resource('deals', DealsController::class);

    ////////////// Setting ///////////////
    Route::post('update_setting', [SettingController::class, 'update_setting']);
    Route::resource('setting', SettingController::class);

    ////////////// Profile ///////////////
    Route::post('profile/update_image', [ProfileController::class, 'update_image']);
    Route::post('profile/change_password', [ProfileController::class, 'change_password']);
    Route::post('profile/update', [ProfileController::class, 'update_profile']);
    Route::resource('profile', ProfileController::class);

    ////////////// Permission ///////////////
    Route::get('permission/api', [PermissionController::class, 'apiPermission'])->name('api.permission');
    Route::resource('permission', PermissionController::class);

    ////////////// Role ///////////////
    Route::get('role/api', [RoleController::class, 'apirole'])->name('api.role');
    Route::resource('role', RoleController::class);

    ////////// Email Templates ///////////////
    Route::get('/email-templates-listing', [EmailTemplatesController::class, 'email_templates_listing']);
    Route::resource('email-templates', EmailTemplatesController::class);
});


Route::group(['middleware' => ['web', 'auth']], function () {
    Route::post('common/status', [CommonController::class, 'update_status'])->name('status.all');
    Route::post('common/delete', [CommonController::class, 'delete'])->name('delete.all');
    Route::post('common/bulk-oprations', [CommonController::class, 'bulkOprations'])->name('bulk-oprations.all');

    ////////////// order ///////////////
    // Route::get('order/api', [OrderController::class, 'apiOrder'])->name('api.order');
    // Route::resource('orders', OrderController::class);
});

Route::get('/datatables_custom', [DatatablesCustomController::class, 'index']);
Route::get('/form-controls', [DatatablesCustomController::class, 'form']);
Route::get('/multi-column-forms', [DatatablesCustomController::class, 'multicolumnforms']);

// Route::get('/order_listing', [OrderController::class, 'index']);