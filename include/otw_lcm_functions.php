<?php
/**
 * Init function
 */
if( !function_exists( 'otw_lcm_init' ) ){
	
	function otw_lcm_init(){
		
		global $otw_lcm_plugin_url, $otw_lcm_plugin_options, $otw_lcm_grid_manager_component, $otw_lcm_shortcode_component, $otw_lcm_shortcode_object, $otw_lcm_form_component, $otw_lcm_validator_component, $otw_lcm_form_object, $otw_lcm_skin, $wp_cm_cs_items, $otw_lcm_factory_component, $otw_lcm_factory_object, $otw_lcm_plugin_id;
		
		if( is_admin() ){
			
			
			include_once( 'otw_lcm_process_actions.php' );
			
			add_action('admin_menu', 'otw_lcm_init_admin_menu' );
			
			add_action('admin_print_styles', 'otw_lcm_enqueue_admin_styles' );
			
			add_filter('otwfcr_notice', 'otw_lcm_factory_message' );
		}
		
		otw_lcm_enqueue_styles();
		
		//otw grid manager component
		
		include_once( plugin_dir_path( __FILE__ ).'otw_lcm_grid_meta_info.php' );
		
		$otw_lcm_grid_manager_component = otw_load_component( 'otw_grid_manager' );
		$otw_lcm_grid_manager_object = otw_get_component( $otw_lcm_grid_manager_component );
		$otw_lcm_grid_manager_object->active_for['page'] = true;
		$otw_lcm_grid_manager_object->active_for['post'] = true;
		$otw_lcm_grid_manager_object->active_for_posts = true;
		$otw_lcm_grid_manager_object->meta_info = $otw_lcm_grid_meta_info;
		
		$otw_lcm_grid_manager_object->shortcode_preview_in_grid = false;
		
		include_once( plugin_dir_path( __FILE__ ).'otw_labels/otw_lcm_grid_manager_object.labels.php' );
		$otw_lcm_grid_manager_object->init();
		
		//shortcode component
		$otw_lcm_shortcode_component = otw_load_component( 'otw_shortcode' );
		$otw_lcm_shortcode_object = otw_get_component( $otw_lcm_shortcode_component );
		$otw_lcm_shortcode_object->editor_button_active_for['page'] = false;
		$otw_lcm_shortcode_object->editor_button_active_for['post'] = false;
		
		if( isset( $otw_lcm_plugin_options['shortcode_editor_button_for'] ) && isset( $otw_lcm_plugin_options['shortcode_editor_button_for']['page'] ) && $otw_lcm_plugin_options['shortcode_editor_button_for']['page'] ){
			$otw_lcm_shortcode_object->editor_button_active_for['page'] = true;
		}elseif( !isset( $otw_lcm_plugin_options['shortcode_editor_button_for'] ) ){
			$otw_lcm_shortcode_object->editor_button_active_for['page'] = true;
		}

		if( isset( $otw_lcm_plugin_options['shortcode_editor_button_for'] ) && isset( $otw_lcm_plugin_options['shortcode_editor_button_for']['post'] ) && $otw_lcm_plugin_options['shortcode_editor_button_for']['post'] ){
			$otw_lcm_shortcode_object->editor_button_active_for['post'] = true;
		}elseif( !isset( $otw_lcm_plugin_options['shortcode_editor_button_for'] ) ){
			$otw_lcm_shortcode_object->editor_button_active_for['post'] = true;
		}
		
		$otw_lcm_shortcode_object->add_default_external_lib( 'css', 'style', get_stylesheet_directory_uri().'/style.css', 'live_preview', 10 );
		
		if( $otw_lcm_skin ){
			$otw_lcm_shortcode_object->add_default_external_lib( 'css', 'otw_content_manager', $otw_lcm_plugin_url.'/skins/'.$otw_lcm_skin.'.css', 'live_preview', 200 );
		}
		
		$otw_lcm_shortcode_object->shortcodes['button'] = array( 'title' => esc_html__('Button', 'otw_lcm'),'enabled' => true,'children' => false, 'parent' => false, 'order' => 0,'path' => dirname( __FILE__ ).'/otw_components/otw_shortcode/', 'url' => $otw_lcm_plugin_url.'/include/otw_components/otw_shortcode/' );
		$otw_lcm_shortcode_object->shortcodes['info_box'] = array( 'title' => esc_html__('Info Box', 'otw_lcm'),'enabled' => true,'children' => false, 'parent' => false, 'order' => 2,'path' => dirname( __FILE__ ).'/otw_components/otw_shortcode/', 'url' => $otw_lcm_plugin_url.'/include/otw_components/otw_shortcode/' );
		$otw_lcm_shortcode_object->shortcodes['dropcap'] = array( 'title' => esc_html__('Dropcaps', 'otw_lcm'),'enabled' => true,'children' => false, 'parent' => false, 'order' => 3,'path' => dirname( __FILE__ ).'/otw_components/otw_shortcode/', 'url' => $otw_lcm_plugin_url.'/include/otw_components/otw_shortcode/' );
		$otw_lcm_shortcode_object->shortcodes['quote'] = array( 'title' => esc_html__('Quote', 'otw_lcm'),'enabled' => true,'children' => false, 'parent' => false, 'order' => 4,'path' => dirname( __FILE__ ).'/otw_components/otw_shortcode/', 'url' => $otw_lcm_plugin_url.'/include/otw_components/otw_shortcode/' );
		$otw_lcm_shortcode_object->shortcodes['tabslayout'] = array( 'title' => esc_html__('Tabs Layout', 'otw_lcm'),'enabled' => true,'children' => false, 'parent' => false, 'order' => 7,'path' => dirname( __FILE__ ).'/otw_components/otw_shortcode/', 'url' => $otw_lcm_plugin_url.'/include/otw_components/otw_shortcode/' );
		$otw_lcm_shortcode_object->shortcodes['content_toggle'] = array( 'title' => esc_html__('Content toggle', 'otw_lcm'),'enabled' => true,'children' => false, 'parent' => false, 'order' => 8,'path' => dirname( __FILE__ ).'/otw_components/otw_shortcode/', 'url' => $otw_lcm_plugin_url.'/include/otw_components/otw_shortcode/' );
		$otw_lcm_shortcode_object->shortcodes['unordered_list'] = array( 'title' => esc_html__('Unordered list', 'otw_lcm'),'enabled' => true,'children' => false, 'parent' => false, 'order' => 15,'path' => dirname( __FILE__ ).'/otw_components/otw_shortcode/', 'url' => $otw_lcm_plugin_url.'/include/otw_components/otw_shortcode/' );
		$otw_lcm_shortcode_object->shortcodes['ordered_list'] = array( 'title' => esc_html__('Ordered list', 'otw_lcm'),'enabled' => true,'children' => false, 'parent' => false, 'order' => 16,'path' => dirname( __FILE__ ).'/otw_components/otw_shortcode/', 'url' => $otw_lcm_plugin_url.'/include/otw_components/otw_shortcode/' );
		$otw_lcm_shortcode_object->shortcodes['divider'] = array( 'title' => esc_html__('Divider', 'otw_lcm'),'enabled' => true,'children' => false, 'parent' => false, 'order' => 17,'path' => dirname( __FILE__ ).'/otw_components/otw_shortcode/', 'url' => $otw_lcm_plugin_url.'/include/otw_components/otw_shortcode/' );
		$otw_lcm_shortcode_object->shortcodes['html_editor'] = array( 'title' => esc_html__('HTML Editor', 'otw_lcm'),'enabled' => true,'children' => false, 'parent' => false, 'order' => 124,'path' => dirname( __FILE__ ).'/otw_components/otw_shortcode/', 'url' => $otw_lcm_plugin_url.'/include/otw_components/otw_shortcode/' );
		
		include_once( plugin_dir_path( __FILE__ ).'otw_labels/otw_lcm_shortcode_object.labels.php' );
		$otw_lcm_shortcode_object->init();
		
		//form component
		$otw_lcm_form_component = otw_load_component( 'otw_form' );
		$otw_lcm_form_object = otw_get_component( $otw_lcm_form_component );
		include_once( plugin_dir_path( __FILE__ ).'otw_labels/otw_lcm_form_object.labels.php' );
		$otw_lcm_form_object->init();
		
		//validator component
		$otw_lcm_validator_component = otw_load_component( 'otw_validator' );
		$otw_lcm_validator_object = otw_get_component( $otw_lcm_validator_component );
		$otw_lcm_validator_object->init();
		
		$otw_lcm_factory_component = otw_load_component( 'otw_factory' );
		$otw_lcm_factory_object = otw_get_component( $otw_lcm_factory_component );
		$otw_lcm_factory_object->add_plugin( $otw_lcm_plugin_id, dirname( dirname( __FILE__ ) ).'/otw_content_manager.php', array( 'menu_parent' => 'otw-lcm-settings', 'lc_name' => esc_html__( 'License Manager', 'otw_lcm' ), 'menu_key' => 'otw-lcm' ) );
		
		include_once( plugin_dir_path( __FILE__ ).'otw_labels/otw_lcm_factory_object.labels.php' );
		$otw_lcm_factory_object->init();
		
	}
}

