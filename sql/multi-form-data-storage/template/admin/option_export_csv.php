<?php
        $Export=$this->data['export'];
?>
            <ul class="to-form-field-list">
                <li>
                    <h5><?php esc_html_e('Header visibility','multi-form-data-storage'); ?></h5>
                    <span class="to-legend"><?php esc_html_e('Enable or disable visibility of header in exported CSV file.','multi-form-data-storage'); ?></span>                    
                    <div class="to-radio-button">
                        <input type="radio" name="<?php MFDSHelper::getFormName('export_csv_header_enable'); ?>" id="<?php MFDSHelper::getFormName('export_csv_header_enable_1'); ?>" value="1" <?php MFDSHelper::checkedIf($this->data['option']['export_csv_header_enable'],1); ?>/>
                        <label for="<?php MFDSHelper::getFormName('export_csv_header_enable_1'); ?>"><?php esc_html_e('Enable','multi-form-data-storage'); ?></label>
                        <input type="radio" name="<?php MFDSHelper::getFormName('export_csv_header_enable'); ?>" id="<?php MFDSHelper::getFormName('export_csv_header_enable_0'); ?>" value="0" <?php MFDSHelper::checkedIf($this->data['option']['export_csv_header_enable'],0); ?>/>
                        <label for="<?php MFDSHelper::getFormName('export_csv_header_enable_0'); ?>"><?php esc_html_e('Disable','multi-form-data-storage'); ?></label>
                    </div>                    
                </li>
                <li>
                    <h5><?php esc_html_e('Column visibility','multi-form-data-storage'); ?>:</h5>
                    <span class="to-legend"><?php esc_html_e('Enable or disable visibility of column in exported CSV file.','multi-form-data-storage'); ?></span>
<?php
        foreach($Export->getMetadata() as $metaName=>$metaData)
        {
            if(!isset($metaData['option']['format']['csv']['enable'])) continue;
            $optionName=$Export->getFullOptionName($metaName,'csv','enable');
?>
                    <div class="to-clear-fix">
                        <span class="to-legend-field"><?php echo esc_html($metaData['option']['header']); ?>:</span>
                        <div class="to-radio-button">
                            <input type="radio" name="<?php MFDSHelper::getFormName($optionName); ?>" id="<?php MFDSHelper::getFormName($optionName.'_1'); ?>" value="1" <?php MFDSHelper::checkedIf($this->data['option'][$optionName],1); ?>/>
                            <label for="<?php MFDSHelper::getFormName($optionName.'_1'); ?>"><?php esc_html_e('Enable','multi-form-data-storage'); ?></label>
                            <input type="radio" name="<?php MFDSHelper::getFormName($optionName); ?>" id="<?php MFDSHelper::getFormName($optionName.'_0'); ?>" value="0" <?php MFDSHelper::checkedIf($this->data['option'][$optionName],0); ?>/>
                            <label for="<?php MFDSHelper::getFormName($optionName.'_0'); ?>"><?php esc_html_e('Disable','multi-form-data-storage'); ?></label>
                        </div>	
                    </div>
<?php          
        }
?>
                </li>
                <li>
                    <h5><?php esc_html_e('Column name','multi-form-data-storage'); ?>:</h5>
                    <span class="to-legend"><?php esc_html_e('Enter name of the column in header of exported CSV file. Name cannot be empty.','multi-form-data-storage'); ?></span>
<?php
        foreach($Export->getMetadata() as $metaName=>$metaData)
        {
            if(!isset($metaData['option']['format']['csv']['name'])) continue;
            $optionName=$Export->getFullOptionName($metaName,'csv','name');
?>
                    <div class="to-clear-fix">
                        <span class="to-legend-field"><?php echo esc_html($metaData['option']['header']); ?>:</span>
                        <input type="text" name="<?php MFDSHelper::getFormName($optionName); ?>" id="<?php MFDSHelper::getFormName($optionName); ?>" value="<?php echo esc_attr($this->data['option'][$optionName]); ?>"/>
                    </div>
<?php          
        }
?>
                </li> 
                <li>
                    <h5><?php esc_html_e('Form fields mapper','multi-form-data-storage'); ?>:</h5>
                    <span class="to-legend">
                        <?php esc_html_e('List of generated (by plugin) and translated (by user) names of fields (columns) from exported CSV file separated by semicolon. E.g:','multi-form-data-storage'); ?><br/>
                        <?php esc_html_e('[contact_form_7][1][field][your-message];Message','multi-form-data-storage'); ?><br/>
                        <?php esc_html_e('[contact_form_7][2][file][your-file];Attached file','multi-form-data-storage'); ?>
                    </span>
                    <div class="to-clear-fix">
                        <textarea name="<?php MFDSHelper::getFormName('export_csv_map'); ?>" id="<?php MFDSHelper::getFormName('export_csv_map'); ?>"><?php echo esc_html($this->data['option']['export_csv_map']); ?></textarea>
                    </div>
                </li>  
            </ul>