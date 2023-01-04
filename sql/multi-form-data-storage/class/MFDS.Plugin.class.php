<?php

/******************************************************************************/
/******************************************************************************/

class MFDSPlugin
{
    /**************************************************************************/
    
    private $optionDefault;
    private $libraryDefault;

    /**************************************************************************/	
	
	function __construct()
	{
        /***/
        
		$this->libraryDefault=array
		(
			'script'															=>	array
			(
				'use'															=>	1,
				'inc'															=>	true,
				'path'															=>	PLUGIN_MFDS_SCRIPT_URL,
				'file'															=>	'',
				'in_footer'														=>	true,
				'dependencies'													=>	array('jquery'),
			),
			'style'																=>	array
			(
				'use'															=>	1,
				'inc'															=>	true,
				'path'															=>	PLUGIN_MFDS_STYLE_URL,
				'file'															=>	'',
				'dependencies'													=>	array()
			)
		);
        
        /***/
        
        $this->optionDefault=array
        (
            'export_csv_header_enable'                                          =>  '1',
            'export_csv_map'                                                    =>  ''
        );
        
        $Export=new MFDSExport();
        foreach($Export->getMetadata() as $metaName=>$metaData)
        {
            $format=$metaData['option']['format'];
            foreach($format as $formatName=>$formatData)
            {
                foreach($formatData as $optionName=>$optionValue)
                    $this->optionDefault[$Export->getFullOptionName($metaName,$formatName,$optionName)]=$optionValue;
            }
        }	
        
        /***/
        
        $ExtensionManager=new MFDSExtensionManager();
        $option=$ExtensionManager->getOptionDeafult();
        
        foreach($option as $value)
            $this->optionDefault=array_merge($this->optionDefault,$value);
	}
	
	/**************************************************************************/
	
	private function prepareLibrary()
	{
		$this->library=array
		(
			'script'															=>	array
			(
				'jquery-ui-core'												=>	array
				(
					'path'														=>	''
				),
				'jquery-ui-tabs'												=>	array
				(
					'path'														=>	''
				),
				'jquery-ui-button'												=>	array
				(
					'path'														=>	''
				),
				'jquery-colorpicker'											=>	array
				(
					'file'														=>	'jquery.colorpicker.js'
				),
				'jquery-dropkick'												=>	array
				(
					'file'														=>	'jquery.dropkick.min.js'
				),
				'jquery-qtip'													=>	array
				(
					'file'														=>	'jquery.qtip.min.js'
				),
				'jquery-blockUI'												=>	array
				(
					'file'														=>	'jquery.blockUI.js'
				),	
				'jquery-infieldlabel'											=>	array
				(
					'file'														=>	'jquery.infieldlabel.min.js'
				),
				'jquery-themeOption'											=>	array
				(
					'file'														=>	'jquery.themeOption.js'
				),
				'jquery-themeOptionElement'										=>	array
				(
					'file'														=>	'jquery.themeOptionElement.js'
				),
				'mfds-admin'                                                    =>	array
				(
					'file'														=>	'admin.js'
				),						
			),
			'style'																=>	array
			(
				'google-font-open-sans'											=>	array
				(
					'path'														=>	'', 
					'file'														=>	add_query_arg(array('family'=>urlencode('Open Sans:300,300i,400,400i,600,600i,700,700i,800,800i'),'subset'=>'cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese'),'//fonts.googleapis.com/css')
				),
				'jquery-ui'														=>	array
				(
					'file'														=>	'jquery.ui.min.css',
				),
				'jquery-qtip'   												=>	array
				(
					'file'														=>	'jquery.qtip.min.css',
				),
				'jquery-themeOption'											=>	array
				(
					'file'														=>	'jquery.themeOption.css'
				),
				'mfds-jquery-themeOption-overwrite'								=>	array
				(
					'file'														=>	'jquery.themeOption.overwrite.css'
				)			
			)
		);		
	}	
	
	/**************************************************************************/
	
