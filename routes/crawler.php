<?php

Route::group(['namespace' => 'Crawler', 'prefix' => 'leech','middleware'=>'admin'], function () {
    Route::get('/', ['as' => 'crawler.index', 'uses' => 'CrawlerController@index']);
});
