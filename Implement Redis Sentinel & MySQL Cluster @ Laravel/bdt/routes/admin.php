<?php

/**
 * route untuk admin
 */

Route::group(['prefix' => 'admin-area', 'namespace' => 'Admin'], function () {

    Route::get('/auth/login', 'Auth\LoginController@loginForm')->name('admin.auth.login');
    Route::post('/auth/login', 'Auth\LoginController@login')->name('admin.auth.login');
    Route::get('/auth/logout', 'Auth\LoginController@logout')->name('admin.auth.logout');

    Route::group(['middleware' => ['admin.auth']], function () {
        Route::get('/', 'AdminController@index')->name('admin.index');

        Route::get('/agents/getDatatablesAgents', 'Agents\AgentController@getDatatablesAgents')->name('agent.getDatatablesAgents');
        Route::resource('/agents', 'Agents\AgentController');
        Route::post('/agents/verification', 'Agents\AgentController@verificate')->name('agent.verification');
        Route::post('/agents/getDatatablesDownline', 'Agents\AgentController@getDatatablesDownline')->name('agent.getDatatablesDownline');

        Route::put('/properties/images/upload', 'Properties\PropertyController@storeImages')->name('properties.images.store');
        Route::get('/properties/images/delete/{id}', 'Properties\PropertyController@deleteImages')->name('properties.images.delete');
        Route::get('/properties/getDatatablesProperties', 'Properties\PropertyController@getDatatablesProperties')->name('properties.getDatatablesProperties');

        Route::resource('/properties', 'Properties\PropertyController')->names([
            'index' => 'properties.index'
        ]);

        Route::get('/transactions/getDatatablesTransactions', 'Transactions\TransactionController@getDatatablesTransactions')->name('transactions.getDatatablesTransactions');
        Route::resource('/transactions', 'Transactions\TransactionController')->names([
            'index' => 'transactions.index'
        ]);

        Route::get('/email/send/verifiednotification/{userid}', 'Emails\EmailVerifiedNotificationController@index')->name('emails.send.verified.notification');

        Route::get('/email/send/newproperties/{propsid}', 'Emails\EmailNewPropertiesController@index')->name('emails.send.newprops.notification');
    });
});
