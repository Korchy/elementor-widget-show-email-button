<?php
/*
Nikita Akimov
interplanety@interplanety.org

Elementor Vidget class: Show E-mail button
*/

if(!defined('ABSPATH')) exit; // Exit if accessed directly.

class ElementorShowEmailButtonWidget extends \Elementor\Widget_Base {

	// --------------------------------------------------------------
	// Changable sections
	// --------------------------------------------------------------

    private static $widgetIcon = 'fa fa-at';
    private static $widgetTitle = 'Show E-mail button';
    private static $widgetName = 'show-email-button';

	protected function _register_controls() {
		// widget controls
		// button settings
		$this->start_controls_section(
			'button_settings',
			[
				'label' => __('Button Settings', 'plugin-name'),
			]
		);
		$this->add_control(
			'button_text',
			[
				'label' => __('Button Text', 'plugin-name'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Show E-mail', 'plugin-name'),
			]
		);
		$this->end_controls_section();
		// email settings
		$this->start_controls_section(
			'email_settings',
			[
				'label' => __('E-mail', 'plugin-name'),
			]
		);
		$this->add_control(
			'email_name',
			[
				'label' => __('name', 'plugin-name'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __('my_mail', 'plugin-name'),
			]
		);
		$this->add_control(
			'email_at',
			[
				'label' => __('@', 'plugin-name'),
				'type' => \Elementor\Controls_Manager::HEADING
			]
		);
		$this->add_control(
			'email_domain',
			[
				'label' => __('domain', 'plugin-name'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __('gmail', 'plugin-name'),
			]
		);
		$this->add_control(
			'email_dot',
			[
				'label' => __('.', 'plugin-name'),
				'type' => \Elementor\Controls_Manager::HEADING
			]
		);
		$this->add_control(
			'email_zone',
			[
				'label' => __('zone', 'plugin-name'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __('com', 'plugin-name'),
			]
		);
		$this->end_controls_section();
	}

	private static function renderBody($settings) {
		// HTML body
		$body = '';
		$body .= '<div class="elementor-widget-' . static::$widgetName . '-body">';
			$body .= '<div class="elementor-widget-' . static::$widgetName . '-button" em_name="' . $settings['email_name'] . '" em_domain="' . $settings['email_domain'] . '" em_zone="' . $settings['email_zone'] . '">';
			$body .= $settings['button_text'];
			$body .= '</div>';
		$body .= '</div>';
		return $body;
	}

    public function __construct($data = [], $args = null) {
		// register js and css
		parent::__construct($data, $args);

 		wp_register_script('ctb-script', '/wp-content/plugins/elementor-widget-show-email-button/widgets/show-email-button.js', ['elementor-frontend'], '1.0.0', true);
		wp_register_style('ctb-stylesheet', '/wp-content/plugins/elementor-widget-show-email-button/widgets/show-email-button.css');
	 }
 
	 public function get_script_depends() {
		//  return js
		return ['ctb-script'];
	 }
 
	 public function get_style_depends() {
		//  return css
		return ['ctb-stylesheet'];
	 }

	// --------------------------------------------------------------
	// Unchangable sections
	// --------------------------------------------------------------

	public function get_name() {
        // widget name
		return static::$widgetName;
    }
    
	public function get_title() {
        // widget title
		return __(static::$widgetTitle, 'plugin-name');
	}

	public function get_icon() {
        // widget icon
		return static::$widgetIcon;
	}

	public function get_categories() {
        // widget category
		return ['general'];
	}
	
	protected function render() {
        // render widget HTML code
		$settings = $this->get_settings_for_display();
		echo '<div class="elementor-widget-' . static::$widgetName . '">';
		echo static::renderBody($settings);
		echo '</div>';
	}
}
?>
