<?php print '<?xml version="1.0" encoding="UTF-8" ?>'; ?>

<feed @foreach($xmlns as $k => $v) xmlns:{{ $k }}="{{ $v }}" @endforeach>
    <link rel="self" href="http://www.youtube.com/feeds/videos.xml?channel_id=UCqFzWxSCi39LnW1JKFR3efg"/>
    <id>yt:channel:UCqFzWxSCi39LnW1JKFR3efg</id>
    <yt:channelId>UCqFzWxSCi39LnW1JKFR3efg</yt:channelId>
    <title>Saturday Night Live</title>
    <link rel="alternate" href="http://www.youtube.com/channel/UCqFzWxSCi39LnW1JKFR3efg"/>
    <author>
        <name>Saturday Night Live</name>
        <uri>http://www.youtube.com/channel/UCqFzWxSCi39LnW1JKFR3efg</uri>
    </author>
    <published>2013-07-23T21:32:27+00:00</published>
    @foreach($items as $item)
        {!! $item !!}
    @endforeach
    <entry>
        <id>yt:video:JUhTsS8JdgQ</id>
        <yt:videoId>JUhTsS8JdgQ</yt:videoId>
        <yt:channelId>UCqFzWxSCi39LnW1JKFR3efg</yt:channelId>
        <title>Creating Saturday Night Live: Hair and Makeup - SNL</title>
        <link rel="alternate" href="http://www.youtube.com/watch?v=JUhTsS8JdgQ"/>
        <author>
            <name>Saturday Night Live</name>
            <uri>http://www.youtube.com/channel/UCqFzWxSCi39LnW1JKFR3efg</uri>
        </author>
        <published>2016-11-08T00:04:40+00:00</published>
        <updated>2016-11-08T09:52:14+00:00</updated>
        <media:group>
            <media:title>Creating Saturday Night Live: Hair and Makeup - SNL</media:title>
            <media:content url="https://www.youtube.com/v/JUhTsS8JdgQ?version=3" type="application/x-shockwave-flash" width="640" height="390"/>
            <media:thumbnail url="https://i3.ytimg.com/vi/JUhTsS8JdgQ/hqdefault.jpg" width="480" height="360"/>
            <media:description>Go behind the scenes of SNL to see what goes into creating the show's weekly looks with Jodi Mancuso and Louie Zakarian. Hear how they transformed Alec Baldwin and Kate McKinnon into Donald Trump and Hillary Clinton for the 2016 election.

                Get more SNL: http://www.nbc.com/saturday-night-live
                Full Episodes: http://www.nbc.com/saturday-night-liv...

                Like SNL: https://www.facebook.com/snl
                Follow SNL: https://twitter.com/nbcsnl
                SNL Tumblr: http://nbcsnl.tumblr.com/
                SNL Instagram: http://instagram.com/nbcsnl
                SNL Pinterest: http://www.pinterest.com/nbcsnl/

                Get more SNL on Hulu: http://www.hulu.com/saturday-night-live</media:description>
            <media:community>
                <media:starRating count="5916" average="4.97" min="1" max="5"/>
                <media:statistics views="181644"/>
            </media:community>
        </media:group>
    </entry>
</feed>
