<?php print '<?xml version="1.0" encoding="UTF-8" ?>'; ?>

<feed @foreach($xmlns as $k => $v) xmlns:{{ $k }}="{{ $v }}" @endforeach xmlns="http://www.w3.org/2005/Atom">
    <title>Mixed Feed</title>
    <link rel="alternate" href="http://37.194.21.81"/>
    <author>
        <name>Mixed Feed</name>
        <uri>http://37.194.21.81</uri>
    </author>
    <published>2013-07-23T21:32:27+00:00</published>
    @foreach($items as $item)
        {!! $item['xml'] !!}
    @endforeach
</feed>