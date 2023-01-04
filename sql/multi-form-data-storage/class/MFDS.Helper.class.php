<?php

/******************************************************************************/
/******************************************************************************/

class MFDSHelper
{
	/**************************************************************************/

    static function createId($prefix=null)
	{
		return((is_null($prefix) ? null : $prefix.'_').strtoupper(md5(microtime().rand())));
	}
	
	/**************************************************************************/
	
	static function createHash($value)
	{
		return(strtoupper(md5($value)));
	}
	
	/**************************************************************************/
	
	static function getPostOption($prefix=null)
	{
		if(!is_null($prefix)) $prefix='_'.$prefix.'_';
		
		$option=array();
        $result=array();
        
        $data=filter_input_array(INPUT_POST);
        
		foreach($data as $key=>$value)
		{
			if(preg_match('/^'.PLUGIN_MFDS_OPTION_PREFIX.$prefix.'/',$key,$result)) 
			{
				$index=preg_replace('/^'.PLUGIN_MFDS_OPTION_PREFIX.'_/','',$key);
				$option[$index]=$value;
			}
		}	
		
		MFDSHelper::stripslashesPOST($option);
		
		return($option);
	}

	/**************************************************************************/
	
	static function stripslashesPOST(&$value)
	{
		$value=stripslashes_deep($value);
	}

	/**************************************************************************/
	
	static function getFormName($name,$display=true)
	{
		if(!$display) return(PLUGIN_MFDS_OPTION_PREFIX.'_'.$name);
		echo PLUGIN_MFDS_OPTION_PREFIX.'_'.$name;
	}
	
	/**************************************************************************/
	
	static function displayIf($value,$testValue,$text,$display=true)
	{
		if(is_array($value))
		{
			foreach($value as $v)
			{
				if(strcmp($v,$testValue)==0) 
				{
					if($display) echo $text;
					else return($text);
					return;
				}	
			}
		}
		else 
		{
			if(strcmp($value,$testValue)==0) 
			{
				if($display) echo $text;
				else return($text);
			}
		}
	}
	
	/**************************************************************************/
	
	static function disabledIf($value,$testValue,$display=true)
	{
		return(self::displayIf($value,$testValue,' disabled ',$display));
	}
	
	/**************************************************************************/

	static function checkedIf($value,$testValue=1,$display=true)
	{
		return(self::displayIf($value,$testValue,' checked ',$display));
	}
	
	/**************************************************************************/
	
	static function selectedIf($value,$testValue=1,$display=true)
	{
		return(self::displayIf($value,$testValue,' selected ',$display));
	}
		
	/**************************************************************************/
	
	static function removeUIndex(&$data)
	{
		$argument=array_slice(func_get_args(),1);
		
		$data=(array)$data;
		
		foreach($argument as $index)
		{
			if(!is_array($index))
			{
				if(!array_key_exists($index,$data))
					$data[$index]='';
			}
			else
			{
				if(!array_key_exists($index[0],$data))
					$data[$index[0]]=$index[1];				
			}
		}
	}
	
	/**************************************************************************/
	
	static function addProtocolName($value,$protocol='http://')
	{
		if(!preg_match('/^'.preg_quote($protocol,'/').'/',$value)) return($protocol.$value);
		return($value);
	}
 
    /**************************************************************************/
    
    static function createLink($value)
    {
        return(preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>',$value));
    }
 
    /**************************************************************************/
    
    static function createMailToLink($value)
    {
        return(preg_replace('/([A-z0-9\._-]+\@[A-z0-9_-]+\.)([A-z0-9\_\-\.]{1,}[A-z])/','<a href="mailto:$1$2">$1$2</a>',$value));
    }

    /**************************************************************************/
    
	static function getPostValue($name,$prefix=true)
	{
		if($prefix) $name=PLUGIN_MFDS_CONTEXT.'_'.$name;
		
		if(!array_key_exists($name,$_POST)) return(null);
		
		return($_POST[$name]);
	}
	
	/**************************************************************************/
	
	static function getGetValue($name,$prefix=true)
	{
		if($prefix) $name=PLUGIN_MFDS_CONTEXT.'_'.$name;
		
		if(!array_key_exists($name,$_GET)) return(null);
		
		return($_GET[$name]);
	}
	
	/**************************************************************************/
    
    static function getEmailFromString($value)
    {
        foreach(preg_split('/\s/', $value) as $token)
        {
            $email=filter_var(filter_var($token, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
            if($email!==false) return($email);
        }
    
        return(null);
    }
    
    /**************************************************************************/
    
    static function sessionStart()
    {
        if(version_compare(PHP_VERSION,'5.4.0','<'))
        {
            if(session_id()=='') session_start();
        }
        else
        {
            if(session_status()==PHP_SESSION_NONE) session_start();
        }
    }
    
    /**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/