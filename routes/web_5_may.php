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


/*Route::get('/', function () {
    // return redirect('/login');
     return view('welcome');
});*/

Route::get('/', 'HomeController@index');

//Route::get('home/', 'HomeController@index');

Route::get('/terms', function () {
    return view('terms_conditions');
});

Route::get('/activities/add-cart', 'ActivityController@add_cart');
Route::get('/cart/', 'ActivityController@cart');
Route::get('checkout', 'ActivityController@checkout');
Route::get('/activities/remove-cart', 'ActivityController@remove_cart');

Route::get('/any', 'testController@index');

/*Route::get('login', 'LoginController@login');
Route::post('signup', 'AdLoginController@signup');
Route::post('logout', 'AdLoginController@logout');*/

use App\User;

Auth::routes();

Route::get('activities/search', 'Auth\LoginController@redirectToProvider');
//Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback');

Route::post('/user_registration', 'RegisterController@register');
Route::post('/news-letter-register', 'RegisterController@news_letter_register');
Route::post('check-email-register', 'RegisterController@check_email_register');
Route::post('userlogin', 'RegisterController@auth');
Route::post('loginVerfi', 'RegisterController@loginVerfi');
Route::post('send-forget-email', 'RegisterController@send_forget_email');
Route::get('forget-password', 'RegisterController@forget_password');
Route::post('password-reset', 'RegisterController@reset_password');
Route::post('password-reset-change', 'RegisterController@password_reset_change');
Route::get('logout', 'LoginController@logout');
Route::get('admin', 'Admin\AdLoginController@index');
Route::get('change-password', 'LoginController@change_password');

Route::post('changepassword', 'ProfileController@changepassword');
Route::post('update-profile', 'ProfileController@update_profile');

Route::get('edit-profile', 'ProfileController@index');

Route::get('explore-gallery', 'HomeController@more_gallery');
Route::get('featured-images', 'HomeController@images');

Route::get('/favourites/add-favorite', 'FavouritesController@add_favorite');
Route::get('/favourites/remove-favorite', 'FavouritesController@remove_favorite');
Route::get('/favourites/removefavorite', 'FavouritesController@removefavorite');
Route::get('/favourites-listing', 'FavouritesController@index');

/************************** route for guide iceland view more/articles page**************************/

Route::get('article', 'ArticlesController@index');

/************************** route for guide iceland view more/articles page ends  **************************/

/************************** route for articles single page  **************************/

Route::get('arttours/all-toursicle/detail/{id}', 'ArticlesController@detail');
/************************** route for articles single page ends  **************************/
//************************** Activities Start***********************************/

Route::get('activities/search', 'ActivityController@searchAct');
Route::get('book-your-adventures', 'ActivityController@allActivities');
//Route::get('activity/detail/{id}', 'ActivityController@detail');
Route::get('activities/detail/{id}', 'ActivityController@detail');
//Route::get('get-activities-by/{slug}', 'ActivityController@get_activities_bySubCat');
Route::get('tours/{slug}', 'ActivityController@getActivitiesBySubCat');
//Route::get('get-activities/{slug}', 'ActivityController@getActivitiesBySubCat');
// Route::get('activities', 'ActivityController@allActivities');


//**************************** Activities end **********************/

/**********************`**** route for search page  **************************/

Route::get('search', 'SearchController@searchPage');
Route::get('search/SearchPlcAutoName', 'SearchController@SearchPlcAutoName');
Route::get('places/SearchPlcAutoName', 'SearchController@SearchPlcAutoName');

Route::get('search/searchAutoRestName', 'SearchController@searchRstAutoName');
Route::get('search/SearchActAutoName', 'SearchController@searchActAutoName');
/************************** route for search page ends  **************************/
//************************* route for places module start *****************************/
Route::get('places/search', 'PlaceController@search');
//Route::get('place/detail/{id}', 'PlaceController@detail');
Route::get('places/detail/{id}', 'PlaceController@detail');
//Route::get('get-places-by/{slug}', 'PlaceController@get_places_bySubCat');
Route::get('places/{slug}', 'PlaceController@get_places_bySubCat');
Route::get('place/subcategory', 'PlaceController@get_subcategories');

