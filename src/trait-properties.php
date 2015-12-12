<?php

namespace GutenPress\Forms;

trait Properties_Trait{

	// Attributes and such
	protected $properties = array();

	/**
	 * Get any property from this element
	 * @param string $key The key name for the property
	 * @return mixed The property value (most likely an string)
	 */
	public function get_property( $key ) {
		return isset( $this->properties[$key] ) ? $this->properties[$key] : '';
	}

	public function set_property( $key, $value ) {
		$this->properties[$key] = $value;
		return $this;
	}

	public function get_properties() {
		return $this->properties;
	}
}