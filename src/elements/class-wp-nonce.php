<?php

namespace GutenPress\Forms\Element;

class WP_Nonce extends Input_Hidden{
	protected $action = '-1';
	protected $name = '_wpnonce';
	protected $referer = true;
	public function set_action( $action ){
		$this->action = $action;
		return $this;
	}
	public function set_name( $name ){
		$this->name = $name;
		return $this;
	}
	public function set_referer( $use_referer ){
		$this->referer = (bool) $use_referer;
		return $this;
	}
	public function get_action(){
		return $this->action;
	}
	public function get_name(){
		return $this->name;
	}
	public function get_referer(){
		return $this->referer;
	}
	public function __toString(){
		return wp_nonce_field( $this->get_action(), $this->get_name(), $this->get_referer(), false);
	}
}