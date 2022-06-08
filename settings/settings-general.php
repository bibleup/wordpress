<?php
/**
 * WordPress Settings Framework
 *
 * @author  Gilbert Pellegrom, James Kemp
 * @link    https://github.com/gilbitron/WordPress-Settings-Framework
 * @license MIT
 */

/**
 * Define your settings
 *
 * The first parameter of this filter should be wpsf_register_settings_[options_group],
 * in this case "my_example_settings".
 *
 * Your "options_group" is the second param you use when running new WordPressSettingsFramework()
 * from your init function. It's important as it differentiates your options from others.
 *
 * To use the tabbed example, simply change the second param in the filter below to 'wpsf_tabbed_settings'
 * and check out the tabbed settings function on line 156.
 */

add_filter( 'wpsf_register_settings_bibleup', 'wpsf_tabbed_settings' );

/**
 * Tabbed example.
 * @param array $wpsf_settings settings.
 */
/**
 * Tabbed example.
 *
 * @param array $wpsf_settings settings.
 */
function wpsf_tabbed_settings( $wpsf_settings ) {
	// Tabs.
	$wpsf_settings['tabs'] = array(
		array(
			'id'    => 'tab_1',
			'title' => esc_html__( 'Select Options', 'bibleup' ),
		),
		array(
			'id'    => 'tab_2',
			'title' => esc_html__( 'Paste Config', 'bibleup' ),
		),
	);

	// Settings.
	$wpsf_settings['sections'] = array(
		array(
			'tab_id'        => 'tab_1',
			'section_id'    => 'note',
			'section_description' => '<b>Please read the following first before you begin to configure BibleUp</b><br>
			There are two methods you can use to configure BibleUp - <b>select Options</b> or <b>Paste Config</b><br>
			Use the <b>Select Options</b> forms below to set your options manually or the <b>Paste Config</b> to paste generated config options from the editor (Recommended)<br><br>
			Set any option to <b>false</b> or leave empty to get the default value<br>
			For full documentation of these options, check the <a href="https://bibleup.netlify.app/docs">docs</a>',
			'section_title' => 'NOTE',
			'section_order' => 10,
		),
		array(
			'tab_id'        => 'tab_1',
			'section_id'    => 'select_options',
			'section_title' => 'Select Options',
			'section_order' => 10,
			'fields'        => array(
				array(
					'id'      => 'popup',
					'title'   => 'Popup Type',
					'desc'    => 'The preferred popup type.',
					'type'    => 'select',
					'default' => 'classic',
					'choices' => array(
						'classic'   => 'classic',
						'inline' => 'inline',
						'wiki'  => 'wiki',
					),
				),
				array(
					'id'      => 'version',
					'title'   => 'Version',
					'desc'    => 'The default Bible translation for references.',
					'type'    => 'select',
					'default' => 'KJV',
					'choices' => array(
						'KJV'   => 'King James Version (KJV)',
						'ASV' => 'American Standard Version (ASV)',
						'LSV'  => 'Literal Standard Version (LSV)',
						'WEB'  => 'World English Bible (WEB)',
					),
				),
				array(
					'id'      => 'dark_theme',
					'title'   => 'Dark Theme',
					'desc'    => 'Enable dark theme on popup.<br>
					This can be overriden by the background and font color set by other options, to preserve the default dark theme you must set other color options to false.',
					'type'    => 'radio',
					'default' => 'false',
					'choices' => array(
						'true'   => 'True',
						'false' => 'False',
					),
				),
			),
		),
        
		array(
			'tab_id'        => 'tab_1',
			'section_id'    => 'popup_style',
			'section_title' => 'Popup Style',
			'section_description' => 'Set popup background and font colors.',
			'section_order' => 10,
			'fields'        => array(
				array(
					'id'      => 'primary',
					'title'   => 'Primary',
					'desc'    => 'Set color for overall popup background',
					'type'    => 'color',
					'default' => 'false',
				),
				array(
					'id'      => 'secondary',
					'title'   => 'Secondary',
					'desc'    => 'Set background color for popup header (if it exists)',
					'type'    => 'color',
					'default' => 'false',
				),
				array(
					'id'      => 'tertiary',
					'title'   => 'Tertiary',
					'desc'    => 'Set background color for popup version (if it exists)',
					'type'    => 'color',
					'default' => 'false',
				),
				array(
					'id'      => 'header_color',
					'title'   => 'Header Color',
					'desc'    => 'Font color for popup header (if it exists).<br>
					This will override the default font color for text in the header only',
					'type'    => 'color',
					'default' => 'false',
				),
				array(
					'id'      => 'font_color',
					'title'   => 'Font Color',
					'desc'    => 'The default font color for the popup',
					'type'    => 'color',
					'default' => 'false',
				),
				array(
					'id'      => 'version_color',
					'title'   => 'Version Color',
					'desc'    => 'Font color for popup version (if it exists).<br>
					This will override the default font color for text in the version box only',
					'type'    => 'color',
					'default' => 'false',
				),
				array(
					'id'      => 'close_color',
					'title'   => 'Close Color',
					'desc'    => 'Set color for close button (if it exists).<br>
					The close button only exists on popup type "wiki" ',
					'type'    => 'color',
					'default' => 'false',
				),
				array(
					'id'      => 'border_radius',
					'title'   => 'Border Radius',
					'desc'    => 'Set border radius for popup (in units)',
					'type'    => 'text',
					'placeholder' => '5px',
					'default' => 'false',
				),
				array(
					'id'      => 'box_shadow',
					'title'   => 'Box Shadow',
					'desc'    => 'Set a drop shadow for the popup (using CSS syntax)',
					'type'    => 'text',
					'placeholder' => '2px 6px 10px #404040',
					'default' => 'false',
				),
				array(
					'id'      => 'font_size',
					'title'   => 'Font Size',
					'desc'    => 'Set font size for all popup (text in units)',
					'type'    => 'text',
					'placeholder' => '16px',
					'default' => 'false',
				),
			),
		),

        array(
			'tab_id'        => 'tab_1',
			'section_id'    => 'additional',
			'section_title' => 'Additional Settings',
			'section_description' => 'Use these options to configure BibleUp behaviour.',
			'section_order' => 10,
			'fields'        => array(
				array(
					'id'      => 'bu_ignore',
					'title'   => 'Ignore Specific HTML Elements',
					'desc'    => "BibleUp won't tag element listed here.<br>
					Seperate these elements using a comma and put inside a square bracket.",
					'type'    => 'text',
					'placeholder'    => "['H1', 'H2', 'H3', 'H4', 'H5', 'H6', 'IMG', 'A']",
					'default' => 'false',
					'link'     => array(
						'url'      => esc_url( 'https://bibleup.netlify.app/docs/guide/options.html#bu-ignore' ),
						'type'     => 'link', // Can be 'tooltip' or 'link'. Default is 'tooltip'.
						'text'     => 'Learn More',
						'external' => true,
					),
				),
				array(
					'id'      => 'bu_allow',
					'title'   => 'Allow Specific HTML Elements',
					'desc'    => "Override the default elements ignored by BibleUp by placing them here.<br>
					Seperate these elements using a comma and put inside a square bracket.",
					'type'    => 'text',
					'placeholder'    => "['H1', 'H2']",
					'default' => 'false',
					'link'     => array(
						'url'      => esc_url( 'https://bibleup.netlify.app/docs/guide/options.html#bu-allow' ),
						'type'     => 'link', // Can be 'tooltip' or 'link'. Default is 'tooltip'.
						'text'     => 'Learn More',
						'external' => true,
					),
				),
			),
        ),
			
		array(
			'tab_id'        => 'tab_2',
			'section_id'    => 'paste_config',
			'section_title' => 'Paste Config',
			'section_description' => 'Use the instant <a target="_blank" href="https://bibleup.netlify.app/demo#editor">editor</a> to style popup in real-time, then copy and paste the generated config options.<br>
			This section <b>overides every options</b> in the <b>Select Options</b> tab.<br><br>
			Leave the editor blank if you want to manually seclect options instead.',
			'section_order' => 10,
			'fields'        => array(
				array(
					'id'      => 'raw_options',
					'title'   => 'Raw Options',
					'desc'    => 'Paste the raw config options here',
					'type'        => 'textarea',
					'default' => '',
				),
			),
		),
	);

	return $wpsf_settings;
}

