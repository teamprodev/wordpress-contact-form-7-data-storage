<?php

/******************************************************************************/
/******************************************************************************/

class MFDSExtensionManager
{
    /**************************************************************************/
	
	function __construct()
	{
        global $mfds_extension;
        if(!is_array($mfds_extension)) $this->init();
        
        $this->extension=$mfds_extension;
	}
    
    /**************************************************************************/
    
    private function init()
    {   
        global $mfds_extension;
        $mfds_extension=array();        
        
        $extension=MFDSFile::scanDir(PLUGIN_MFDS_EXTENSION_PATH);
        
        foreach($extension as $extensionName)
        {
            $fileName=$this->createExtensionClassFileName($extensionName);
            MFDSInclude::includeFile(PLUGIN_MFDS_EXTENSION_PATH.$extensionName.'/'.$fileName);
            
            $className=$this->createExtensionClassName($extensionName);
            
            $Extension=new $className();
            $Extension->init();
            
            $mfds_extension[$Extension->getId()]=array('className'=>$className);
        }
    }
    
    /**************************************************************************/
    
    private function createExtensionClassFileName($extensionDir)
    {
        return(PLUGIN_MFDS_CLASS_PREFIX.'.Extension.'.join('',array_map('ucfirst',explode('-',$extensionDir))).'.class.php');
    }
    
    /**************************************************************************/
    
    private function createExtensionClassName($extensionDir)
    {
        return(PLUGIN_MFDS_CLASS_PREFIX.'Extension'.join('',array_map('ucfirst',explode('-',$extensionDir))));
    }
    
    /**************************************************************************/
    
    private function callExtensionFunction($functionName)
    {
        $data=array();
        
        foreach($this->extension as $extensionName=>$extensionData)
        {
            $Extension=new $extensionData['className']();
            $data[$extensionName]=call_user_func(array($Extension,$functionName));          
        }   
        
        return($data);
    }
    
    /**************************************************************************/
    
    public function getExtensionName($id)
    {
        $Extension=new $this->extension[$id]['className'];
        return($Extension->getName());
    }
         
    /**************************************************************************/
    
    public function getOptionDeafult()
    {
        return($this->callExtensionFunction('getOptionDeafult'));
    }
    
    /**************************************************************************/
    
    public function createOptionMenu()
    {
        return(join('',$this->callExtensionFunction('createOptionMenu')));
    }
    
    /**************************************************************************/
    
    public function createOptionPanel()
    {
        return(join('',$this->callExtensionFunction('createOptionPanel')));
    }
    
    /**************************************************************************/
    
    public function optionSave(&$Validation)
    {
        foreach($this->extension as $extensionData)
        {
            $Extension=new $extensionData['className']();
            $Extension->optionSave($Validation);
        }   
    }
    
    /**************************************************************************/
    
    public function createEditFormLink($extensionId,$formId,$formName)
    {
        $Extension=new $this->extension[$extensionId]['className'];
        return($Extension->createEditFormLink($formId,$formName));        
    }
    
    /**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/