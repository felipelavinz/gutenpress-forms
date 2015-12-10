<?php

namespace GutenPress\Forms;

use GutenPress\Helpers\Arrays;

abstract class HTML_Element implements Element_Interface{

	/**
	 * HTML attributes that apply for any element.
	 * @var array
	 * @link http://www.w3.org/TR/html5/dom.html#global-attributes
	 */
	private static $global_attributes = array(
		'accesskey',
		'class',
		'contenteditable',
		'dir',
		'hidden',
		'id',
		'lang',
		'spellcheck',
		'style',
		'tabindex',
		'title',
		'translate',
	);

	/**
	 * Patterns for composed attributes (e.g: data-src, aria-required).
	 * @var array
	 */
	private static $global_attribute_pattern_prefixes = array(
		'data',
		'aria'
	);

	/**
	 * Element's own attributes.
	 * @var array
	 */
	protected static $element_attributes = array();

	protected $text_content = '';

	/**
	 * Collected attributes
	 * @var array
	 */
	protected $attributes = array();

	// Attributes and such
	protected $properties = array();

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

	public function has_attribute( $key ) {
		return isset( $this->attributes[$key] );
	}

	public function has_attributes( array $keys ) {
		return (bool) array_intersect( array_keys( $this->get_attributes() ), $keys );
	}

	/**
	 * Set the value of a named attribute.
	 *
	 * Since it returns a reference to the same element, you can use it
	 * on a "fluid" way:
	 * $obj->set_attribute( 'foo', 'bar' )->set_attribute( 'lorem', 'ipsum' );
	 *
	 * @param string $attr  The name of the attribute
	 * @param string $value Value of the attribute
	 * @return HTMLElement Reference to the same element
	 */
	public function set_attribute( $attr, $value ) {
		$this->attributes[ $attr ] = $value;
		return $this;
	}

	public function set_attributes( array $attributes = array() ) {
		foreach ( $attributes as $key => $val ) {
			$this->set_attribute( $key, $val);
		}
		return $this;
	}

	public function get_attribute( $attr ) {
		return isset( $this->attributes[ $attr ] ) ? $this->attributes[ $attr ] : '';
	}

	public function get_attributes() {
		return $this->attributes;
	}

	public function get_class_list() {
		$classes = $this->get_attribute('class');
		$classes = explode( ' ', $classes );
		$classes = array_unique( $classes );
		return $classes;
	}

	public function get_class_name() {
		return implode( ' ', $this->get_class_list() );
	}

	public function add_class( $class ) {
		$classes = $this->get_class_list();
		$classes[] = $class;
		$this->set_attribute('class', implode(' ', $classes));
		return $this;
	}

	public function remove_class( $class ) {
		$classes = $this->get_class_list();
		$without = Arrays::without( $classes, $class );
		$this->set_attribute('class', implode(' ', $without));
		return $this;
	}

	public function get_id() {
		return $this->get_attribute( 'id' );
	}

	/**
	 * Get the HTML content for the tag (innerHTML)
	 * @return string
	 */
	public function get_text_content() {
		return $this->text_content;
	}

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

	/**
	 * Output all the element's attributes.
	 * @uses esc_attr()
	 * @return string Element attributes
	 */
	protected function render_attributes() {
		$out = '';
		foreach ( $this->get_attributes() as $key => $val ) {
			$out  .= ' '. $key .'="'. esc_attr( $val ) .'"';
		}
		return $out;
	}

	public function get_children(){
		return $this->children;
	}
	public function append_node_child( Element_Interface $element ){
		$this->children[] = $element;
		return $this;
	}
}