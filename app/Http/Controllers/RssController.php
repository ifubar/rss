<?php

namespace App\Http\Controllers;

class RssController extends Controller
{
    protected $items = [];
    protected $xmlns = [];
    protected $feed;
    //RSS 2.0  to  Atom 1.0
    protected $mapper = [
        'channel' => 'feed',
        'copyright' => 'rights',
        'description' => 'content',
        'guid' => 'id',
        'image' => 'logo',
        'item' => 'entry',
        'lastBuildDate' => 'updated',
        'managingEditor' => 'author',
        'pubDate' => 'published',
    ];
    public function show()
    {
        $feeds = array(
            'https://www.youtube.com/feeds/videos.xml?channel_id=UCqFzWxSCi39LnW1JKFR3efg',
//            'http://atwar.blogs.nytimes.com/feed/',
//            'http://feeds.soundcloud.com/users/soundcloud:users:209936547/sounds.rss',
        );
        foreach ($feeds as $feed) {
            $xml = simplexml_load_file($feed);
            $this->children($xml);
            $this->parseNs($xml);
        }
        $items = $this->items;
        $xmlns = $this->xmlns;
        return response()->view('rss', compact(['items', 'xmlns']))->header('Content-Type', 'text/xml');
// Sort feed entries by pubDate (ascending)
//        usort($entries, function ($x, $y) {
//            return strtotime($x->pubDate) - strtotime($y->pubDate);
//        });
//
//        echo "<pre>";
//        print_r($entries);
//        echo "</pre>";
//        die();
    }
    protected function children(\SimpleXMLElement $xml) {
        foreach($xml->children() as $k => $v) {
            if (in_array($k, ['entry', 'item'])) {
                $this->addItem($v);
                continue;
            }
            if (in_array($k, ['channel', 'feed'])) {
                $this->children($v);
                continue;
            }
        }
    }
    protected function addItem(\SimpleXMLElement $xml) {
        $entry = new \SimpleXMLElement('<entry/>');
        foreach($xml->children() as $k => $v) {
            $nk = $k;
            if (in_array($k, array_keys($this->mapper))) {
                $nk = $this->mapper[$k];
            }
            $this->sxml_append($entry, $v);
        }
        $domxml = dom_import_simplexml($entry);
        array_push($this->items, $domxml->ownerDocument->saveXML($domxml->ownerDocument->documentElement));
    }
    protected function parseNs(\SimpleXMLElement $xml) {
        $out = [];
        foreach ($xml->getNamespaces(true) as $k => $ns) {
            if (!empty($k)) {
                $out[$k] = $ns;
            }
        }
        $this->xmlns = array_collapse([$this->xmlns, $out]);
    }

    protected function sxml_append(\SimpleXMLElement $to, \SimpleXMLElement $from) {
        $toDom = dom_import_simplexml($to);
        $fromDom = dom_import_simplexml($from);
        $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
    }
}