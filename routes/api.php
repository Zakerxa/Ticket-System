<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;


// Protected Route
Route::group(['middleware'=>['auth:sanctum']],function(){

    // Auth User
    Route::get('user',[AuthController::class,'index']);
    Route::get('user/logout',[AuthController::class,'logout']);

    // Ticket
    Route::get('user/tickets',[TicketController::class,'index']);
    Route::post('user/ticket/{id}',[TicketController::class,'show']);
    Route::post('user/create/ticket',[TicketController::class,'store']);
    Route::post('user/edit/ticket/{id}',[TicketController::class,'edit']);
    Route::post('user/delete/ticket/{id}',[TicketController::class,'destory']);

    // Log
    Route::get('user/log',[LogController::class,'index']);
});


// Public Route
Route::post('user/register',[AuthController::class,'register']);
Route::post('user/login',[AuthController::class,'login']);


