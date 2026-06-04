<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageArticlesController;
use App\Http\Controllers\HubController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\TestController as AdminTestController;
use App\Http\Controllers\Admin\TestQuestionController;


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

Route::get('/tests/{test}', [TestController::class, 'show'])->name('tests.show');
Route::post('/tests/{test}', [TestController::class, 'submit'])
    ->middleware('auth')
    ->name('tests.submit');

Route::get('/hub/{slug}', [PageArticlesController::class, 'show'])
    ->middleware(['permission:view articles'])
    ->where('slug', '^[A-Za-z0-9\-]+$')
    ->name('hub.section');

Route::get('/tests/{test}', [TestController::class, 'show'])
    ->middleware(['permission:view articles'])
    ->name('tests.show');

Route::post('/tests/{test}', [TestController::class, 'submit'])
    ->middleware(['auth', 'permission:take tests'])
    ->name('tests.submit');

Route::middleware(['auth', 'permission:edit tests'])->group(function () {

});

Route::middleware(['auth', 'permission:edit articles'])->group(function () {
});



Route::get('/', function () {
    return view('welcome');
});
Route::get('/hub', [HubController::class, 'index'])->name('hub.index');
Route::get('/hub/{slug}', [PageArticlesController::class, 'show'])
    ->where('slug', '^[A-Za-z0-9\-]+$')
    ->name('hub.section');

Route::get('/hub/Slovencina1', fn () =>
app(PageArticlesController::class)->show('Slovencina1')
)->name('hub.slovencina1');


Route::get('/hub/Slovencina2', fn () =>
app(PageArticlesController::class)->show('Slovencina2')
)->name('hub.slovencina2');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.hub');
    })->middleware('permission:edit tests|edit articles')
        ->name('admin.hub');

    Route::middleware('permission:edit articles')->prefix('admin/articles')->name('admin.articles.')->group(function () {
        Route::get('/',         [ArticleController::class, 'index'])->name('index');
        Route::get('/create',   [ArticleController::class, 'create'])->name('create');
        Route::post('/',        [ArticleController::class, 'store'])->name('store');
        Route::get('/{article}/edit', [ArticleController::class, 'edit'])->name('edit');
        Route::put('/{article}',       [ArticleController::class, 'update'])->name('update');
        Route::delete('/{article}',    [ArticleController::class, 'destroy'])->name('destroy');
    });

    Route::middleware(['auth', PermissionMiddleware::class . ':edit tests'])
        ->prefix('admin/tests')->name('admin.tests.')->group(function () {
            Route::get('/',               [AdminTestController::class, 'index'])->name('index');
            Route::get('/create',         [AdminTestController::class, 'create'])->name('create');
            Route::post('/',              [AdminTestController::class, 'store'])->name('store');
            Route::get('/{test}/edit',    [AdminTestController::class, 'edit'])->name('edit');
            Route::put('/{test}',         [AdminTestController::class, 'update'])->name('update');
            Route::delete('/{test}',      [AdminTestController::class, 'destroy'])->name('destroy');

            Route::get('/{test}/questions',  [TestQuestionController::class, 'edit'])->name('questions');
            Route::post('/{test}/questions', [TestQuestionController::class, 'update'])->name('questions.update');
        });

});

require __DIR__.'/auth.php';

