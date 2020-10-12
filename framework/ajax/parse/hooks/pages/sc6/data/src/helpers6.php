<?php

namespace framework\ajax\parse\hooks\pages\sc6\data\src;

class helpers6
{

  public static function min($arr, $zero = false) {
    foreach ($arr as $k=>$v) {
      if (!is_numeric($v) || ($zero && $v === 0)) {
        unset($arr[$k]);
      }
    }
    return min($arr);
  }

  public static function shuffle(&$arr, $position = 0, $srand = false) {
    if ($srand !== false) {
      srand($srand);
    }
    $a = array_slice($arr,0, $position);
    $b = array_slice($arr,$position,sizeof($arr));
    shuffle($b);
    $arr = array_merge($a, $b);
    if ($srand !== false) {
      srand();
    }
  }

  public static function renderText($text, $replace) {
    $res = '';
    foreach ($text as $tItem) {
      $tag = $tItem[0];
      $t = $tItem[1];
      switch ($tag) {
        case 'h':
          $res .= "<p class=\"h2\">$t</p>";
        break;
        case 'ul':
          if (isset($t['before']))
            $res .= "<p class = \"part-txt part-txt-sm\">{$t['before']}</p>";
          if (isset($t['list'])) {
            $res .= '<ul class = "part-txt part-ul">';
            foreach ($t['list'] as $li) {
              $res .= "<li>$li</li>";
            }
            $res .= '</ul>';
          }
          if (isset($t['after']))
            $res .= "<p class = \"part-txt part-txt-sm\">{$t['after']}</p>";
        break;
        case 'p':
          if (!is_array($t))
            $t = [$t];
          foreach ($t as $p) {
            $res .= "<p class = \"part-txt part-txt-sm\">$p</p>";
          }
        break;
      }
    }

    $res = strtr($res, $replace);

    return $res;
  }

  public static function skShuffle(&$arr, $position = 0, $srand = false) {
    $keys = array_keys($arr);
    self::shuffle($keys, $position, $srand);
    $arr2 = [];
    foreach ($keys as $k) {
      $arr2[$k] = $arr[$k];
    }
    $arr = $arr2;
  }

  public static function arr_slice($arr, $countInBlock = 100) {
    $count = count($arr);
    $res = [];
    for ($i = 1; $i <= ceil($count/$countInBlock); $i++) {
      $from = ($i-1)*$countInBlock;
      $countSlice = $count >= $i*$countInBlock ? $countInBlock : ($count % $countInBlock + 1);
      $res[] = array_slice($arr, $from, $countSlice);
    }
    return $res;
  }

  public static function translit($string) {
    $converter = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => '',  'ы' => 'y',   'ъ' => '',
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => '',  'Ы' => 'Y',   'Ъ' => '',
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
    );
    return preg_replace("/\s+/", " ", strtr($string, $converter));
  }

  public static function skl($str, $pad) {
    $skl = $str;
    switch ($pad) {
      case 'v':
        $skl = str_replace(
          array('замена','ремонт','настройка','установка','работа','восстановление','калибровка','юстировка','обновление','переустановка',
                  'устранение', 'маскировка', 'скрытие', 'пайка', 'перепайка', 'чистка', 'очистка', 'прошивка','ребболинг','заправка'),
          array('замену','ремонт','настройку','установку','работу','восстановление','калибровку','юстировку','обновление','переустановку',
                  'устранение', 'маскировку', 'скрытие', 'пайку', 'перепайку', 'чистку', 'очистку', 'прошивку','ребболинг','заправку'),
            mb_strtolower($str));
      break;
      default:
        $skl = $str;
      break;
    }
    return $skl;
  }

  public static function breadcrumbs($list) {
    echo '<div class="container">
    	<ol class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">';
    $last = count($list);
    $i = 1;
    foreach ($list as $item) {
      $title = $item[1];
      $url = $item[0];
      if ($i++ == $last) {
        echo '<li class = "active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="item"><span itemprop="name">'.$title.'</span></span><meta itemprop="position" content="'.($i-1).'" /></li>';
      }
      else {
        $url = '/'.($url == '/' ? '' : (preg_replace('/(^\/|\/$)/', '', $url).'/'));
        echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href = "'.$url.'"><span itemprop="name" >'.$title.'</span></a><meta itemprop="position" content="'.($i-1).'" /></li>';
      }
    }
    echo '	</ol>
    </div>';
  }

  public static function repl($v, $replace) {
  	foreach($v as $j => $c) {
  		if (is_array($c)) {
  			foreach ($c as $z => $item) {
  				$v[$j][$z] = strtr($item, $replace);
          if (preg_match_all('/\{(.*)\}/', $v[$j][$z], $match)) {
            foreach ($match as $m) {
              $arr = implode('|', $m[0]);
              $v[$j][$z] = str_replace('{'.$m[0].'}', $arr[array_rand($arr)], $v[$j][$z]);
            }
          }
  			}
  		}
  		else {
  			$v[$j] = strtr($c, $replace);
        if (preg_match_all('/\{(.*)\}/', $v[$j], $match)) {
          foreach ($match as $m) {
            $arr = explode('|', $m[0]);
            $v[$j] = str_replace('{'.$m[0].'}', $arr[array_rand($arr)], $v[$j]);
          }
        }
      }
  	}
  	return $v;
  }

}


?>
