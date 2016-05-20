<?php

namespace GutenPress\Forms\Element;

use GutenPress\Forms;

class Button extends Forms\HTML_Form_Element{
	public function __construct( array $properties = array() , $text_content = '' ){
		parent::__construct( $properties, $text_content );
	}
	public function get_tag_name(){
		return 'button';
	}
	public function get_children(){
		return array();
	}
	public function set_value( $val ){
		$this->set_attribute('value', $val);
		return $this;
	}
	public function get_value(){
		return $this->get_attribute('value');
	}
	public function __toString(){
		return '<button '. $this->render_attributes() .'>'. $this->get_text_content() .'</button>';
	}
}