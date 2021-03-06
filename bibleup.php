<?php
/*
   Plugin Name: BibleUp
   Plugin URI: https://bibleup.netlify.com
   description: BibleUp transforms Bible References on a webpage into flexible, and highly customisable popovers.  
   Version: 1.0.0
   Author: BibleUp
   Author URI: https://bibleup.netlify.com
   License: GPLv3
   License URI: https://www.gnu.org/licenses/gpl-3.0.html
   */

class BibleUp {
	
	private $plugin_path; // @var string
	private $wpsf; // @var Bibleup_WordPressSettingsFramework
	private $script; // CDN delivered and source-controlled

	// BibleUp constructor.
	function __construct() {
		$this->plugin_path = plugin_dir_path( __FILE__ );
		$this->script = 'https://cdn.jsdelivr.net/npm/@bibleup/bibleup@beta'; //this service is documented and delivery is pegged to major version

		// Include and create a new Bibleup_WordPressSettingsFramework
		require_once( $this->plugin_path . 'wp-settings-framework/wp-settings-framework.php' );
		$this->wpsf = new Bibleup_WordPressSettingsFramework( $this->plugin_path . 'settings/settings-general.php', 'bibleup' );

		// Add admin menu
		add_action( 'admin_menu', array( $this, 'add_settings_page' ), 20 );
		
		// Add an optional settings validation filter (recommended)
		add_filter( $this->wpsf->get_option_group() . '_settings_validate', array( &$this, 'validate_settings' ) );
	}

	/**
	 * Add settings page.
	 */
	function add_settings_page() {
		$this->wpsf->add_settings_page( array(
			'parent_slug' => 'options-general.php',
			'page_title'  => __( 'BibleUp', 'bibleup' ),
			'menu_title'  => __( 'BibleUp', 'bibleup' ),
			'capability'  => 'manage_options',
		));
	}

	/**
	 * Validate settings.
	 * @param $input
	 * @return mixed
	 */
	function validate_settings( $input ) {
		// Do your settings validation here
		// Same as $sanitize_callback from http://codex.wordpress.org/Function_Reference/register_setting
		// sanitize 
		return $input;
	}
	
	function start() {
		add_action( 'wp_enqueue_scripts', array( $this, 'handle_scripts' ) );
	}

	function handle_scripts() {
		$raw_options = wpsf_get_setting_bibleup( 'bibleup', 'tab_2_paste_config', 'raw_options' );
		wp_enqueue_script( 'bibleup', $this->script, null, null, true );

		if (empty($raw_options)) {
			$data = $this->get_select_options();
			wp_add_inline_script('bibleup', $data, 'after');
		} else {
			$data_r = $this->get_raw_options();
			wp_add_inline_script('bibleup', $data_r, 'after');
		}
	}

	function get_select_options() {
		// tab_1 section ID - select_options
		$popup = wpsf_get_setting_bibleup( 'bibleup', 'tab_1_select_options', 'popup' );
		$version = wpsf_get_setting_bibleup( 'bibleup', 'tab_1_select_options', 'version' );
		$dark_theme = wpsf_get_setting_bibleup( 'bibleup', 'tab_1_select_options', 'dark_theme' );
		// tab_1 section ID - popup_style
		$primary = wpsf_get_setting_bibleup( 'bibleup', 'tab_1_popup_style', 'primary' );
		$secondary = wpsf_get_setting_bibleup( 'bibleup', 'tab_1_popup_style', 'secondary' );
		$tertiary = wpsf_get_setting_bibleup( 'bibleup', 'tab_1_popup_style', 'tertiary' );
		$header_color = wpsf_get_setting_bibleup( 'bibleup', 'tab_1_popup_style', 'header_color' );
		$font_color = wpsf_get_setting_bibleup( 'bibleup', 'tab_1_popup_style', 'font_color' );
		$version_color = wpsf_get_setting_bibleup( 'bibleup', 'tab_1_popup_style', 'version_color' );
		$close_color = wpsf_get_setting_bibleup( 'bibleup', 'tab_1_popup_style', 'close_color' );
		$border_radius = wpsf_get_setting_bibleup( 'bibleup', 'tab_1_popup_style', 'border_radius' );
		$box_shadow = wpsf_get_setting_bibleup( 'bibleup', 'tab_1_popup_style', 'box_shadow' );
		$font_size = wpsf_get_setting_bibleup( 'bibleup', 'tab_1_popup_style', 'font_size' );
		// tab_1 section ID - additional
		$bu_allow = wpsf_get_setting_bibleup( 'bibleup', 'tab_1_additional', 'bu_allow' );
		$bu_ignore = wpsf_get_setting_bibleup( 'bibleup', 'tab_1_additional', 'bu_ignore' );
		// tab_2 section ID - paste_config
		
		$call = function($prop, $default, $isArray=false) {
			if ($prop == 'false' || empty($prop) ) {
				return ($isArray) ? $default : "'$default'";
			} else if ($prop == 'true') {
				return 'true';
			} else {
				$prop = esc_js($prop);
				return "'${prop}'";
			}
		};

		$r = "
			let b = new BibleUp(document.body, {
  				popup: ". $call($popup, 'classic') .",
				version: ". $call($version, 'KJV') .",
				darkTheme: ". $call($dark_theme, 'false') .",
				bu_ignore: ". $call($bu_ignore, '["H1", "H2", "H3", "H4", "H5", "H6", "IMG", "A"]', true) .",
				bu_allow: ". $call($bu_allow, '[]', true) .",
				styles: {
					primary: ". $call($primary, 'false') .",
					secondary: ". $call($secondary, 'false') .", 
					tertiary: ". $call($tertiary, 'false') .",
					headerColor: ". $call($header_color, 'false') .",
					color: [". $call($font_color, 'false') .", ". $call($version_color, 'false') .", ". $call($close_color, 'false') ."],
					borderRadius: ". $call($border_radius, 'false') .",
					boxShadow: ". $call($box_shadow, 'false') .",
					fontSize: ". $call($font_size, 'false') .",
				}
			})
			b.create();";

		return $r;
	}
	
	function get_raw_options() {
		$raw_options = wpsf_get_setting_bibleup( 'bibleup', 'tab_2_paste_config', 'raw_options' );

		$r = "
			let b = new BibleUp(document.body, ".$raw_options.");
			b.create();";

		return $r;
	}

	function bibleup_deactivate() {
		// Delete all saved settings from option group - bibleup
		wpsf_delete_settings_bibleup( 'bibleup' );
	}
	
}

$bibleup = new BibleUp();
$bibleup->start();
register_deactivation_hook( __FILE__, array( 'BibleUp', 'bibleup_deactivate' ) );