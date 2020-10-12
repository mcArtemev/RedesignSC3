<?
/*function resize_image($source_path, $width, $height, $name)
{
    $file_name_path = $_SERVER['DOCUMENT_ROOT']. '/sc6_pic/planshet/'. $name . '.jpg';
    $source_path = $_SERVER['DOCUMENT_ROOT']. '/sc6_pic/'. $source_path;
    
    $m = explode('/', $file_name_path);
    unset($m[count($m) - 1]);
    $m = implode('/', $m);
    
    //echo $file_name_path.' '.$source_path.' '.$m.PHP_EOL;
    
    if (!is_dir($_SERVER['DOCUMENT_ROOT']. '/sc6_pic/planshet/'. $m)) mkdir($m);
    
    list($source_image_width, $source_image_height, $source_image_type) = getimagesize($source_path);
    
    switch ($source_image_type) {
        case IMAGETYPE_GIF:
            $source_gd_image = imagecreatefromgif($source_path);
            break;
        case IMAGETYPE_JPEG:
            $source_gd_image = imagecreatefromjpeg($source_path);
            break;
        case IMAGETYPE_PNG:
            $source_gd_image = imagecreatefrompng($source_path);
            break;
    }

    $source_aspect_ratio = $source_image_width / $source_image_height;
    $thumbnail_aspect_ratio = $width / $height;

    if ($source_image_width <= $width && $source_image_height <= $height) {
        $thumbnail_image_width = $source_image_width;
        $thumbnail_image_height = $source_image_height;
    } elseif ($thumbnail_aspect_ratio > $source_aspect_ratio) {
        $thumbnail_image_width = (int) ($height * $source_aspect_ratio);
        $thumbnail_image_height = $height;
    } else {
        $thumbnail_image_width = $width;
        $thumbnail_image_height = (int) ($width / $source_aspect_ratio);
    }

    $thumbnail_gd_image = imagecreatetruecolor($thumbnail_image_width, $thumbnail_image_height);
    imagecopyresampled($thumbnail_gd_image, $source_gd_image, 0, 0, 0, 0, $thumbnail_image_width, $thumbnail_image_height, $source_image_width, $source_image_height);

    imagejpeg($thumbnail_gd_image, $file_name_path, 90);
    imagedestroy($source_gd_image);
    imagedestroy($thumbnail_gd_image);    
}

$dir = opendir('planshet');
$files = array();

while($file = readdir($dir)) 
{
   if (is_dir('planshet/'.$file) && $file != '.' && $file != '..') 
   {
       $name = mb_strtolower($file);
       $name = trim(preg_replace("/(\s){2,}/",' ',$name));
       $name = str_replace(' ', '_', $name);
       
       if ($pos = mb_strpos($name, 'packard_bell') !== false)
       {
        $pos = mb_strpos($name, '_') + 5;
       }
       else
       {
         $pos = mb_strpos($name, '_');
       }
       
       $brand = mb_substr($name, 0, $pos);
       $name = mb_substr($name, $pos + 1);
       
       $dir_files = opendir('planshet/'.$file);
       
       while($file_s = readdir($dir_files))
       {
            if (is_file('planshet/'.$file.'/'.$file_s))
            {
                $files[$brand.'/'.$name][] = 'planshet/'.$file.'/'.$file_s;
            }
       }
   }
}
       
foreach ($files as $key => $value)
{
   $v = $value[rand(0, count($value) - 1)];
   if ($v)
   {
       resize_image($v, 1024, 150, $key);    
   }
}*/

?>