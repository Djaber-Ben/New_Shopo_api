<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StoreApiController;
use App\Http\Controllers\Api\SliderApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\WishlistApiController;
use App\Http\Controllers\Api\ConversationApiController;
use App\Http\Controllers\OfflinePaymentController;
use App\Http\Controllers\Api\SubscriptionPlanApiController;


// ============================================
// PUBLIC ROUTES - NO AUTHENTICATION REQUIRED
// ============================================

// User Authentication API
Route::post('/register', [AuthController::class, 'registerClient']);
Route::post('/login', [AuthController::class, 'login']);

// Stores API (Public)
Route::get('/stores', [StoreApiController::class, 'index'])->name('api.store.index');
Route::get('/stores/nearby', [StoreApiController::class, 'nearby'])->name('api.store.nearby');
Route::get('/store/{id}', [StoreApiController::class, 'show'])->name('api.store.show');

// Products API (Public)
Route::get('/products', [ProductApiController::class, 'index'])->name('api.product.index');
Route::get('/product/{id}', [ProductApiController::class, 'show'])->name('api.product.show');

// Wilayas API
Route::get('/wilaya', [StoreApiController::class, 'wilayas'])->name('api.categories.wilayas');

// Categories API
Route::get('/categories', [CategoryApiController::class, 'index'])->name('api.categories.index');
Route::get('/categories/{category}', [CategoryApiController::class, 'show'])->name('api.categories.show');

// Sliders API
Route::get('/sliders', [SliderApiController::class, 'index'])->name('api.sliders.index');
Route::get('/sliders/{slider}', [SliderApiController::class, 'show'])->name('api.sliders.show');

  // Offline Payment API
  Route::get('/offline-payments', [OfflinePaymentController::class, 'show'])->name('offline-payments.show');

  // Subscription plans API
  Route::get('/offline-payment', [OfflinePaymentController::class, 'show']);
  Route::get('/subscription-plans', [SubscriptionPlanApiController::class, 'index']);
  Route::get('/subscription-plans/{subscription_plan}', [SubscriptionPlanApiController::class, 'show']);

// ============================================
// PROTECTED ROUTES - AUTHENTICATION REQUIRED
// ============================================

Route::middleware('auth:sanctum')->group(function () {

  // Logout
  Route::post('/logout', [AuthController::class, 'logout']);

  // Get current authenticated user
  Route::get('/user', function (Request $request) {
    return response()->json($request->user());
  });

  // User Management
  Route::get('/user/{id}', [AuthController::class, 'edit'])->name('api.user.edit');
  Route::put('/user/{id}', [AuthController::class, 'update'])->name('api.user.update');
  Route::post('/user/update-type', [AuthController::class, 'updateUserType'])->name('api.user.updateType');

  // User's Stores
  Route::get('/user/{id}/stores', [StoreApiController::class, 'userStores'])->name('api.user.stores');

  // Store Management (Protected)
  // Route::get('/stores/{id}', [StoreApiController::class, 'show']);
  Route::get('/stores/create', [StoreApiController::class, 'create'])->name('api.store.create');
  Route::post('/stores/store', [StoreApiController::class, 'store'])->name('api.store.store');
  Route::post('/stores/auto-create', [StoreApiController::class, 'autoCreate'])->name('api.stores.autoCreate');
  Route::get('/stores/{id}/edit', [StoreApiController::class, 'edit'])->name('api.store.edit');
  Route::put('/stores/{id}', [StoreApiController::class, 'update'])->name('api.store.update');
  Route::delete('/stores/{id}', [StoreApiController::class, 'destroy'])->name('api.store.destroy');

  // Product Management (Protected)
  Route::get('/product/create', [ProductApiController::class, 'create'])->name('api.product.create');
  Route::post('/product/store', [ProductApiController::class, 'store'])->name('api.product.store');
  Route::get('/product/{id}/edit', [ProductApiController::class, 'edit'])->name('api.product.edit');
  Route::put('/product/{id}', [ProductApiController::class, 'update'])->name('api.product.update');
  Route::delete('/product/{id}', [ProductApiController::class, 'destroy'])->name('api.product.destroy');

  // Wishlist API
  Route::get('/wishlist', [WishlistApiController::class, 'index'])->name('api.wishlist.index');
  Route::post('/wishlist/store', [WishlistApiController::class, 'store'])->name('api.wishlist.store');
  Route::delete('/wishlist/{product_id}', [WishlistApiController::class, 'destroy'])->name('api.wishlist.destroy');

  // Conversations API
  Route::get('/conversations', [ConversationApiController::class, 'index'])->name('api.conversations.index');
  Route::post('/conversations/start', [ConversationApiController::class, 'startConversation'])->name('api.conversations.start');
  Route::post('/conversations/{id}/send-message', [ConversationApiController::class, 'sendMessage'])->name('api.conversations.send');
  Route::get('/conversations/{id}/messages', [ConversationApiController::class, 'getMessages'])->name('api.conversations.messages');

  // Subscription plans API
  Route::post('/subscription-plans/subscribe', [SubscriptionPlanApiController::class, 'subscribe']);
});