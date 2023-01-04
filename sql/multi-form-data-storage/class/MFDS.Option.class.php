<?php

/******************************************************************************/
/******************************************************************************/

class MFDSOption
{
	/**************************************************************************/
	
	static function createOption($refresh=false)
	{
		$GlobalData=new MFDSGlobalData();
		return($GlobalData->setGlobalData(PLUGIN_MFDS_CONTEXT,array('MFDSOption','createOptionObject'),$refresh));				
	}
        
	/**************************************************************************/
	
	static function createOptionObject()
	{	
		return((array)get_option(PLUGIN_MFDS_OPTION_PREFIX.'_option'));
	}
	
	/**************************************************************************/
	
	static function refreshOption()
	{
		return(self::createOption(true));
	}
	
	/**************************************************************************/
	
	static function getOption($name)
	{
		global $mfdsGlobalData;

		self::createOption();

		if(!array_key_exists($name,$mfdsGlobalData[PLUGIN_MFDS_CONTEXT])) return(null);
		return($mfdsGlobalData[PLUGIN_MFDS_CONTEXT][$name]);		
	}

	/**************************************************************************/
	
	static function getOptionObject()
	{
		global $mfdsGlobalData;
		return($mfdsGlobalData[PLUGIN_MFDS_CONTEXT]);
	}
	
	/**************************************************************************/
	
	static function updateOption($option)
	{
		$nOption=array();
		foreach($option as $index=>$value) $nOption[$index]=$value;
		
		$oOption=self::refreshOption();

		update_option(PLUGIN_MFDS_OPTION_PREFIX.'_option',array_merge($oOption,$nOption));
		
		self::refreshOption();
	}
	
	/**************************************************************************/
	
	static function resetOption()
	{
		update_option(PLUGIN_MFDS_OPTION_PREFIX.'_option',array());
		self::refreshOption();		
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/