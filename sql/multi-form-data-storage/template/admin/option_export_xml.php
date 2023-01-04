<?php
        $Export=$this->data['export'];
?>
            <ul class="to-form-field-list">
                <li>
                    <h5><?php esc_html_e('Data visibility','multi-form-data-storage'); ?></h5>
                    <span class="to-legend"><?php esc_html_e('Enable or disable visibility of data in exported XML file.','multi-form-data-storage'); ?></span>
<?php
        foreach($Export->getMetadata() as $metaName=>$metaData)
        {
            if(!isset($metaData['option']['format']['xml']['enable'])) continue;
            $optionName=$Export->getFullOptionName($metaName,'xml','enable');
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
            </ul>