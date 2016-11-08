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

Route::get('/', function () {



    $feeds = array(
        'https://www.youtube.com/feeds/videos.xml?channel_id=UCqFzWxSCi39LnW1JKFR3efg',
//        'http://atwar.blogs.nytimes.com/feed/',
        // etc.
    );

// Get all feed entries
    $entries = array();
    foreach ($feeds as $feed) {
        $xml = simplexml_load_file($feed);
//        $entries = array_merge($entries, $xml->xpath('/rss//item'));
        foreach ($xml->children() as $prop => $items) {
            if ($prop == 'entry') {
                var_dump($items);
            }

        }
//        var_dump($xml->children());die();
//        var_dump($xml->xpath('/feed/entry'));
        die();
        $entries = array_merge($entries, $xml->children('entry'));
    }

// Sort feed entries by pubDate (ascending)
    usort($entries, function ($x, $y) {
        return strtotime($x->pubDate) - strtotime($y->pubDate);
    });

    echo "<pre>";
    print_r($entries);
    echo "</pre>";
    die();



    //return view('welcome');
});
