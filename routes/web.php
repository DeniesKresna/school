<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
/*
$router->get('/', function () use ($router) {
    return $router->app->version();
});*/
$router->get('/', function () {
    return view('app');
});
//======================API========================

//======================Group=============================
$router->get('/group/assettypeAutocomplete', 'GroupController@assettypeAutocomplete');

//======================Kategori==========================
$router->get('/assettype/{group_id}/autocomplete', 'AssettypeController@indexAutocomplete');

//======================Room=============================
$router->get('/room/autocomplete', 'RoomController@autocomplete');

//======================Asset==========================
$router->post('/asset/filter', 'AssetController@filter');
$router->post('/asset/import', 'AssetController@import');
$router->post('/asset', 'AssetController@store');
$router->delete('/asset/{id}','AssetController@delete');
$router->get('/asset/detail/{id}','AssetController@detail');
$router->patch('/asset/detail/{id}','AssetController@updateAll');

//======================Receive==========================
$router->post('/receive/{asset_id}','ReceiveController@store');
$router->get('/receive/show/{asset_id}','ReceiveController@showAsset');

//======================User==========================
$router->get('/user/autocomplete','UserController@autocomplete');

//======================Condition Type==========================
$router->get('/conditiontype/autocomplete','ConditiontypeController@autocomplete');

//======================Move==========================
//$router->post('/move/{asset_id}','MoveController@store');
$router->post('/move/{asset_id}','MoveController@store');
$router->patch('/move/{asset_id}/{id}','MoveController@update');
$router->get('/move/{asset_id}','MoveController@showAsset');
$router->delete('/move/{id}','MoveController@delete');

//======================Condition==========================
$router->post('/condition/{asset_id}','ConditionController@store');
$router->patch('/condition/{asset_id}/{id}','ConditionController@update');
$router->get('/condition/{asset_id}','ConditionController@showAsset');
$router->delete('/condition/{id}','ConditionController@delete');