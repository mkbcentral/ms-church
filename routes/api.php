<?php

use App\Http\Controllers\Api\Church\ChurchesToFollowController;
use App\Http\Controllers\Api\Church\CrudChurchController;
use App\Http\Controllers\Api\Church\FollowChurchController;
use App\Http\Controllers\Api\Preaching\CrudPreachingController;
use App\Http\Controllers\Api\Preaching\FollowPreachingController;
use App\Http\Controllers\Api\Preaching\PreachingFroFollowedChurchController;
use App\Http\Controllers\Api\Preaching\RecentPreachingsController;
use App\Http\Controllers\Api\User\LoginUserController;
use App\Http\Controllers\Api\User\LogoutController;
use App\Http\Controllers\Api\User\RegisterNewUserController;
use App\Http\Controllers\Api\User\UpdateProfileController;
use App\Http\Controllers\Api\User\UserProfileController;
use Illuminate\Support\Facades\Route;


Route::prefix('user')->group(function (){
    Route::post('register',RegisterNewUserController::class)->name('auth.register');
    Route::post('login',LoginUserController::class)->name('auth.login');
    Route::middleware('auth:sanctum')->group(function (){
        Route::get('logout',LogoutController::class)->name('auth.logout');
        Route::put('update',UpdateProfileController::class)->name('auth.update.profile');
        Route::get('profile',UserProfileController::class)->name('auth.profile');
        Route::get('/followed-churches', [FollowChurchController::class, 'followedChurches']);
    });
});

Route::middleware('auth:sanctum')->group(function (){
    Route::apiResource('church',CrudChurchController::class);
    Route::apiResource('preaching',CrudPreachingController::class);

    //Liste des aglise à suivre
    Route::get('churches-to-follow',[ChurchesToFollowController::class,'index'])
        ->name('churches-to-follow');
    //Suivre une eglise
    Route::post('/church/{church}/follow', [FollowChurchController::class, 'follow'])
        ->name('church.follow');
    //Ne pas suivre une eglise
    Route::post('/church/{church}/unfollow', [FollowChurchController::class, 'unfollow'])
        ->name('church.unfollow');
    //Preches pour les eglises que l'utilisateur suit déjà
    Route::get('/preaching-followed',[PreachingFroFollowedChurchController::class,'preachings'])
        ->name('preaching.followed');
    //Preches recommandées
    Route::get('recommendations',[FollowPreachingController::class,'recommendations'])
        ->name('preaching.recommendations');
    //Recommander une preche
    Route::post('preaching/{preaching}/follow',[FollowPreachingController::class,'follow'])
        ->name('preaching.follow');
    //Recents preachings
    Route::get('recent-preachings',[RecentPreachingsController::class,'index'])
        ->name('preaching.recent');
});

