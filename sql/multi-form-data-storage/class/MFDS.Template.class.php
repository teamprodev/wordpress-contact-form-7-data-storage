<?php

/******************************************************************************/
/******************************************************************************/

class MFDSTemplate
{
	/**************************************************************************/
	
	function __construct($data,$path)
	{
		$this->data=$data;
		$this->path=$path;
	}

	/**************************************************************************/

	public function output()
	{
		ob_start();
 		include($this->path);
		$value=ob_get_clean();
		return($value);
	}
    
    /**************************************************************************/
    
    public static function displayLine($label,$value,$echo=true)
    {
        $Validation=new MFDSValidation();
        if(($Validation->isEmpty($label)) || ($Validation->isEmpty($value))) return;
        
        $html=
        '
            <li>
                <div>'.$label.'</div>
                <div>'.$value.'</div>
            </li>       
        ';
        
        if($echo) echo $html;
        else return($html);
    }
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/