	private function addLibrary($type,$use)
	{
		foreach($this->library[$type] as $index=>$value)
			$this->library[$type][$index]=array_merge($this->libraryDefault[$type],$value);
		
		foreach($this->library[$type] as $index=>$data)
		{
			if(!$data['inc']) continue;
			
			if($data['use']!=3)
			{
				if($data['use']!=$use) continue;
			}			
			
			if($type=='script')
			{
				wp_enqueue_script($index,$data['path'].$data['file'],$data['dependencies'],false,$data['in_footer']);
			}
			else 
			{
				wp_enqueue_style($index,$data['path'].$data['file'],$data['dependencies'],false);
			}
		}
	}
	
	/**************************************************************************/
	
	public function pluginActivation()
	{        
		MFDSOption::updateOption($this->optionDefault);
	}
	
	/**************************************************************************/
	
	public function pluginDeactivation()
	{

	}
    
    /**************************************************************************/
    
    public function setupTheme()
    {

    }
        
	/**************************************************************************/
	
	public function init()
	{
        MFDSFormEntry::registerCPT();
        
        MFDSOption::createOption();
        
        add_action('admin_init',array($this,'adminInit'));
        add_action('admin_menu',array($this,'adminMenu'));
        
        add_action('wp_ajax_'.PLUGIN_MFDS_CONTEXT.'_option_page_save',array($this,'adminOptionPanelSave'));
        
        add_action('add_meta_boxes',array($this,'adminInitMetaBox'));
        
		add_filter('manage_edit-'. MFDSFormEntry::getCPTName().'_columns',array($this,'manageEditColumn')); 
		add_action('manage_'. MFDSFormEntry::getCPTName().'_posts_custom_column',array($this,'manageColumn'));
		add_filter('manage_edit-'. MFDSFormEntry::getCPTName().'_sortable_columns',array($this,'manageEditSortableColumn'));
        
        add_filter('post_row_actions',array($this,'postRowActions'),10,2);
        
		add_action('restrict_manage_posts',array($this,'restrictManagePosts'));
		add_filter('parse_query',array($this,'parseQuery'));
        
        new MFDSExtensionManager();

        $this->export();
	}
    
	/**************************************************************************/
	
	public function publicInit()
	{
		$this->prepareLibrary();
		
		$this->addLibrary('style',2);
		$this->addLibrary('script',2);	
	}
	
	/**************************************************************************/
	
	public function adminInit()
	{
		$this->prepareLibrary();
		
		$this->addLibrary('style',1);
		$this->addLibrary('script',1);
	}
    
    /**************************************************************************/
    
    public function adminMenu()
    {
   		global $submenu;
		unset($submenu['edit.php?post_type='.MFDSFormEntry::getCPTName()][10]);
        add_options_page(__('MF Data Storage','multi-form-data-storage'),__('MF Data Storage','multi-form-data-storage'),'edit_theme_options',PLUGIN_MFDS_CONTEXT,array($this,'adminCreateOptionPage'));
    }
    
    /**************************************************************************/
    
    public function adminCreateOptionPage()
    {
		$data=array();
        
        $Export=new MFDSExport();
        $Extension=new MFDSExtension();
        
        $data['export']=$Export;
        $data['extension']=$Extension;
        
        $data['option']=MFDSOption::getOptionObject();
        
		$Template=new MFDSTemplate($data,PLUGIN_MFDS_TEMPLATE_PATH.'admin/option.php');
		echo $Template->output();	
    }
    
    /**************************************************************************/
    
