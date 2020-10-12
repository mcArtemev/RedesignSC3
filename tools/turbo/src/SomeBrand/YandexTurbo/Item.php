<?php

namespace tools\turbo\src\SomeBrand\YandexTurbo;

class Item
{
    protected $turbo;

    protected $title;

    protected $link;

    protected $category;

    protected $pubDate;

    protected $author;

    protected $fullText;

    protected $turboSource;

    protected $turboTopic;

    protected $turboContent;

    protected $relatedItemsList;

    public function __construct( $turbo = true )
    {
        $this->turbo = $turbo;
    }

    public function title( $title )
    {
        $title = (mb_strlen($title) > 240) ? mb_substr($title, 0, 239) . '…' : $title;
        $this->title = $title;
        return $this;
    }

    public function link( $link )
    {
        $this->link = $link;
        return $this;
    }

    public function category( $category )
    {
        $this->category = $category;
        return $this;
    }

    public function pubDate( $pubDate )
    {
        $this->pubDate = $pubDate;
        return $this;
    }

    public function turboSource( $turboSource )
    {
        $this->turboSource = $turboSource;
        return $this;
    }

    public function turboTopic( $turboTopic )
    {
        $this->turboTopic = $turboTopic;
        return $this;
    }

    public function turboContent( $turboContent )
    {
        $this->turboContent = $turboContent;
        return $this;
    }

    public function author( $author )
    {
        $this->author = $author;
        return $this;
    }

    public function fullText( $fullText )
    {
        $this->fullText = $fullText;
        return $this;
    }

    public function appendTo( $channel )
    {
        $channel->addItem($this);
        return $this;
    }

    public function addRelatedItemsList( $relatedItemsList )
    {
        $this->relatedItemsList = $relatedItemsList;
        return $this;
    }

    public function asXML()
    {
        $isTurboEnabled = $this->turbo ? 'true' : 'false';

        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><item turbo="' . $isTurboEnabled
            . '"></item>', LIBXML_NOERROR | LIBXML_ERR_NONE | LIBXML_ERR_FATAL);

        $xml->addChild('title', $this->title);
        $xml->addChild('link', $this->link);
        $xml->addCdataChild('turbo:content', $this->turboContent, 'http://turbo.yandex.ru');

        $xml->addChildWithValueChecking('pubDate', date(DATE_RSS, $this->pubDate));
        $xml->addChildWithValueChecking('category', $this->category);
        $xml->addChildWithValueChecking('author', $this->author);
        $xml->addChildWithValueChecking('yandex:full-text', $this->fullText, 'http://news.yandex.ru');
        $xml->addChildWithValueChecking('turbo:topic', $this->turboTopic, 'http://turbo.yandex.ru');
        $xml->addChildWithValueChecking('turbo:source', $this->turboSource, 'http://turbo.yandex.ru');

        if ($this->relatedItemsList) {
            $toDom = dom_import_simplexml($xml);
            $fromDom = dom_import_simplexml($this->relatedItemsList->asXML());
            $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
        }

        return $xml;
    }
}
