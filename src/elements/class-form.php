<?php

namespace GutenPress\Forms\Element;

use GutenPress\Forms;

class Form extends Forms\HTML_Element{
	protected static $element_attributes = array(
		'accept-charset',
		'action',
		'autocomplete',
		'enctype',
		'method',
		'name',
		'novalidate',
		'target'
	);
	protected static $valid_enctype = array(
		'application/x-www-form-urlencoded',
		'multipart/form-data',
		'text/plain'
	);
	protected $view = '';
	public function get_tag_name(){
		return 'form';
	}
	public function set_view( $view_class ){
		if ( ! in_array( 'GutenPress\Forms\View_Interface', class_implements( $view_class ) ) ) {
			throw new \InvalidArgumentException();
		}
		$this->view = $view_class;
	}
	public function get_view(){
		if ( empty( $this->view ) ) {
			return apply_filters('gutenpress_form_default_view', '\GutenPress\Forms\View\WP_Wide');
		} else {
			return $this->view;
		}
	}
	public function __toString(){
		$out  = '';
		$view = new $this->{ $this->get_view() }( $this );
		$out .= '<form'. $this->render_attributes() .'>';
			$out .= $view;
		$out .= '</form>';
		return $out;
	}
}