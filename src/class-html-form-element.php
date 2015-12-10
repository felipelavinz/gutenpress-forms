<?php

namespace GutenPress\Forms;

abstract class HTML_Form_Element extends HTML_Element implements Form_Element_Interface{
	protected $label = '';
	protected $value = null;
	public function set_label( $label ){
		$this->label = $label;
		return $this;
	}
	public function get_label(){
		return $this->label;
	}
	public function set_name( $name ){
		$this->set_attribute('name', $name);
		return $this;
	}
	public function get_name(){
		return $this->name;
	}
}