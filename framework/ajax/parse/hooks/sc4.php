<?

namespace framework\ajax\parse\hooks;

use framework\tools;

class sc4 extends sc 
{
    public function generate($answer, $params)
    {
        $this->_sqlData($params);
        
        $ret = array();   
        
        if (isset($params['m_model_id']))
        {
            switch ($params['key'])
            {
                case 'service':
                
                    $ret['title'] = array(
                        tools::mb_firstupper($this->_datas['syns'][0]),
                        $this->_datas['marka']['name'],
                        $this->_datas['m_model']['name'].':',
                        //
                    );
                    
                    $ret['h1'] = array(
                        tools::mb_firstupper($this->_datas['syns'][1]),
                        $this->_datas['model_type'][1]['name_re'],
                        $this->_datas['m_model']['name']
                    );
                    
                    $ret['description'] = array(
                        $this->_datas['marka']['ru_name'],
                        $this->_datas['m_model']['ru_name'].':',
                        tools::mb_firstlower($this->_datas['syns'][2]),
                        $this->_datas['dop']
                    );
                    
                $file_name = 'm-model-service';
                
                break;
                
                case 'defect':
                
                    $ret['title'] = array(
                        $this->_datas['marka']['name'],
                        $this->_datas['m_model']['name'],
                        tools::mb_firstlower($this->_datas['syns'][0]),
                        '-',
                        'решение:',
                        //
                    );
                    
                    $ret['h1'] = array(
                        $this->_datas['m_model']['name'],
                        tools::mb_firstlower($this->_datas['syns'][1])
                    );
                    
                    $ret['description'] = array(
                        tools::mb_firstupper($this->_datas['syns'][2]),
                        $this->_datas['marka']['ru_name'],
                        $this->_datas['m_model']['ru_name'],
                        $this->_datas['dop']
                    );
                    
                $file_name = 'm-model-defect';
                    
                break;
                
                case 'complect':
                
                    $ret['title'] = array(
                        tools::mb_firstupper($this->_datas['syns'][0]),
                        $this->_datas['marka']['name'],
                        $this->_datas['m_model']['name'].':',
                        //
                    );
                    
                    $ret['h1'] = array(
                        tools::mb_firstupper($this->_datas['syns'][1]),
                        $this->_datas['m_model']['name']
                    );
                    
                    $ret['description'] = array(
                        tools::mb_firstupper($this->_datas['syns'][2]),
                        'для',
                        $this->_datas['model_type'][2]['name_re'],
                        $this->_datas['marka']['ru_name'],
                        $this->_datas['m_model']['ru_name']
                        $this->_datas['dop']
                    );
                    
                $file_name = 'm-model-complect';
                
                break;    
            }
        }
        
        if (isset($params['model_id']))
        {
            if (!isset($params['key']))
            {
                $ret['title'] = array(
                    'Ремонт',
                    $this->_datas['model']['name'].':',
                    //
                );
                    
                $ret['h1'] = array(
                    'Ремонт',
                    $this->_datas['m_model']['name'],
                    $this->_datas['model']['submodel']
                );
                
                $ret['description'] = array(
                    $this->_datas['m_model']['ru_name'],
                    $this->_datas['model']['ru_submodel'].':',
                    'сервисное обслуживание',
                    $this->_datas['dop']
                );
                
                $file_name = 'model';
            }
            else
            {
                switch ($params['key'])
                {
                    case 'service':
                    
                        $ret['title'] = array(
                            tools::mb_firstupper($this->_datas['syns'][0]),
                            $this->_datas['model']['name'].':',
                            //
                        );
                        
                        $ret['h1'] = array(
                            tools::mb_firstupper($this->_datas['syns'][1])
                            $this->_datas['m_model']['name'],
                            $this->_datas['model']['submodel']
                        );
                        
                        $ret['description'] = array(
                            $this->_datas['m_model']['ru_name'],
                            $this->_datas['model']['ru_submodel'].':',
                            tools::mb_firstlower($this->_datas['syns'][2]),
                            $this->_datas['dop']
                        );
                        
                    $file_name = 'model-service';
                    
                    break;
                    
                    case 'defect':
                    
                        $ret['title'] = array(
                            $this->_datas['model']['name'],
                            tools::mb_firstlower($this->_datas['syns'][0]),
                            '-',
                            'решение:'
                            //
                        );
                        
                        $ret['h1'] = array(
                            $this->_datas['m_model']['name'],
                            $this->_datas['model']['submodel'],
                            tools::mb_firstlower($this->_datas['syns'][1])
                        );
                        
                        $ret['description'] = array(
                            tools::mb_firstupper($this->_datas['syns'][2]),
                            $this->_datas['m_model']['ru_name'],
                            $this->_datas['model']['ru_submodel'],
                            $this->_datas['dop']
                        );
                        
                    $file_name = 'model-defect';
                        
                    break;
                    
                    case 'complect':
                    
                        $ret['title'] = array(
                            tools::mb_firstupper($this->_datas['syns'][0]),
                            $this->_datas['model']['name'].':',
                            //                            
                        );
                        
                        $ret['h1'] = array(
                            tools::mb_firstupper($this->_datas['syns'][1]),
                            $this->_datas['m_model']['name'],
                            $this->_datas['model']['submodel']
                        );
                        
                        $ret['description'] = array(
                            tools::mb_firstupper($this->_datas['syns'][2]),
                            'для',
                            $this->_datas['model_type'][2]['name_re'],
                            $this->_datas['m_model']['ru_name'],
                            $this->_datas['model']['ru_submodel']
                            $this->_datas['dop']
                        );
                        
                    $file_name = 'model-complect';
                    
                    break;    
                }                    
            }
        }                
        
        $ret['body'] = $this->_body($file_name);
        $this->_ret = $ret;
        return $this->_answer($answer);       
    }
}

?>