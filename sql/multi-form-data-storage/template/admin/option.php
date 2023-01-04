<?php
        $ExtensionManager=new MFDSExtensionManager();
?>
		<div class="to to-to" style="display:none">

			<form name="to_form" id="to_form" method="POST" action="#">

				<div id="to_notice"></div> 

				<div class="to-header to-clear-fix">

					<div class="to-header-left">

						<div>
							<h3><?php esc_html_e('QuanticaLabs','multi-form-data-storage'); ?></h3>
							<h6><?php esc_html_e('Plugin Options','multi-form-data-storage'); ?></h6>
						</div>

					</div>

					<div class="to-header-right">

						<div>
							<h3>
								<?php esc_html_e('Multi Form Data Storage','multi-form-data-storage'); ?>
							</h3>
							<h6>
								<?php echo sprintf(esc_html__('WordPress Plugin ver. %s','multi-form-data-storage'),PLUGIN_MFDS_VERSION); ?>
							</h6>
							&nbsp;&nbsp;
							<a href="<?php echo esc_url('http://support.quanticalabs.com'); ?>" target="_blank"><?php esc_html_e('Support Forum','multi-form-data-storage'); ?></a>
							<a href="<?php echo esc_url('https://codecanyon.net/user/quanticalabs'); ?>" target="_blank"><?php esc_html_e('Plugin site','multi-form-data-storage'); ?></a>
						</div>

						<a href="<?php echo esc_url('http://quanticalabs.com'); ?>" class="to-header-right-logo"></a>

					</div>

				</div>

				<div class="to-content to-clear-fix">

					<div class="to-content-left">

						<ul class="to-menu" id="to_menu">
							<li>
								<a href="#export"><?php esc_html_e('Export','multi-form-data-storage'); ?><span></span></a>
								<ul>
									<li><a href="#export_csv"><?php esc_html_e('CSV','multi-form-data-storage'); ?></a></li>
                                    <li><a href="#export_xml"><?php esc_html_e('XML','multi-form-data-storage'); ?></a></li>
                                </ul>
							</li>
                            <li>
								<a href="#extension"><?php esc_html_e('Extension','multi-form-data-storage'); ?><span></span></a>
								<ul>
                                    <?php echo $ExtensionManager->createOptionMenu(); ?>
                                </ul>
							</li>
						</ul>

					</div>

					<div class="to-content-right" id="to_panel">
<?php
		$content=array
        (
            'export_csv',
            'export_xml'
        );
        
		foreach($content as $value)
		{
?>
						<div id="<?php echo $value; ?>">
<?php
			$Template=new MFDSTemplate($this->data,PLUGIN_MFDS_TEMPLATE_PATH.'admin/option_'.$value.'.php');
			echo $Template->output(false);
?>
						</div>
<?php
		}
?>
                        <?php echo $ExtensionManager->createOptionPanel(); ?>
                        
					</div>

				</div>

				<div class="to-footer to-clear-fix">

					<div class="to-footer-left">

						<ul class="to-social-list">
							<li><a href="<?php echo esc_url('http://themeforest.net/user/QuanticaLabs?ref=quanticalabs'); ?>" class="to-social-list-envato" title="<?php esc_attr_e('Envato','multi-form-data-storage'); ?>"></a></li>
							<li><a href="<?php echo esc_url('http://www.facebook.com/QuanticaLabs'); ?>" class="to-social-list-facebook" title="<?php esc_attr_e('Facebook','multi-form-data-storage'); ?>"></a></li>
							<li><a href="<?php echo esc_url('https://twitter.com/quanticalabs'); ?>" class="to-social-list-twitter" title="<?php esc_attr_e('Twitter','multi-form-data-storage'); ?>"></a></li>
							<li><a href="<?php echo esc_url('http://quanticalabs.tumblr.com/'); ?>" class="to-social-list-tumblr" title="<?php esc_attr_e('Tumblr','multi-form-data-storage'); ?>"></a></li>
						</ul>

					</div>
					
					<div class="to-footer-right">
						<input type="submit" value="<?php esc_attr_e('Save changes','multi-form-data-storage'); ?>" name="Submit" id="Submit" class="to-button"/>
					</div>			
				
				</div>
				
				<input type="hidden" name="action" id="action" value="<?php echo esc_attr(PLUGIN_MFDS_CONTEXT.'_option_page_save'); ?>" />
				
				<script type="text/javascript">

					jQuery(document).ready(function($)
					{
						$('.to').themeOption();
						$('.to').themeOptionElement({init:true});
					});

				</script>

			</form>
			
		</div>