    public function adminOptionPanelSave()
    {        
        $option=MFDSHelper::getPostOption();

        $response=array('global'=>array('error'=>1));

        $Notice=new MFDSNotice();
        $Export=new MFDSExport();
        $Validation=new MFDSValidation($Notice);
        $ExtensionManager=new MFDSExtensionManager();
        
        $Validation->notice('isBool',array($option['export_csv_header_enable']),array(MFDSHelper::getFormName('export_csv_header_enable',false),__('This field conatins invalid value.','multi-form-data-storage')));
        
        foreach($Export->getMetadata() as $metaName=>$metaData)
        {
            foreach($metaData['option']['format'] as $formatName=>$formatData)
            {
                foreach($formatData as $optionName=>$optionValue)
                {
                    $fullOptionName=$Export->getFullOptionName($metaName,$formatName,$optionName);
                   
                    switch($optionName)
                    {
                        case 'name':
                            
                            $Validation->notice('isNotEmpty',array($option[$fullOptionName]),array(MFDSHelper::getFormName($fullOptionName,false),__('This field cannot be empty.','multi-form-data-storage')));
                            
                        break;
                    
                        case 'enable':
                           
                            $Validation->notice('isBool',array($option[$fullOptionName]),array(MFDSHelper::getFormName($fullOptionName,false),__('This field conatins invalid value.','multi-form-data-storage')));
                            
                        break;
                    }
               
                }
            }
        }
        
        $ExtensionManager->optionSave($Validation);
        
		if($Notice->isError())
		{
			$response['local']=$Notice->getError();
		}
		else
		{
			$response['global']['error']=0;
			MFDSOption::updateOption($option);
		}

		$response['global']['notice']=$Notice->createHTML(PLUGIN_MFDS_TEMPLATE_PATH.'notice.php');

		echo json_encode($response);
		exit;
    }
    
    /**************************************************************************/
    
    public function adminInitMetaBox()
    {
        add_meta_box('meta_box_'.MFDSFormEntry::getCPTName().'_general',__('General','multi-form-data-storage'),array($this,'adminCreateMetaBoxGeneral'),MFDSFormEntry::getCPTName(),'normal','default');
    
        add_filter('postbox_classes_'.MFDSFormEntry::getCPTName().'_meta_box_'.MFDSFormEntry::getCPTName().'_general',array($this,'adminCreateMetaBoxClass'));
    }
    
    /**************************************************************************/
    
    public function adminCreateMetaBoxGeneral()
    {
        global $post;
        
		$data=new stdClass();
        
        $data->entry=new MFDSFormEntry($post->ID);
        $data->entry->get();
        
        $data->nonce=wp_nonce_field('adminSaveMetaBox','storage_meta_box_noncename',false,false);
        
		$Template=new MFDSTemplate($data,PLUGIN_MFDS_TEMPLATE_PATH.'admin/meta_box_general.php');
		echo $Template->output();	       
    }
    
    /**************************************************************************/
    
    public function adminCreateMetaBoxClass($class) 
    {
        array_push($class,'to-postbox-1');
        return($class);
    }
    
	/**************************************************************************/
    /**************************************************************************/
    
	public function manageEditSortableColumn($column)
	{
		$column['title']='title';
		$column['sender']='sender';
		$column['date']='date';
		return($column);
	}
    
    /**************************************************************************/
    
	public function manageEditColumn($column)
	{
		$column=array
		(  
			'cb'																=>	'<input type="checkbox"/>',
            'title'																=>	__('Subject','multi-form-data-storage'),
            'sender'                                                            =>	__('Sender','multi-form-data-storage'),
			'form'                                                              =>	__('Form name','multi-form-data-storage'),
			'date'																=>	__('Date','multi-form-data-storage')
		);   
		
		return($column);  
	}  
    
    /**************************************************************************/
    
	public function manageColumn($column)
	{		
		global $post;
		
        $Entry=new MFDSFormEntry($post->ID);
        $Entry->get();
        
		switch($column) 
		{
			case 'sender':
                
                echo $Entry->getSender(1);
				
			break;
		
			case 'form':

                echo $Entry->createEditFormLink();
               
			break;
		}
	}    
    
    /**************************************************************************/
	
    public function postRowActions($actions,$post)
    {
        if($post->post_type==MFDSFormEntry::getCPTName())
        {   
            $Entry=new MFDSFormEntry($post->ID);
            $Entry->get();
            
            $actions['entry-preview']='<a href="#" class="to-entry-preview-link">'.esc_html__('Preview','multi-form-data-storage').'</a><div class="to-entry-preview-body"><tt>'.$Entry->getBody(1).'</tt></div>';
        }
        
        return($actions);
    }
    
    /**************************************************************************/
    
