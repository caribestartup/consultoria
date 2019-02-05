<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/micro_contents', function () {
    return App\MicroContent::with('user')->get();
});
Route::get('/micro_contents/{id}', function ($id) {
    return App\MicroContent::where('micro_contents.id', '=', $id)->with('user')->get();
});
Route::get('/action_plans', function () {
    return App\ActionPlanConfiguration::with('actionPlan')->with('users')->with('coach')->get();
});
Route::get('/action_plans/{id}', function ($id) {
    return App\ActionPlanConfiguration::where('action_plan_configurations.action_plan_id', '=', $id)->with('actionPlan')->with('users')->with('coach')->get();
});
Route::get('/interests', function () {
    return App\Interest::all();
});
Route::get('/interests/{id}', function ($id) {
    return App\Interest::where('interests.id', '=', $id)->get();
});
Route::get('/users', function () {
    return App\User::all();
});
Route::get('/users/{id}', function ($id) {
    return App\User::where('users.id', '=', $id)->get();
});
Route::get('/chatbots', function () {
    return App\Chatbot::with('users')->with('questions')->get();
});
Route::get('/chatbots/{id}', function ($id) {
    return App\Chatbot::where('chatbots.id', '=', $id)->with('users')->get();
});
Route::get('/departments', function () {
    return App\Department::all();
});
Route::get('/departments/{id}', function ($id) {
    return App\Department::where('departments.id', '=', $id)->get();
});
Route::get('/groups', function () {
    return App\Group::all();
});
Route::get('/groups/{id}', function ($id) {
    return App\Group::where('groups.id', '=', $id)->get();
});
Route::get('/topics', function () {
    return App\Topic::all();
});
Route::get('/topics/{id}', function ($id) {
    return App\Topic::where('topics.id', '=', $id)->get();
});
