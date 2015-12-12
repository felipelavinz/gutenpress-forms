<?php

namespace GutenPress\Forms\Element;

use GutenPress\Forms;

class WP_Image extends WP_Media{
	public function get_default_args(){
		return [
			'title'    => $this->get_label(),
			'multiple' => false,
			'button'   => array(
				'text' => _x('Select image', 'WP_Image button text', 'gutenpress'),
			),
			'library'  => array(
				'type' => 'image',
			)
		];
	}
	public function get_upload_button_text(){
		return _x('Upload or select an existing image', 'WP_Image button text', 'gutenpress');
	}

	public function get_remove_button_text(){
		return _x('Remove image', 'WP_Image button text', 'gutenpress');
	}

	public function get_replace_button_text(){
		return _x('Replace image', 'WP_Image button text', 'gutenpress');
	}
}