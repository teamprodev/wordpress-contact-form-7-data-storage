<?php

/******************************************************************************/
/******************************************************************************/

class MFDSFormEntry
{
    /**************************************************************************/	
        
    private $id;
    
    private $body;
    private $subject;       

    private $senderName;
    private $senderEmail;
    
    private $recipient;
    
    private $cc;
    private $bcc;
    private $replyTo;

    private $userIP;
    private $userAgent;
    
    private $referrerPostId;
    private $referrerPostName;
    
    private $extensionId;
    private $extensionFormId;
    private $extensionFormName;
    
    private $post;
    private $postMeta;

    private $formData;
    private $formFile;
    
	/**************************************************************************/	
	
	function __construct($id=0)
    {
        $this->id=$id;
        
        /***/
        
        $this->body=null;
        $this->subject=null;       
        
        $this->senderName=null;
        $this->senderEmail=null;
        
        $this->recipient=array();
        
        $this->cc=array();
        $this->bcc=array();
        $this->replyTo=array();
        
        /***/
        
        $this->userIP=null;
        $this->userAgent=null;
        
        /***/
        
        $this->referrerPostId=0;    
        $this->referrerPostName=null;
        
        /***/
        
        $this->extensionId=null;
        $this->extensionFormId=0;
        $this->extensionFormName=null;
        
        /***/
        
        $this->post=null;
        $this->postMeta=null;
        
        /***/
        
        $this->formData=array();
        $this->formFile=array();
	}

    /**************************************************************************/
	/**************************************************************************/

    public function save()
    {
        $argument=array
        (
            'post_status'                                                       =>  'publish',
            'post_title'                                                        =>  $this->getSubject(),
            'post_content'                                                      =>  $this->getBody(),
            'post_type'                                                         =>  self::getCPTName()
        );
        
        $this->id=wp_insert_post($argument); 
        if($this->id==0) return(false);

        $postMeta=array
        (
            'sender_name'                                                       =>  $this->getSenderName(),
            'sender_email'                                                      =>  $this->getSenderEmail(),
            'recipient'                                                         =>  $this->getRecipient(),
            'cc'                                                                =>  $this->getCC(),
            'bcc'                                                               =>  $this->getBCC(),
            'reply_to'                                                          =>  $this->getReplyTo(),
            'user_ip'                                                           =>  $this->getUserIP(),
            'user_agent'                                                        =>  $this->getUserAgent(),
            'referrer_post_id'                                                  =>  $this->getReferrerPostId(),
            'referrer_post_name'                                                =>  $this->getReferrerPostName(),
            'extension_id'                                                      =>  $this->getExtensionId(),
            'extension_form_id'                                                 =>  $this->getExtensionFormId(),
            'extension_form_name'                                               =>  $this->getExtensionFormName(),
            'form_data'                                                         =>  $this->getFormData()
        );
        
        foreach($postMeta as $index=>$value)
            add_post_meta($this->id,PLUGIN_MFDS_CONTEXT.'_'.$index,$value);
    } 
    
    /**************************************************************************/
    
    public function get()
    {
        $this->post=get_post($this->id);
        if(is_null($this->post)) return(false);

        $this->setSubject($this->post->post_title);
        $this->setBody($this->post->post_content);
        
        $this->setSenderName($this->getPostMeta('sender_name'));
        $this->setSenderEmail($this->getPostMeta('sender_email'));
        
        $this->setRecipient($this->getPostMeta('recipient'));
        $this->setCC($this->getPostMeta('cc'));
        $this->setBCC($this->getPostMeta('bcc'));
        $this->setReplyTo($this->getPostMeta('reply_to'));
        
        $this->setUserIP($this->getPostMeta('user_ip'));
        $this->setUserAgent($this->getPostMeta('user_agent'));
        
        $this->setReferrerPostId($this->getPostMeta('referrer_post_id'));
        $this->setReferrerPostName($this->getPostMeta('referrer_post_name'));
        
        $this->setExtensionId($this->getPostMeta('extension_id'));
        $this->setExtensionFormId($this->getPostMeta('extension_form_id'));
        $this->setExtensionFormName($this->getPostMeta('extension_form_name'));
        
        $this->setFormData($this->getPostMeta('form_data'));
        $this->setFormFile($this->getPostMeta('form_file'));
    }
        
