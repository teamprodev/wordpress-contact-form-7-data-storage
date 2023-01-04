<?php

/******************************************************************************/
/******************************************************************************/

class MFDSExtension
{
    /**************************************************************************/
	
	function __construct()
	{

	}
    
    /**************************************************************************/
    
    public function getOptionDeafult()
    {
        return($this->optionDefault); 
    }
    
    /**************************************************************************/
    
    public function getName()
    {
        return($this->name);
    }
    
    /**************************************************************************/
    
    public function getId()
    {
        return($this->id);
    }
    
    /**************************************************************************/
    
    public function getExtensionSlug()
    {
        return(preg_replace('/_/','-',$this->getId()));
    }
    
    /**************************************************************************/
    
    public function getExtensionPath()
    {
        return(PLUGIN_MFDS_EXTENSION_PATH.$this->getExtensionSlug().'/');
    }
    
    /**************************************************************************/
    
    public function createOptionMenu()
    {
        return('<li><a href="#extension_'.esc_attr($this->getId()).'">'.esc_html($this->getName()).'</a></li>');
    }
    
    /**************************************************************************/
    
    public function createOptionPanel()
    {
        $data=array();
        
        $data['option']=MFDSOption::getOptionObject();

		$Template=new MFDSTemplate($data,$this->getExtensionPath().'option.php');
		
        return('<div id="extension_'.esc_attr($this->getId()).'">'.$Template->output().'</div>');
    }
    
    /**************************************************************************/
    
    public function optionSave(&$Validation)
    {
        $option=MFDSHelper::getPostOption();
        
        $Validation->notice('isBool',array($option['extension_'.$this->getId().'_enable']),array(MFDSHelper::getFormName('extension_'.$this->getId().'_enable',false),__('This field conatins invalid value.','multi-form-data-storage')));
    }
    
    /**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/