<?php

namespace GutenPress\Forms\Element;

use GutenPress\Forms;
use GutenPress\Helpers\Arrays;

class UI_Select2 extends Select{
	public function append_node_child( Forms\Element_Interface $element ){
		return;
	}

	public function get_tag_name(){
		return 'ui-select2';
	}

	public function __toString(){
		$this->add_class('select-2');
		$instance = array();
		if ( $this->get_property('instance') ) {
			$instance = $this->get_property('instance');
		} elseif ( $this->has_attribute('data-select2') ) {
			$raw_data = $this->get_attribute('data-select2');
			// attribute value should be json-encoded
			$instance = is_string( $raw_data ) ? json_decode( $this->get_attribute('data-select2') ) : $raw_data;
		}
		$this->set_attribute('data-select2-args', $instance );

		// it could have some extra values, so let's add them to the available options
		if ( ! array_intersect( array_keys( (array) $this->get_options() ), (array) $this->get_value() ) ) {
			$added_options = array_combine( (array) $this->get_value(), (array) $this->get_value() );
			$this->set_options( (array) $this->get_options() + $added_options );
		}

		static::enqueue_assets();

		return parent::__toString();
	}

	public static function register_assets(){
		$current_locale = apply_filters('gutenpress_forms_element_ui_select2_locale', current( explode('_', get_locale() ) ) );

		wp_register_style( 'select2-css', plugins_url( 'assets/select2/dist/css/select2.min.css', __FILE__ ) , array(), '4.0.1' );
		wp_register_script( 'select2-js', plugins_url( 'assets/select2/dist/js/select2.min.js', __FILE__ ), array('jquery'), '4.0.1', true );
		wp_register_script( 'select2-i18n', plugins_url( 'assets/select2/dist/js/i18n/'. $current_locale .'.js', __FILE__ ), array('select2-js'), '4.0.1', true );
		wp_register_script( 'select2-custom-js', plugins_url( 'js/element-ui-select2.js', __FILE__ ), array('select2-js') );
	}

	public static function enqueue_assets(){
		static::register_assets();
		wp_enqueue_style( 'select2-css' );
		wp_enqueue_script( 'select2-js' );
		wp_enqueue_script( 'select2-i18n' );
		wp_enqueue_script( 'select2-custom-js' );
	}
}