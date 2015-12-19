<?php

namespace GutenPress\Forms\Element;

use GutenPress\Forms;
use GutenPress\Helpers\Arrays;

class Select extends Forms\HTML_Form_Element implements Forms\Option_Element_Interface{
	use Forms\Options_Trait;

	/**
	 * Allowed element attributes
	 * @var array
	 * @link http://www.w3.org/TR/html5/forms.html#the-select-element
	 */
	protected static $element_attributes = array(
		'autofocus',
		'disabled',
		'form',
		'multiple',
		'name',
		'required',
		'size',
	);

	protected $value = null;

	public function get_tag_name(){
		return 'select';
	}

	public function get_children(){
		// @todo -- technically, options and optgroups are children elements
	}

	public function set_value( $value ){
		$this->value = $value;
	}

	public function get_value(){
		return $this->value;
	}

	private function maybe_deep_options( $options ){
		if ( ! Arrays::is_assoc( $options ) ) {
			$options = array_combine( $options, $options );
		}
		foreach ( $options as $key => &$val ) {
			if ( is_array( $val ) && ! Arrays::is_assoc( $val ) ) {
				$val = $this->maybe_deep_options( $val );
			}
		}
		return $options;
	}

	public function __toString(){
		$options = $this->get_options();
		$options = $this->maybe_deep_options( $options );
		if ( $this->get_attribute('multiple') ) {
			$this->set_name( $this->get_name() .'[]' );
		}
		$out  = '<select'. $this->render_attributes() .'>';
			foreach ( $options as $key => $val ) {
				if ( is_array($val) ) {
					$out .= '<optgroup label="'. esc_attr($key) .'">';
					foreach ( $val as $value => $label ) {
						$out .= $this->render_option( $value, $label );
					}
					$out .= '</optgroup>';
				} else {
					$out .= $this->render_option( $key, $val );
				}
				$out .= '';
			}
		$out .= '</select>';
		return $out;
	}

	private function render_option( $value, $label ){
		$selections = (array) $this->get_value();
		$selected   = in_array( $value, $selections ) ? ' selected="selected"' : '';
		return '<option value="'. esc_attr( $value ) .'"'. $selected .'>'. $label .'</option>';
	}
}