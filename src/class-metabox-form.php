<?php

namespace GutenPress\Forms;

class Metabox_Form extends Element\Form{
	public function __toString(){
		$view_class = $this->get_view();
		$view = new $view_class( $this );
		return (string) $view;
	}
}