/////////////////////// route for restaurants  start//////////////////////

Route::get('restaurants/search', 'RestaurantController@search');
Route::get('restaurants/detail/{id}', 'RestaurantController@detail');
////will remove below line.///////
//Route::get('get-restaurants-by/{slug}', 'RestaurantController@get_restaurants_bySubCat');
Route::get('restaurants/{slug}', 'RestaurantController@get_restaurants_bySubCat');

Route::get('restaurant/subcategory', 'RestaurantController@get_subcategories');
////////////////////// route for restaurants end /////////////////
// ///////////////////// Review ///////////////////////////
Route::post('review/store', 'ReviewController@store');
///////////////////// route for item detail start ////////////////

Route::view('terms-conditions', 'terms_conditions');
Route::view('privacy-policy', 'privacy_policy');


/************************** route for search page to get search data  **************************/

Route::get('getSearch', 'Admin\ActivityController@getSearch');

/************************** route for search page to get search data ends  **************************/


Route::prefix('admin')->group(function () {
    Route::get('signup', 'Admin\AdLoginController@signup');
    Route::post('register', 'Admin\AdLoginController@register');
    Route::get('test', 'Admin\AdLoginController@test');
    Route::post('auth', 'Admin\AdLoginController@auth');
    Route::get('logout', 'Admin\AdLoginController@logout');
    /*  Route::get('signup', 'Admin\AdLoginController@signup');
      Route::post('login', 'Admin\AdLoginController@index');
      Route::post('logout', 'Admin\AdLoginController@logout');*/
    // Route::get('dashboard', 'Admin\DashboardController@index')->name('dashboard');
    Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard');
    Route::get('ausers/api', 'Admin\UserController@apiUsers')->name('api.users');
    Route::get('users-lisitng', 'Admin\UserController@users_lisitng')->name('users-lisitng');
    Route::resource('users', 'Admin\UserController');
    Route::get('administrator-listing', 'Admin\AdminController@administrator_listing')->name('administratorListing');
    Route::resource('administrator', 'Admin\AdminController');

    //////////////////////Customers Listing//////////////////////
    Route::resource('customers', 'Admin\CustomerController');


    Route::get('placesListing', 'Admin\PlacesController@placesListing')->name('placesListing');
    Route::get('places/remove_image', 'Admin\PlacesController@remove_image');
    Route::get('places-listing', 'Admin\PlacesController@places_listing')->name('places_listing');


    Route::get('places/import-excel', 'Admin\PlacesController@import_excel');
    Route::post('places/import-places', 'Admin\PlacesController@store_excel');
    Route::get('places/import-rcg-plc', 'Admin\PlacesController@import_rcg_plc');
    Route::get('places/import-idiscover-plc', 'Admin\PlacesController@import_idiscover_plc');
    Route::resource('/places', 'Admin\PlacesController');
//////////////////////////// sctivities //////////////////////////////////////////////////////////////

    Route::get('activities/remove_image', 'Admin\ActivityController@remove_image');
    Route::get('activities/geocodes', 'Admin\ActivityController@geo_codes');

    Route::get('activity/availability', 'Admin\ActivityController@activity_availability');

    Route::get('activities/api', 'Admin\ActivityController@api');
    Route::get('activities/api_old', 'Admin\ActivityController@api_old');

    Route::get('activities-listing', 'Admin\ActivityController@activities_listing')->name('activities_listing');
    Route::resource('/activities', 'Admin\ActivityController');
    ////////////////////////////// articals /////////////////////////////////////////
    Route::get('articles/remove-image/{id}', 'Admin\ArticlesController@remove_image');
    Route::get('articles-listing ', 'Admin\ArticlesController@articles_listing')->name('articles_listing');
    Route::resource('/articles', 'Admin\ArticlesController');

    ////////////// restaurants ///////////////////////////////////////////////////////////
    Route::get('restaurants/import-rcg-places', 'Admin\RestaurantController@import_rcg_rst');
    Route::get('restaurants/import-idiscover-rst', 'Admin\RestaurantController@import_idiscover_rst');
    Route::get('/restaurants/address_delete/{id}', 'Admin\RestaurantController@address_delete');
    Route::get('/restaurants/address/{id}', 'Admin\RestaurantController@address');
    Route::post('/restaurants/address_store/{id}', 'Admin\RestaurantController@address_store');
    Route::get('/restaurants/remove_image/{id}', 'Admin\RestaurantController@remove_image');
    Route::post('/restaurants/edit_address', 'Admin\RestaurantController@edit_address');
    Route::get('/restaurant-listing', 'Admin\RestaurantController@restaurant_listing');
    Route::get('/restaurants/address/{id}', 'Admin\RestaurantController@address');
    Route::resource('/restaurants', 'Admin\RestaurantController');


    Route::get('categoriesListing', 'Admin\CategoriesController@categoryListing')->name('categoryListing');
    Route::resource('/categories', 'Admin\CategoriesController');

    Route::get('subcategories/subcategoriesListing', 'Admin\SubCategoriesController@subcategoriesListing')->name('subcategoriesListing');
    Route::resource('/subcategories', 'Admin\SubCategoriesController');
    ////////////// keyword ///////////////
    Route::get('keyword-listing', 'Admin\KeywordsController@keyword_listing')->name('keyword-listing');
    Route::resource('keywords', 'Admin\KeywordsController');
    ////////////// Supplier ///////////////
    Route::get('supplier-listing', 'Admin\SupplierController@supplier_listing')->name('supplier-listing');
    Route::resource('suppliers', 'Admin\SupplierController');
    ////////////// Delas ///////////////
    Route::get('/deals/get_places/{id}', 'Admin\DealsController@get_places');

    Route::get('dealsListing', 'Admin\DealsController@dealsListing')->name('dealsListing');
    Route::resource('deals', 'Admin\DealsController');
    ////////////// setting ///////////////
    Route::post('update_setting', 'Admin\SettingController@update_setting');
    Route::resource('setting', 'Admin\SettingController');
    ////////////// profile ///////////////
    Route::post('profile/update_image', 'Admin\ProfileController@update_image');
    Route::post('profile/change_password', 'Admin\ProfileController@change_password');
    Route::post('profile/update', 'Admin\ProfileController@update_profile');
    Route::resource('profile', 'Admin\ProfileController');


    ////////////// permission ///////////////
    Route::get('permission/api', 'Admin\PermissionController@apiPermission')->name('api.permission');
    Route::resource('permission', 'Admin\PermissionController');
    ////////////// role ///////////////
    Route::get('role/api', 'Admin\RoleController@apirole')->name('api.role');
    Route::resource('role', 'Admin\RoleController');

////////////// EmailTemplatesController ///////////////
    Route::get('/email-templates-listing', 'Admin\EmailTemplatesController@email_templates_listing');
    Route::resource('email-templates', 'Admin\EmailTemplatesController');


});
Route::group(['middleware' => ['web', 'auth']], function () {
    Route::post('common/status', 'CommonController@update_status')->name('status.all');
    Route::post('common/delete', 'CommonController@delete')->name('delete.all');
    Route::post('common/bulk-oprations', 'CommonController@bulkOprations')->name('bulk-oprations.all');


    //Route::get( 'users/{user}/getData', 'UserController@getData' )->name('users.getData');

    ////////////// order ///////////////
    Route::get('order/api', 'OrderController@apiOrder')->name('api.order');
    Route::resource('orders', 'OrderController');
});


Route::get('/datatables_custom', 'DatatablesCustomController@index');
Route::get('/form-controls', 'DatatablesCustomController@form');
Route::get('/multi-column-forms', 'DatatablesCustomController@multicolumnforms');

///////////Order Controller ///////////
Route::get('/order_listing', 'OrderController@index');
