<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

Route::get('/page', function(){
    return view('page');
});

// Route utama
Route::prefix('dashboard')->middleware('auth')->group(function () {
    
    // dashboard route
    Route::get('/', function () { return view('dashboard');
    })->name('dashboard');

    // user routes
    Route::controller(UserController::class)->prefix('users')->group(function(){
        Route::get('/', 'index')->name('users');
        Route::get('{slug}/show', 'show')->name('users.show');
        Route::get('create', 'create')->name('users.create');
        Route::post('store', 'store')->name('users.store');
        Route::get('{slug}/edit', 'edit')->name('users.edit');
        Route::put('{id}/update', 'update')->name('users.update');
        Route::delete('{id}/delete', 'destroy')->name('users.delete');
        Route::put('{id}/change-password', 'changePassword')->name('users.change.password');
        Route::get('trashed', 'trashed')->name('users.trashed');
        Route::delete('trashed/delete/{id}', 'forceDelete')->name('users.force.delete');
        Route::delete('trashed/delete-permanent-all', 'forceDeleteAll')->name('users.force.delete.all');
        Route::put('trashed/restore/{id}', 'trashRestore')->name('users.restore');
        Route::put('trashed/restore-all', 'restoreAll')->name('users.restore.all');
        Route::get('showPage', 'showPage')->name('users.show.page');
    });

    // Role routes
    Route::controller(RoleController::class)->prefix('roles')->group(function(){
        Route::get('/', 'index')->name('roles');
        Route::get('{id}/show', 'show')->name('roles.show');
        Route::get('create', 'create')->name('roles.create');
        Route::post('store', 'store')->name('roles.store');
        Route::put('{id}/update', 'update')->name('roles.update');
        Route::delete('{id}/delete', 'destroy')->name('roles.delete');
        Route::get('showPage', 'showPage')->name('roles.show.page');
    });

    // Permission route
    Route::controller(PermissionController::class)->prefix('permissions')->group(function(){
        Route::get('/', 'index')->name('permissions');
        Route::get('{id}/show', 'show')->name('permissions.show');
        Route::get('create', 'create')->name('permissions.create');
        Route::post('store', 'store')->name('permissions.store');
        Route::put('{id}/update', 'update')->name('permissions.update');
        Route::delete('{id}/delete', 'destroy')->name('permissions.delete');
        Route::get('showPage', 'showPage')->name('permissions.show.page');
    });

    // sync permission role route
    Route::controller(SyncPermissionController::class)->prefix('sync-permissions')->group(function(){
        Route::get('/', 'index')->name('sync.permissions');
        Route::get('assign', 'assign')->name('sync.permissions.assign');
        Route::post('assign', 'store')->name('sync.permissions.store');
    });

    // option route
    Route::controller(OptionController::class)->prefix('options')->group(function(){
        Route::get('/', 'index')->name('options');
        Route::put('/', 'update')->name('options.update');
    });

});

require __DIR__.'/auth.php';
