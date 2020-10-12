<?php

namespace tools\turbo\src\SomeBrand\YandexTurbo;

class RelatedItem
{
    protected $title;

    protected $link;

    protected $img;

    public function __construct( $title,  $link,  $img = '' )
    {
        $this->link = $link;
        $this->title = $title;
        $this->img = $img;
    }

    public function appendTo( $relatedItemsList)
    {
        $relatedItemsList->addItem($this);
        return $this;
    }

    public function asXML()
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><link>'
            . $this->title . '</link>', LIBXML_NOERROR | LIBXML_ERR_NONE | LIBXML_ERR_FATAL);

        $xml->addAttribute('url', $this->link);

        if (!empty($this->img)) {
            $xml->addAttribute('img', $this->img);
        }

        return $xml;
    }
}
