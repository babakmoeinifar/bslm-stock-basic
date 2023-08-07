<?php

use \Bslm\Stock\Http\Controllers\Admin as C;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin/stock', 'middleware' => 'web', 'namespace' => 'Bslm\Stock\Http\Controllers\Admin'], function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/lastPrice/{symbol_id}', [C\StockSymbolChangesController::class, 'lastPrice']);
        Route::get('/lastPrice', [C\StockSymbolChangesController::class, 'lastPrice']);

        Route::get('/symbolChanges', [C\StockSymbolChangesController::class, 'index']);
        Route::get('/symbolChanges/{slug}', [C\StockSymbolChangesController::class, 'index']);
        Route::get('/symbolChanges/{id}/edit', [C\StockSymbolChangesController::class, 'edit']);
        Route::post('/symbolChanges/edit', [C\StockSymbolChangesController::class, 'editSubmit']);
        Route::get('/symbolChanges/{slug}/new', [C\StockSymbolChangesController::class, 'new']);
        Route::post('/symbolChanges/{slug}/new', [C\StockSymbolChangesController::class, 'newSubmit']);

        Route::get('/symbol', [C\StockSymbolController::class, 'index']);
        Route::get('/symbol/new', [C\StockSymbolController::class, 'new']);
        Route::post('/symbol/new', [C\StockSymbolController::class, 'newSubmit']);
        Route::get('/symbol/{id}/edit', [C\StockSymbolController::class, 'edit']);
        Route::post('/symbol/edit', [C\StockSymbolController::class, 'editSubmit']);

        Route::get('/esops', [C\StockEsopsController::class, 'index']);
        Route::get('/esops/new', [C\StockEsopsController::class, 'new']);
        Route::get('/esops/{userid}', [C\StockEsopsController::class, 'index']);
        Route::get('/esops/new/{userid}', [C\StockEsopsController::class, 'new']);
        Route::get('/esops/new', [C\StockEsopsController::class, 'new']);
        //Route::post('/esops/{userid}/new', [C\StockEsopsController::class, 'newSubmit']);
        Route::post('/esops/new/{userid}', [C\StockEsopsController::class, 'newSubmit']);
        Route::post('/esops/new/', [C\StockEsopsController::class, 'newSubmit']);
        Route::post('/esops/vest/{esopid}', [C\StockEsopsController::class, 'vestSubmit']);
        Route::post('/esops/expire/{esopId}', [C\StockEsopsController::class, 'expireSubmit']);

        Route::get('/esops/edit/{esopid}', [C\StockEsopsController::class, 'edit']);
        Route::post('/esops/edit/{esopid}', [C\StockEsopsController::class, 'editSubmit']);

        Route::get('/trades', [C\StockTradesController::class, 'index']);
        Route::get('/trades/{userid}', [C\StockTradesController::class, 'index']);
        Route::post('/trades', [C\StockTradesController::class, 'trade']);

        Route::get('/trades-history', [C\StockTradesController::class, 'tradeHistory']);
        Route::get('/trades-history/create', [C\StockTradesController::class, 'tradeHistoryCreate']);
        Route::post('/trades-history/create', [C\StockTradesController::class, 'tradeHistoryCreateSubmit']);
        Route::get('/trades-history/{id}', [C\StockTradesController::class, 'tradeHistoryEdit']);
        Route::post('/trades-history/{id}', [C\StockTradesController::class, 'tradeHistoryEditSubmit']);
        Route::delete('/trades-history/{id}', [C\StockTradesController::class, 'tradeHistoryDestroy']);
    });
});