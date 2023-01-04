<?php

/******************************************************************************/
/******************************************************************************/

class MFDSExportXML extends MFDSExport
{
    /**************************************************************************/
    
    const EXPORT_FILE_NAME='export.xml';
    const EXPORT_CONTENT_TYPE='text/xml';
    
	/**************************************************************************/

	function __construct()
	{
         parent::__construct();
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
        
        $Document=new MFDSXMLDocument();
        
        $Document->openElement('export');
        
        foreach($this->data as $data)
        {
            $Document->openElement('form_entry');
            
            foreach($data as $metaName=>$metaData)
            {
                $fullOptionName=parent::getFullOptionName($metaName,'xml','enable');
             
                if(MFDSOption::getOption($fullOptionName)==1)
                {
                    $name=MFDSOption::getOption(parent::getFullOptionName($metaName,'xml','name'));
                    
                    switch($metaName)
                    {
                        case 'form_data':
                            
                            $Document->openElement($name);
                            
                            foreach($metaData as $formDataValue)
                            {
                                $Document->openElement('field');
                                
                                $Document->createElement('name',$formDataValue['field_name']);
                                $Document->createElement('label',$formDataValue['field_label']);
                                $Document->createElement('value',is_array($formDataValue['field_value']) ? join(',',$formDataValue['field_value']) : $formDataValue['field_value']);
                                
                                $Document->closeElement('field');
                            }
                            
                            $Document->closeElement($name);
                            
                        break;
                        
                        case 'form_file':
                            
                            $Document->openElement($name);
                            
                            foreach($metaData as $formDataValue)
                            {
                                $Document->openElement('file');
                                
                                $Document->createElement('field_name',$formDataValue['field_name']);
                                $Document->createElement('field_label',$formDataValue['field_label']);
                                $Document->createElement('post_id',$formDataValue['post_id']);
                                $Document->createElement('post_url',$formDataValue['post_url']);
                                $Document->createElement('post_title',$formDataValue['post_title']);
                                
                                $Document->closeElement('file');
                            }
                            
                            $Document->closeElement($name);                            
                            
                        break;
                    
                        default:
                            
                            $Document->createElement($name,$metaData);
                    }
                }
            }
 
            $Document->closeElement('form_entry');
        }
        
        $Document->closeElement('export');
        
        $this->content=$Document->getDocument();
    }
    
    /**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/