    /**************************************************************************/
    /**************************************************************************/
    
    public function setSenderName($senderName)
    {
        $this->senderName=$senderName;
    }
    
    public function getSenderName()
    {
        return($this->senderName);
    }
    
    public function setSenderEmail($senderEmail)
    {
        $this->senderEmail=$senderEmail;
    }
    
    public function getSenderEmail()
    {
        return($this->senderEmail);
    }
    
    public function getSender($format=0)
    {
        $sender=$this->formatEmail(array(array('name'=>$this->getSenderName(),'email'=>$this->getSenderEmail())));
        
        switch($format)
        {
            case 1:
                
                return(MFDSHelper::createMailToLink($sender));
        }
        
        return($sender);
    }
    
    /**************************************************************************/
    
    public function setRecipient($recipient)
    {
        $this->setEmailArray($this->recipient,$recipient);
    }
    
    public function getRecipient($format=0)
    {
        switch($format)
        {
            case 1:
                
                return(MFDSHelper::createMailToLink($this->formatEmail($this->recipient)));
                
            case 2:
                
                return($this->formatEmail($this->recipient));
                
        }
        
        return($this->recipient);
    } 
    
    /**************************************************************************/
    
    public function setCC($cc)
    {
        $this->setEmailArray($this->cc,$cc);
    }
    
    public function getCC($format=0)
    {
        switch($format)
        {
            case 1:
                
                return(MFDSHelper::createMailToLink($this->formatEmail($this->cc)));
                
            case 2:
                
                return($this->formatEmail($this->cc));
        }
        
        return($this->cc);
    }
    
    /**************************************************************************/
    
    public function setBCC($bcc)
    {
        $this->setEmailArray($this->bcc,$bcc);
    }
    
    public function getBCC($format=0)
    {
        switch($format)
        {
            case 1:
                
                return(MFDSHelper::createMailToLink($this->formatEmail($this->bcc)));
                
            case 2:
                
                return($this->formatEmail($this->bcc));               
        }
        
        return($this->bcc);
    }
    
    /**************************************************************************/
    
    public function setReplyTo($replyTo)
    {
        $this->setEmailArray($this->replyTo,$replyTo);
    }
    
    public function getReplyTo($format=0)
    {
        switch($format)
        {
            case 1:
                
                return(MFDSHelper::createMailToLink($this->formatEmail($this->replyTo)));
                
            case 2:
                
                return($this->formatEmail($this->replyTo));
        }
        
        return($this->replyTo);
    }    
   
    /**************************************************************************/
    
    public function setSubject($subject)
    {
        $this->subject=$subject;
    }
    
    public function getSubject()
    {
        return($this->subject);
    }
    
    /**************************************************************************/
    
    public function setBody($body)
    {
        $this->body=$body;
    }
    
    public function getBody($format=0)
    {
        switch($format)
        {
            case 1:
                
                return(nl2br(MFDSHelper::createLink($this->body)));
        }
        
        return($this->body);
    }
    
    /**************************************************************************/
    
    public function setUserIP($userIP=-1)
    {
        if($userIP===-1)
            $userIP=$_SERVER['REMOTE_ADDR'];
        
        $this->userIP=$userIP;
    }
    
    public function getUserIP()
    {
        return($this->userIP);
    }
    
    /**************************************************************************/
    
    public function setUserAgent($userAgent=-1)
    {
        if($userAgent===-1)
            $userAgent=$_SERVER['HTTP_USER_AGENT'];

        $this->userAgent=$userAgent;
    }
    
    public function getUserAgent()
    {
        return($this->userAgent);
    }
    
    /**************************************************************************/
    
    public function setReferrerPostId($referrerPostId=-1)
    {
        $this->referrerPostId=$referrerPostId;
    }
    
    public function getReferrerPostId()
    {
        return($this->referrerPostId);
    }
    
    /**************************************************************************/
    
    public function setReferrerPostName($referrerPostName)
    {
        $this->referrerPostName=$referrerPostName;
    }
    
    public function getReferrerPostName()
    {
        return($this->referrerPostName);
    }
    
    /**************************************************************************/
    
    public function setExtensionFormId($extensionFormId)
    {
        $this->extensionFormId=$extensionFormId;
    }
    
    public function getExtensionFormId()
    {
        return($this->extensionFormId);
    }
    
    /**************************************************************************/
    
