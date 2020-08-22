<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'BlockexplorerController@listBlocks');

Route::get('/search/{something}', 'BlockexplorerController@search');

Route::get('/browser/{block}', 'BlockexplorerController@listBlocks');

Route::get('/block/{block}', 'BlockexplorerController@showBlock');

Route::get('/tx/{transaction}', 'BlockexplorerController@showTransaction');


Route::group(['prefix' => 'stats'], function () {

	Route::get('', 'StatsController@index');
	Route::get('blockchain-growth', 'StatsController@showBlockchainGrowth');
	Route::get('transaction-stats', 'StatsController@showTransactionsStats');
	Route::get('transactions/{period}/{records}', 'StatsController@showTransactionStats');
//	Route::get('block-medians', 'StatsController@showBlockMedians');
	Route::get('block-medians', 'StatsController@showBlockMediansHistory');
	Route::get('ring-size', 'StatsController@showRingSize');
	Route::get('ringct-transactions', 'StatsController@showRingCTTransactions');
	Route::get('transaction-average', 'StatsController@showAverageTransactions');
});



Route::get('/richlist', 'StaticPagesController@richlist');

Route::get('/api', 'StaticPagesController@api');
Route::get('/api/get_stats', 'APIController@getStats');
Route::get('/api/get_block_header/{block}', 'APIController@getBlockHeader');
Route::get('/api/get_block_data/{block}', 'APIController@getBlockData');
Route::get('/api/get_transaction_data/{hash}', 'APIController@getTransactionData');
Route::get('/api/is_key_image_spent/{hash}', 'APIController@isKeyImageSpent');


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
