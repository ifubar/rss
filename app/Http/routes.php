<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/feed', 'Rss2Controller@show');
Route::get('/feed2', function() {
    $xml = simplexml_load_file('http://atwar.blogs.nytimes.com/feed/');
    //echo $xml->asXML();

    return response($xml->asXML())->header('Content-Type', 'text/xml');
});


Route::get('/feeder', 'FeedController@show');

