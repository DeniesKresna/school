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
$router->patch('/asset/{id}', 'AssetController@update');
$router->post('/asset', 'AssetController@store');
$router->delete('/asset/{id}','AssetController@delete');
$router->get('/asset/detail/{id}','AssetController@detail');

//======================Receive==========================
$router->post('/receive/{asset_id}','ReceiveController@store');

//======================User==========================
$router->get('/user/autocomplete','UserController@autocomplete');

//======================Condition Type==========================
$router->get('/conditiontype/autocomplete','ConditiontypeController@autocomplete');

//======================Move==========================
$router->post('/move','MoveController@store');