/**
 * include needed styles
 */
if( !function_exists( 'otw_lcm_enqueue_styles' ) ){
	function otw_lcm_enqueue_styles(){
		global $otw_lcm_plugin_url, $otw_lcm_css_version, $otw_lcm_skin;
		if( !is_admin() && $otw_lcm_skin ){
			wp_enqueue_style( 'otw_content_manager', $otw_lcm_plugin_url.'/skins/'.$otw_lcm_skin.'.css', array(), $otw_lcm_css_version );
		}
	}
}


/**
 * Admin styles
 */
if( !function_exists( 'otw_lcm_enqueue_admin_styles' ) ){
	
	function otw_lcm_enqueue_admin_styles(){
		
		global $otw_lcm_plugin_url, $otw_lcm_css_version;
		
		wp_enqueue_style( 'otw_lcm_admin', $otw_lcm_plugin_url.'/css/otw_lcm_admin.css', array( 'thickbox' ), $otw_lcm_css_version );
	}
}

/**
 * Init admin menu
 */
if( !function_exists( 'otw_lcm_init_admin_menu' ) ){
	
	function otw_lcm_init_admin_menu(){
		
		global $otw_lcm_plugin_url;
		
		add_menu_page(__('Content Manager Light', 'otw_lcm'), esc_html__('Content Manager Light', 'otw_lcm'), 'manage_options', 'otw-lcm-settings', 'otw_lcm_settings', $otw_lcm_plugin_url.'/images/otw-sbm-icon.png');
		add_submenu_page( 'otw-lcm-settings', esc_html__('Settings', 'otw_lcm'), esc_html__('Settings', 'otw_lcm'), 'manage_options', 'otw-lcm-settings', 'otw_lcm_settings' );
	}
}

