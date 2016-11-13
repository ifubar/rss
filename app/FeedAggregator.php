<?php


namespace App;


class FeedAggregator
{
    protected $urls;

    protected $items = [];

    protected $xmlns = [];

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


    public function __construct(array $urls)
    {
        $this->urls = $urls;
        $this->parseFeeds();
    }

    public function getXmlns()
    {
        return $this->xmlns;
    }

    public function getItems($count = 50)
    {
        $items = $this->items;
        usort($items, function ($x, $y) {
            return strtotime($y['pubDate']) - strtotime($x['pubDate']);
        });
        $items = array_slice($items, 0, $count);

        return $items;
    }

    protected function parseFeeds()
    {
        foreach ($this->urls as $feed) {
            try {
                $ch = \curl_init();
                curl_setopt($ch, CURLOPT_URL, $feed);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $output = curl_exec($ch);
                curl_close($ch);
                $xml = simplexml_load_string($output);
                $this->children($xml);
                $this->parseNs($xml);
            } catch (\Exception $e) {
                //
            }
        }

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
        $namespaces = ($xml->getNamespaces(true));
        $entry = new \SimpleXMLElement('<entry/>');

        if (empty($namespaces[""])) {
            $namespaces[""] = 'http://www.w3.org/2005/Atom';
        }

        foreach($namespaces as $ns => $nsLink) {
            foreach ($xml->children($ns, true) as $k => $v) {

                if (in_array($k, array_keys($this->mapper))) {
                    $newKey = $this->mapper[$k];

                    $data = htmlspecialchars($v->__toString(), ENT_QUOTES, 'UTF-8');
                    $nk = new \SimpleXMLElement("<$newKey>" . $data . "</$newKey>");

                    foreach ($v->attributes() as $ak => $av) {
                        $nk->addAttribute($ak, $av);
                    }

                    foreach ($v->children() as $subKey => $subVal) {
                        $nk->addChild($subKey, $subVal);
                    }

                    $this->sxmlAppend($entry, $nk);
                    continue;
                }

                $this->sxmlAppend($entry, $v);
            };
        }

        $domxml = dom_import_simplexml($entry);
        array_push($this->items, [
            'xml' => $domxml->ownerDocument->saveXML($domxml->ownerDocument->documentElement),
            'pubDate' => (string) $entry->published,
        ]);
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

    protected function sxmlAppend(\SimpleXMLElement $to, \SimpleXMLElement $from) {
        $toDom = dom_import_simplexml($to);
        $fromDom = dom_import_simplexml($from);
        $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
    }

}