    public function restrictManagePosts()
    {
		if(!is_admin()) return;
        if(get_query_var('post_type')!==MFDSFormEntry::getCPTName()) return;
        
        /***/
        
        $Entry=new MFDSFormEntry();
        $ExtensionManager=new MFDSExtensionManager();
        
        $form=$Entry->getAllExtensionForm();

        if(count($form))
        {
            $html=null;
            
            foreach($form as $extensionId=>$extensionData)
            {
                $html.='<optgroup label="'.esc_attr($ExtensionManager->getExtensionName($extensionId)).'">';

                foreach($extensionData as $extensionFormId=>$extensionFormName)
                {
                    $id=$extensionId.'-'.$extensionFormId;
                    $html.='<option value="'.esc_attr($id).'"'.MFDSHelper::selectedIf($id,MFDSHelper::getGetValue('extension_form'),false).'>'.esc_html($extensionFormName).'</option>';
                }
                
                $html.='</optgroup>';
            }
            
            echo
            '
                <select name="'.PLUGIN_MFDS_CONTEXT.'_extension_form" id="'.PLUGIN_MFDS_CONTEXT.'_extension_form">
                    <option value="-1">'.esc_html('[All forms]','multi-form-data-storage').'</option>
                    '.$html.'
                </select>
            ';
        }
        
        /**/
        
        echo 
        '
            <input type="submit" id="'.PLUGIN_MFDS_CONTEXT.'_export" class="button" value="'.esc_attr__('Export','multi-form-data-storage').'" >
            <select name="'.PLUGIN_MFDS_CONTEXT.'_export_option" id="'.PLUGIN_MFDS_CONTEXT.'_export_option">
                <option value="0">'.__('[Select export option]','multi-form-data-storage').'</option>
                <option value="1">'.__('Export to XML','multi-form-data-storage').'</option>
                <option value="2">'.__('Export to CSV (tab)','multi-form-data-storage').'</option>
                <option value="3">'.__('Export to CSV (semicolon)','multi-form-data-storage').'</option>
            </select>
        ';
    }
	
	/**************************************************************************/
    
    public function parseQuery($query) 
    {
        if(!is_admin()) return;
        if(get_query_var('post_type')!==MFDSFormEntry::getCPTName()) return;
        if($query->query['post_type']!==MFDSFormEntry::getCPTName()) return;
        
        $metaQuery=array();
        $Validation=new MFDSValidation();
        
        /***/

        $extensionForm=MFDSHelper::getGetValue('extension_form');
        
        if($Validation->isNotEmpty($extensionForm))
        {
            list($extensionId,$extensionFormId)=explode('-',$extensionForm);
            
 			array_push($metaQuery,array
			(
				'key'															=>	PLUGIN_MFDS_CONTEXT.'_extension_id',
				'value'															=>	$extensionId
			));
            
			array_push($metaQuery,array
			(
				'key'															=>	PLUGIN_MFDS_CONTEXT.'_extension_form_id',
				'value'															=>	$extensionFormId
			));
        }
        
        /***/
        
        $order=MFDSHelper::getGetValue('order',false);
		$orderby=MFDSHelper::getGetValue('orderby',false);
		
        switch($orderby)
        {
            case 'title':
            case 'subject':
             
                $query->set('orderby','title');
                
            break;
                
            case 'sender':
                
                $query->set('meta_key',PLUGIN_MFDS_CONTEXT.'_sender');
                $query->set('orderby','meta_value');
                
            break; 
        }
        
        $query->set('order',$order);
        
        /***/
        
        if(count($metaQuery)) $query->set('meta_query',$metaQuery);
    }
    
    /**************************************************************************/
    
    public function export()
    {
        if((int)MFDSHelper::getGetValue('action')===1)
        {
            $exportOption=(int)MFDSHelper::getGetValue('export_option');

            if(in_array($exportOption,array(1,2,3)))
            {
                if($exportOption==1)
                   $Export=new MFDSExportXML();
                else
                   $Export=new MFDSExportCSV($exportOption==2 ? 9 : 59);

                $Export->export();
            }
        }
    }
        
    /**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/