<?php
/**
 * Process otw cm actions
 *
 */
if( otw_post( 'otw_lcm_action', false ) ){
	
	require_once( ABSPATH . WPINC . '/pluggable.php' );
	
	switch( otw_post( 'otw_lcm_action', '' ) ){
		
		case 'manage_otw_lcm_skin':
				global $otw_lcm_skins, $otw_lcm_skins_path, $validate_messages, $wp_filesystem;
				
				$validate_messages = array();
				
				$valid_page = true;
				
				if( !otw_post( 'otw_skin_title', false ) || !strlen( trim( otw_post( 'otw_skin_title', '' ) ) ) ){
					$valid_page = false;
					$validate_messages[] = esc_html__( 'Please type valid skin name', 'otw_lcm' );
				}elseif( !otw_lcm_valid_skin_name( otw_post( 'otw_skin_title', '' ) ) ){
					$valid_page = false;
					$validate_messages[] = esc_html__( 'Please type valid skin name', 'otw_lcm' );
				}elseif( otw_post( 'otw_skin_edit', false ) && !otw_post( 'otw_skin_edit', '' ) && array_key_exists( otw_post( 'otw_skin_title', '' ), $otw_lcm_skins ) ){
					$valid_page = false;
					$validate_messages[] = esc_html__( 'The skin with same name already exists', 'otw_lcm' );
				}
				
				if( $valid_page ){
					
					if( otw_init_filesystem() && !$wp_filesystem->put_contents( $otw_lcm_skins_path.otw_post( 'otw_skin_title', '' ).'.css', otw_post( 'otw_skin_content', '' ) ) ){
						$valid_page = false;
						$validate_messages[] = esc_html__( 'Error, can not safe the skin file. Check folder perimitions.', 'otw_lcm' );
					}
					wp_redirect( 'admin.php?page=otw-lcm-skins&message=1' );
				}
			break;
		case 'otw_lcm_settings_action':
				
				global $wp_cm_tmc_items, $wp_cm_agm_items, $otw_lcm_skins, $wp_cm_cs_items;
				
				$options = array();
				
				$options['shortcode_editor_button_for'] = array();
				
				foreach( $wp_cm_tmc_items as $wp_item_type => $wpItem ){
					if( otw_post( 'otw_cm_editor_shortcodes', false ) && is_array( otw_post( 'otw_cm_editor_shortcodes', array() ) ) && otw_post( array( 'otw_cm_editor_shortcodes', $wp_item_type ), false ) ){
						$options['shortcode_editor_button_for'][ $wp_item_type ] = otw_post( array( 'otw_cm_editor_shortcodes', $wp_item_type ), array() );
					}else{
						$options['shortcode_editor_button_for'][ $wp_item_type ] = 0;
					}
				}
				
				foreach( $wp_cm_agm_items as $wp_item_type => $wpItem ){
					if( otw_post( 'otw_cm_grid', false ) && is_array( otw_post( 'otw_cm_grid', '' ) ) && otw_post( array( 'otw_cm_grid', $wp_item_type ), false ) ){
						$options['grid_for'][ $wp_item_type ] = otw_post( array( 'otw_cm_grid', $wp_item_type ), array() );
					}else{
						$options['grid_for'][ $wp_item_type ] = 0;
					}
				}
				
				foreach( $wp_cm_cs_items as $wp_item_type => $wpItem ){
					if( otw_post( 'otw_cm_cs', false ) && is_array( otw_post( 'otw_cm_cs', '' ) ) && otw_post( array( 'otw_cm_cs', $wp_item_type ), false ) ){
						$options['cs_for'][ $wp_item_type ] = otw_post( array( 'otw_cm_cs', $wp_item_type ), array() );
					}else{
						$options['cs_for'][ $wp_item_type ] = 0;
					}
				}
				
				$options['otw_cm_skin'] = '';
				if( otw_post( 'otw_cm_skin', false ) && array_key_exists( otw_post( 'otw_cm_skin', '' ), $otw_lcm_skins ) ){
					$options['otw_cm_skin'] = otw_post( 'otw_cm_skin', '' );
				}
				
				$options['otw_cm_grid_previews'] = '';
				if( otw_post( 'otw_cm_grid_previews', false ) ){
					$options['otw_cm_grid_previews'] = otw_post( 'otw_cm_grid_previews', '' );
				}
				
				if( otw_post( 'otw_cm_promotions', false ) && !empty( otw_post( 'otw_cm_promotions', '' ) ) ){
					
					global $otw_lcm_factory_object, $otw_lcm_plugin_id;
					
					update_option( $otw_lcm_plugin_id.'_dnms', otw_post( 'otw_cm_promotions', '' ) );
					
					if( is_object( $otw_lcm_factory_object ) ){
						$otw_lcm_factory_object->retrive_plungins_data( true );
					}
				}
				
				update_option( 'otw_cm_plugin_options', $options );
				wp_redirect( admin_url( 'admin.php?page=otw-lcm-settings&message=1' ) );
			break;
	}
}
?>