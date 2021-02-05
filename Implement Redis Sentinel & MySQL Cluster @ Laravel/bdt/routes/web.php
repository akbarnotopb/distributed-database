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

Route::get('/test','Frontend\Dashboard\Listings\PropertyController@test');

Route::group(['namespace' => 'Frontend'], function () {
    Route::get('/', 'HomeController@index')->name('frontend.welcome');

    Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {

        Route::group(['middleware' => 'guest:agents'], function () {
            Route::get('login', 'LoginController@index')->name('agents.auth.login');
            Route::post('login', 'LoginController@login')->name('agents.auth.login-process');
            Route::get('register', 'RegisterController@index')->name('agents.auth.register');
            Route::post('register', 'RegisterController@store')->name('agents.auth.register-process');
            Route::get('restore', 'RestoreController@showLinkRequestForm')->name('agents.auth.restore');
            Route::post('restore', 'RestoreController@sendResetLinkEmail')->name('agents.auth.restore-process');
            Route::get('restore/password/{token}/{email}', 'ResetPasswordController@showResetForm')->name('agents.auth.reset');
            Route::post('restore/password', 'ResetPasswordController@reset')->name('agents.auth.reset-process');
        });

        Route::view('/', 'frontend.auth.approvalWait')->name('agents.auth.pending')->middleware('agent', 'agent.auth');
        Route::get('logout', 'LoginController@logout')->name('agents.auth.logout')->middleware('agent.auth');
    });

    Route::group(['prefix' => 'dashboard', 'namespace' => 'Dashboard', 'middleware' => ['agent', 'agent.auth', 'dashboard.shared-variables']], function () {

        Route::get('/', 'DashboardController@index')->name('dashboard.index');


        Route::group(['prefix' => 'profile', 'namespace' => 'Profiles'], function () {
            Route::get('/', 'ProfileController@index')->name('dashboard.profile');
            Route::get('/member', 'ProfileController@member')->name('dashboard.profile.member');
        });

        Route::group(['prefix' => 'settings', 'namespace' => 'Settings'], function () {
            Route::get('account', 'AccountController@edit')->name('settings.account.edit');
            Route::put('account', 'AccountController@update')->name('settings.account.update');
            Route::put('security', 'SecurityController@update')->name('settings.security.update');
        });

        Route::group(['prefix' => 'listings', 'namespace' => 'Listings'], function () {
            Route::resource('/property', 'PropertyController')->names([
                'create' => 'listings.property.add',
                'store' => 'listings.property.store',
                'index' => 'listings.property.index',
                'edit' => 'listing.property.edit',
                'update' => 'listing.property.update',
                'show' => 'listing.property.show'
            ]);
            Route::post('/property/deleteImages', 'PropertyController@deleteImages')->name('listings.property.deleteImage');
            Route::post('/property/delete', 'PropertyController@delete')->name('listings.property.delete');
            Route::put('/property/images/upload', 'PropertyController@storeImages')->name('listings.property.images.store');
            Route::get('/search', 'PropertySearchController@index')->name('listings.property.search');
            route::post('/favorite/add', 'PropertyFavoritesController@add')->name('listings.favorite.store');
        });
        Route::group(['prefix' => 'transaction', 'namespace' => 'Transactions'], function () {
            Route::get('/transactions/getDatatablesTransactions', 'TransactionController@getDatatablesTransactions')->name('transaction.agent.getDatatablesTransactions');
            Route::resource('/', 'TransactionController')->names([
                'create' => 'transaction.agent.create',
                'store' => 'transaction.agent.store',
                'index' => 'transaction.agent.index',
                'edit' => 'transaction.agent.edit',
                'update' => 'transaction.agent.update',
                'show' => 'transaction.agent.show',
                'destroy' => 'transaction.agent.destroy'
            ]);
        });

        Route::group(['prefix' => 'favorites', 'namespace' => 'Favorites'], function () {
            Route::resource('/', 'FavoriteController')->names([
                'index' => 'favorites.property.index'
            ]);

            Route::post('/delete', 'FavoriteController@delete')->name('favorites.property.delete');
        });

        Route::group(['prefix' => 'contacts', 'namespace' => 'Contacts'], function () {
            Route::resource('/', 'ContactController')->names([
                'index' => 'contacts.index'
            ]);
        });
    });
});
