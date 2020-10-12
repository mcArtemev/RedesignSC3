<? use framework\tools;
$ring = 20;
$all_models = isset($all_models) ? $all_models : null;
$model_type = $this->_datas['model_type'][3];

if (isset($this->_datas['all_models']) && is_null($all_models)) {
    $all_models = $this->_datas['all_models'];
}

if ($all_models): ?>
<div class="index-popular">
    <h2>Другие популярные <?= tools::get_rand(array('устройства', 'модели', $model_type['name_m']), $this->_datas['feed']); ?></h2>
    <?php
    if (isset($hubText) && is_array($hubText)) {
        if (isset($hubText[$marka_lower])) {
            renderIndexText($hubText[$marka_lower][1]);
            //$genText = true;
        }
    }
    ?>
        <div class="model-group-items">
            <ul class="row">
            <?php

            $itemHtml = '';
            $showMore = false;
            $countModel = 0;
            // var_dump($all_models);
            $verModel=[];
            foreach ($all_models  as $key => $value) {
                $verModel[$value['id']]=$value;
            }

            foreach ($verModel as $k => $model) {
                if ($countModel >= $ring ) {
                    $countModel = 0;
                    $itemHtml .=  '</ul>';
                    $itemHtml .=  '<ul class="row" style="display: none">';
                    $showMore = true;
                }

                $max_model_name_length = 20;
                if ($max_model_name_length < strlen($model['name'])) {
                    $model_name = substr($model['name'], 0, $max_model_name_length);
                    $model_name .= ' ...';
                } else {
                    $model_name = $model['name'];
                }

                $itemHtml .= '<li class="col-sm-3 col-xs-6"><a href="/' . tools::search_url($site_id, serialize(array('model_id' => $model['id']))) . '/">' . $model_name . '</a></li>';
                $countModel++;
            }
            echo $itemHtml;
            ?>
            </ul>
        </div>
    <?php if ($showMore) :; ?>
        <a href="#" class="js-show">Показать другие модели</a>
    <?php endif; ?>
    <? endif; ?>
</div>