<?php

/******************************************************************************/
/******************************************************************************/

class MFDSExport
{
    /**************************************************************************/
    
    protected $data;
    protected $header;
    protected $content;
    
	/**************************************************************************/

	function __construct()
	{
        $this->content=null;
        
        $this->data=array();
        $this->header=array();
        
        $this->metadata=array
        (
            'sender'                                                            =>  array
            (
                'option'                                                        =>  array
                (
                    'header'                                                    =>  __('Sender','multi-form-data-storage'),
                    'format'                                                    =>  array
                    (
                        'xml'                                                   =>  array
                        (
                            'enable'                                            =>  '1'
                        ),
                        'csv'                                                   =>  array
                        (
                            'enable'                                            =>  '1',
                            'name'                                              =>  'Sender',
                        )
                    )
                ),
                'getFunction'                                                   =>  'getSender'
            ),
            'recipient'                                                         =>  array
            (
                'option'                                                        =>  array
                (
                    'header'                                                    =>  __('Recipients','multi-form-data-storage'),
                    'format'                                                    =>  array
                    (
                        'xml'                                                   =>  array
                        (
                            'enable'                                            =>  '1'
                        ),
                        'csv'                                                   =>  array
                        (
                            'enable'                                            =>  '1',
                            'name'                                              =>  'Recipient',
                        )
                    )
                )
            ),
            'cc'                                                                =>  array
            (
                'option'                                                        =>  array
                (
                    'header'                                                    =>  __('Carbon copy (CC)','multi-form-data-storage'),
                    'format'                                                    =>  array
                    (
                        'xml'                                                   =>  array
                        (
                            'enable'                                            =>  '1'
                        ),
                        'csv'                                                   =>  array
                        (
                            'enable'                                            =>  '1',
                            'name'                                              =>  'CC',
                        )
                    )
                )
            ),            
            'bcc'                                                               =>  array
            (
                'option'                                                        =>  array
                (
                    'header'                                                    =>  __('Blind carbon copy (BCC)','multi-form-data-storage'),
                    'format'                                                    =>  array
                    (
                        'xml'                                                   =>  array
                        (
                            'enable'                                            =>  '1'
                        ),
                        'csv'                                                   =>  array
                        (
                            'enable'                                            =>  '1',
                            'name'                                              =>  'BCC',
                        )
                    )
                )
            ),               
            'reply_to'                                                          =>  array
            (
                'option'                                                        =>  array
                (
                    'header'                                                    =>  __('Reply to','multi-form-data-storage'),
                    'format'                                                    =>  array
                    (
                        'xml'                                                   =>  array
                        (
                            'enable'                                            =>  '1'
                        ),
                        'csv'                                                   =>  array
                        (
                            'enable'                                            =>  '1',
                            'name'                                              =>  'Reply To',
                        )
                    )
                )
            ),             
            'subject'                                                           =>  array
            (
                'option'                                                        =>  array
                (
                    'header'                                                    =>  __('Subject','multi-form-data-storage'),
                    'format'                                                    =>  array
                    (
                        'xml'                                                   =>  array
                        (
                            'enable'                                            =>  '1'
                        ),
                        'csv'                                                   =>  array
                        (
                            'enable'                                            =>  '1',
                            'name'                                              =>  'Subject',
                        )
                    )
                ),
                'getFunction'                                                   =>  'getSubject'
            ),            
            'body'                                                              =>  array
            (
                'option'                                                        =>  array
                (
                    'header'                                                    =>  __('Body','multi-form-data-storage'),
                    'format'                                                    =>  array
                    (
                        'xml'                                                   =>  array
                        (
                            'enable'                                            =>  '1'
                        ),
                        'csv'                                                   =>  array
                        (
                            'enable'                                            =>  '1',
                            'name'                                              =>  'Body',
                        )
                    )
                ),
                'getFunction'                                                   =>  'getBody'
            ),             
            'user_ip'                                                           =>  array
            (
                'option'                                                        =>  array
                (
                    'header'                                                    =>  __('User IP','multi-form-data-storage'),
                    'format'                                                    =>  array
                    (
                        'xml'                                                   =>  array
                        (
                            'enable'                                            =>  '1'
                        ),
                        'csv'                                                   =>  array
                        (
                            'enable'                                            =>  '1',
                            'name'                                              =>  'User IP',
                        )
                    )
                ),
                'getFunction'                                                   =>  'getUserIP',
            ),
            'user_agent'                                                        =>  array
            (
                'option'                                                        =>  array
                (
                    'header'                                                    =>  __('User agent','multi-form-data-storage'),
                    'format'                                                    =>  array
                    (
                        'xml'                                                   =>  array
                        (
                            'enable'                                            =>  '1'
                        ),
                        'csv'                                                   =>  array
                        (
                            'enable'                                            =>  '1',
                            'name'                                              =>  'User agent',
                        )
                    )
                ),
                'getFunction'                                                   =>  'getUserAgent',
            ),
            'referrer_post_name'                                                =>  array
            (
                'option'                                                        =>  array
                (
                    'header'                                                    =>  __('Referrer post name','multi-form-data-storage'),
                    'format'                                                    =>  array
                    (
                        'xml'                                                   =>  array
                        (
                            'enable'                                            =>  '1'
                        ),
                        'csv'                                                   =>  array
                        (
                            'enable'                                            =>  '1',
                            'name'                                              =>  'Referrer post name',
                        )
                    )
                ),
                'getFunction'                                                   =>  'getReferrerPostName'
            ),
            'extension_form_name'                                                 =>  array
            (
                'option'                                                        =>  array
                (
                    'header'                                                    =>  __('Form name','multi-form-data-storage'),
                    'format'                                                    =>  array
                    (
                        'xml'                                                   =>  array
                        (
                            'enable'                                            =>  '1'
                        ),
                        'csv'                                                   =>  array
                        (
                            'enable'                                            =>  '1',
                            'name'                                              =>  'Form name',
                        )
                    )
                ),
                'getFunction'                                                   =>  'getExtensionFormName'
            ),
            'form_data'                                                          =>  array
            (
                'option'                                                        =>  array
                (
                    'header'                                                    =>  __('Form data','multi-form-data-storage'),
                    'format'                                                    =>  array
                    (
                        'xml'                                                   =>  array
                        (
                            'enable'                                            =>  '1'
                        ),
                        'csv'                                                   =>  array
                        (
                            'enable'                                            =>  '1'
                        )
                    )
                )
            ),
            'form_file'                                                          =>  array
            (
                'option'                                                        =>  array
                (
                    'header'                                                    =>  __('Form files','multi-form-data-storage'),
                    'format'                                                    =>  array
                    (
                        'xml'                                                   =>  array
                        (
                            'enable'                                            =>  '1'
                        ),
                        'csv'                                                   =>  array
                        (
                            'enable'                                            =>  '1'
                        )
                    )
                )
            )
        ); 
	}
    
