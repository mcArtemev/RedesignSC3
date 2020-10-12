<?php if (isset($minCost) && isset($minTime)) { ?>
  <ul class="accessories-matrix">
    <li>
      <span>Стоимость</span>
      <p><?=(is_numeric($minCost) ? "от $minCost рублей" : $minCost)?></p>
    </li>
    <li>
      <span>Время замены</span>
      <p>от <?=$minTime?> минут</p>
    </li>
  </ul>
<?php } ?>
