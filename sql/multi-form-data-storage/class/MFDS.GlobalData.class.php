<?php

/******************************************************************************/
/******************************************************************************/

class MFDSGlobalData
{
	/**************************************************************************/
	
	function __construct()
	{
		
	}
	
	/**************************************************************************/
	
	public function setGlobalData($name,$functionCallback,$refresh=false)
	{
		global $mfdsGlobalData;
		
		if(isset($mfdsGlobalData[$name]) && (!$refresh)) return($mfdsGlobalData[$name]);
		
		$mfdsGlobalData[$name]=call_user_func($functionCallback);
		
		return($mfdsGlobalData[$name]);
	}

	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/