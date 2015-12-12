<?php

namespace GutenPress\Forms;

use GutenPress\Helpers\Arrays;

abstract class HTML_Element implements Element_Interface{

	use Attributes_Trait, Properties_Trait;

	protected $text_content = '';

	protected $children = array();

	/**
	 * Build an HTMLElement
	 * @param array  $properties Element properties; most likely attributes but might include other stuff to be used by the view
	 * @param string $content Element content
	 */
	public function __construct( array $properties = array() , $text_content = '' ) {
		if ( $properties )
			$this->init_properties( $properties );
		if ( $text_content )
			$this->set_text_content( $content );
	}

	/**
	 * Set element content (stuff inside the tag)
	 * @param string $content
	 */
	public function set_text_content( $content ) {
		$this->text_content = $content;
		return $this;
	}

	/**
	 * Set element properties (attributes and others)
	 * @param array $properties [description]
	 */
	public function set_properties( array $properties) {
		$this->init_properties( $properties );
		return $this;
	}

	/**
	 * Set element properties: attributes and others.
	 * Will separate attributes from other types of attributes based on $global_attributes and $element_attributes
	 * @param array $properties
	 */
	private function init_properties( array $properties ) {
		// recursively filter null values
		$this->properties = Arrays::filter_recursive( $properties );
		// collect all attributes properties for this element
		$this->collect_attributes();
	}

	/**
	 * Loop the element properties and check if they're allowed HTML attributes
	 */
	protected function collect_attributes() {
		foreach ( $this->properties as $key => $val ) {
			if ( in_array($key, self::$global_attributes) || in_array($key, static::$element_attributes) ) {
				$this->attributes[ $key ] = $val;
				continue;
			}
			// also check for compound attributes, such as data-src, aria-required, etc.
			foreach ( self::$global_attribute_pattern_prefixes as $prefix ) {
				if ( preg_match( '/'. $prefix .'[-]\w+/', $key ) ) {
					$this->attributes[ $key ] = $val;
					continue;
				}
			}
		}
	}

	public function __get( $key ) {
		if ( 'class' == $key ) {
			return $this->get_class_name();
		}
		if ( 'id' == $key ) {
			return $this->get_id();
		}
		return $this->get_attribute( $key );
	}

	/**
	 * Get the HTML content for the tag (innerHTML)
	 * @return string
	 */
	public function get_text_content() {
		return $this->text_content;
	}

	public function get_children(){
		return $this->children;
	}
	public function append_node_child( Element_Interface $element ){
		$this->children[] = $element;
		return $this;
	}
}