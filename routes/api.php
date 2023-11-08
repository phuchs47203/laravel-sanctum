<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\Comment;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::resource('products', ProductController::class);

//public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/products/search/{name}', [ProductController::class, 'search']);
Route::get('/csrf-token', function () {
    return response()->json(['csrfToken' => csrf_token()]);
});
//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/users', [UserController::class, 'show']);
});
//
//
///
//
//
//
//grehn kgrngr 



// 
Route::post('/comment', function () {
    $product = Product::find(2);
    if (!$product) {
        return 'product not found';
    }
    return Comment::create([
        'reviews' => 'nice' . '' . $product['name'],
        'product_id' => $product['id'],
        'star' => '5'
    ]);
});
Route::get('product/comment', function () {
    $comments = Product::find(16)->comments;

    return $comments;
});
Route::get('comment', function () {
    $comments = Comment::all();

    return $comments;
});
Route::get('product/comment/{id}', function ($id) {
    $comments = Product::find($id)->comments;

    return $comments;
});

// Route::get('/products', [ProductController::class, 'index']);
// Route::post('/products', [ProductController::class, 'store']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


///
// EMAIL VERTIFICATION
// 
// To properly implement email verification, three routes will need to be defined.
//  First, a route will be needed to display a notice to the user that they should click the email verification link in the verification email that Laravel sent them after registration.

// Second, a route will be needed to handle requests generated when the user clicks the email verification link in the email.

// Third, a route will be needed to resend a verification link if the user accidentally loses the first verification link.

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');



Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');



Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

//Protecting Routes
Route::get('/profile', function () {
    // Only verified users may access this route...
})->middleware(['auth', 'verified']);
