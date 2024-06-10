<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// get 表示するだけ 、１番最初のページ
// post　前のページからフォームを受け取るとき

// 掲示板
Route::get('/boards', 'BoardsController@index')->name('boards.index');
// プレビュー
Route::post('/boards/preview', 'BoardsController@preview')->name('boards.preview');
// 完了
Route::post('/boards/complete', 'BoardsController@complete')->name('boards.complete');

// 返信
Route::get('/replies', 'BoardsController@replies')->name('replies.index');
// Route::get('/replies', 'BoardsController@replies');
// 返信　プレビュー
Route::post('/replies/preview', 'BoardsController@repliespreview')->name('replies.preview');

// 返信完了
Route::post('/replies/complete', 'BoardsController@repliescomplete')->name('replies.complete');

// 削除処理
Route::post('/delete', 'BoardsController@delete')->name('delete.index');
Route::get('/delete', 'BoardsController@delete');

// 削除完了
Route::post('/delete/complete', 'BoardsController@deletecomplete')->name('delete.complete');

// 読み込み password入力画面
Route::get('/read', 'BoardsController@read')->name('read.index');
//　再読み込み password入力画面
// Route::get('/read/complete', 'BoardsController@readcomplete')->name('read.complete');
// 編集確認 編集開始 edit_top
Route::get('/edit', 'BoardsController@edit')->name('edit.index');
// 編集完了 edit_thanks
Route::post('/edit/complete', 'BoardsController@editcomplete')->name('edit.complete');

// 検索開始 
Route::get('/search', 'BoardsController@search')->name('search.index');
// 検索完了 
Route::post('/search/complete', 'BoardsController@searchcomplete')->name('search.complete');