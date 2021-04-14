<?php

// use App\Models\Product; //for test in `Postman`
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
// api/products, test in `Postman` GET:http://127.0.0.1:8000/api/products
// Map the route 'products' for the method 'index' in the controller 'ProductController', so all are fetched from controller.



// This will give us all the routes for `CRUD`: see in terminal `php artisan route:list`
// Route::resource('products', ProductController::class);

// Public routes:
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

// Add a search function in Controller
Route::get('products/search/{name}', [ProductController::class, 'search']);

// Protect our routes 'search' here, test in `Postman`, result == "message": "Unauthenticated.", make sure `header accept application/json`
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('products', [ProductController::class, 'store']);
    Route::put('products/{id}', [ProductController::class, 'update']);
    Route::delete('products/{id}', [ProductController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
