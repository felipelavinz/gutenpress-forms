<?php

namespace GutenPress\Forms\Element;

use GutenPress\Forms;

class Textarea extends Forms\HTML_Form_Element{

	/**
	 * Allowed element attributes
	 * @var array
	 * @link http://www.w3.org/TR/html5/forms.html#the-textarea-element
	 */
	protected static $element_attributes = array(
		'autocomplete',
		'autofocus',
		'cols',
		'dirname',
		'disabled',
		'form',
		'inputmode',
		'maxlength',
		'minlength',
		'name',
		'placeholder',
		'readonly',
		'required',
		'rows',
		'wrap'
	);

	public function get_tag_name(){
		return 'textarea';
	}
	public function get_children(){
		return array();
	}
	public function set_value( $val ){
		return $this->set_text_content( $val );
	}
	public function get_value(){
		return $this->get_text_content();
	}
	public function get_attributes(){
		if ( ! $this->get_attribute('cols') ) {
			$this->set_attribute('cols', 45);
		}
		if ( ! $this->get_attribute('rows') ) {
			$this->set_attribute('rows', 10);
		}
		return parent::get_attributes();
	}
	public function __toString(){
		$out  = '<textarea '. $this->render_attributes() .'>';
		$out .= esc_textarea( $this->get_value() );
		$out .= '</textarea>';
		return $out;
	}
}