/**
 * Settings page
 */
if( !function_exists( 'otw_lcm_settings' ) ){
	
	function otw_lcm_settings(){
		require_once( 'otw_lcm_settings.php' );
	}
}

/**
 * Edit Skins page
 */
if( !function_exists( 'otw_lcm_skins_manage' ) ){
	
	function otw_lcm_skins_manage(){
		require_once( 'otw_lcm_skins_manage.php' );
	}
}

/**
 * Skins page
 */
if( !function_exists( 'otw_lcm_skins' ) ){
	
	function otw_lcm_skins(){
		require_once( 'otw_lcm_skins.php' );
	}
}

/**
 * Check if Skins directory is writable
 */
if( !function_exists( 'otw_lcm_skins_writable' ) ){
	
	function otw_lcm_skins_writable( $skins_path ){
		
		global $wp_filesystem;
		
		if( otw_init_filesystem() ){
			return $wp_filesystem->is_writable($skins_path);
		}
		return false;
	}
}

/**
 * Check for valid skin name
 */
if( !function_exists( 'otw_lcm_valid_skin_name' ) ){
	
	function otw_lcm_valid_skin_name( $skin_name ){
		
		if( preg_match( "/^[a-z\_]{3,15}$/", $skin_name, $matches ) ){
			return true;
		}
		return false;
	}
}

/**
 * Load skins
 */
if( !function_exists( 'otw_lcm_load_skins' ) ){
	
	function otw_lcm_load_skins( $skins_path ){
		
		global $wp_filesystem;
		
		$skins = array();
		
		if( otw_init_filesystem() ){
			
			$files = $wp_filesystem->dirlist( $skins_path, false );
			
			if( is_array( $files ) && count( $files ) ){
				
				foreach( $files as $file ){
					
					if( $file['type'] == 'f' ){
						
						if( preg_match( "/^([a-z\-\_]+)\.css$/", $file['name'], $matches ) ){
							$skins[ $matches[1] ] = array( $matches[1], $matches[1] );
						}
					}
				}
			}
		}
		
		return $skins;
	}
}

/**
 * factory messages
 */
if( !function_exists( 'otw_lcm_factory_message' ) ){
	
	function otw_lcm_factory_message( $params ){
		
		global $otw_lcm_plugin_id;
		
		if( isset( $params['plugin'] ) && $otw_lcm_plugin_id == $params['plugin'] ){
			
			//filter out some messages if need it
		}
		if( isset( $params['message'] ) )
		{
			return $params['message'];
		}
		return $params;
	}
}
?>