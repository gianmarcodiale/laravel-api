<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Post;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Set a route for the API call using response()->json() customizable
// Route::get('posts', function () {
//     $posts= Post::all();
//     return response()->json([
//         "status_code" => 200,
//         "status_text" => "Success",
//         "posts" => $posts,
//     ]);
// });

// Other method not customizable
// Route::get('posts', function () {
//     $posts = Post::all();
//     return $posts;
// });

// Or with pagination
// Route::get('posts', function () {
//     $posts = Post::paginate(10); // -> for returning the a set number of records
//     return $posts;
// });

// This returns the Post instance with the relationships that we set inside the Post model
// Route::get('posts', function () {
//     $posts = Post::with(['tags', 'category', 'user'])->get();
//     return $posts;
// });

// This returns the relationships and the pagination
Route::get('posts', 'API\PostController@index');

Route::get('categories', 'API\CategoryController@index');

Route::get('tags', 'API\TagController@index');


