<?

use framework\ajax\parse\hooks\pages\sc6\data\src\defect_service;

$dft = defect_service::getForType($this->_datas['model_type']['name'], $this->_datas['site_id']);
    
if (count($dft) >= 2)
{  
    echo '<div class="relink">';
    
    echo '<span>'.$this->firstup($defect['name']).'</span>';
    
    if (count($dft) == 2)
    {
        foreach ($dft as $v)
        {
            if ($v['id'] != $defect['id'])
            {
                $da = $v;
                break;
            }
        }

        echo '<a href="'.defect_service::fullUrl($da['type'], $da['url']).'">'.$this->firstup($da['name']).'</a>';
    }	
    else
    {
        $defect_array = array();
        $count = count($dft) - 1;
        
        foreach ($dft as $i => $v)
        {
            if ($v['id'] == $defect['id'])
            {
                $last = ($i == 0) ? $count : $i - 1;
                $next = ($i == $count) ? 0 : $i + 1;
                  
                $defect_array[] = $dft[$last];
                $defect_array[] = $dft[$next];    
            }
        }
            
        foreach ($defect_array as $da)
        {
            echo '<a href="'.defect_service::fullUrl($da['type'], $da['url']).'">'.$this->firstup($da['name']).'</a>';
        }
    }

    echo '</div>';
}     
    
    
?>	