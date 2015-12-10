<?php
/**
 * Define a high-level interface for form elements.
 *
 * All elements that can have or use a value within a form must implement
 * this interface: inputs, textareas, selects... but also composed elements
 * that are not simple HTML elements -- complex controls such as image
 * galleries, location maps or other javascript-based controls.
 */
namespace GutenPress\Forms;

interface Form_Element_Interface{

	/**
	 * Set the label for the form control.
	 * @param string $label Label for the control
	 */
	public function set_label( $label );

	public function get_label();

	/**
	 * Set the name used in form submission.
	 *
	 * This is the name that will be used as key in the $_POST or $_GET request
	 * sent to the server and it's used to identify a single control.
	 * It's not required to be unique.
	 *
	 * @param string $name Element name
	 */
	public function set_name( $name );

	public function get_name();

	/**
	 * Set the value of the form control.
	 *
	 * In many cases it will be a string value (textareas, text, email or url inputs),
	 * but it can also be an array of values for fields such as checkboxes.
	 *
	 * @param mixed $value Value for the form control.
	 */
	public function set_value( $value );

	public function get_value();

}