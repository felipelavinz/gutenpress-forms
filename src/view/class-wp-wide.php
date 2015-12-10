<?php

namespace GutenPress\Forms\View;

use GutenPress\Forms;
use GutenPress\Forms\Element;

class WP_Wide extends Forms\Form_View{
	private $i = 1;
	public function __toString(){
		$out  = '';
		$out .= '<table class="form-table gutenpress-form">';
			foreach ( $this->form->get_children() as $element ){
				$this->set_element_view_attributes( $element );
				if ( $element instanceof Element\Input_Hidden ) {
					$out .= '<tr class="hidden">';
						$out .= '<td colspan="2">';
							$out .= (string)$element;
						$out .= '</td>';
					$out .= '</tr>';
				// } elseif ( $element instanceof Element\Input_Button || $element instanceof Element\Button || ! method_exists($element, 'getLabel') ) {
				// 	$out .= '<tr>';
				// 		$out .= '<td colspan="2">';
				// 			$out .= (string)$element;
				// 		$out .= '</td>';
				// 	$out .= '</tr>';
				} else {
					$this->set_input_size( $element );
					$out .= '<tr>';
						$out .= '<th scope="row">';
							$out .= '<label for="'. $element->get_attribute('id') .'">'. $element->get_label() .'</label>';
						$out .= '</th>';
						$out .= '<td>';
							$out .= (string)$element;
							$out .= $this->get_element_description( $element );
						$out .= '</td>';
					$out .= '</tr>';
				}
			}
		$out .= '</table>';
		return $out;
	}
	protected function set_element_view_attributes( Forms\Element_Interface &$element ){
		$has_id = $element->get_attribute('id');
		if ( ! $has_id ) {
			$element->set_attribute('id', $this->form->get_attribute('id') .'-'. $this->i );
		}
		// if ( $element instanceof Element\InputSubmit || $element instanceof Element\Button && $element->getAttribute('type') === 'submit' ) {
		// 	$element->setAttribute('class', 'button-primary');
		// } elseif ( $element instanceof Element\InputButton || $element instanceof Element\Button ) {
		// 	$element->setAttribute('class', 'button');
		// }
		$this->i++;
	}
	/**
	 * Automatically set a suitable class for text input fields
	 */
	protected function set_input_size( Forms\Element_Interface &$element ){
		if ( ! $element instanceof Element\Input )
			return;

		if ( $element->get_class_name() )
			return;

		$maxlength = $element->get_attribute('maxlength');
		if ( !empty($maxlength) ) {
			if ( $maxlength < 6 ) {
				$element->set_attribute('class', 'small-text');
				return;
			}
			if ( $maxlength > 40 ) {
				$element->set_attribute('class', 'widefat');
				return;
			}
		}

		if ( ! $element->get_attribute('size') ) {
			$element->set_attribute('class', 'regular-text');
		}
		return;
	}
	protected function get_element_description( Forms\Element_Interface $element ){
		$description = $element->get_property('description');
		$show_inline = $element->get_property('description_inline');
		if ( $description ) {
			return $show_inline ? ' <span class="description">'. $description .'</span>' : '<p class="description">'. $description .'</p>';
		}
	}
}