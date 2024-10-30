<?php
	global $wp_cm_tmc_items, $wp_cm_agm_items, $otw_lcm_skins, $wp_cm_cs_items, $otw_lcm_plugin_id;
	
	$otw_lcm_plugin_options = get_option( 'otw_cm_plugin_options' );
	
	//pupulate form values
	$db_values = array();
	$db_values['shortcode_editor_button_for'] = array();
	$db_values['grid_for'] = array();
	$db_values['cs_for'] = array();
	$db_values['otw_cm_skin'] = 'carbon';
	$db_values['otw_cm_grid_previews'] = 'no';
	
	$db_values['otw_cm_promotions'] = get_option( $otw_lcm_plugin_id.'_dnms' );
	
	if( empty( $db_values['otw_cm_promotions'] ) ){
		$db_values['otw_cm_promotions'] = 'on';
	}
	
	
	if( otw_post( 'otw_cm_skin', false ) ){
		$db_values['otw_cm_skin'] = otw_post( 'otw_cm_skin', '' );
	}elseif( isset( $otw_lcm_plugin_options['otw_cm_skin'] ) ){
		$db_values['otw_cm_skin'] = $otw_lcm_plugin_options['otw_cm_skin'];
	}
	
	if( otw_post( 'otw_cm_grid_previews', false ) ){
		$db_values['otw_cm_grid_previews'] = otw_post( 'otw_cm_grid_previews', '' );
	}elseif( isset( $otw_lcm_plugin_options['otw_cm_grid_previews'] ) && strlen( $otw_lcm_plugin_options['otw_cm_grid_previews'] ) ){
		$db_values['otw_cm_grid_previews'] = $otw_lcm_plugin_options['otw_cm_grid_previews'];
	}
	
	foreach( $wp_cm_tmc_items as $item_key => $wpItem ){
		
		//shortcode editor values
		$db_values['shortcode_editor_button_for'][ $item_key ] = '';
		
		if( otw_post( 'otw_cm_editor_shortcodes', false ) ){
			
			if( otw_post( array( 'otw_cm_editor_shortcodes', $item_key ), false ) && otw_post( array( 'otw_cm_editor_shortcodes', $item_key ), array() ) == 1  ){
				$db_values['shortcode_editor_button_for'][ $item_key ] = ' checked="checked"';
			}
			
		}elseif( isset( $otw_lcm_plugin_options['shortcode_editor_button_for'] ) && isset( $otw_lcm_plugin_options['shortcode_editor_button_for'][ $item_key ] ) ){
			
			if( $otw_lcm_plugin_options['shortcode_editor_button_for'][ $item_key ] == 1 ){
				$db_values['shortcode_editor_button_for'][ $item_key ] = ' checked="checked"';
			}
			
		}elseif( !isset( $otw_lcm_plugin_options['shortcode_editor_button_for'] ) || !isset( $otw_lcm_plugin_options['shortcode_editor_button_for'][ $item_key ] ) ){
			
			$db_values['shortcode_editor_button_for'][ $item_key ] = ' checked="checked"';
		}
		
	}
	
	foreach( $wp_cm_agm_items as $item_key => $wpItem ){
		
		//grid values
		$db_values['grid_for'][ $item_key ] = '';
		
		if( otw_post( 'otw_cm_grid', false ) ){
			
			if( isset( otw_post( 'otw_cm_grid', '' )[ $item_key ] ) && otw_post( 'otw_cm_grid', '' )[ $item_key ] == 1  ){
				$db_values['grid_for'][ $item_key ] = ' checked="checked"';
			}
			
		}elseif( isset( $otw_lcm_plugin_options['grid_for'] ) && isset( $otw_lcm_plugin_options['grid_for'][ $item_key ] ) ){
			
			if( $otw_lcm_plugin_options['grid_for'][ $item_key ] == 1 ){
				$db_values['grid_for'][ $item_key ] = ' checked="checked"';
			}
			
		}elseif( !isset( $otw_lcm_plugin_options['grid_for'] ) || !isset( $otw_lcm_plugin_options['grid_for'][ $item_key ] ) ){
			
			$db_values['grid_for'][ $item_key ] = ' checked="checked"';
		}
	}
	
	foreach( $wp_cm_cs_items as $item_key => $wpItem ){
		
		//grid values
		$db_values['cs_for'][ $item_key ] = '';
		
		if( otw_post( 'otw_cm_cs', false ) ){
			
			if( isset( otw_post( 'otw_cm_cs', '' )[ $item_key ] ) && otw_post( 'otw_cm_cs', '' )[ $item_key ] == 1  ){
				$db_values['cs_for'][ $item_key ] = ' checked="checked"';
			}
			
		}elseif( isset( $otw_lcm_plugin_options['cs_for'] ) && isset( $otw_lcm_plugin_options['cs_for'][ $item_key ] ) ){
			
			if( $otw_lcm_plugin_options['cs_for'][ $item_key ] == 1 ){
				$db_values['cs_for'][ $item_key ] = ' checked="checked"';
			}
			
		}elseif( !isset( $otw_lcm_plugin_options['cs_for'] ) || !isset( $otw_lcm_plugin_options['cs_for'][ $item_key ] ) ){
			
			$db_values['cs_for'][ $item_key ] = ' checked="checked"';
		}
	}
	
