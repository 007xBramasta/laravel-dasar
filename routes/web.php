<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\InputController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/bram', function(){
    return "Hallo Bram ganteng";
});

Route::redirect('/youtube', '/bram');

Route::fallback(function (){
    return "404 by Bramasta Albatio";
});

Route:: view('/hello', 'hello', ['name' => 'Bram']); //Route view

Route::get('/hello-again', function(){ //Route view menggunakan function
    return view('hello', ['name' => 'Bram']);
});

Route::get('/hello-world', function(){ //Route view menggunakan function
    return view('hello.world', ['name' =>'Bram']);
});

Route::get('/products/{id}', function ($productId){ //With parameter
    return  "Product $productId";
})->name('product.detail');

Route::get('/products/{product}/items/{item}', function ($productId, $itemId){
    return "Product $productId, Item $itemId";
})->name('product.item.detail');

Route::get('/categories/{id}', function ($categoryId){ //with Regex
    return "Category $categoryId";
})->where('id', '[0-9]+')->name('category.detail');

Route::get('/users/{id?}', function ($userId = '404'){ //Router Optinal harus dengan defualt valuenya
    return "User $userId";
})->name('user.detail');

Route::get('/conflict/bram', function (){ //Conflict Routes Prioritas urutan yang di atas agar tidak bertabrakan
    return "Conflict Bramasta Albatio";
});

Route::get('/conflict/{name}', function ($name){ 
    return "Conflict $name";
});

Route::get('/produk/{id}', function ($id){
    $link = route('product.detail', ['id' => $id]);
    return "Link $link";
});

Route::get('/produk-redirect/{id}', function ($id){
    return redirect()->route('product.detail', ['id' => $id]);
});

Route::get('/controller/hello/request', [\App\Http\Controllers\HelloController::class, 'request']);
Route::get('/controller/hello/{name}', [\App\Http\Controllers\HelloController::class, 'hello']);

Route::get('/input/hello', [\App\Http\Controllers\InputController::class, 'hello']); //Input
Route::post('/input/hello', [\App\Http\Controllers\InputController::class, 'hello']);

Route::post('/input/hello/first', [\App\Http\Controllers\InputController::class, 'helloFirstName']);
Route::post('/input/hello/input', [\App\Http\Controllers\InputController::class, 'helloInput']);
Route::post('/input/hello/array', [\App\Http\Controllers\InputController::class, 'helloArray']);

Route::post('/input/type', [\App\Http\Controllers\InputController::class, 'inputType']);
Route::post('/input/filter/only', [\App\Http\Controllers\InputController::class, 'filterOnly']);
Route::post('/input/filter/except', [\App\Http\Controllers\InputController::class, 'filterExcept']);
Route::post('/input/filter/merge', [\App\Http\Controllers\InputController::class, 'filterMerge']);

Route::post('/file/upload', [\App\Http\Controllers\FileController::class, 'upload'])
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]); 

Route::get('/response/hello', [\App\Http\Controllers\ResponseController::class, 'response']);
Route::get('/response/header', [\App\Http\Controllers\ResponseController::class, 'header']);

Route::prefix("response/type")->group(function (){
    Route::get('/view', [\App\Http\Controllers\ResponseController::class, 'ResponseView']);
    Route::get('/json', [\App\Http\Controllers\ResponseController::class, 'ResponseJson']);
    Route::get('/file', [\App\Http\Controllers\ResponseController::class, 'ResponseFile']);
    Route::get('/download', [\App\Http\Controllers\ResponseController::class, 'ResponseDownload']);
});

Route::controller(\App\Http\Controllers\CookieController::class)->group(function (){
    Route::get("/cookie/set",'createCookie');
    Route::get("/cookie/get",'getCookie');
    Route::get("/cookie/clear",'clearCookie');
});

Route::get('/redirect/from', [\App\Http\Controllers\RedirectContrller::class, 'redirectFrom']);
Route::get('/redirect/to', [\App\Http\Controllers\RedirectContrller::class, 'redirectTo']);
Route::get('redirect/name', [\App\Http\Controllers\RedirectContrller::class, 'redirectName']);
Route::get('redirect/name/{name}', [\App\Http\Controllers\RedirectContrller::class, 'redirectHello'])
    ->name('redirect-hello');
Route::get('redirect/named', function (){
//    return route('redirect-hello', ['name' => 'Bram']);
//    return url()->route('redirect-hello', ['name' => 'Bram']);
    return URL::route('redirect-hello', ['name' => 'Bram']);
});

Route::get('redirect/action', [\App\Http\Controllers\RedirectContrller::class, 'redirectAction']);    
Route::get('redirect/away', [\App\Http\Controllers\RedirectContrller::class, 'redirectAway']);

Route::middleware(['contoh:PZN,401'])->prefix('/middleware')->group(function (){
    Route::get('/api', function(){
        return "OK";
    });
    Route::get('/group', function(){
        return "GROUP";
    });
});

Route::get('url/action', function (){
//    return action([\App\Http\Controllers\FormController::class, 'form'], []);
//    return url()->action([\App\Http\Controllers\FormController::class, 'form'], []);
    return URL::action([\App\Http\Controllers\FormController::class, 'form'], []);
});

Route::get('/form', [\App\Http\Controllers\FormController::class, 'form']);
Route::post('/form', [\App\Http\Controllers\FormController::class, 'submitForm']);

Route::get('url/current', function (){
    return URL::full();
});

Route::get('/session/create', [\App\Http\Controllers\SessionController::class, 'createSession']);
Route::get('/session/get', [\App\Http\Controllers\SessionController::class, 'getSession']);

Route::get('/error/sample', function (){
    throw new Exception("Sample Error");
});

Route::get('/error/manual', function (){
    report(new Exception("Sample Error"));
    return "OK";
});

Route::get('/error/validation', function (){
    throw new \App\Exceptions\ValidationException("Validation Error");
});     

 Route::get('/abort/400', function(){
    abort(400, "Ups Validation Error");
 });
 Route::get('/abort/401', function(){
    abort(401);
 });
 Route::get('/abort/500', function(){
    abort(500);
 });