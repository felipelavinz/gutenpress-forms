<?php

namespace GutenPress\Forms\Element;

use GutenPress\Forms;

class WP_Gallery extends WP_Media{
	public function get_default_args(){
		return [
			'title'    => $this->get_label(),
			'multiple' => 'add',
			'button'   => array(
				'text' => _x('Select images', 'WP_Gallery button text', 'gutenpress'),
			),
			'library'  => array(
				'type' => 'image',
			)
		];
	}
	public function get_upload_button_text(){
		return _x('Upload or select some existing images', 'WP_Gallery button text', 'gutenpress');
	}

	public function get_remove_button_text(){
		return _x('Remove images', 'WP_Gallery button text', 'gutenpress');
	}

	public function get_replace_button_text(){
		return _x('Replace images', 'WP_Gallery button text', 'gutenpress');
	}
}