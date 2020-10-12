<?php

namespace tools\turbo\src\SomeBrand\YandexTurbo;

class Channel
{
    const AD_TYPE_YANDEX = 'Yandex';
    const AD_TYPE_ADFOX = 'AdFox';

    protected $title;

    protected $link;

    protected $description;

    protected $language;

    protected $adType;

    protected $adId;

    protected $adTurboAdId;

    protected $adCode;

    protected $items = [];

    protected $counters = [];

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

    public function description( $description )
    {
        $this->description = $description;
        return $this;
    }

    public function language( $language )
    {
        $this->language = $language;
        return $this;
    }

    public function adNetwork( $type = self::AD_TYPE_YANDEX, $id = '', $turboAdId, $code = '' )
    {
        $this->adType      = $type;
        $this->adId        = $id;
        $this->adTurboAdId = $turboAdId;
        $this->adCode      = $code;

        if ($type == self::AD_TYPE_YANDEX && !$id) {
            throw new \UnexpectedValueException('Please set id for Yandex Ad');
        }

        if ($type == self::AD_TYPE_ADFOX && !$this->adCode) {
            throw new \UnexpectedValueException('Please set code for Adfox network');
        }

        return $this;
    }

    public function addItem( $item )
    {
        $this->items[] = $item;
        return $this;
    }

    public function addCounter( $counter )
    {
        $this->counters[] = $counter;
        return $this;
    }

    public function appendTo( $feed )
    {
        $feed->addChannel($this);
        return $this;
    }

    public function asXML()
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><channel></channel>', LIBXML_NOERROR | LIBXML_ERR_NONE | LIBXML_ERR_FATAL);
        $xml->addChild('title', $this->title);
        $xml->addChild('link', $this->link);
        $xml->addChild('description', $this->description);

        $xml->addChildWithValueChecking('language', $this->language);

        if ($this->adType) {

            $adChild = $xml->addChild('yandex:adNetwork', '', 'http://news.yandex.ru');
            $adChild->addAttribute('type', $this->adType);

            if ($this->adId) {
                $adChild->addAttribute('id', $this->adId);
            }

            if ($this->adTurboAdId) {
                $adChild->addAttribute('turbo-ad-id', $this->adTurboAdId);
            }

            if ($this->adType == self::AD_TYPE_ADFOX) {
                $dom = dom_import_simplexml($adChild);
                $elementOwner = $dom->ownerDocument;
                $dom->appendChild($elementOwner->createCDATASection($this->adCode));
            }
        }

        foreach ($this->counters as $counter) {
            $toDom = dom_import_simplexml($xml);
            $fromDom = dom_import_simplexml($counter->asXML());
            $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
        }

        foreach ($this->items as $item) {
            $toDom = dom_import_simplexml($xml);
            $fromDom = dom_import_simplexml($item->asXML());
            $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
        }

        return $xml;
    }
}
