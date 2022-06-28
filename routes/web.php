<?php


Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::get('login', 'Auth\AccessController@index')->name('login');
Route::post('login', 'Auth\AccessController@authorise')->name('admin.login');
Route::get('unsubscribe/{key}', 'Dashboard\UnsubscribeController@terminate')->name('unsubscribe');

Route::group(['middleware'=>'accessed'], function () {
    Route::get('/', 'Dashboard\DashboardController@dashboard')->name('dashboard');
    Route::get('tasks', 'Dashboard\DashboardController@tasks')->name('tasks');
    Route::get('admin/logout', 'Auth\AccessController@logoutAdmin')->name('logout');

    //email list routes
    Route::resource('email', 'Dashboard\EmailController');
    Route::get('email/pop/{id}', 'Dashboard\EmailController@pop')->name('email.pop');
    Route::get('email/status-toggle/{id}', 'Dashboard\EmailController@toggle')->name('email.toggle');

    Route::resource('maillist', 'Dashboard\MailListController');

    Route::get('mail-list/add-recipient/{id}', 'Dashboard\MailListController@addRecipient')->name('mail.list.add_recipient');
    Route::get('mail-list/toggle/{id}', 'Dashboard\MailListController@toggle')->name('mail-list.toggle');
    Route::get('mail-list/run/{id}', 'Dashboard\MailListController@runList')->name('mail-list.run');
    Route::get('mail-list/recipients/{id}', 'Dashboard\MailListController@recipients')->name('maillist.recipients');

    Route::get('private-mail','Dashboard\PrivateMailController@index')->name('private.mail');
    Route::get('send/private-mail/{id}','Dashboard\PrivateMailController@send')->name('mail.send');

    Route::get('mail-list/add-one/{id}', 'Dashboard\MailListController@addOneToList')->name('add.one.to.mail-list');
    Route::post('mail-list/store-one', 'Dashboard\MemberController@storeOneToList')->name('store.one.to.mail-list');

    Route::get('mail-list/add/member/{id}', 'Dashboard\MemberController@addToList')->name('member.to-list');
    Route::get('mail-list/add-member/tolist', 'Dashboard\MemberController@addToListGroup')->name('add.member.to-list');
    Route::get('mail-list/remove/recipients', 'Dashboard\MailListController@removeRecipient')->name('mail-list.remove_recipient');
    Route::get('mail-list/remove-all/recipients/{list_id}', 'Dashboard\MailListController@removeAllRecipient')->name('mail-list.del-all.items');


    //ADD CLIENTS ROUTES
    //add member option
    Route::get('recipients/add/{id}', 'Dashboard\MailListController@addRecipientToList')->name('add_recipient.to.list');

    //view member search
    Route::get('recipients/add/{id}', 'Dashboard\MemberController@index')->name('member.search');

    //add member search results
    Route::get('recipients/add/{id}', 'Dashboard\MailListController@addRecipientWithSearch')->name('add_recipient.from-search');

    //add direct member
    Route::post('recipient/add/member','Dashboard\MailListController@simpleAdd')->name('add.direct.members');

    //upload members
    Route::post('upload/member/template','Dashboard\ExcelController@uploadTemplate')->name('add.direct.members');

    //download template
    Route::get('download-template', 'Dashboard\MailListController@downloadTemplate')->name('template.download');

    //MEMBERS
    Route::get('members', 'Dashboard\MemberController@index')->name('member.index');

    //DATA CHART
    Route::get('/get-chart-data', 'Dashboard\ChartController@respond');

    //TEMPLATE ROUTES
    Route::resource('template', 'Dashboard\EmailTemplateController');

    Route::post('template/make', 'Dashboard\EmailTemplateController@make')->name('template.make');
    Route::post('template/do-update/{uuid}', 'Dashboard\EmailTemplateController@update')->name('template.do-update');

    Route::get('template/toggle/{id}', 'Dashboard\EmailTemplateController@toggle')->name('template.toggle');
    Route::get('template/pop/{id}', 'Dashboard\EmailTemplateController@pop')->name('template.pop');

    //AUTOMATE ROUTES
    Route::get('automates', 'Automate\AutoController@index')->name('automate');
    Route::get('automate/create', 'Automate\AutoController@create')->name('automate.create');
    Route::post('automate/store', 'Automate\AutoController@store')->name('automate.store');
    Route::get('automate/manage/{uuid}', 'Automate\AutoController@manage')->name('automate.manage');
    Route::post('automate/update/{uuid}', 'Automate\AutoController@update')->name('automate.update');
    Route::get('automate/edit/{uuid}', 'Automate\AutoController@edit')->name('automate.edit');
    Route::get('automate/toggle/{uuid}', 'Automate\AutoController@toggle')->name('automate.toggle');
    Route::get('automate/destroy/{uuid}', 'Automate\AutoController@destroy')->name('automate.destroy');
    Route::get('automate/stage-toggle/{uuid}/{action}', 'Automate\AutoController@toggleAll')->name('automate.toggle.all');
    Route::get('automate/item/delete/{uuid}', 'Automate\AutoController@autoDelete')->name('automate.delete');

    //AUTOMATE STAGE ROUTES
    Route::get('automate/stage/create/{uuid}', 'Automate\StageController@stageCreate')->name('automate.stage.create');
    Route::post('automate/stage/create/{uuid}', 'Automate\StageController@stageStore')->name('automate.stage.store');
    Route::get('automate/stage/toggle/{uuid}', 'Automate\StageController@stageToggle')->name('automate.stage.toggle');
    Route::get('automate/stage/edit/{uuid}', 'Automate\StageController@stageEdit')->name('automate.stage.edit');
    Route::post('automate/stage/update/{uuid}', 'Automate\StageController@stageUpdate')->name('automate.stage.update');
    Route::get('automate/stage/delete/{uuid}', 'Automate\StageController@stageDelete')->name('automate.stage.delete');


});


Route::group(['prefix'=>'trigger'], function () {
    //sync emails from server at intervals
    Route::get('sync-emails', 'Sync\UpdateListsController@intervalSync');

    Route::get('bulk-process', 'Dashboard\ProcessMailController@processDaily');
    Route::get('once-process', 'Dashboard\ProcessMailController@processOnce');
    Route::get('ready-task-run', 'Dashboard\ProcessMailController@readyTaskRun');

    Route::get('automate-initiate-run', 'Automate\RunAutomateController@initiate'); //runs every 7 mins
    Route::get('automate-reset-run', 'Automate\AutoServiceController@runReset'); //runs every 30 mins
});

Route::get('test-mail-ui', 'TestController@testEmailUi');

Route::group(['prefix'=>'api-service'], function () {
    Route::get('quick-mail', 'API\InstantMailBuildController@queueMail');
});
