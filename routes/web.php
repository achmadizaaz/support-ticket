<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    return view('index');
    // return view('welcome');
})->middleware(['guest']);

// Jika user belum diaktifkan
Route::get('dashboard/profile/activated', function(){
    return view('profile.is_active');
})->middleware('auth')->name('not_active');

// Route utama
Route::prefix('/')->middleware(['auth', 'active', 'verified'])->group(function () {
    
    // dashboard route
    Route::get('/dashboard', function () { return view('dashboard');
    })->name('dashboard');

    Route::controller(TicketController::class)->prefix('tickets')->group(function() {
        Route::get('/', 'index')
        ->middleware('can:read-tickets')
        ->name('ticket');
        
        Route::get('/all', 'all')
        ->middleware('can:read-all-tickets')
        ->name('ticket.all');

        Route::get('/create', 'create')
        ->middleware('can:create-tickets')
        ->name('ticket.create');

        Route::post('/create', 'store')
        ->middleware('can:create-tickets')
        ->name('ticket.store');

        Route::get('/{slug}', 'show')
        ->middleware('can:read-tickets')
        ->name('ticket.show');
        
        Route::put('/{slug}/update', 'update')
        ->middleware('can:update-tickets')
        ->name('ticket.update');

        Route::delete('/{slug}/delete', 'destroy')
        ->middleware('can:delete-tickets')
        ->name('ticket.delete');
        
        Route::put('/{slug}/status', 'status')
        ->middleware('can:update-tickets')
        ->name('ticket.update.status');

        Route::put('/{slug}/completed', 'completed')
        ->middleware('can:update-tickets')
        ->name('ticket.update.completed');

        Route::put('/{slug}/closed', 'closed')
        ->middleware('can:update-tickets')
        ->name('ticket.update.closed');
        
        Route::put('/{slug}/progress', 'progress')
        ->middleware('can:update-tickets')
        ->name('ticket.update.progress');

        
        // Comment
        Route::post('/{slug_ticket}/7MzXPCA1og73oWbqoaYF2ZOgQ', [CommentController::class, 'store'])
        // ->middleware('can:create-tickets')
        ->name('comment.store');

    });

    
    

    // Unit routes
    Route::controller(UnitController::class)->prefix('units')->group(function() {
        Route::get('/', 'index')->name('unit');
        Route::post('/', 'store')->name('unit.store');
        Route::get('/{slug}/show', 'show')->name('unit.show');
        Route::put('/{slug}/update', 'update')->name('unit.update');
        Route::delete('/{slug}/destroy', 'destroy')->name('unit.delete');
    });
    
    // Category routes
    Route::controller(CategoryController::class)->prefix('categories')->group(function() {
        Route::get('/', 'index')->name('category');
        Route::post('/', 'store')->name('category.store');
        Route::get('/{id}/show', 'show')->name('category.show');
        Route::put('/{id}/update', 'update')->name('category.update');
        Route::delete('/{id}/destroy', 'destroy')->name('category.delete');
    });
    
    // Notif Category routes
    Route::controller(NotifCategoryUserController::class)->prefix('notif-categories')->group(function() {
        Route::get('/', 'index')->name('notif.categories');
        Route::post('/', 'store')->name('notif.categories.store');
        Route::get('/{id}/show', 'show')->name('notif.categories.show');
        Route::put('/{id}/update', 'update')->name('notif.categories.update');
        Route::delete('/{user_id}/destroy', 'destroy')->name('notif.categories.delete');
    });
    
    // Profile user
    Route::controller(ProfileController::class)->prefix('profile')->group(function() {
        Route::get('/', 'index')->name('profile');
        Route::get('/edit', 'edit')->name('profile.edit');
        Route::put('/edit', 'update')->name('profile.update');
        Route::put('/change-password', 'changePassword')->name('profile.change.password');
        Route::post('/delete', 'destroy')->name('profile.delete');
    });

    // user routes
    Route::controller(UserController::class)->prefix('users')->group(function(){
        Route::get('/', 'index')
            ->middleware('can:read-users')
            ->name('users');

        Route::get('{slug}/show', 'show')
            ->middleware('can:read-users')
            ->name('users.show');

        Route::get('create', 'create')
            ->middleware('can:create-users')
            ->name('users.create');

        Route::post('store', 'store')
            ->middleware('can:create-users')
            ->name('users.store');

        Route::get('{slug}/edit', 'edit')
            ->middleware('can:update-users')
            ->name('users.edit');

        Route::put('{id}/update', 'update')
            ->middleware('can:update-users')
            ->name('users.update');

        Route::delete('{id}/delete', 'destroy')
            ->middleware('can:delete-users')
            ->name('users.delete');

        Route::put('{id}/change-password', 'changePassword')
        ->middleware('can:change-password-users')
        ->name('users.change.password');

        Route::get('trashed', 'trashed')
        ->middleware('can:read-trashed-users')
        ->name('users.trashed');

        Route::delete('trashed/delete/{id}', 'forceDelete')
        ->middleware('can:delete-trashed-users')
        ->name('users.force.delete');

        Route::delete('trashed/delete-permanent-all', 'forceDeleteAll')
        ->middleware('can:delete-all-trashed-users')
        ->name('users.force.delete.all');

        Route::put('trashed/restore/{id}', 'trashRestore')
        ->middleware('can:restore-trashed-users')
        ->name('users.restore');

        Route::put('trashed/restore-all', 'restoreAll')
        ->middleware('can:restore-all-trashed-users')
        ->name('users.restore.all');

        Route::get('showPage', 'showPage')
        ->name('users.show.page');

        Route::post('import', 'import')
        ->name('users.import');

        Route::get('/download-template-users', 'downloadTemplateUserExport')->name('users.import.template');

    });

    // Role routes
    Route::controller(RoleController::class)->prefix('roles')->group(function(){
        Route::get('/', 'index')
            ->middleware('can:read-roles')
            ->name('roles');

        Route::get('{id}/show', 'show')
            ->middleware('can:read-roles')
            ->name('roles.show');

        Route::get('create', 'create')
            ->middleware('can:create-roles')
            ->name('roles.create');

        Route::post('store', 'store')
            ->middleware('can:create-roles')
            ->name('roles.store');

        Route::put('{id}/update', 'update')
            ->middleware('can:update-roles')
            ->name('roles.update');

        Route::delete('{id}/delete', 'destroy')
            ->middleware('can:delete-roles')
            ->name('roles.delete');

        Route::get('showPage', 'showPage')
            ->name('roles.show.page');
    });

    // Permission route
    Route::controller(PermissionController::class)->prefix('permissions')->group(function(){
        Route::get('/', 'index')
            ->middleware('can:read-permissions')
            ->name('permissions');

        Route::get('{id}/show', 'show')
            ->middleware('can:read-permissions')
            ->name('permissions.show');

        Route::get('create', 'create')
            ->middleware('can:create-permissions')
            ->name('permissions.create');

        Route::post('store', 'store')
            ->middleware('can:create-permissions')
            ->name('permissions.store');

        Route::put('{id}/update', 'update')
            ->middleware('can:update-permissions')
            ->name('permissions.update');

        Route::delete('{id}/delete', 'destroy')
            ->middleware('can:delete-permissions')
            ->name('permissions.delete');

        Route::get('showPage', 'showPage')
            ->name('permissions.show.page');
    });

    // sync permission role route
    Route::controller(SyncPermissionController::class)->prefix('sync-permissions')->group(function(){
        Route::get('/', 'index')
            ->middleware('can:read-sync-permission-roles')
            ->name('sync.permissions');

        Route::get('assign', 'assign')
            ->middleware('can:create-sync-permission-roles')
            ->name('sync.permissions.assign');

        Route::post('assign', 'store')
            ->middleware('can:create-sync-permission-roles')
            ->name('sync.permissions.store');
    });

    // option route
    Route::controller(OptionController::class)->prefix('options')->group(function(){
        Route::get('/', 'index')
            ->middleware('can:read-options')
            ->name('options');
            
        Route::put('/', 'update')
            ->middleware('can:update-options')
            ->name('options.update');
    });

    Route::controller(ReportTicketController::class)->prefix('report-tickets')->group(function(){
        Route::get('/', 'index')->name('report.ticket');
        Route::post('/show', 'show')->name('report.ticket.show');
    });

});

require __DIR__.'/auth.php';
