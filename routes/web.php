<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Admin\AdLoginController;
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

Route::get('/', [HomeController::class, 'index']);

Route::get('/terms', fn() => view('terms_conditions'));

Route::get('remove-booking/{sessionId}/{id}', [CheckoutController::class, 'remove_booking']);
Route::get('booking-success/{id}', [CheckoutController::class, 'booking_success']);
Route::resource('checkout', CheckoutController::class);

Route::get('/activities/add-cart', [ActivityController::class, 'add_cart']);
Route::get('/cart/', [ActivityController::class, 'cart']);
Route::get('/activities/remove-cart', [ActivityController::class, 'remove_cart']);

Route::get('/any', [testController::class, 'index']);

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
Route::get('logout', [CustomLoginController::class, 'logout']);
Route::get('admin', [AdLoginController::class, 'index']);
Route::get('change-password', [CustomLoginController::class, 'change_password']);

Route::post('changepassword', [ProfileController::class, 'changepassword']);
Route::post('update-profile', [ProfileController::class, 'update_profile']);
Route::get('edit-profile', [ProfileController::class, 'index']);

Route::get('explore-gallery', [HomeController::class, 'more_gallery']);
Route::get('featured-images', [HomeController::class, 'images']);

Route::get('/favourites/add-favorite', [FavouritesController::class, 'add_favorite']);
Route::get('/favourites/remove-favorite', [FavouritesController::class, 'remove_favorite']);
Route::get('/favourites/removefavorite', [FavouritesController::class, 'removefavorite']);
Route::get('/favourites-listing', [FavouritesController::class, 'index']);

Route::get('article/detail/{id}', [ArticlesController::class, 'detail']);
Route::get('article', [ArticlesController::class, 'index']);

Route::get('activities/search', [ActivityController::class, 'searchAct']);
Route::get('book-your-adventures', [ActivityController::class, 'allActivities']);
Route::get('activities/detail/{id}', [ActivityController::class, 'detail']);
Route::get('tours/{slug}', [ActivityController::class, 'getActivitiesBySubCat']);

Route::get('search', [SearchController::class, 'searchPage']);
Route::get('search/SearchPlcAutoName', [SearchController::class, 'SearchPlcAutoName']);
Route::get('places/SearchPlcAutoName', [SearchController::class, 'SearchPlcAutoName']);
Route::get('search/searchAutoRestName', [SearchController::class, 'searchRstAutoName']);
Route::get('search/SearchActAutoName', [SearchController::class, 'searchActAutoName']);

Route::get('places/search', [PlaceController::class, 'search']);
Route::get('places/detail/{id}', [PlaceController::class, 'detail']);
Route::get('places/{slug}', [PlaceController::class, 'get_places_bySubCat']);
Route::get('place/subcategory', [PlaceController::class, 'get_subcategories']);

Route::get('restaurants/search', [RestaurantController::class, 'search']);
Route::get('restaurants/detail/{id}', [RestaurantController::class, 'detail']);
Route::get('restaurants/{slug}', [RestaurantController::class, 'get_restaurants_bySubCat']);
Route::get('restaurant/subcategory', [RestaurantController::class, 'get_subcategories']);

Route::post('review/store', [ReviewController::class, 'store']);

Route::view('terms-conditions', 'terms_conditions');
Route::view('privacy-policy', 'privacy_policy');
Route::view('cancellation-policy', 'cancellation_policy');

Route::get('getSearch', [ActivityController::class, 'getSearch']);

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
    Route::resource('customers', CustomerController::class);
    Route::get('placesListing', [PlacesController::class, 'placesListing'])->name('placesListing');
    Route::get('places/remove_image', [PlacesController::class, 'remove_image']);
    Route::get('places-listing', [PlacesController::class, 'places_listing'])->name('places_listing');
    Route::resource('/places', PlacesController::class);
});

