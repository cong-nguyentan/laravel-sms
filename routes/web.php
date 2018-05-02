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

Route::get('/', 'HomeController@index')->name('home');

Route::prefix('admin')->middleware(['auth', 'auth.restrict_user'])->group(function() {
    Route::get('users/profile', 'UsersController@profile')->name('users.profile');
    Route::post('users/profile', 'UsersController@profile')->name('users.profile');
    Route::get('users/{user}/delete', 'UsersController@destroy')->name('users.delete');
    Route::resource('users', 'UsersController');

    Route::get('acl/design', 'AclController@designMenu')->name('acl.design_menu');
    Route::post('acl/store_design', 'AclController@storeDesignedMenu')->name('acl.store_designed_menu');
    Route::get('acl/{acl}/delete', 'AclController@destroy')->name('acl.delete');
    Route::resource('acl', 'AclController');

    Route::get('permissions/design', 'PermissionsController@designGroup')->name('permissions.design_group');
    Route::post('permissions/store_design', 'PermissionsController@storeDesignedGroup')->name('permissions.store_designed_group');
    Route::get('permissions/{permission}/delete', 'PermissionsController@destroy')->name('permissions.delete');
    Route::resource('permissions', 'PermissionsController');

    Route::get('contacts/{contact}/delete', 'ContactsController@destroy')->name('contacts.delete');
    Route::get('contacts/import', 'ContactsController@import')->name('contacts.import');
    Route::post('contacts/import', 'ContactsController@import')->name('contacts.import');
    Route::resource('contacts', 'ContactsController');

    Route::get('group_contacts/{groupContact}/delete', 'GroupContactsController@destroy')->name('group_contacts.delete');
    Route::resource('group_contacts', 'GroupContactsController');

    Route::get('roles/{role}/delete', 'RolesController@destroy')->name('roles.delete');
    Route::resource('roles', 'RolesController');

    Route::get('report', 'ReportController@index')->name('report.index');
    Route::get('send_message', 'SendMessagesController@index')->name('send_message.index');
});
Auth::routes();

Route::get('/logout', function() {
    Auth::logout();
    return redirect('/login');
})->name('auth.logout');

Route::get('/test', function() {
    debugVar(sms_send("841217604545", "Test", "Test"));
});