<?php

namespace App\Http\Controllers;

use App\FeedAggregator;

class FeedController extends Controller
{
    public function show()
    {

        $feed = new FeedAggregator([
//            'https://www.youtube.com/feeds/videos.xml?channel_id=UCqFzWxSCi39LnW1JKFR3efg',
//            'http://atwar.blogs.nytimes.com/feed/',
//            'http://feeds.soundcloud.com/users/soundcloud:users:209936547/sounds.rss',

            'http://boss.blogs.nytimes.com/feed/',
            'http://learning.blogs.nytimes.com/feed/'

        ]);

        $items = $feed->getItems();
        $xmlns = $feed->getXmlns();

        //pass own props
        $feedTitle = 'Mixed Feed';
        $feedUrl = 'http://37.194.21.81';
        $feedPublished = '2013-07-23T21:32:27+00:00';

        return response()->view('rss', compact([
            'items',
            'xmlns',
            'feedTitle',
            'feedUrl',
            'feedPublished'
        ]))->header('Content-Type', 'text/xml');

    }
}