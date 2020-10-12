<?

namespace framework\ajax\parse\hooks;

use framework\tools;
use framework\pdo;

define('USE_TYPES', false);

class context 
{
    private $_datas = array();
    private $_mode = 0;
    private $_cache_mode = false;
    private $_suffics = '';
    private $_site_id = 0;
    
    public function __construct($sc)
    {
        $this->_datas = $sc->getData();
        $this->_mode = $sc->getMode();
        $this->_cache_mode = $sc->getCacheMode();
        $this->_suffics = $sc->getSuffics();
        $this->_site_id = $sc->getSiteId();
    }
    
    public function createContext()
    {
        $access_values = array(2, 3, 0, -2, -3, 1, -1);
        //$access_values = array(3, 0, -2, -3, 1, -1);
        
        if (!in_array($this->_mode, $access_values)) return;
        
        $key_table = '';
        
        if (isset($this->_datas['key']))
        {
            $key_table = $this->_datas['key'];
            if ($key_table == 'complect' || $key_table == 'defect') return;
        }
         
        $site_name = $this->_datas['site_name'];
        $setka_name = $this->_datas['setka_name'];
        
        $suffics = $this->_suffics;
        
        //syns 
        if ($this->_mode >= 0)
        {
            $search_id = ($this->_mode) ? $this->_datas['id'] : $this->_datas['min_id']; 
            
            $table = $suffics.'_'.$key_table.'_context_syns';
            $join_field = $suffics.'_'.$key_table.'_id';
             
            $sql = "SELECT `name` FROM `{$table}` WHERE `{$join_field}` = ?";
            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute(array($search_id));
            $syns = $stm->fetchAll(\PDO::FETCH_COLUMN);
            
            if (!$syns) return;
        }
        else
        {
            $syns = array('Ремонт');
        }
        
        $model_type = $this->_datas['model_type'][3];        
                   
        //global
        $url = 'http://'.$site_name.'/'.$this->_datas['arg_url'].'/';
        
        if ($this->_cache_mode == 3)
        {
           $url .= '?utm_source=google&utm_medium=cpc&utm_campaign={network}&utm_content={creative}&utm_term={keyword}';
        }
        
        //check for google
        /*$check_google = false;
        
        $ru_markas = array('Sony', 'Dell', 'Lenovo');
        if ($this->_cache_mode == 3 && ((in_array($this->_datas['marka']['name'], $ru_markas) && $setka_name == 'СЦ-1') || ($setka_name == 'СЦ-2')))
        {
            $t_servicename = $this->_datas['servicename'];
            $this->_datas['servicename'] = $this->_datas['ru_servicename'];
            
            $t_marka_name = $this->_datas['marka']['name'];
            $this->_datas['marka']['name'] = $this->_datas['marka']['ru_name'];
            
            if ($this->_mode != 0)
            {
                $t_model_name = $this->_datas['model']['name'];
                if ($setka_name == 'СЦ-1')
                {
                    if (mb_strtolower($this->_datas['model']['lineyka']) != mb_strtolower($this->_datas['model']['sublineyka']))
                        $this->_datas['model']['name'] = $this->_datas['marka']['name'].' '.$this->_datas['m_model']['name'].' '.$this->_datas['model']['submodel'];
                    else
                        $this->_datas['model']['name'] = $this->_datas['marka']['name'].' '.$this->_datas['model']['submodel'];
                }    
                    
                if ($setka_name == 'СЦ-2')
                {
                    if (mb_strtolower($this->_datas['model']['lineyka']) != mb_strtolower($this->_datas['model']['sublineyka']))
                        $this->_datas['model']['name'] = $this->_datas['marka']['ru_name'].' '.$this->_datas['m_model']['ru_name'].' '.$this->_datas['model']['submodel'];
                    else
                        $this->_datas['model']['name'] = $this->_datas['marka']['ru_name'].' '.$this->_datas['model']['submodel'];
                }
            }
            
            $check_google = true;
        }*/
                
        //links
        if ($this->_cache_mode == 2)
        {
            $links = array();
            $first_link = array();
            
            if ($setka_name == 'СЦ-1')
            {
                if ($this->_mode == 2)
                {
                    //$first_link[] = 'Ремонт '.$this->_datas['model']['name'];
                    
                    if (mb_strtolower($this->_datas['model']['lineyka']) != mb_strtolower($this->_datas['model']['sublineyka']))
                    {
                        $first_link[] = 'Ремонт '.$this->_datas['marka']['name'].' '.$this->_datas['m_model']['name'].' '.$this->_datas['model']['submodel'];
                        //$first_link[] = 'Ремонт '.$this->_datas['m_model']['name'].' '.$this->_datas['model']['submodel'];
                        $first_link[] = 'Ремонт '.$this->_datas['marka']['name'].' '.$this->_datas['m_model']['name'];
                    }
                    else
                    {
                        $first_link[] = 'Ремонт '.$this->_datas['marka']['name'].' '.$this->_datas['model']['submodel'];
                        $first_link[] = 'Ремонт '.$this->_datas['marka']['name'].' '.$this->_datas['model']['lineyka'];
                    }
                    
                    $links[] = array('Ремонт '.$model_type['name_rm'].' '.$this->_datas['marka']['name'],
                            tools::search_url($this->_site_id, serialize(array('model_type_id' => $this->_datas['model_type']['id'], 'marka_id' => $this->_datas['marka']['id']))));
                }
                
                if ($this->_mode == -2)
                {
                    $model_id = $this->_datas['model']['id'];
                    
                    if ($this->_suffics == 'p' || $this->_suffics == 'f')
                    {
                        $links[] = array('Ремонт платы',  
                            tools::search_url($this->_site_id, serialize(array('model_id' => $model_id, 'key' => 'service', 'id' => '5'))));
                        $links[] = array('Ремонт разъема',
                            tools::search_url($this->_site_id, serialize(array('model_id' => $model_id, 'key' => 'service', 'id' => '13')))); 
                        $links[] = array('Замена экрана',
                            tools::search_url($this->_site_id, serialize(array('model_id' => $model_id, 'key' => 'service', 'id' => '3'))));
                        $links[] = array('Замена батареи',
                            tools::search_url($this->_site_id, serialize(array('model_id' => $model_id, 'key' => 'service', 'id' => '12'))));
                    } 
                    else
                    {
                        $links[] = array('Ремонт платы', 
                            tools::search_url($this->_site_id, serialize(array('model_id' => $model_id, 'key' => 'service', 'id' => '9'))));
                        $links[] = array('Ремонт разъема', 
                            tools::search_url($this->_site_id, serialize(array('model_id' => $model_id, 'key' => 'service', 'id' => '25'))));
                        $links[] = array('Замена матрицы',
                            tools::search_url($this->_site_id, serialize(array('model_id' => $model_id, 'key' => 'service', 'id' => '3'))));
                        $links[] = array('Замена клавиатуры',
                            tools::search_url($this->_site_id, serialize(array('model_id' => $model_id, 'key' => 'service', 'id' => '7'))));
                    }  
                } 
                
                if ($this->_mode == 3) 
                {
                    $first_link[] = 'Ремонт '.$model_type['name_rm'].' '.$this->_datas['marka']['name'];
                    
                    $links[] = array('Сервис центр '.$this->_datas['marka']['name'], '');  
                }
                
                if ($this->_mode == -3)
                {
                    $marka_id = $this->_datas['marka']['id'];
                    $model_type_id = $this->_datas['model_type']['id'];
                    
                    if ($this->_suffics == 'p' || $this->_suffics == 'f')
                    {
                        $links[] = array('Ремонт платы',  
                            tools::search_url($this->_site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'service', 'id' => '5'))));
                        $links[] = array('Ремонт разъема',
                            tools::search_url($this->_site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'service', 'id' => '13')))); 
                        $links[] = array('Замена экрана',
                            tools::search_url($this->_site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'service', 'id' => '3'))));
                        $links[] = array('Замена батареи',
                            tools::search_url($this->_site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'service', 'id' => '12'))));
                    } 
                    else
                    {
                        $links[] = array('Ремонт платы', 
                            tools::search_url($this->_site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'service', 'id' => '9'))));
                        $links[] = array('Ремонт разъема', 
                            tools::search_url($this->_site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'service', 'id' => '25'))));
                        $links[] = array('Замена матрицы',
                            tools::search_url($this->_site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'service', 'id' => '3'))));
                        $links[] = array('Замена клавиатуры',
                            tools::search_url($this->_site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'service', 'id' => '7'))));
                    }  
        
                }
                
                if ($this->_mode == 0)
                {
                    $vals = $this->_datas['vals'];
                    $marka_id = $this->_datas['marka']['id'];
                    
                    foreach ($vals as $key => $value)
                    {
                        $suffics = $this->_datas[$key]['suffics'];
                        $model_type_id = $this->_datas[$key]['model_type']['id'];  
                        
                        if ($key_table == 'service')
                        {
                            $links[] = array(
                                'Ремонт '.$this->_datas[$key]['model_type'][3]['name_re'],
                                    tools::search_url($this->_site_id, 
                                        serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'service', 'id' => $value[$suffics.'_service_id']))));
                        }
                        else
                        {
                            $links[] = array(
                                'Ремонт '.$this->_datas[$key]['model_type'][3]['name_re'],
                                    tools::search_url($this->_site_id, 
                                        serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'defect', 'id' => $value[$suffics.'_defect_id']))));
                        }                    
                    }
                    
                    if (count($links) == 2) $links[] = array('Комплектующие', 'zapchasti');
                    
                    $links[] = array('Контакты', 'kontakty');    					
                }
                
                if ($this->_mode == 2 || $this->_mode == 3)
                {
                    $links[] = array('Комплектующие', 'zapchasti');
                    $links[] = array('Контакты', 'kontakty');
                }            
            }
            
            if ($setka_name == 'СЦ-2')
            {
                $remont_str = 'Ремонт с 10% скидкой';
                
                if ($this->_mode == 2 || $this->_mode == -2)
                {
                    $first_link[] = 'Ремонт ' . $this->_datas['m_model']['name'];                    
                }
                
                if ($this->_mode == -3)            
                {
                    $l = 66 - mb_strlen($remont_str);
                    $count_vsemodeli = 0;
                      
                    foreach ($this->_datas['vsemodeli_array'] as $key => $value)
                    {
                        $s = 'Ремонт ' . $value;
                        $l = $l - mb_strlen($s);
                        
                        if ($l < 0 || $count_vsemodeli > 1) break;
                        
                        $links[] = 
                            array($s,
                                 tools::search_url($this->_site_id, serialize(array('m_model_id' => $this->_datas['vsemodeli_id'][$key]))));
                                 
                        $count_vsemodeli++;
                        
                    }
                }
                
                if ($this->_mode == 1 || $this->_mode == -1)
                {
                    $first_link[] = 'Ремонт ' . $this->_datas['model_type'][3]['name_rm'].' '.$this->_datas['marka']['name'];              
                }
                
                if ($this->_mode == 0)
                {
                    $key_models = array();
                    
                    foreach ($this->_datas as $key => $value)
                    {
                        if (is_numeric($key))
                        {
                            if ($value['vsemodeli_array'])
                                $key_models['Ремонт '.current($value['vsemodeli_array'])] = current($value['vsemodeli_id']);                         
                        }
                    } 
                    
                    $l = 66 - mb_strlen($remont_str);
                    
                    foreach ($key_models as $k => $m)
                    {         
                        $l = $l - mb_strlen($k);
                            
                        if ($l < 0) break;   
                        
                        $links[] = array($k, 
                                tools::search_url($this->_site_id, serialize(array('m_model_id' => $m))));
                   }             
                                 
                }
                
                if ($this->_mode != 0)
                {
                    //$links[] = array('Ремонт '.$this->_datas['marka']['name'], '');
                    $links[] = array('Задать вопрос эксперту', 'ask');
                }
                    
                $links[] = array($remont_str, 'order');
            }
            
            if ($first_link)
            {
                $l = 66;
                foreach($links as $link)
                    $l = $l - mb_strlen($link[0]);
                
                $k = tools::get_optimal_variant($first_link, $l);
                
                if ($setka_name == 'СЦ-1')
                {
                    if ($k !== false)
                    { 
                        if ($this->_mode == 2)
                        {
                            $first_link = array($first_link[$k], 
                                tools::search_url($this->_site_id, 
                                    serialize(array('model_id' => $this->_datas['model']['id']))));
                                    
                             array_unshift($links, $first_link);
                        }
                        
                        if ($this->_mode == 3) 
                        {
                             $first_link = array($first_link[$k], 
                                tools::search_url($this->_site_id, 
                                    serialize(array('model_type_id' => $this->_datas['model_type']['id'], 'marka_id' => $this->_datas['marka']['id']))));
                                    
                              array_unshift($links, $first_link);
                        }               
                    }
                    else
                    {
                        if ($this->_mode == 2)
                        {
                            $first_link = array($this->_datas['servicename'], '');
                            
                            array_unshift($links, $first_link); 
                        }
                        
                        if ($this->_mode == 3) 
                        {
                            
                        }
                    }
                }
                
                if ($setka_name == 'СЦ-2') 
                {
                    if ($k !== false)
                    { 
                        if ($this->_mode == -1 || $this->_mode == 1)
                        {
                            $first_link = array($first_link[$k], 
                                 tools::search_url($this->_site_id, serialize(array('model_type_id' => $this->_datas['model_type']['id'], 
                            'marka_id' =>  $this->_datas['marka']['id']))));
                                    
                             array_unshift($links, $first_link);
                        } 
                        
                        if ($this->_mode == 2)
                        {
                            $first_link = array($first_link[$k],
                                tools::search_url($this->_site_id, serialize(array('m_model_id' => $this->_datas['m_model']['id'], 
                            'key' => $this->_datas['key'], 'id' => $this->_datas['id']))));
                            
                            array_unshift($links, $first_link);
                        }
                        
                        if ($this->_mode == -2)
                        {
                            $first_link = array($first_link[$k],
                                tools::search_url($this->_site_id, serialize(array('m_model_id' => $this->_datas['m_model']['id']))));
                            
                             array_unshift($links, $first_link);
                        }
                        
                    }
                    else
                    {
                        
                    }
                }
            }
        }            
                        
        foreach ($links as $key => $link)
            $links[$key] = array($link[0], 'http://'.$site_name.'/'.$link[1].(($link[1]) ? '/' : '')); 
          
        $link_h = array();
        $link_u = array();
        
        foreach($links as $link)
        {
            $link_h[] = $link[0];
            $link_u[] = $link[1];
        }
              
        //syns
        foreach ($syns as $syn)
        {
            $str = array();
            
            $orig_syn = $syn;
            $syn = tools::mb_firstupper($syn);
            
            //header
            $header = array();
            
            /*if ($this->_cache_mode == 3)
            {
                $t_upper_marka_name = $this->_datas['marka']['name'];
                $this->_datas['marka']['name'] = mb_strtoupper($this->_datas['marka']['name']);
            }*/
            
            if ($this->_mode == 2 || $this->_mode == -2)
            {           
                if ($setka_name == 'СЦ-1')
                {
                    //$header[] = $syn.' '.$this->_datas['model']['name'];
                    
                    if (mb_strtolower($this->_datas['model']['lineyka']) != mb_strtolower($this->_datas['model']['sublineyka']))
                    {
                        $header[] = $syn.' '.$this->_datas['marka']['name'].' '.$this->_datas['m_model']['name'].' '.$this->_datas['model']['submodel'];                        
                        //$header[] = $syn.' '.$this->_datas['m_model']['name'].' '.$this->_datas['model']['submodel'];
                        $header[] = $syn.' '.$this->_datas['marka']['name'].' '.$this->_datas['m_model']['name'];                  
                    }
                    else
                    {
                        $header[] = $syn.' '.$this->_datas['marka']['name'].' '.$this->_datas['model']['submodel'];                        
                        $header[] = $syn.' '.$this->_datas['marka']['name'].' '.$this->_datas['model']['lineyka']; 
                    }
                }
                
                if ($setka_name == 'СЦ-2')
                {
                    if (mb_strtolower($this->_datas['model']['lineyka']) != mb_strtolower($this->_datas['model']['sublineyka']))
                    {
                        $header[] = $syn.' '.$this->_datas['marka']['ru_name'].' '.$this->_datas['m_model']['ru_name'].' '.$this->_datas['model']['submodel'];                        
                        //$header[] = $syn.' '.$this->_datas['m_model']['ru_name'].' '.$this->_datas['model']['submodel'];
                        $header[] = $syn.' '.$this->_datas['marka']['ru_name'].' '.$this->_datas['m_model']['ru_name'];                  
                    }
                    else
                    {
                        $header[] = $syn.' '.$this->_datas['marka']['ru_name'].' '.$this->_datas['model']['submodel'];                        
                        $header[] = $syn.' '.$this->_datas['marka']['ru_name'].' '.$this->_datas['model']['lineyka']; 
                    }
                }
            }
            
            //only sc-1
            if ($this->_mode == 3)
            {
                if ($key_table == 'service')
                    $header[] = $syn.' '.$model_type['name_rm'].' '.$this->_datas['marka']['name'];
                else
                    $header[] = tools::mb_firstupper($this->_datas['model_type'][3]['name']).' '.$this->_datas['marka']['name'].': '.tools::mb_firstlower($orig_syn);
            }
            
            if ($this->_mode == -3)
            {
                if ($setka_name == 'СЦ-1')
                    $header[] = 'Ремонт '.$model_type['name_rm'].' '.$this->_datas['marka']['name'];
                
                if ($setka_name == 'СЦ-2')
                    $header[] = 'Ремонт '.$model_type['name_rm'].' '.$this->_datas['marka']['ru_name'];
            }
            
            //only sc-2
            if ($this->_mode == 1 || $this->_mode == -1)
            {
                $header[] = $syn.' '.$this->_datas['marka']['ru_name'].' '.$this->_datas['m_model']['ru_name'];
            }
            
            if ($setka_name == 'СЦ-1')
                $header[] = $syn.' '.$this->_datas['marka']['name'];
                
            if ($setka_name == 'СЦ-2')
                $header[] = $syn.' '.$this->_datas['marka']['ru_name'];    
            
            $k = false;
            if ($this->_cache_mode == 2)
                $k = tools::get_optimal_variant($header, 33);
                
            if ($this->_cache_mode == 3)
                $k = tools::get_optimal_variant($header, 30);
                
            if ($k === false) continue;
             
            $header = $header[$k];
            
            /*if ($this->_cache_mode == 3)
            {
                $this->_datas['marka']['name'] = $t_upper_marka_name;
            }*/
            
            //text
            $text = array();
            $header2 = array();
            
            if ($setka_name == 'СЦ-1')
            {
                if ($this->_mode == 2)
                {
                    if ($key_table == 'service')
                        $t_str = $this->_datas['price'].' руб! '.$syn.' '.$this->_datas['model']['name'];
                    else
                        $t_str = 'Ремонт от '.$this->_datas['price'].' руб! Ремонт '.$this->_datas['model']['name'];
                }
                
                if ($this->_mode == -2)
                {
                    $t_str = 'от '.$this->_datas['price'].' руб! Ремонт '.$this->_datas['model']['name'];
                }
                
                if ($this->_mode == 3)
                {
                    if ($key_table == 'service')
                        $t_str = $this->_datas['price'].' руб! '.$syn.' '.$model_type['name_re'].' '.$this->_datas['marka']['name'];
                    else
                        $t_str = 'Ремонт от '.$this->_datas['price'].' руб! Ремонт '.$model_type['name_re'].' '.$this->_datas['marka']['name'];
                }
                
                if ($this->_mode == -3)
                {
                    $t_str = 'от '.$this->_datas['price'].' руб! Ремонт '.$model_type['name_re'].' '.$this->_datas['marka']['name'];
                }
                
                if ($this->_mode == 0)
                {
                    if ($key_table == 'service')
                        $t_str = $this->_datas['price'].' руб! '.$syn.' '.$this->_datas['marka']['name'];
                    else
                        $t_str = 'Ремонт от '.$this->_datas['price'].' руб! Ремонт '.$this->_datas['marka']['name'];
                }
                
                $text[] = $t_str.' в сервисе '.$this->_datas['servicename'].' в Москве';
                $text[] = $t_str.' в сервисе '.$this->_datas['servicename'];
                $text[] = $t_str.' в '.$this->_datas['servicename'];
                $text[] = $t_str;
            }
            
            if ($setka_name == 'СЦ-2')
            {
                $t_str = array();
                
                if ($this->_datas['time'] > 60)
                    $time = 'за 1-2 часа';
                else
                    $time = 'от '.$this->_datas['time'].' мин';
                    
                if ($this->_cache_mode == 2)
                    $service_name = mb_strtoupper($this->_datas['servicename']);
                
                if ($this->_cache_mode == 3)
                    $service_name = $this->_datas['servicename'];
                    
                $v = array();                                
                $v[] = 'Ремонт в '.$service_name.'!';
                $v[] =  $service_name.'!';
                
                $prc = $this->_datas['price'].'р.';
                
                if ($this->_mode == 2)
                {
                    if ($key_table == 'service')
                    {
                       if ($this->_cache_mode == 2)
                       {
                           foreach ($v as $vv)
                           {
                                $t_str[] = $vv.' '.$prc.' '.$syn.' '.$this->_datas['model']['name'].' '.$time;
                                $t_str[] = $vv.' '.$prc.' '.$syn.' '.$this->_datas['model']['name']; 
                           }
                       }
                       
                       if ($this->_cache_mode == 3)
                       {
                            $header2[] = 'в '.$service_name.': '.$prc;
                            $t_str[] = $syn.' '.$this->_datas['model']['name'].' '.$time;
                            $t_str[] = $syn.' '.$this->_datas['model']['name'];
                       }
                                  
                    }
                    else
                    {
                       if ($this->_cache_mode == 2)
                       {
                           $t_str[] = $service_name.'! от '.$this->_datas['price'].'р.'.
                                ' Ремонт '.$this->_datas['model']['name'].' '.$time;
                                
                           $t_str[] = $service_name.'! от '.$this->_datas['price'].'р.'.
                                ' Ремонт '.$this->_datas['model']['name'];
                       }
                       
                       if ($this->_cache_mode == 3)
                       {
                            $header2[] = 'Ремонт от '.$prc.', '.$time;
                             if (mb_strpos($time, 'мин') !== false) $header2[] = 'Ремонт от '.$prc.', '.$time.'ут';                             
                            
                            $t_str[] = 'Ремонт '.$this->_datas['model']['name'].' в '.$service_name; 
                       }
                    }                          
                }
                
                if ($this->_mode == -2)
                {
                    if ($this->_cache_mode == 2)
                    {
                        foreach ($v as $vv)
                        {
                            $t_str[] = $vv.' от '.$prc.' Ремонт '.$this->_datas['model']['name'].' '.$time; 
                            $t_str[] = $vv.' от '.$prc.' Ремонт '.$this->_datas['model']['name'];
                        }
                    }
                    
                    if ($this->_cache_mode == 3)
                    {
                        $header2[] = 'в '.$service_name.': от '.$prc;
                        $t_str[] = 'Ремонт '.$this->_datas['model']['name'].' '.$time;
                        $t_str[] = 'Ремонт '.$this->_datas['model']['name'];
                    }
                }
                
                if ($this->_mode == 1)
                {
                    if ($key_table == 'service')
                    {
                       if ($this->_cache_mode == 2)
                       {
                           foreach ($v as $vv)
                           {
                                $t_str[] = $vv.' от '.$prc.' '.$syn.' '.$this->_datas['marka']['name'].' '.
                                    $this->_datas['m_model']['name'].' '.$time;
                                $t_str[] = $vv.' от '.$prc.' '.$syn.' '.$this->_datas['marka']['name'].' '.
                                    $this->_datas['m_model']['name'];
                           }
                       }
                       
                       if ($this->_cache_mode == 3)
                       {
                            $header2[] = 'в '.$service_name.': от '.$prc;
                            $t_str[] = $syn.' '.$this->_datas['marka']['ru_name'].' '.
                                    $this->_datas['m_model']['ru_name'].' '.$time;
                            $t_str[] = $syn.' '.$this->_datas['marka']['ru_name'].' '.
                                    $this->_datas['m_model']['ru_name'];
                       }                       
                    }
                    else
                    {
                       if ($this->_cache_mode == 2)
                       {
                            $t_str[] = $service_name.'! от '.$prc.
                                ' Ремонт '.$this->_datas['marka']['name'].' '.
                                    $this->_datas['m_model']['name'].' '.$time;
                                    
                            $t_str[] = $service_name.'! от '.$prc.
                                ' Ремонт '.$this->_datas['marka']['name'].' '.
                                    $this->_datas['m_model']['name'];
                       }
                       
                       if ($this->_cache_mode == 3)
                       {
                            $header2[] = 'Ремонт от '.$prc.', '.$time;
                            if (mb_strpos($time, 'мин') !== false) $header2[] = 'Ремонт от '.$prc.', '.$time.'ут';                       
                            
                            $t_str[] = 'Ремонт '.$this->_datas['marka']['ru_name'].' '.
                                    $this->_datas['m_model']['ru_name'].' в '.$service_name;
                       }
                    }
                }
                
                if ($this->_mode == -1)
                {
                    if ($this->_cache_mode == 2) 
                    {
                        foreach ($v as $vv)
                        {
                            $t_str[] = $vv.' от '.$prc.' Ремонт '.$this->_datas['marka']['name'].' '.
                                $this->_datas['m_model']['name'].' '.$time;
                            $t_str[] = $vv.' от '.$prc.' Ремонт '.$this->_datas['marka']['name'].' '.
                                $this->_datas['m_model']['name'];
                        }
                    }
                    
                    if ($this->_cache_mode == 3)
                    {
                        $header2[] = 'в '.$service_name.': от '.$prc;
                        $t_str[] = 'Ремонт '.$this->_datas['marka']['ru_name'].' '.
                                $this->_datas['m_model']['ru_name'].' '.$time;
                        $t_str[] = 'Ремонт '.$this->_datas['marka']['ru_name'].' '.
                                $this->_datas['m_model']['ru_name'];
                    }
                }
                
                if ($this->_mode == -3)
                {
                    if ($this->_cache_mode == 2) 
                    { 
                        foreach ($v as $vv)
                        {
                            $t_str[] = $vv.' от '.$prc.' Ремонт '.$model_type['name_re'].' '.$this->_datas['marka']['name'].' '.$time;
                            $t_str[] = $vv.' от '.$prc.' Ремонт '.$model_type['name_re'].' '.$this->_datas['marka']['name'];
                        }
                    }
                    
                    if ($this->_cache_mode == 3)
                    {
                        $header2[] = 'в '.$service_name.': от '.$prc;
                        $t_str[] = 'Ремонт '.$model_type['name_re'].' '.$this->_datas['marka']['ru_name'].' '.$time;
                        $t_str[] = 'Ремонт '.$model_type['name_re'].' '.$this->_datas['marka']['ru_name'];
                    }
                }
                
                if ($this->_mode == 0)
                {
                    if ($key_table == 'service')
                    {
                       if ($this->_cache_mode == 2) 
                       {
                           foreach ($v as $vv)
                           {
                                $t_str[] = $vv.' от '.$prc.' '.$syn.' '.$this->_datas['marka']['name'].' '.$time;
                                $t_str[] = $vv.' от '.$prc.' '.$syn.' '.$this->_datas['marka']['name'];
                           }
                        }
                        
                        if ($this->_cache_mode == 3)
                        {
                            $header2[] = 'в '.$service_name.': от '.$prc;
                            $t_str[] = $syn.' '.$this->_datas['marka']['ru_name'].' '.$time;
                            $t_str[] = $syn.' '.$this->_datas['marka']['ru_name'];
                        }
                    }
                    else
                    {
                       if ($this->_cache_mode == 2) 
                       {
                            $t_str[] = $service_name.'! от '.$this->_datas['price'].'р.'.
                                ' Ремонт '.$this->_datas['marka']['name'].' '.$time;
                                
                            $t_str[] = $service_name.'! от '.$this->_datas['price'].'р.'.
                                ' Ремонт '.$this->_datas['marka']['name'];
                       }
                       
                       if ($this->_cache_mode == 3)
                       {
                            $header2[] = 'Ремонт от '.$prc.', '.$time;
                            if (mb_strpos($time, 'мин') !== false) $header2[] = 'Ремонт от '.$prc.', '.$time.'ут';                           
                            
                            $t_str[] = 'Ремонт '.$this->_datas['marka']['ru_name'].' в '.$service_name;
                       }
                    }
                      
                }
                
                foreach ($t_str as $t)
                {
                    $text[] = $t;
                    $text[] = $t.'. Москва.';
                }   
            }
            
            $k1 = false;
            $k2 = false;
                        
            if ($this->_cache_mode == 2)
                $k2 = tools::get_optimal_variant($text, 75);
                
            if ($this->_cache_mode == 3)
            {
                if ($setka_name == 'СЦ-1')
                {
                    $t_text = array();
                    
                    foreach($text as $txt) 
                    {
                        $pos = mb_strpos($txt, '!');
                        $t_header = mb_substr($txt, 0, $pos);
                        
                        $t_sn_array = explode(' ', $this->_datas['servicename']);
                        //$t_sn_str = mb_strtoupper($t_sn_array[0]) . ' ' . $t_sn_array[1];
                        $t_sn_str = $t_sn_array[0] . ' ' . $t_sn_array[1];
                        
                        $header2[] = $t_header;
                        $header2[] = $t_header . 'лей';
                        $header2[] = $t_header . '. ' . $t_sn_str;
                        $header2[] = $t_header . 'лей. ' . $t_sn_str;
                        $t_text[] =  mb_substr($txt, $pos + 2);                        
                    }
                    
                    $text = $t_text;
                }
                
                $k1 = tools::get_optimal_variant($header2, 30);
                $k2 = tools::get_optimal_variant($text, 80);  
            }
                
            if ($this->_cache_mode == 2 && $k2 === false) continue;
            if ($this->_cache_mode == 3 && ($k1 === false || $k2 === false)) continue;            
            
            $text = $text[$k2];
            
            if ($this->_cache_mode == 3)
                $header2 = $header2[$k1];
            
            //vis-link
            if ($this->_cache_mode == 2)
            {
                if ($setka_name == 'СЦ-1')
                {
                    $vis_link = array();
                    
                    if ($this->_mode >=0)
                    {
                        $vis_link[] = mb_strtolower(str_replace(array(' '), '-', $syn));
                        $vis_link[] = mb_strtolower('ремонт-'.$this->_datas['marka']['ru_name']);
                    }
                    
                    $vis_link[] = mb_strtolower(str_replace(array(' '), '-', $syn).'-'.$this->_datas['marka']['ru_name']);
                    
                    $k = tools::get_optimal_variant($vis_link, 20);
                           
                    if ($k === false)
                        $vis_link = '';
                    else            
                        $vis_link = $vis_link[$k];
                }
                
                if ($setka_name == 'СЦ-2')
                {
                    $vis_link = 'Ремонт';
                }
            }
            
            if ($this->_cache_mode == 3)
            {
                if ($setka_name == 'СЦ-1')
                {
                    $path1 = 'ремонт-'.$this->_datas['marka']['ru_name'];
                    $path2 = mb_strtolower(str_replace(array(' '), '-', $syn));
                    if (mb_strlen($path2) > 15) $path2 = '';
                }
                
                if ($setka_name == 'СЦ-2')
                {
                    $path1 = 'Ремонт';
                    $path2 = '';
                }
            }
                       
            //keywords
           /*if ($check_google)
           {
                $this->_datas['servicename'] = $t_servicename;
                $this->_datas['marka']['name'] = $t_marka_name;
                if ($this->_mode != 0) $this->_datas['model']['name'] = $t_model_name;     
           }*/
                      
            $keywords = array();
            
            //if (mb_strpos($syn, 'Не ') === 0) $syn = '+' . $syn;
            
            if ($this->_mode == 2 || $this->_mode == -2)
            {
                if (mb_strtolower($this->_datas['model']['lineyka']) != mb_strtolower($this->_datas['model']['sublineyka']))
                {
                    $keywords[] = array($syn.' '.$this->_datas['marka']['name'].' '.$this->_datas['m_model']['name'].' '.$this->_datas['model']['submodel'], false);
                    //$keywords[] = $syn.' '.$this->_datas['marka']['name'].' '.$this->_datas['m_model']['ru_name'].' '.$this->_datas['model']['submodel'];                 
                    //$keywords[] = $syn.' '.$this->_datas['marka']['name'].' '.$this->_datas['m_model']['ru_name'].' '.$this->_datas['model']['ru_submodel'];
                    //$keywords[] = $syn.' '.$this->_datas['marka']['name'].' '.$this->_datas['m_model']['ru_name'].' '.tools::mb_ucfirst($this->_datas['model']['ru_submodel_syn']);                    
                    
                    $keywords[] = array($syn.' '.$this->_datas['marka']['ru_name'].' '.$this->_datas['m_model']['name'].' '.$this->_datas['model']['submodel'], false);
                    $keywords[] = array($syn.' '.$this->_datas['marka']['ru_name'].' '.$this->_datas['m_model']['ru_name'].' '.$this->_datas['model']['submodel'], false);                 
                    $keywords[] = array($syn.' '.$this->_datas['marka']['ru_name'].' '.$this->_datas['m_model']['ru_name'].' '.$this->_datas['model']['ru_submodel'], false);
                    $keywords[] = array($syn.' '.$this->_datas['marka']['ru_name'].' '.$this->_datas['m_model']['ru_name'].' '.tools::mb_ucfirst($this->_datas['model']['ru_submodel_syn']), false);
                    
                    $keywords[] = array($syn.' '.$this->_datas['m_model']['name'].' '.$this->_datas['model']['submodel'], false);
                    $keywords[] = array($syn.' '.$this->_datas['m_model']['ru_name'].' '.$this->_datas['model']['submodel'], false);                 
                    $keywords[] = array($syn.' '.$this->_datas['m_model']['ru_name'].' '.$this->_datas['model']['ru_submodel'], false);
                    $keywords[] = array($syn.' '.$this->_datas['m_model']['ru_name'].' '.tools::mb_ucfirst($this->_datas['model']['ru_submodel_syn']), false);
                    
                    if (mb_strlen($this->_datas['model']['submodel']) > 1)
                    {
                        $keywords[] = array($syn.' '.$this->_datas['marka']['name'].' '.$this->_datas['model']['submodel'], true);
                        //$keywords[] = $syn.' '.$this->_datas['marka']['name'].' '.$this->_datas['model']['ru_submodel'];
                        //$keywords[] = $syn.' '.$this->_datas['marka']['name'].' '.tools::mb_ucfirst($this->_datas['model']['ru_submodel_syn']);                    
                        
                        $keywords[] = array($syn.' '.$this->_datas['marka']['ru_name'].' '.$this->_datas['model']['submodel'], true);
                    }
                    
                    if (mb_strlen($this->_datas['model']['ru_submodel']) > 1)
                    { 
                        $keywords[] = array($syn.' '.$this->_datas['marka']['ru_name'].' '.$this->_datas['model']['ru_submodel'], true);
                    }
                    
                    if (mb_strlen($this->_datas['model']['ru_submodel_syn']) > 1)
                    {
                        $keywords[] = array($syn.' '.$this->_datas['marka']['ru_name'].' '.tools::mb_ucfirst($this->_datas['model']['ru_submodel_syn']), true);
                    }  
                }
                else
                {
                     $keywords[] = array($syn.' '.$this->_datas['marka']['name'].' '.$this->_datas['model']['submodel'], true);  
                     
                     $keywords[] = array($syn.' '.$this->_datas['marka']['ru_name'].' '.$this->_datas['model']['submodel'], true); 
                     $keywords[] = array($syn.' '.$this->_datas['marka']['ru_name'].' '.$this->_datas['model']['ru_submodel'], true);
                     $keywords[] = array($syn.' '.$this->_datas['marka']['ru_name'].' '.tools::mb_ucfirst($this->_datas['model']['ru_submodel_syn']), true);
                                            
                     $keywords[] = array($syn.' '.$this->_datas['marka']['name'].' '.$this->_datas['model']['lineyka'], true);
                     $keywords[] = array($syn.' '.$this->_datas['marka']['ru_name'].' '.$this->_datas['model']['ru_lineyka'], true);      
                }
           }
           
           if ($this->_mode == 3 || $this->_mode == -3)
           {
                foreach($this->_datas['orig_model_type'] as $type)
                {
                    $keywords[] = $syn.' '.$type['name_re'].' '.$this->_datas['marka']['name'];
                    $keywords[] = $syn.' '.$type['name_re'].' '.$this->_datas['marka']['ru_name'];
                }            
           }
           
           if ($this->_mode == 1 || $this->_mode == -1)
           {
                if (USE_TYPES)
                {
                    $keywords[] = $syn.' '.$model_type['name'].' '.$this->_datas['marka']['name'].' '.$this->_datas['m_model']['name'];
                    $keywords[] = $syn.' '.$model_type['name'].' '.$this->_datas['marka']['name'].' '.$this->_datas['m_model']['ru_name'];
                    
                    $keywords[] = $syn.' '.$model_type['name'].' '.$this->_datas['marka']['ru_name'].' '.$this->_datas['m_model']['name'];
                    $keywords[] = $syn.' '.$model_type['name'].' '.$this->_datas['marka']['ru_name'].' '.$this->_datas['m_model']['ru_name'];
                }

                //non type
                $keywords[] = $syn.' '.$this->_datas['marka']['name'].' '.$this->_datas['m_model']['name'];
                //$keywords[] = $syn.' '.$this->_datas['marka']['name'].' '.$this->_datas['m_model']['ru_name'];
                
                $keywords[] = $syn.' '.$this->_datas['marka']['ru_name'].' '.$this->_datas['m_model']['name'];
                $keywords[] = $syn.' '.$this->_datas['marka']['ru_name'].' '.$this->_datas['m_model']['ru_name'];                        
           }
           
           if ($this->_mode == 0)
           {
                $keywords[] = $syn.' '.$this->_datas['marka']['name'];
                $keywords[] = $syn.' '.$this->_datas['marka']['ru_name'];  
           }
           
           $t_keywords = array();
           foreach ($keywords as $key => $keyword)
           {
                $marka = 'NULL'; 
                if (is_array($keyword)) 
                {
                    $marka = ($keyword[1]) ? '1' : 'NULL';
                    $keyword = $keyword[0];
                } 
                
                $keyword = str_replace(array('-'), ' ', $keyword);
                $k_array = explode(" ", $keyword);
                
                if (count($k_array) <= 7) 
                {
                    $t_keywords[$keyword] = $marka;
                }  
           }
           
           $keywords = array();
           foreach ($t_keywords as $key => $val)
           {
                $keywords[] = array($key, $val);
           }
           
           
           /*$accord = array(
                'Замена северного моста' => 'Заменить северный мост',
                'Замена южного моста' => 'Заменить южный мост', 
                'Замена АКБ' => 'Заменить АКБ',
                'Замена аккумулятора' => 'Заменить аккумулятор',
                'Замена батареи' => 'Заменить батарею',
                'Замена гнезда питания' => 'Заменить гнездо питания',
                'Замена разъема зарядки' =>
                'Замена разъема питания' => '',
                'Замена HDMI' => '',
                'Замена камеры' => '',
                'Замена клавиатуры' => '',
                'Замена платы' => '',
                'Замена матрицы' => '',
	            'Замена микрофона' => '',
	            'Замена контроллера' => '',
	            'Замена мультиконтроллера' => '',
                'Замена памяти' => '',
                'Замена тачпада' => '',
                'Замена USB' => '',
	            'Замена видеокарты' => '',
                'Замена видеочипа' => '',
                'Замена Wifi' => '',
	            'Замена HDD' => '',
                'Замена жесткого диска' => '',
                'Замена звуковой карты' => '',*/

                )
           foreach ($keywords as $key => $keyword)
           {
                if (mb_strpos(mb_strtolower($keyword[0]), 'замена') !== false)
                    $keywords[] = array(str_replace(array('замена', 'Замена'), array('заменить', 'Заменить'), $keyword[0]), $keyword[1]); 
           }
           
           /*if ($this->_cache_mode == 2)
           {
               foreach ($keywords as $keyword)
                    $keywords[] = '""'.$keyword.'""';
           }*/
           
           /*if ($this->_cache_mode == 3)
           {
                foreach ($keywords as $key => $keyword)
                {             
                    $k_array = explode(" ", $keyword);
                    
                    foreach ($k_array as $k_key => $k_value)
                    {
                        $k_array[$k_key] = '+' . $k_value;   
                    }
                    
                    $keywords[$key] = implode(" ", $k_array);
                }
           }*/
                
           //write          
           /* if ($this->_cache_mode == 3)
           {
               if ($this->_datas['marka']['name'] == 'Samsung')
                    $cpc = '20.0';
               else
                    $cpc = '32.0';

               $str[] = array($campaign, '', '',
                        '', '', '', '', '',
                            '',  '0.00', '', '', '', 
                                '', '', 
                                '',
                                    '', '', '', '',
                                        $group, $cpc, '0.01', '', '', '', '',
                                            'None', 'Disabled', 'Default', '[]'); 
           }*/
           
           $insert = array();
           
           $tmp_model_id = isset($this->_datas['model']['id']) ? $this->_datas['model']['id'] : 'NULL';
           $tmp_m_model_id = isset($this->_datas['m_model']['id']) ? $this->_datas['m_model']['id'] : 'NULL';
           $tmp_key = isset($this->_datas['key']) ? "'".$this->_datas['key']."'" : 'NULL';
           $tmp_key_id = isset($this->_datas['id']) ? (!is_array($this->_datas['id']) ? $this->_datas['id'] : 'NULL') : 'NULL';
           
           foreach ($keywords as $keyword)        
           {
               /*if ($this->_cache_mode == 3)
               {
                   $t_str = array($campaign, '', '',
                    '', '', '', '', '',
                        '',  '', '', '', '', 
                            '', '', 
                            '',
                                '', '', '', '',
                                    $group, '', '', '', '', '', '',
                                        '', '', '', '',
                                        '', '', '', '',
                                        '', '', $keyword, 
                                        'Broad');
               }
                    
               $str[] = $t_str;*/

               $insert[] = "('".$keyword[0]."',".$this->_mode.",'".$this->_datas['arg_url']."',".$tmp_model_id.",".$tmp_m_model_id.",".$tmp_key.",".$tmp_key_id.",".$keyword[1].")";
               
           }
           
           if ($insert)
           {
               $sql = "INSERT IGNORE INTO `keywords` (`name`, `mode`, `url`, `model_id`, `m_model_id`, `key`, `k_id`, `use_marka`) VALUES ".implode(',', $insert);              
               pdo::getPdo()->query($sql);
           }
           
           /*if ($this->_cache_mode == 2)
           {
               $old_keywords = false;               
              
               $t_keywords = implode(";", $keywords);
               $t_link_h = implode('||', $link_h);
               $t_link_u = implode('||', $link_u);
                
               $sql = "INSERT INTO `ads_yd` (`header`, `text`, `keywords`, `url`, `vis_link`, `link_h`, `link_u`, `site_name`, `mode`) VALUES 
                            ('{$header}','{$text}', '{$t_keywords}', '{$url}', '{$vis_link}', '{$t_link_h}', '{$t_link_u}', '{$site_name}', {$this->_mode})";              
               
               pdo::getPdo()->query($sql);
           }
           
           if ($this->_cache_mode == 3)
           {
               $old_keywords = false;
               
               if (DELETE_DOUBLES)
               {
                
               }
               
               if (!$old_keywords)
               {
                    $sql = "INSERT INTO `ads_yd` (`header`, `text`, `keywords`, `url`, `vis_link`, `link_h`, `link_u`, `site_name`) VALUES 
                                ('{$header}','{$text}', '{$t_keywords}', '{$url}', '{$vis_link}', '{$t_link_h}', '{$t_link_u}', '{$site_name}')";
               }
               
               pdo::getPdo()->query($sql);               
           }*/
           
           /*if ($this->_cache_mode == 3)
           {
                $str[] = array($campaign, '', '',
                    '', '', '', '', '',
                        '',  '', '', '', '', 
                            '', '', 
                            '',
                                '', '', '', '',
                                    $group, '', '', '', '', '', '',
                                        '', '', '', '',
                                        '', '', '', '',
                                        '', '', '', 
                                        '', '', '',
                                        '', '', $url,
                                        '', '', '',
                                        '', '', '', '', '',
                                        '', 
                                        '', '', '',
                                        $header, $header2,
                                        $text, $path1, $path2); 
                                        
                
                $dops = array();                  

                if ($key_table != 'defect' && $setka_name == 'СЦ-1')      
                {
                    $t_dops = array();
                    $accord = array();
                                        
                    if ($this->_suffics == 'n')
                    {
                        $t_dops[] = 'замена матрицы';
                        $t_dops[] = 'замена клавиатуры';
                        $t_dops[] = 'ремонт разъема';  
                        $t_dops[] = 'ремонт платы';
                        
                        $accord_dops = array(3 => 0, 7 => 1, 25 => 2, 9 => 3);
                    }
                            
                    if ($this->_suffics == 'p' || $this->_suffics == 'f')
                    {
                        $t_dops[] = 'замена экрана';
                        $t_dops[] = 'замена батареи';
                        $t_dops[] = 'ремонт разъема';
                        $t_dops[] = 'ремонт платы';
                        
                        $accord_dops = array(3 => 0, 12 => 1, 13 => 2, 5 => 3);                                                
                    }
                    
                    if ($this->_mode == 0)
                    {
                        $t_dops[] = 'замена экрана';
                        $t_dops[] = 'ремонт разъема';
                        $t_dops[] = 'ремонт платы'; 
                        $t_dops[] = 'замена батареи';
                    }
                        
                    if ($this->_mode > 0 && $key_table == 'service')
                    {
                        if (mb_strlen($orig_syn) <= 25)
                        {
                            $dops[] = mb_strtolower($orig_syn);
  
                            $accord_id = (integer) $this->_datas['id'];
                            if (isset($accord_dops[$accord_id]))
                            {
                                unset($t_dops[$accord_dops[$accord_id]]);
                                $t_dops = array_values($t_dops);
                            }
                        }                        
                    }
                                            
                    $count_dops = 4 - count($dops);                    
                    for ($dops_count = 0; $dops_count < $count_dops; $dops_count++)
                        $dops[] = $t_dops[$dops_count];                
                }
                
                if ($dops)
                {
                    $str[] = array($campaign, '', '',
                        '', '', '', '', '',
                            '',  '', '', '', '', 
                                '[]', '[]', 
                                '[]',
                                    '', '', '', '',
                                        $group, '', '', '', '', '', '',
                                            '', '', '', '',
                                            '', '', '', '',
                                            '', '', '', 
                                            '', '', '',
                                            '', '', '',
                                            '', 'All', '',
                                            '', '', 'Главный фид структурированных описаний', 'All', '',
                                            '',
                                            '', '', '',
                                            '', '',
                                            '', '', '',
                                            'Услуги', '"'.implode("\n", $dops).'"');
               }
                                        
               if (($contexts % $step) == 0)
               {
                   foreach ($link_h as $link_h_key => $link_h_value)
                   {
                        $str[] = array($campaign, '', '',
                        '', '', '', '', '',
                            '',  '', '', '', '', 
                                '[]', '[]', 
                                '[]',
                                    '', '', '', '',
                                        '', '', '', '', '', '', '',
                                            '', '', '', '',
                                            '', '', '', '',
                                            '', '', '', 
                                            '', '', '',
                                            '', '', $link_u[$link_h_key], 
                                            '', 'All', $link_h_value,
                                            $desc_link_1[$link_h_key], $desc_link_2[$link_h_key], 'AdWords Express Sitelinks feed', 'All');
                   }
                    
               }
           }*/  
                                                       
          //foreach ($str as $key => $as)
            //foreach ($as as $k => $s)
                //if (!(($contexts % 2000) == 1 && $key == 0) && $s && !preg_match("/^[,.0-9]+$/i", $s)) $str[$key][$k] = "\"".$s."\""; 

           /*if ($check_google)
           {
                $t_servicename = $this->_datas['servicename'];
                $this->_datas['servicename'] = $this->_datas['ru_servicename'];
                
                $t_marka_name = $this->_datas['marka']['name'];
                $this->_datas['marka']['name'] = $this->_datas['marka']['ru_name'];
                
                if ($this->_mode != 0)
                {
                    $t_model_name = $this->_datas['model']['name'];
                    if (mb_strtolower($this->_datas['model']['lineyka']) != mb_strtolower($this->_datas['model']['sublineyka']))
                        $this->_datas['model']['name'] = $this->_datas['marka']['name'].' '.$this->_datas['m_model']['name'].' '.$this->_datas['model']['submodel'];
                    else
                        $this->_datas['model']['name'] = $this->_datas['marka']['name'].' '.$this->_datas['model']['submodel'];
                }
            }*/
        }
     } 
}