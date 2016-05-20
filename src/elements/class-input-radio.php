<?php

namespace GutenPress\Forms\Element;

use GutenPress\Forms;
use GutenPress\Helpers\Arrays;

class Input_Radio extends Input implements Forms\Option_Element_Interface{
	use Forms\Options_Trait;
	public function __toString(){
		$options = $this->get_options();
		if ( ! Arrays::is_assoc( $options ) ) {
			$options = array_combine( $options, $options );
		}
		$out  = '<div'. $this->render_attributes() .'>';
			$out .= '<ul>';
			foreach ( $options as $value => $label ) {
				$out .= $this->render_element( $value, $label );
			}
			$out .= '</ul>';
		$out .= '</div>';
		return $out;
	}
	public function render_element( $value, $label ){
		static $i = 1;
		$name    = $this->get_name();
		$checked = $value == $this->get_value() ? ' checked="checked"' : '';
		$out  = '';
		$out .= '<li>';
			$out .= '<label>';
				$out .= '<input type="radio" name="'. $name .'" id="'. $this->get_id() .'-'. $i .'" value="'. esc_attr( $value ) .'"'. $checked .'> ';
				$out .= $label;
			$out .= '</label>';
		$out .= '</li>';
		++$i;
		return $out;
	}
}