<?php

/******************************************************************************/
/******************************************************************************/

class MFDSExtensionFastSecureContactForm extends MFDSExtension
{
	/**************************************************************************/	
	
	function __construct()
    {
        $this->optionDefault=array
        (
            'extension_fast_secure_contact_form_enable'                         =>  1
        );
        
        $this->id='fast_secure_contact_form';
        $this->name='Fast Secure Contact Form';
        
        parent::__construct();
	}
	
	/**************************************************************************/
	
    public function init()
    {
        if(MFDSOption::getOption('extension_fast_secure_contact_form_enable')==1)
        {
            add_action('fsctf_mail_sent',array($this,'mailSent'));
            add_filter('body_class',array($this,'setPostId'));
        }
    }
    
    /**************************************************************************/
    
    public function setPostId()
    {
        global $post;
        if(!is_object($post)) return;

        $_SESSION[PLUGIN_MFDS_CONTEXT.'_post_id']=$post->ID;
    }
    
	/**************************************************************************/
    
    public function mailSent($data)
    {
        $Entry=new MFDSFormEntry();
        
        $Entry->setBody($data->{'posted_data'}['full_message']);
        $Entry->setSubject($data->{'posted_data'}['subject']);
        
        $Entry->setSenderName($data->{'posted_data'}['from_name']);
        $Entry->setSenderEmail($data->{'posted_data'}['from_email']);
                
        $Entry->setRecipient(array('name'=>$data->{'posted_data'}['name_to'],'email'=>$data->{'posted_data'}['email_to']));
        
        $Entry->setExtensionId($this->getId());
        $Entry->setExtensionFormId($data->{'form_number'}); 
        $Entry->setExtensionFormName($data->{'title'}); 
        
        $Entry->setUserIP($data->{'posted_data'}['ip_address']); 
        $Entry->setUserAgent();
        
        MFDSHelper::sessionStart();

        if(isset($_SESSION[PLUGIN_MFDS_CONTEXT.'_post_id']))
        {
            $postId=(int)$_SESSION[PLUGIN_MFDS_CONTEXT.'_post_id'];
            $post=get_post($postId);
            
            if(!is_null($post))
            {
                $Entry->setReferrerPostId($post->ID);
                $Entry->setReferrerPostName($post->post_title);
            }
        }
        
        $Entry->setFormData($data->{'posted_data'},1);

        $Entry->save();
        
        $Entry->uploadFile($data->{'uploaded_files'});
    }
    
    /**************************************************************************/
    
    public function createEditFormLink($formId,$formName)
    {
       return('<a href="'.admin_url('options-general.php?page=si-contact-form/si-contact-form.php&amp;fscf_tab=1&amp;fscf_form='.$formId).'" target="_blank">'.$formName.'</a>');        
    }
    
    /**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/