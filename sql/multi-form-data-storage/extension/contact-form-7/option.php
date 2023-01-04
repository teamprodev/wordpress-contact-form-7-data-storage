        <ul class="to-form-field-list">
            <li>
                <h5><?php esc_html_e('Enable','multi-form-data-storage'); ?></h5>
                <span class="to-legend"><?php esc_html_e('Enable or disable this extension.','multi-form-data-storage'); ?></span>                    
                <div class="to-radio-button">
                    <input type="radio" name="<?php MFDSHelper::getFormName('extension_contact_form_7_enable'); ?>" id="<?php MFDSHelper::getFormName('extension_contact_form_7_enable_1'); ?>" value="1" <?php MFDSHelper::checkedIf($this->data['option']['extension_contact_form_7_enable'],1); ?>/>
                    <label for="<?php MFDSHelper::getFormName('extension_contact_form_7_enable_1'); ?>"><?php esc_html_e('Enable','multi-form-data-storage'); ?></label>
                    <input type="radio" name="<?php MFDSHelper::getFormName('extension_contact_form_7_enable'); ?>" id="<?php MFDSHelper::getFormName('extension_contact_form_7_enable_0'); ?>" value="0" <?php MFDSHelper::checkedIf($this->data['option']['extension_contact_form_7_enable'],0); ?>/>
                    <label for="<?php MFDSHelper::getFormName('extension_contact_form_7_enable_0'); ?>"><?php esc_html_e('Disable','multi-form-data-storage'); ?></label>
                </div>                    
            </li>
        </ul>