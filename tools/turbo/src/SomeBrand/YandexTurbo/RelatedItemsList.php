<?php

namespace tools\turbo\src\SomeBrand\YandexTurbo;

class RelatedItemsList
{
    protected $relatedItems = [];

    protected $infinity;

    public function __construct( $infinity = false )
    {
        $this->infinity = $infinity;
    }

    public function appendTo( $item )
    {
        $item->addRelatedItemsList($this);
        return $this;
    }

    public function addItem( $relatedItem )
    {
        $this->relatedItems[] = $relatedItem;
        return $this;
    }

    public function asXML()
    {
        $infinity = $this->infinity ? 'type="infinity"' : '';

        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><yandex:related '
            . $infinity . '></yandex:related>',
            LIBXML_NOERROR | LIBXML_ERR_NONE | LIBXML_ERR_FATAL);

        foreach ($this->relatedItems as $item) {
            $toDom = dom_import_simplexml($xml);
            $fromDom = dom_import_simplexml($item->asXML());
            $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
        }

        return $xml;
    }
}