    public function setExtensionFormName($extensionFormName)
    {
        $this->extensionFormName=$extensionFormName;
    }
    
    public function getExtensionFormName()
    {
        return($this->extensionFormName);
    }
   
    /**************************************************************************/
    /**************************************************************************/
    
    public function setExtensionId($extensionId)
    {
        $this->extensionId=$extensionId;
    }
    
    public function getExtensionId()
    {
        return($this->extensionId);
    }  
    
    /**************************************************************************/
    /**************************************************************************/
    
    public function setFormData($formData,$format=0)
    {
        switch($format)
        {
            case 1:
                
                $data=array();
                foreach($formData as $name=>$value)
                    $data[]=array('field_name'=>$name,'field_value'=>$value,'field_label'=>null);
                
                $formData=$data;
        }
        
        $this->formData=$formData;
    }
    
    /**************************************************************************/
    
    public function getFormData()
    {
        $formDataSort=array();
        $formDataTemp=$this->formData;
        
        foreach($this->formData as $index=>$value)
            $formDataSort[$index]=$value['field_name'];

        asort($formDataSort);

        $this->formData=array();
        foreach($formDataSort as $index=>$value)
            $this->formData[$index]=$formDataTemp[$index];
        
        return($this->formData);
    }
    
    /**************************************************************************/
    
    public function getSingleFormDataName($value)
    {
        $Validation=new MFDSValidation();
        if($Validation->isEmpty($value['field_label']))
            return($value['field_name']);
        
        return($value['field_label'].' ('.$value['field_name'].')');
    }
    
    /**************************************************************************/
    
    public function getSingleFormDataValue($value)
    {
        return(is_array($value['field_value']) ? join(', ',$value['field_value']) : $value['field_value']);
    }
    
    /**************************************************************************/
    /**************************************************************************/

    public function uploadFile($file)
    {
        if(!is_array($file)) return;
                
        $formFile=array();
        
        foreach($file as $index=>$value)
        {
            $fileName=basename($value);
            
            $result=wp_upload_bits($fileName,null,file_get_contents($value));
            if($result['error']) continue;
            
            $fileType=wp_check_filetype($fileName,null);

            $argument=array
            (
                'post_mime_type'                                                =>  $fileType['type'],
                'post_title'                                                    =>  $fileName,
                'post_content'                                                  =>  '',
                'post_status'                                                   =>  'inherit'
            );            
            
            $attachment=wp_insert_attachment($argument,$result['file'],$this->getReferrerPostId());
            if(!is_wp_error($attachment))
            {
                require_once(ABSPATH.'wp-admin/includes/image.php');
                
                $attachmentMetadata=wp_generate_attachment_metadata($attachment,$result['file']);
                wp_update_attachment_metadata($attachment,$attachmentMetadata);       
                
                $formFile[]=array('field_label'=>'','field_name'=>$index,'post_id'=>$attachment);
            }
        }
        
        add_post_meta($this->id,PLUGIN_MFDS_CONTEXT.'_form_file',$formFile);  
    }
    
    /**************************************************************************/
    
    public function getFormFile()
    {
        return($this->formFile);
    }
    
    /**************************************************************************/
    
    public function setFormFile($formFile)
    {
        foreach($formFile as $index=>$value)
        {
            $post=get_post($value['post_id']);

            if(is_null($post))
            {
                unset($this->formFile[$index]);
                continue;
            }
            
            $formFile[$index]['post_url']=admin_url('post.php?post='.$value['post_id'].'&action=edit');
            $formFile[$index]['post_title']=$post->post_title;       
        }   
        
        $this->formFile=$formFile;
    }
  
    /**************************************************************************/
    /**************************************************************************/
    
    private function getPostMeta($name)
    {
        if(is_null($this->postMeta))
        {
            $this->postMeta=get_post_meta($this->id);
            
            $toArray=array('recipient','cc','bcc','reply_to','form_data','form_file');
            foreach($toArray as $value)
                $this->postMeta[PLUGIN_MFDS_CONTEXT.'_'.$value][0]=maybe_unserialize($this->postMeta[PLUGIN_MFDS_CONTEXT.'_'.$value][0]);
        }

        $name=PLUGIN_MFDS_CONTEXT.'_'.$name;
        if(array_key_exists($name,$this->postMeta))
            return($this->postMeta[$name][0]);
        
        return('');
    }
       
