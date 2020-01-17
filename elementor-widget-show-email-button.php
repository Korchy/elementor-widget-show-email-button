<?php
/*
Plugin Name: Elementor widget: Show E-mail button
Version: 1.0.0
Plugin URI: https://progr.interplanety.org/en/elementor-widget%E2%80%A6ow-e-mail-button/
Author:  Nikita Akimov
Description: Widget for Elementor: Show E-mail button
*/

if(!defined('ABSPATH')) exit; // Exit if accessed directly.

final class Elementor_Show_Email_Button_Extension {

	const VERSION = '1.0.0';					// plugin version
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';	// minimun Elementor version required to be installed
	const MINIMUM_PHP_VERSION = '7.0';			// minimum PHP version required to be installed

	private static $_instance = null;	// instance of the plugin class

	private static $textdomain = 'elementor-show-email-button-extension';
	private static $textdomainU = 'Elementor Test Extension';

	public function init_widgets() {
		// init widget
		require_once(__DIR__ . '/widgets/show-email-button.php');
		// Register widget
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \ElementorShowEmailButtonWidget());
	}

	public static function instance() {
		// create instance of the pulugin class
		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct() {
		// Comstructor
		add_action('init', [$this, 'i18n']);
		add_action('plugins_loaded', [$this, 'init']);
	}

	public function i18n() {
		// Load plugin localization files.
		load_plugin_textdomain(static::$textdomain);
	}

	public function init() {
		// main plugin functionality
		// Check if Elementor installed and activated
		if(!did_action('elementor/loaded')) {
			add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
			return;
		}
		// Check for required Elementor version
		if(!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
			add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);
			return;
		}
		// Check for required PHP version
		if(version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
			add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
			return;
		}
		// Add Plugin actions
		add_action('elementor/widgets/widgets_registered', [$this, 'init_widgets']);
	}

	public function admin_notice_missing_main_plugin() {
		// Error notification - no Elementor plugin installed
		if(isset($_GET['activate'])) unset($_GET['activate']);
		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__('"%1$s" requires "%2$s" to be installed and activated.', static::$textdomain),
			'<strong>' . esc_html__(static::$textdomainU, static::$textdomain) . '</strong>',
			'<strong>' . esc_html__('Elementor', static::$textdomain) . '</strong>'
		);
		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
	}

	public function admin_notice_minimum_elementor_version() {
		// Error notification - incompatible Elementor version
		if(isset($_GET['activate'])) unset($_GET['activate']);
		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', static::$textdomain),
			'<strong>' . esc_html__(static::$textdomainU, static::$textdomain) . '</strong>',
			'<strong>' . esc_html__('Elementor', static::$textdomain) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	public function admin_notice_minimum_php_version() {
		// Error notification - incompatible PHP version
		if(isset($_GET['activate'])) unset($_GET['activate']);
		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', static::$textdomain),
			'<strong>' . esc_html__(static::$textdomainU, static::$textdomain) . '</strong>',
			'<strong>' . esc_html__('PHP', static::$textdomain) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
}
Elementor_Show_Email_Button_Extension::instance();
?>
