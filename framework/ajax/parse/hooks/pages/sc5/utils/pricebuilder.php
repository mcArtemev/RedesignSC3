<?php

namespace framework\ajax\parse\hooks\pages\sc5\utils;

use framework\tools;

class pricebuilder
{
    private $data;
    private $actualTypes;
    private $allDevises;
    private $marka;
    private $markaLower;
    private $accord2;
    private $accord;
    private $i = 1;
    private $apple_device_type;
    private $siteId;
    private $ring;

    public function __construct($site_id, $data, $all_devises, $marka)
    {
        $this->data = $data;
        $this->allDevises = $all_devises;
        $this->marka = $marka;
        $this->markaLower = mb_strtolower($this->marka);
        $this->siteId = $site_id;

        $this->ring = 20;

        $this->setAppleDeviceType();
        $this->setActualTypes();
        $this->setAccord2();
        $this->setAccord();
    }

    public function render()
    {
        $html = $this->buildItemTabs();
        return $html;
    }

    private function buildItemTabs()
    {
        $contentHtml = '';
        $html = '<div>';
        $html .= '<div class="services-list owl-carousel owl-theme owl-loaded nav nav-tabs" role="tablist" id="zamena-tabs">';
        foreach ($this->allDevises as $devise) {
            $type = $devise['type'];
            if (!in_array($type, $this->actualTypes)) continue;
            if (!isset($this->data[$type])) continue;

            $html .= '<div  role="presentation" class="item'.(($this->i==1)? " active" : "").'">';
            $html .= '<a href="#zamena-tabs-'.$this->i.'" aria-controls="zamena-tabs-'.$this->i.'" role="tab" data-toggle="tab" class="service-link">';
            $html .= '<div class="service-images contain-img" style="background-image: url(/bitrix/templates/remont/images/'.$this->markaLower.'/'.$this->accord2[$type].'-mini.png)">';
            $html .= '<img src="/bitrix/templates/remont/images/shared/empty-service.png">';
            $html .= '</div>';

            if ($this->markaLower == 'apple') {
                $html .=  '<div class="service-title">'.$this->apple_device_type[$type].'</div>';
            } else {
                $html .= '<div class="service-title">'.tools::mb_ucfirst($type).'</div>';
            }

            $html .= '</a>';
            $html .= '</div>'; // Item

            $contentHtml .= $this->buildItemContentPopularView($type);

            $this->i++;
        }
        $html .= '</div>'; //Services list
        $html .= '<div class="tab-content">';
        $html .= $contentHtml;
        $html .= '</div>';

        $html .= '</div>'; //TabPanel list

        return $html;
    }

    private function buildItemContentPopularView($type = '')
    {

        $wrapperHtml = '<div role="tabpanel" class="tab-pane fade price-content'.(($this->i==1)? " in active" : "").'" id="zamena-tabs-'.$this->i.'">';
        $wrapperHtml .= '<div class="model-list index-popular">';
        $wrapperHtml .= '<div class="model-group-items">';
        $wrapperHtml .= '<ul class="row">';

        $itemHtml = '';
        $showMore = false;

        foreach ($this->data[$type] as $k => $model) {

            $max_model_name_length = 20;
            if ($max_model_name_length < strlen($model['name'])) {
                $model_name = substr($model['name'], 0, $max_model_name_length);
                $model_name .= ' ...';
            } else {
                $model_name = $model['name'];
            }

            if ($k >= $this->ring && $k%$this->ring === 0)
            {
                $itemHtml .=  '</ul>';
                $itemHtml .=  '<ul class="row" style="display: none">';
                $showMore = true;
            }
            $itemHtml .= '<li class="col-sm-3 col-xs-6"><a href="/'.tools::search_url($this->siteId, serialize(array('model_id' => $model['id'], 'key' => 'service', 'id' => $this->accord[tools::get_suffics($type)]))).'/">'.$model_name.'</a></li>';
        }

        $wrapperHtml .= $itemHtml;
        $wrapperHtml .= '</ul>';
        $wrapperHtml .= '</div>';
        if ($showMore)
            $wrapperHtml .= '<a href="#" class="js-show">Показать другие модели</a>';
        
        $wrapperHtml .= '</div>';
        $wrapperHtml .= '</div>';


        return $wrapperHtml;
    }

    private function setActualTypes()
    {
        $actualTypes = array('ноутбук', 'планшет', 'смартфон');
        if ($this->markaLower == 'xiaomi' || $this->markaLower == 'huawei')
        {
            $actualTypes = array('планшет', 'смартфон');
        }

        $this->actualTypes = $actualTypes;
    }

    private function setAccord2()
    {
        $this->accord2 = ['смартфон' => 'telefon', 'ноутбук' => 'notebook', 'планшет' => 'planshet'];
    }

    private function setAccord()
    {
        $this->accord = ['p' => '3', 'n' => '3', 'f' => '3'];
    }

    private function setAppleDeviceType()
    {
        $this->apple_device_type = ['ноутбук' => 'MacBook', 'планшет' => 'iPad', 'смартфон' => 'iPhone'];
    }
}