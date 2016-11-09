<?php print '<?xml version="1.0" encoding="UTF-8" ?>'; ?>

<feed @foreach($xmlns as $k => $v) xmlns:{{ $k }}="{{ $v }}" @endforeach xmlns="http://www.w3.org/2005/Atom">
    <title>{{ $feedTitle }}</title>
    <link rel="alternate" href="{{ $feedUrl }}"/>
    <author>
        <name>{{ $feedTitle }}</name>
        <uri>{{ $feedUrl }}</uri>
    </author>
    <published>{{ $feedPublished }}</published>
    @foreach($items as $item)
        {!! $item['xml'] !!}
    @endforeach
</feed>