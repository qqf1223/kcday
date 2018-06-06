<?php

//page
Route::get('/login', 'Login\LoginController@index')->name('login');
Route::get('/logout', 'Login\LoginController@logout')->name('logout');

Route::group(['middleware'=> ['kcAdmin.login:admin','kcAdmin.permission', 'setTheme:ADMINLTE']], function(){

    Route::get('/', 'Home\IndexController@index');

    //系统设置
    Route::name('system.setting')->get('/setting', 'System\SysController@index');
    //权限管理
    Route::name('permission.index')->get('permission', 'System\PermissionController@index');
    Route::name('permission.index')->get('permission/index/{id}', 'System\PermissionController@index');
    Route::name('permission.add')->get('permission/add', 'System\PermissionController@add');
    Route::name('permission.add')->get('permission/add/{id}', 'System\PermissionController@add');
    Route::name('permission.edit')->get('permission/edit/{id}', 'System\PermissionController@edit');

    //角色管理
    Route::name('role.index')->get('role', 'System\RoleController@index');
    Route::name('role.index')->get('role/index/{id}', 'System\RoleController@index');
    Route::name('role.add')->get('role/add', 'System\RoleController@add');
    Route::name('role.add')->get('role/add/{id}', 'System\RoleController@add');
    Route::name('role.edit')->get('role/edit/{id}', 'System\RoleController@edit');
    Route::name('role.show')->get('role/show/{id}', 'System\RoleController@show');
    Route::name('role.auth')->get('role/auth/{id}', 'System\RoleController@auth');
    //岗位管理

    //管理员管理
    Route::name('adminUser.index')->get('adminUser', 'System\AdminUserController@index');
    Route::name('adminUser.add')->get('adminUser/add', 'System\AdminUserController@add');
    Route::name('adminUser.edit')->get('adminUser/edit/{id}', 'System\AdminUserController@edit');
    Route::name('adminUser.show')->get('adminUser/show/{id}', 'System\AdminUserController@show');
});

//api
Route::post('/login', 'Api\LoginController@login');

Route::group(['middleware'=> ['kcAdmin.login:admin'], 'prefix'=>'api'], function(){

    //权限
    Route::name('permission.index')->post('permission/index/{id?}', 'Api\PermissionController@index');

    Route::name('permission.add')->post('permission/save/{id?}', 'Api\PermissionController@save');

    Route::name('permission.edit')->post('permission/update/{id}', 'Api\PermissionController@update');

    Route::name('permission.delete')->delete('permission/delete/{id?}', 'Api\PermissionController@delete');

    //角色
    Route::name('role.index')->post('role/index/{id?}', 'Api\RoleController@index');

    Route::name('role.add')->post('role/save', 'Api\RoleController@save');

    Route::name('role.edit')->post('role/update/{id}', 'Api\RoleController@update');

    Route::name('role.delete')->delete('role/delete/{id?}', 'Api\RoleController@delete');

    Route::name('role.auth')->put('role/auth/{id}', 'Api\RoleController@auth');

    //管理员管理
    Route::name('adminUser.index')->post('adminUser', 'Api\AdminUserController@index');

    Route::name('adminUser.add')->post('adminUser/add', 'Api\AdminUserController@createAdmin');

    Route::name('adminUser.edit')->put('adminUser/avatar', 'Api\AdminUserController@avatar');

    Route::name('adminUser.edit')->post('adminUser/edit/{id}', 'Api\AdminUserController@editAdmin');

    Route::name('adminUser.delete')->delete('adminUser/delete/{id}', 'Api\AdminUserController@delete');

});

Route::group(['prefix'=>''], function(){
    Route::get('chat', 'Chat\IndexController@test');
});

Route::get('/voice', 'VoiceController@index');