<?php

use Illuminate\Support\Facades\Route;
use \Bslm\Stock\Http\Controllers\User as C;

Route::group(['middleware' => 'web', 'namespace' => 'Bslm\Stock\Http\Controllers\User'], function () {
    Route::group(['prefix' => 'stock'], function () {
        Route::get('/main-dashboard', [C\StockTradesController::class, 'mainDashboard'])->name('mainStockDashboard');
        Route::get('/dashboard', [C\StockTradesController::class, 'dashboard'])->name('stock');
        Route::get('/symbol/{slug?}', [C\StockTradesController::class, 'symbolPage'])->name('symbolPage');
        Route::get('/more-info', [C\StockEsopsController::class, 'moreInfo'])->name('stockMoreInfo');
        Route::get('/get/{id}', [C\StockSymbolChangesController::class, 'getLastPrice'])->name('stockGetLastPrice');
        Route::get('/esops', [C\StockEsopsController::class, 'esops'])->name('stockEsops');
        Route::get('/trades', [C\StockTradesController::class, 'trades'])->name('stockTrades');
        Route::get('/symbolChanges/{slug}', [C\StockSymbolChangesController::class, 'changes'])->name('stockChanges');
        Route::get('/test/{symbol_id}', [C\StockEsopsController::class, 'nonVestedValue'])->name('stockNonVestedValue');
        Route::get('/tradeAds', [C\StockTradeAdsController::class, 'index'])->name('tradeAds');
        Route::get('/tradeGuide', [C\StockTradeAdsController::class, 'tradeGuide'])->name('tradeGuide');
    });

    Route::group(['prefix' => 'trade'], function () {
        Route::post('/delete', [C\StockTradeAdsController::class, 'delete'])->name('tradeDelete');
        Route::post('/newTradeAd', [C\StockTradeAdsController::class, 'newTradeAd'])->name('newTrade');
//        Route::post('/goForTrade', [C\TradeAdsController::class, 'goForTrade'])->name('goTrade);
    });
});
