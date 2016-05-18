<?php

namespace GutenPress\Forms;

use GutenPress\Helpers\Arrays;

trait Attributes_Trait{

	/**
	 * Element's own attributes.
	 * @var array
	 */
	protected static $element_attributes = array();

	/**
	 * Collected attributes
	 * @var array
	 */
	protected $attributes = array();

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
	 * Output all the element's attributes.
	 * @uses esc_attr()
	 * @return string Element attributes
	 */
	protected function render_attributes() {
		$out = '';
		foreach ( $this->get_attributes() as $key => $val ) {
			if ( ! is_string( $val ) ) {
				$val = json_encode( $val );
			}
			$out  .= ' '. $key .'="'. esc_attr( trim($val) ) .'"';
		}
		return $out;
	}
}