<?php

/******************************************************************************/
/******************************************************************************/

class MFDSExportCSV extends MFDSExport
{
    /**************************************************************************/
    
    private $delimiter;
    
    const EXPORT_FILE_NAME='export.csv';
    const EXPORT_CONTENT_TYPE='text/csv';
    
	/**************************************************************************/

	function __construct($delimiter=';')
	{
        parent::__construct();
        
        $this->header=array();
        $this->delimiter=$delimiter;
	}
    
    /**************************************************************************/
    
    public function export()
    {
        parent::setData();
        $this->setContent();
        parent::download(self::EXPORT_FILE_NAME,self::EXPORT_CONTENT_TYPE);
    }
    
    /**************************************************************************/
    
    private function setContent()
    {
        if(!count($this->data)) return;
        
        $Validation=new MFDSValidation();
        
        /***/
        
        $header=array_keys($this->metadata);
        
        foreach($header as $value)
        {
            if(MFDSOption::getOption(parent::getFullOptionName($value,'csv','enable')))
                $this->header[]=array('realName'=>$value,'name'=>$this->translateColumnName($value));
        }
        
        foreach($this->header as $index=>$value)
        {
            if($value['realName']=='form_data')
            {
                $this->createHeader('data');
                unset($this->header[$index]);
            }
            if($value['realName']=='form_file')
            {
                $this->createHeader('file');
                unset($this->header[$index]);
            }            
            
        }

        /***/

        if(MFDSOption::getOption('export_csv_header_enable')==1)
        {
            foreach($this->header as $value)
            {
                if($Validation->isNotEmpty($this->content)) $this->content.=chr($this->delimiter);
                
                $this->content.=$value['name'];
            }
        }
           
        /***/
            
        foreach($this->data as $index=>$data)
        {
            if($Validation->isNotEmpty($this->content))
                $this->content.=PHP_EOL;
            
            $this->createLine($data,'data');
            $this->createLine($data,'file');

            $line=null;
            foreach($this->header as $value)
            {
                if(isset($data[$value['realName']]))
                {
                    if(is_array($data[$value['realName']]))
                    {
                        $line.=$this->formatValue(join(',',$data[$value['realName']]));
                    }
                    else $line.=$this->formatValue($data[$value['realName']]);
                }
                else $line.=' ';
                
                $line.=chr($this->delimiter);
            }
            
            $this->content.=$line;
        }
        
        /***/
    }
    
    /**************************************************************************/
    
    private function formatValue($value)
    {
        return(preg_replace("/\r|\n|\\".chr($this->delimiter)."/",' ',$value));
    }
        
    /**************************************************************************/
    
    private function createLine(&$data,$type)
    {
        $type='form_'.$type;
        
        if(!isset($data[$type])) return;
        
        foreach($data[$type] as $value)
            $data[$this->getColumnName($data['extension_id'],$data['extension_form_id'],$type,$value['field_name'])]=($type=='form_data' ? $value['field_value'] : $value['post_url']);    
           
        unset($data[$type]);
    }
    
    /**************************************************************************/
    
    private function createHeader($type)
    {
        $type='form_'.$type;
        foreach($this->data as $data)
        {
            if(is_array($data[$type]))
            {
                foreach($data[$type] as $value)
                {
                    $realName=$this->getColumnName($data['extension_id'],$data['extension_form_id'],$type,$value['field_name']);
                    $this->header[]=array('realName'=>$realName,'name'=>$this->translateColumnName($realName,true));
                }
            }
        }
    }
    
    /**************************************************************************/
    
    private function getColumnName($extensionId,$extensionFormId,$type,$fieldName)
    {
        return('['.$extensionId.']['.$extensionFormId.']['.($type=='form_data' ? 'field' : 'file').']['.$fieldName.']');
    }
    
    /**************************************************************************/
    
    private function translateColumnName($realName,$useMap=false)
    {
        $Validation=new MFDSValidation();
        
        if($useMap)
        {
            $map=array();
            
            $map[0]=MFDSOption::getOption('export_csv_map');
            if($Validation->isEmpty($map[0])) return($realName);
            
            $map[1]=explode(PHP_EOL,$map[0]);
            foreach($map[1] as $value)
            {
                $map[2]=explode(';',$value); 
                if($Validation->isNotEmpty($map[2][0]) && $Validation->isNotEmpty($map[2][1]))
                {
                    if($realName==$map[2][0]) return($map[2][1]);
                }
            }
            
            return($realName);
        }
        else
        {
            $name=MFDSOption::getOption(parent::getFullOptionName($realName,'csv','name'));
            if($Validation->isEmpty($name)) $name=$realName;
        }
        
        return($name);
    }
    
    /**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/