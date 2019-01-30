<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------



Route::rule('/', 'index/Open/index');

Route::rule('api/register', 'index/Open/register');
Route::rule('api/login', 'index/Open/login');
Route::rule('api/upload', 'index/Open/upload');
Route::rule('api/grouplist', 'index/Index/grouplist');
Route::rule('api/createGroup', 'index/Index/createGroup');
Route::rule('api/groupInfo', 'index/Index/groupInfo');
Route::rule('api/memberInfo', 'index/User/memberInfo');
Route::rule('api/joinGroup', 'index/Index/joinGroup');
Route::rule('api/chatRecord', 'index/Index/chatRecord');
Route::rule('api/groupUser', 'index/Index/groupUser');
Route::rule('api/groupShenhe', 'index/Index/groupShenhe');
Route::rule('api/deleteGroupUser', 'index/Index/deleteGroupUser');
Route::rule('api/loginout', 'index/User/loginout');


/*
 * admin
 *
 * */
Route::rule('admin', 'admin/Admin/index');
Route::rule('rootlogin', 'admin/Login/login');
Route::rule('adminmember', 'admin/Adminmember/index');
Route::rule('savepassword', 'admin/Adminmember/savepassword');
Route::rule('setgrouproot', 'admin/Adminmember/setgrouproot');
Route::rule('savegameid', 'admin/Adminmember/savegameid');
Route::rule('admingroup', 'admin/Admingroup/index');
Route::rule('savegroupname', 'admin/Admingroup/savegroupname');


Route::rule(':user', 'index/Open/index'); // 全动态地址

