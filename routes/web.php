<?php

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'DashboardController@index')->name('dash');
    // Route::resource('users', 'UserController');
    Route::post('/users/search', 'UserController@search' );
    Route::get('/users/approve/{id}/{micro_content_id}/{notificarion_id}', 'UserController@approve' );

    Route::resource('notifications', 'NotificationController');
    Route::resource('notifications/unread', 'NotificationController@unread');

    Route::resource('micro_contents', 'MicroContentController');
    Route::post('/micro_contents/evaluate', 'MicroContentController@evaluate' );
    Route::post('/micro_contents/actions', 'MicroContentController@ajaxActions' );

    Route::post('/micro_contents/actionPlans', 'MicroContentController@ajaxActionPlans' );
    Route::get('/training/{id}', 'TrainingController@show' );
    Route::post('/training', 'TrainingController@create' );

    Route::resource('action_plans', 'ActionPlanController');

    // Route::resource('interests', 'InterestController');
    // Route::resource('departments', 'DepartmentController');
    // Route::resource('groups', 'GroupController');
    // Route::resource('topics', 'TopicController');

    // Route::resource('action_plans', 'ActionPlanController');
    Route::post('action_plans/{id}/update_assigned', 'ActionPlanController@updateAssigned');
    // Route::resource('chatbot', 'ChatbotController');

});

Route::group(['middleware' => 'admin'], function () {

    Route::resource('users', 'UserController');

    Route::resource('departments', 'DepartmentController');
    Route::resource('groups', 'GroupController');
    Route::resource('topics', 'TopicController');

    Route::resource('interests', 'InterestController');

    Route::resource('chatbot', 'ChatbotController');
});

Route::group(['middleware' => 'advance'], function () {

    
});