    /**************************************************************************/
    
    public function getMetadata()
    {
        return($this->metadata);
    }
    
    /**************************************************************************/
    
    protected function setData()
    {
        $post=$this->getPostFromRequest();
        
        $argument=array
        (
            'orderby'                                                           =>  'date',
            'order'                                                             =>  'asc',
            'post_type'                                                         =>  MFDSFormEntry::getCPTName(),
            'posts_per_page'                                                    =>  -1
        );
        
        if(count($post)) $argument['post__in']=$post;
        
        $result=get_posts($argument);
        if(is_null($result)) return;
        
        foreach($result as $value)
        { 
            $Entry=new MFDSFormEntry($value->ID);
            $Entry->get();
        
            $line=array();
            
            $line['extension_id']=$Entry->getExtensionId();
            $line['extension_form_id']=$Entry->getExtensionFormId();

            foreach($this->getMetadata() as $metaName=>$metaData)
            {
                switch($metaName)
                {
                    case 'recipient':
                      
                        $line[$metaName]=$Entry->getRecipient(2);
                        
                    break;
                
                    case 'cc':
                      
                        $line[$metaName]=$Entry->getCC(2);
                        
                    break;
                
                    case 'bcc':
                      
                        $line[$metaName]=$Entry->getBCC(2);
                        
                    break;
                
                    case 'reply_to':
                      
                        $line[$metaName]=$Entry->getReplyTo(2);
                        
                    break;
                
                    case 'extension_form_id':
                        
                        list(,$line[$metaName])=$Entry->getExtensionFormName();
                        
                    break;
                    
                    case 'form_data':
                        
                        $line['form_data']=$Entry->getFormData();
                        
                    break;
                    
                    case 'form_file':
                        
                        $line['form_file']=$Entry->getFormFile();
                        
                    break;
                    
                    default:
                        
                        $line[$metaName]=call_user_func(array($Entry,$metaData['getFunction']));
                }
            }
            
            array_push($this->data,$line);
        }  
    }

    /**************************************************************************/
    
    protected function download($contentFileName,$contentFileType)
    {
        $content=$this->getContent();
        
        $Validation=new MFDSValidation();
        if($Validation->isEmpty($content)) return;

        header('Content-Type: '.$contentFileType);
        header('Content-Description: File Transfer'); 
        header('Content-Disposition: attachment; filename='.basename($contentFileName)); 
        echo $content;
        exit;
    }
    
    /**************************************************************************/
    
    private function getContent()
    {
        return($this->content);
    }

	/**************************************************************************/
    
    private function getPostFromRequest()
    {
        if(!isset($_GET['post'])) return(array());
        return(array_map('intval',$_GET['post']));
    }
    
    /**************************************************************************/
    
    public function getFullOptionName($metaName,$formatName,$optionName)
    {
        return('export_data_'.$metaName.'_format_'.$formatName.'_option_'.$optionName);
    }
    
    /**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/