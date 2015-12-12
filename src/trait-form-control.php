<?php

namespace GutenPress\Forms;

trait Form_Control_Trait{
	protected $label = '';
	public function set_label( $label ){
		$this->label = $label;
		return $this;
	}
	public function get_label(){
		return $this->label;
	}
}