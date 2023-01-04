<?php 
        $Entry=$this->data->entry;
       
        echo $this->data->nonce; 
        
        $formFile=$Entry->getFormFile();
        $formData=$Entry->getFormData();
?>
        <div class="to">
            <div class="ui-tabs">
                <ul>
                    <li>
                        <a href="#meta-box-general-1">
                            <span>
                                <span class="mfds-icon-archive"></span>
                                <span><?php esc_html_e('General','multi-form-data-storage'); ?></span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="#meta-box-general-2">
                            <span>
                                <span class="mfds-icon-mail"></span>
                                <span><?php esc_html_e('Message','multi-form-data-storage'); ?></span>
                            </span>
                        </a>
                    </li>
<?php
        if(count($formData))
        {
?>
                    <li>
                        <a href="#meta-box-general-3">
                            <span>
                                <span class="mfds-icon-paper-plane"></span>
                                <span>
                                    <?php esc_html_e('Form data','multi-form-data-storage'); ?>
                                    (<?php echo count($formData); ?>)
                                </span>
                            </span>
                        </a>
                    </li>
<?php
        }
        if(count($formFile))
        {
?>
                    <li>
                        <a href="#meta-box-general-4">
                            <span>
                                <span class="mfds-icon-attachment"></span>
                                <span>
                                    <?php esc_html_e('Form files','multi-form-data-storage'); ?>
                                    (<?php echo count($formFile); ?>)
                                <span>
                            </span>
                        </a>
                    </li>
<?php
        }
?>
                </ul>
                <div id="meta-box-general-1">
                    <ul class="to-entry-table">
<?php
        MFDSTemplate::displayLine(
                esc_html__('Form name','multi-form-data-storage'),
                $Entry->createEditFormLink());
        
        MFDSTemplate::displayLine(
                esc_html__('Referrer post','multi-form-data-storage'),
                $Entry->createEditPostLink());
        
        MFDSTemplate::displayLine(
                esc_html__('User IP address','multi-form-data-storage'),
                $Entry->getUserIP());
        
        MFDSTemplate::displayLine(
                esc_html__('User agent name','multi-form-data-storage'),
                $Entry->getUserAgent());
?>
                    </ul>
                </div>
                <div id="meta-box-general-2">
                    <ul class="to-entry-table">
<?php
        MFDSTemplate::displayLine(
                esc_html__('Sender','multi-form-data-storage'),
                $Entry->getSender(1));
  
         MFDSTemplate::displayLine(
                esc_html__('Recipients','multi-form-data-storage'),
                $Entry->getRecipient(1));
         
        MFDSTemplate::displayLine(
                esc_html__('Carbon copy (CC)','multi-form-data-storage'),
                $Entry->getCC(1));
        
         MFDSTemplate::displayLine(
                esc_html('Blind carbon copy (CC','multi-form-data-storage'),
                $Entry->getBCC(1));
         
        MFDSTemplate::displayLine(
                esc_html__('Reply to','multi-form-data-storage'),
                $Entry->getReplyTo(1));
        
        MFDSTemplate::displayLine(
                esc_html__('Subject','multi-form-data-storage'),
                esc_html($Entry->getSubject()));
        
        MFDSTemplate::displayLine(
                esc_html__('Message','multi-form-data-storage'),
                $Entry->getBody(1));
?>
                    </ul>
                </div>
<?php
        if(count($formData))
        {
?>
                <div id="meta-box-general-3">

                    <ul class="to-entry-table">
<?php
            foreach($formData as $index=>$value)
            {
?>                
                        <li>
                            <div><?php echo esc_html($Entry->getSingleFormDataName($value)); ?></div>
                            <div><?php echo nl2br(esc_html($Entry->getSingleFormDataValue($value))); ?></div>
                        </li>           
<?php          
            }
?>
                    </ul>
                </div>
<?php
        }
        if(count($formFile))
        {
?>
                <div id="meta-box-general-4">
                    <ul class="to-entry-table">
<?php
            foreach($formFile as $index=>$value)
            {
?>                
                        <li>
                            <div><?php echo esc_html($Entry->getSingleFormDataName($value)); ?></div>
                            <div><a href="<?php echo esc_attr($value['post_url']); ?>" target="_blank"><?php echo esc_html($value['post_title']); ?></a></div>
                        </li>           
<?php          
            }
?>
                    </ul>
                </div>  
<?php
        }
?>
            </div>
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function($) 
            {
                $('.to').themeOption();
				var element=$('.to').themeOptionElement({init:true});
                element.bindBrowseMedia('.to-button-browse');
            });
        </script>