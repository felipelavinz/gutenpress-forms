<?php

namespace GutenPress\Forms;

abstract class Form_Component implements Form_Element_Interface{
	use Form_Control_Trait;
	protected $name;
	protected $value;
	public function set_name( $name ){
		$this->name = $name;
		return $this;
	}
	public function get_name(){
		return $this->name;
	}
	public function set_value( $value ){
		$this->value = $value;
		return $this;
	}
	public function get_value(){
		return $this->value;
	}
}