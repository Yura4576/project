<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestTestController;

Route::get('/',function(){
    return view('Welcome');
});
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['namespace' => 'Blog', 'prefix' => 'blog'], function () {
    Route::resource('posts', '\App\Http\Controllers\Blog\PostController')->names('blog.posts');
});


//Админка Блога
$groupData = [
    'namespace' =>  'Blog\Admin',
    'prefix'    =>  'admin/blog',
];
Route::group($groupData, function (){
    //BlogCategory
    $methods = ['index', 'edit', 'update', 'create', 'store'];
    Route::resource('categories', 'CategoryController')
        ->only($methods)
        ->names('blog.admin.categories');

    //BlogPost
    Route::resource('posts','PostController')
        ->except(['show'])
        ->names('blog.admin.posts');
});
//Route::resource('rest', '\App\Http\Controllers\RestTestController')->names('restTest');


