<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware('auth')->name('logs');

Auth::routes();

Route::view('/', 'smstake.index', ['breadcrumbs' => 'Dashboard'])->middleware('auth')->name('dashboard');

Route::get('sms/group/listData', ['as' => 'group.forDataTable', 'uses' => 'smstake\group\GroupController@getDataForDataTable'])->middleware('auth');
Route::get('sms/group/getAddForm', ['as' => 'group.getAddForm', 'uses' => 'smstake\group\GroupController@getAddForm'])->middleware('auth');
Route::get('sms/group/getEditForm', ['as' => 'group.getEditForm', 'uses' => 'smstake\group\GroupController@getEditForm'])->middleware('auth');
Route::resource('sms/group', 'smstake\group\GroupController')->middleware('auth');

Route::get('sms/senderID/listData', ['as' => 'senderID.forDataTable', 'uses' => 'smstake\senderID\SenderIDController@getDataForDataTable'])->middleware('auth');
Route::resource('sms/senderID', 'smstake\senderID\SenderIDController')->middleware('auth');

Route::get('sms/contact/listData', ['as' => 'contact.forDataTable', 'uses' => 'smstake\contact\ContactController@getDataForDataTable'])->middleware('auth');
Route::post('sms/contact/multiDelete', ['as' => 'contact.multiDelete', 'uses' => 'smstake\contact\ContactController@multiDelete'])->middleware('auth');
Route::get('sms/contact/getAddForm', ['as' => 'contact.getAddForm', 'uses' => 'smstake\contact\ContactController@getAddForm'])->middleware('auth');
Route::get('sms/contact/getEditForm', ['as' => 'contact.getEditForm', 'uses' => 'smstake\contact\ContactController@getEditForm'])->middleware('auth');
Route::get('sms/contact/{group}/listContactOfGroup', ['as' => 'contact.listContactOfGroup', 'uses' => 'smstake\contact\ContactController@listContactOfGroup'])->middleware('auth');
Route::resource('sms/contact', 'smstake\contact\ContactController')->middleware('auth');

Route::get('findSenderIdByStatus/{status}', 'smstake\senderID\SenderIDController@findSenderIdByStatus')->middleware('auth');

Route::prefix('sms/draft')->group(
    function () {
        Route::get('/', ['as' => 'draft.index', 'uses' => 'smstake\draft\DraftController@index'])->middleware('auth');
        Route::get('getAddForm', ['as' => 'draft.getAddForm', 'uses' => 'smstake\draft\DraftController@getAddForm'])->middleware('auth');
        Route::get('getEditForm', ['as' => 'draft.getEditForm', 'uses' => 'smstake\draft\DraftController@getEditForm'])->middleware('auth');
        Route::get('listData', ['as' => 'draft.forDataTable', 'uses' => 'smstake\draft\DraftController@getDataForDataTable'])->middleware('auth');
        Route::get('listDraftData', ['as' => 'draft.listDraftData', 'uses' => 'smstake\draft\DraftController@getListOfDrafts'])->middleware('auth');
        Route::post('store', ['as' => 'draft.store', 'uses' => 'smstake\draft\DraftController@store'])->middleware('auth');
        Route::get('{draft}/edit', ['as' => 'draft.edit', 'uses' => 'smstake\draft\DraftController@edit'])->middleware('auth');
        Route::patch('{draft}', ['as' => 'draft.update', 'uses' => 'smstake\draft\DraftController@update'])->middleware('auth');
        Route::delete('{draft}', ['as' => 'draft.destroy', 'uses' => 'smstake\draft\DraftController@destroy'])->middleware('auth');
        Route::get('translate', ['as' => 'google.translate', 'uses' => 'smstake\draft\DraftController@translate'])->middleware('auth');
        Route::get('toggle', ['as' => 'google.translate.toggle', 'uses' => 'smstake\draft\DraftController@toggle'])->middleware('auth');
    }
);

Route::prefix('sms/quick-sms')->group(
    function () {
        Route::get('/', ['as' => 'quickSms.index', 'uses' => 'smstake\quickSMS\QuickSMSController@index'])->middleware('auth');
        Route::post('store', ['as' => 'quickSms.store', 'uses' => 'smstake\quickSMS\QuickSMSController@store'])->middleware('auth');
        Route::get('list', ['as' => 'quickSms.list', 'uses' => 'smstake\quickSMS\QuickSMSController@list'])->middleware('auth');
        Route::get('getListForDataTable', ['as' => 'quickSms.getDataTable', 'uses' => 'smstake\quickSMS\QuickSMSController@getListForDataTable'])->middleware('auth');
    }
);
