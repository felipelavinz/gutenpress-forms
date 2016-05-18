<?php

namespace GutenPress\Forms;

trait Options_Trait{
	protected $options;
	public function set_options( $options ){
		$this->options = $options;
		return $this;
	}
	public function get_options(){
		return $this->options;
	}
}