    /**************************************************************************/ 
    /**************************************************************************/
    
    public function createEditFormLink()
    {
        $ExtensionManager=new MFDSExtensionManager();
        return($ExtensionManager->createEditFormLink($this->getExtensionId(),$this->getExtensionFormId(),$this->getExtensionFormName()));
    }
    
    /**************************************************************************/
    
    public function createEditPostLink()
    {
        return('<a href="'.get_edit_post_link($this->getReferrerPostId()).'" target="_blank">'.$this->getReferrerPostName().'</a>');
    }
    
    /**************************************************************************/
    /**************************************************************************/
    
    private function formatEmail($data,$delimiter=' ')
    {
        $ret=null;
        $Validation=new MFDSValidation();

        foreach($data as $value)
        {
            if($Validation->isNotEmpty($ret)) $ret.=$delimiter;
            if($Validation->isNotEmpty($value['name'])) $ret.=$value['name'].' ';
            $ret.=$value['email'];
        }
        
        return($ret);
    }
    
    /**************************************************************************/
    
    private function setEmailArray(&$var,$array)
    {
        $Validation=new MFDSValidation();
        
        if(is_array($array))
        {
            if((count($array)==2) && (isset($array['name'],$array['email'])))
                array_push($var,$array);
            else $var=$array;
        }
        else
        {
            if($Validation->isEmpty($array)) return;
            
            $position=strpos($array,',');
            
            if($position===false)
                array_push($var,array('name'=>'','email'=>$array));
            else
            {
                $data=explode(',',$array);                
                foreach($data as $value)
                {
                    if($Validation->isNotEmpty($value))
                        array_push($var,array('name'=>'','email'=>trim($value)));
                }
            }
        }
    }
        
    /**************************************************************************/
    /**************************************************************************/
    
    static function getCPTName()
    {
        return(PLUGIN_MFDS_CONTEXT.'_form_entry');
    }
    
	/**************************************************************************/
    
    static function registerCPT()
    {
		register_post_type
		(
			self::getCPTName(),
			array
			(
				'labels'=>array
				(
					'name'														=>	__('Multi Form Data Storage','multi-form-data-storage'),
					'singular_name'												=>	__('Multi Form Data Storage','multi-form-data-storage'),
					'add_new'													=>	__('Add New','multi-form-data-storage'),
					'edit_item'													=>	__('View Entry','multi-form-data-storage'),
					'all_items'													=>	__('All Entries','multi-form-data-storage'),
					'view_item'													=>	__('View Entry','multi-form-data-storage'),
					'search_items'												=>	__('Search Entries','multi-form-data-storage'),
					'not_found'													=>	__('No Entries Found','multi-form-data-storage'),
					'not_found_in_trash'										=>	__('No Entries Found in Trash','multi-form-data-storage'), 
					'parent_item_colon'											=>	'',
					'menu_name'													=>	__('MF Data Storage','multi-form-data-storage')
				),	
				'public'														=>	false,  
				'show_ui'														=>	true,  
				'capability_type'												=>	'post',
				'hierarchical'													=>	false,  
				'rewrite'														=>	true,  
				'supports'														=>	false,
                'menu_icon'                                                     =>  'dashicons-archive'
			)
		);	        
    }

    /**************************************************************************/
    
    public function getAllExtensionForm()
    {
        global $wpdb;
        
        $data=array(array(),array());
        
        $query="select post_id,meta_key,meta_value from ".$wpdb->prefix."postmeta where meta_key in ('".PLUGIN_MFDS_CONTEXT."_extension_id','".PLUGIN_MFDS_CONTEXT."_extension_form_id','".PLUGIN_MFDS_CONTEXT."_extension_form_name') and post_id in (select ID from ".$wpdb->prefix."posts where post_type='".PLUGIN_MFDS_CONTEXT."_form_entry')";
        $result=$wpdb->get_results($query);
        
        foreach($result as $line)
           $data[0][$line->post_id][$line->meta_key]=$line->meta_value; 

        foreach($data[0] as $line)
        {
            if(isset($line['mfds_extension_form_name']))
                $data[1][$line['mfds_extension_id']][$line['mfds_extension_form_id']]=$line['mfds_extension_form_name'];
        }
        
        return($data[1]);
    }

    /**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/