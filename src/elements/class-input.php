<?php

namespace GutenPress\Forms\Element;

use GutenPress\Forms;

class Input extends Forms\HTML_Form_Element{
	protected static $type;
	public function __construct( array $properties = array() , $text_content = '' ){
		parent::__construct( $properties, $text_content );
		$this->set_attribute('type', static::$type);
	}
	public function get_tag_name(){
		return 'input';
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
		return '<input '. $this->render_attributes() .'>';
	}
}