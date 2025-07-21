<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WaitingListController;
use Illuminate\Support\Facades\Auth;



Route::post('/waiting-list', [WaitingListController::class, 'store']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/waiting-list', [WaitingListController::class, 'index']);
    Route::put('/waiting-list/{id}', [WaitingListController::class, 'update']);
    Route::delete('/waiting-list/{id}', [WaitingListController::class, 'destroy']);
    //Route::get('/waiting-list/stats', [WaitingListStatsController::class, 'index']);
});

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = \App\Models\User::where('email', $request->email)->first();

    if (! $user || ! \Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    return response()->json([
        'token' => $user->createToken('api-token')->plainTextToken,
    ]);
});