$message = '';
$massages = array();
$messages[1] = esc_html__( 'Settings saved', 'otw_cm' );

if( otw_get('message',false) && isset( $messages[ otw_get('message','') ] ) ){
	$message .= $messages[ otw_get('message','') ];
}
?>
<?php if ( $message ) : ?>
<div id="message" class="updated"><p><?php echo esc_html( $message ); ?></p></div>
<?php endif; ?>
<div class="wrap">
	<div id="icon-edit" class="icon32"><br/></div>
	<h2>
		<?php esc_html_e('Plugin Settings', 'otw_lcm') ?>
	</h2>
	<div class="form-wrap otw_cm_options" id="poststuff">
		<form method="post" action="" class="validate">
			<input type="hidden" name="otw_lcm_action" value="otw_lcm_settings_action" />
			<?php wp_original_referer_field(true, 'previous'); wp_nonce_field('otw-lcm-settings'); ?>
			<div id="post-body">
				<div id="post-body-content">
					<?php include_once( 'otw_lcm_help.php' );?>
					<div class="otw-form-settings-field">
						<label for="otw_cm_skin"><?php esc_html_e( 'Default skin', 'otw_lcm' )?></label>
						<select id="otw_cm_skin" name="otw_cm_skin" style="width: 150px;">
							<option value=""><?php esc_html_e( 'Default skin', 'otw_lcm')?></option>
							<?php foreach( $otw_lcm_skins as $skin_key => $skin ){?>
								<?php
									if( $db_values['otw_cm_skin'] == $skin_key ){
										$selected = ' selected="selected"';
									}else{
										$selected = '';
									}
								?>
								<option<?php echo $selected;?> value="<?php echo esc_attr( $skin_key )?>"><?php echo esc_html( $skin[1] )?></option>
							<?php }?>
						</select>
						<p><?php esc_html_e( 'Add your own skin. A skin is a css file in the skins folder inside the plugin folder. Once a css file is added it will be loaded in the dropdown above.', 'otw_lcm' );?></p>
					</div>
					<div class="form-field">
						<label for="otw_cm_promotions"><?php esc_html_e('Show OTW Promotion Messages in my WordPress admin', 'otw_lcm'); ?></label>
						<select id="otw_cm_promotions" name="otw_cm_promotions">
							<option value="on" <?php echo ( isset( $db_values['otw_cm_promotions'] ) && ( $db_values['otw_cm_promotions'] == 'on' ) )? 'selected="selected"':''?>>on(default)</option>
							<option value="off"<?php echo ( isset( $db_values['otw_cm_promotions'] ) && ( $db_values['otw_cm_promotions'] == 'off' ) )? 'selected="selected"':''?>>off</option>
						</select>
					</div>
					<p class="submit">
						<input type="submit" value="<?php esc_html_e( 'Save Settings', 'otw_lcm') ?>" name="submit" class="button"/>
					</p>
				</div>
			</div>
		</form>
	</div>
</div>

