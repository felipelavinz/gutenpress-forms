<?php

namespace GutenPress\Forms;

interface Element_Interface{
	/**
	 * Indicate if the element has the specified attribute or not.
	 * @param  string  $attribute_name The name of the attribute you're checking
	 * @return boolean                 True if the element has the attribute
	 */
	public function has_attribute( $attribute_name );

	/**
	 * Indicate if the element has one or more of the given attributes.
	 * @param  array   $attribute_names The name of the attributes you're checking
	 * @return boolean                  True if the element has at least one of the checked attributes
	 */
	public function has_attributes( array $attribute_names );

	/**
	 * Set the value of a named attribute.
	 * @param string $name  The name of the attribute
	 * @param string|mixed $value  Value of the attribute
	 */
	public function set_attribute( $name, $value );

	/**
	 * Get the value of a given attribute.
	 * @param string $attribute_name Name of the attribute
	 * @return string|mixed Value of the named attribute
	 */
	public function get_attribute( $attribute_name );

	/**
	 * Get all attributes associated with this element.
	 * @return array All the element's attributes
	 */
	public function get_attributes();

	/**
	 * Get a collection of all child elements of the element.
	 * @return array Child elements
	 */
	public function get_children();

	/**
	 * Get a list of all class attributes.
	 * @return array All element classes
	 */
	public function get_class_list();

	/**
	 * Get a string representing the class of the element.
	 * @return string Element class as a string
	 */
	public function get_class_name();

	/**
	 * Get the unique ID of the element.
	 * @return string ID of the element
	 */
	public function get_id();

	/**
	 * Get the name of the tag for the given element.
	 * @return string Tag name of the element
	 */
	public function get_tag_name();

	/**
	 * Get a string representation of the element,
	 * Use (string)$object to get, or echo $object to output
	 * @return string String representation of the element
	 */
	public function __toString();
}