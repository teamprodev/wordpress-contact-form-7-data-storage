<?php

/******************************************************************************/
/******************************************************************************/

class MFDSExtensionContactForm7 extends MFDSExtension
{
	/**************************************************************************/	
	
	function __construct()
    {
        $this->optionDefault=array
        (
            'extension_contact_form_7_enable'                                   =>  1
        );
        
        $this->id='contact_form_7';
        $this->name='Contact Form 7';
        
        parent::__construct();
	}
	
	/**************************************************************************/
	
    public function init()
    {
        if(MFDSOption::getOption('extension_contact_form_7_enable')==1)
            add_action('wpcf7_mail_sent',array($this,'mailSent'));
    }
    
	/**************************************************************************/
    
    public function mailSent($form)
    {
        $mail=WPCF7_Mail::get_current();
        $submission=WPCF7_Submission::get_instance();

        if((is_null($mail)) || (is_null($submission))) return(false);

        $Entry=new MFDSFormEntry();
        
        /***/
        
        $Entry->setBody($mail->get('body',true));
        $Entry->setSubject($mail->get('subject',true));
        
        $Entry->setSenderEmail(MFDSHelper::getEmailFromString($mail->get('sender',true)));
        $Entry->setRecipient($mail->get('recipient',true));
        
        /***/
        
        $Entry->setUserIP($submission->get_meta('remote_ip')); 
        $Entry->setUserAgent($submission->get_meta('user_agent'));
        
        $Entry->setReferrerPostId($submission->get_meta('container_post_id'));
        $Entry->setReferrerPostName(get_the_title($Entry->getReferrerPostId()));
        
        $Entry->setExtensionId($this->getId());
        $Entry->setExtensionFormId($form->id()); 
        $Entry->setExtensionFormName($form->title());
        
        /***/
        
        $formData=$this->filterFormData($submission->get_posted_data());
        
        $Entry->setFormData($formData,1);
        
        /***/
            
        $Entry->save();

        $Entry->uploadFile($submission->uploaded_files());
    }
    
    /**************************************************************************/
    
    private function filterFormData($formData)
    {
        $formDataIndexToRemove=array('_wpcf7','_wpcf7_version','_wpcf7_locale','_wpcf7_unit_tag','_wpcf7_container_post');
        
        foreach($formDataIndexToRemove as $index)
            unset($formData[$index]);
        
        return($formData);
    }
    
    /**************************************************************************/
    
    public function createEditFormLink($formId,$formName)
    {
        return('<a href="'.admin_url('edit.php?page=wpcf7&post='.$formId.'&action=edit').'" target="_blank">'.$formName.'</a>');
    }
    
    /**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/