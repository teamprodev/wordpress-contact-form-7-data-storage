<?php

/******************************************************************************/
/******************************************************************************/

class MFDSExtensionCalderaForm extends MFDSExtension
{
	/**************************************************************************/	
	
	function __construct()
    {
        $this->optionDefault=array
        (
            'extension_caldera_form_enable'                                     =>  1
        );
        
        $this->id='caldera_form';
        $this->name='Caldera Forms';
        
        parent::__construct();
	}
	
	/**************************************************************************/
	
    function init()
    {
        if(MFDSOption::getOption('extension_caldera_form_enable')==1)
            add_action('caldera_forms_submit_complete',array($this,'submitComplete'));
    }
    
	/**************************************************************************/
    
    function submitComplete($form)
    {
        global $post;
      
        $Entry=new MFDSFormEntry();

        $Entry->setBody($form['mailer']['email_message']);
        $Entry->setSubject($form['mailer']['email_subject']);     
        
        $Entry->setSenderName($form['mailer']['sender_name']);
        $Entry->setSenderEmail($form['mailer']['sender_email']);       
 
        $Entry->setRecipient($form['mailer']['recipients']); 
        
        $Entry->setBCC($form['mailer']['bcc_to']);          
        $Entry->setReplyTo($form['mailer']['reply_to']); 
        
        $Entry->setUserIP(); 
        $Entry->setUserAgent(); 
        
        $Entry->setReferrerPostId($post->ID);
        $Entry->setReferrerPostName($post->post_title);
        
        $Entry->setExtensionId($this->getId());
        $Entry->setExtensionFormId($form['ID']);        
        $Entry->setExtensionFormName($form['name']);
        
        $data=array();
        foreach($form['fields'] as $fieldId=>$fieldData)
            $data[$fieldData['slug']]=Caldera_Forms::get_field_data($fieldId,$form);
   
        $Entry->setFormData($data,1);
        
        $Entry->save();
        
        $Entry->uploadFile($this->findFile($form,$data));
    }
    
    /**************************************************************************/
    
    private function findFile($form,$data)
    {
        $file=array();
        
        if(!is_array($form['fields'])) return($file);
        
        foreach($form['fields'] as $fieldData)
        {
            $type=$fieldData['type'];
            $slug=$fieldData['slug'];
            
            if((in_array($type,array('file','advanced_file'))) && (array_key_exists($slug,$data)))
            {
                if(is_array($data[$slug]))
                {
                    foreach($data[$slug] as $index=>$value)
                        $file[$slug.'_'.$index]=$value;
                }
                else $file[$slug]=$data[$slug];
            }
        }
        
        return($file);
    }
        
    /**************************************************************************/
    
    public function createEditFormLink($formId,$formName)
    {
       return('<a href="'.admin_url('admin.php?page=caldera-forms&amp;edit='.$formId).'" target="_blank">'.$formName.'</a>');
    }
   
    /**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/


 