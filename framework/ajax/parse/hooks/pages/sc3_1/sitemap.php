<div class = "sitemap">
  <div class = "container">
    <h1><?=$this->_ret['h1']?></h1>
    <?php foreach ($this->_datas['sitemap'] as $siteMapPart) { ?>
    <h2><?=$siteMapPart['title']?></h2>
    <?php foreach ($siteMapPart['list'] as $smpBlock) { ?>
    <?php foreach ($smpBlock as $smpBlockList) { ?>
        <?php foreach ($smpBlockList as $url=>$item) { ?>
        <a href = "/<?=$url?>/"><?=$item?></a> 
        <?php } ?>
      <br>
    <?php } ?>
    <br>
    <?php } ?>
    <?php } ?>
  </div>
</div>
