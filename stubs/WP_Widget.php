<?php
/**
 * Support template for @instance
 *
 * Temporary ovveride while we wait for the PR to be merged
 *
 * @link https://github.com/php-stubs/wordpress-stubs/pull/160
 */

namespace {

	/**
	 * @phpstan-template T of array<string, mixed>
	 */
	#[\AllowDynamicProperties]
	class WP_Widget {
		/**
		 * Root ID for all widgets of this type.
		 *
		 * @since 2.8.0
		 * @var mixed|string
		 */
		public $id_base;

		/**
		 * Name for this widget type.
		 *
		 * @since 2.8.0
		 * @var string
		 */
		public $name;

		/**
		 * Option name for this widget type.
		 *
		 * @since 2.8.0
		 * @var string
		 */
		public $option_name;

		/**
		 * Alt option name for this widget type.
		 *
		 * @since 2.8.0
		 * @var string
		 */
		public $alt_option_name;

		/**
		 * Option array passed to wp_register_sidebar_widget().
		 *
		 * @since 2.8.0
		 * @var array
		 */
		public $widget_options;

		/**
		 * Option array passed to wp_register_widget_control().
		 *
		 * @since 2.8.0
		 * @var array
		 */
		public $control_options;

		/**
		 * Unique ID number of the current instance.
		 *
		 * @notice Could be '__i__' if a legacy widget block.
		 *
		 * @since 2.8.0
		 * @var bool|int|string
		 */
		public $number = \false;

		/**
		 * Unique ID string of the current instance (id_base-number).
		 *
		 * @since 2.8.0
		 * @var bool|string
		 */
		public $id = \false;

		/**
		 * Whether the widget data has been updated.
		 *
		 * Set to true when the data is updated after a POST submit - ensures it does
		 * not happen twice.
		 *
		 * @since 2.8.0
		 * @var bool
		 */
		public $updated = \false;

		//
		// Member functions that must be overridden by subclasses.
		//

		/**
		 * PHP5 constructor.
		 *
		 * @since 2.8.0
		 *
		 * @param string $id_base         Base ID for the widget, lowercase and unique. If left empty,
		 *                                a portion of the widget's PHP class name will be used. Has to be unique.
		 * @param string $name            Name for the widget displayed on the configuration page.
		 * @param array  $widget_options  Optional. Widget options. See wp_register_sidebar_widget() for
		 *                                information on accepted arguments. Default empty array.
		 * @param array  $control_options Optional. Widget control options. See wp_register_widget_control() for
		 *                                information on accepted arguments. Default empty array.
		 *
		 * @phpstan-param array{
		 *   classname?: string,
		 *   description?: string,
		 *   show_instance_in_rest?: bool,
		 * }             $widget_options  See wp_register_sidebar_widget()
		 * @phpstan-param array{
		 *   height?: int,
		 *   width?: int,
		 *   id_base?: int|string,
		 * }             $control_options See wp_register_widget_control()
		 */
		public function __construct( $id_base, $name, $widget_options = [], $control_options = [] ) {
		}


		/**
		 * Echoes the widget content.
		 *
		 * Subclasses should override this function to generate their widget code.
		 *
		 * @since 2.8.0
		 *
		 * @param array     $args
		 * @param array     $instance
		 * @phpstan-param T $instance
		 * @phpstan-param array{name:string,id:string,description:string,class:string,before_widget:string,after_widget:string,before_title:string,after_title:string,before_sidebar:string,after_sidebar:string,show_in_rest:boolean,widget_id:string,widget_name:string} $args
		 */
		public function widget( $args, $instance ) {
		}


		/**
		 * Updates a particular instance of a widget.
		 *
		 * This function should check that `$new_instance` is set correctly. The newly-calculated
		 * value of `$instance` should be returned. If false is returned, the instance won't be
		 * saved/updated.
		 *
		 * @since 2.8.0
		 *
		 * @param array     $new_instance New settings for this instance as input by the user via
		 *                                WP_Widget::form().
		 * @param array     $old_instance Old settings for this instance.
		 *
		 * @return array Settings to save or bool false to cancel saving.
		 * @phpstan-param T $new_instance
		 * @phpstan-param T $old_instance
		 */
		public function update( $new_instance, $old_instance ) {
		}
		// Functions you'll need to call.


		/**
		 * Outputs the settings update form.
		 *
		 * @since 2.8.0
		 *
		 * @param array     $instance Current settings.
		 *
		 * @return string Default return is 'noform'.
		 *
		 * @phpstan-param T $instance
		 */
		public function form( $instance ) {
		}


		/**
		 * PHP4 constructor.
		 *
		 * @since      2.8.0
		 * @see        WP_Widget::__construct()
		 *
		 * @deprecated 4.3.0 Use __construct() instead.
		 *
		 * @param string $id_base         Base ID for the widget, lowercase and unique. If left empty,
		 *                                a portion of the widget's PHP class name will be used. Has to be unique.
		 * @param string $name            Name for the widget displayed on the configuration page.
		 * @param array  $widget_options  Optional. Widget options. See wp_register_sidebar_widget() for
		 *                                information on accepted arguments. Default empty array.
		 * @param array  $control_options Optional. Widget control options. See wp_register_widget_control() for
		 *                                information on accepted arguments. Default empty array.
		 *
		 * @phpstan-param array{
		 *   classname?: string,
		 *   description?: string,
		 *   show_instance_in_rest?: bool,
		 * }             $widget_options  See wp_register_sidebar_widget()
		 * @phpstan-param array{
		 *   height?: int,
		 *   width?: int,
		 *   id_base?: int|string,
		 * }             $control_options See wp_register_widget_control()
		 */
		public function WP_Widget( $id_base, $name, $widget_options = [], $control_options = [] ) {
		}


		/**
		 * Constructs name attributes for use in form() fields
		 *
		 * This function should be used in form() methods to create name attributes for fields
		 * to be saved by update()
		 *
		 * @since 2.8.0
		 * @since 4.4.0 Array format field names are now accepted.
		 *
		 * @param string $field_name Field name.
		 *
		 * @return string Name attribute for `$field_name`.
		 */
		public function get_field_name( $field_name ) {
		}


		/**
		 * Constructs id attributes for use in WP_Widget::form() fields.
		 *
		 * This function should be used in form() methods to create id attributes
		 * for fields to be saved by WP_Widget::update().
		 *
		 * @since 2.8.0
		 * @since 4.4.0 Array format field IDs are now accepted.
		 *
		 * @param string $field_name Field name.
		 *
		 * @return string ID attribute for `$field_name`.
		 */
		public function get_field_id( $field_name ) {
		}


		/**
		 * Register all widget instances of this widget class.
		 *
		 * @since 2.8.0
		 */
		public function _register() {
		}


		/**
		 * Sets the internal order number for the widget instance.
		 *
		 * @since 2.8.0
		 *
		 * @param int $number The unique order number of this widget instance compared to other
		 *                    instances of the same class.
		 */
		public function _set( $number ) {
		}


		/**
		 * Retrieves the widget display callback.
		 *
		 * @since 2.8.0
		 *
		 * @return callable Display callback.
		 */
		public function _get_display_callback() {
		}


		/**
		 * Retrieves the widget update callback.
		 *
		 * @since 2.8.0
		 *
		 * @return callable Update callback.
		 */
		public function _get_update_callback() {
		}


		/**
		 * Retrieves the form callback.
		 *
		 * @since 2.8.0
		 *
		 * @return callable Form callback.
		 */
		public function _get_form_callback() {
		}


		/**
		 * Determines whether the current request is inside the Customizer preview.
		 *
		 * If true -- the current request is inside the Customizer preview, then
		 * the object cache gets suspended and widgets should check this to decide
		 * whether they should store anything persistently to the object cache,
		 * to transients, or anywhere else.
		 *
		 * @since 3.9.0
		 *
		 * @global WP_Customize_Manager $wp_customize
		 *
		 * @return bool True if within the Customizer preview, false if not.
		 */
		public function is_preview() {
		}


		/**
		 * Generates the actual widget content (Do NOT override).
		 *
		 * Finds the instance and calls WP_Widget::widget().
		 *
		 * @since 2.8.0
		 *
		 * @param array     $args        Display arguments. See WP_Widget::widget() for information
		 *                               on accepted arguments.
		 * @param int|array $widget_args {
		 *                               Optional. Internal order number of the widget instance, or array of multi-widget arguments.
		 *                               Default 1.
		 *
		 * @type int        $number      Number increment used for multiples of the same widget.
		 *                               }
		 * @phpstan-param int|array{
		 *   number?: int,
		 * }                $widget_args
		 * @phpstan-return void
		 */
		public function display_callback( $args, $widget_args = 1 ) {
		}


		/**
		 * Handles changed settings (Do NOT override).
		 *
		 * @since 2.8.0
		 *
		 * @global array $wp_registered_widgets
		 *
		 * @param int    $deprecated Not used.
		 *
		 * @phpstan-return void
		 */
		public function update_callback( $deprecated = 1 ) {
		}


		/**
		 * Generates the widget control form (Do NOT override).
		 *
		 * @since 2.8.0
		 *
		 * @param int|array $widget_args {
		 *                               Optional. Internal order number of the widget instance, or array of multi-widget arguments.
		 *                               Default 1.
		 *
		 * @type int        $number      Number increment used for multiples of the same widget.
		 *                               }
		 * @return string|null
		 * @phpstan-param int|array{
		 *   number?: int,
		 * }                $widget_args
		 */
		public function form_callback( $widget_args = 1 ) {
		}


		/**
		 * Registers an instance of the widget class.
		 *
		 * @since 2.8.0
		 *
		 * @param int $number Optional. The unique order number of this widget instance
		 *                    compared to other instances of the same class. Default -1.
		 */
		public function _register_one( $number = - 1 ) {
		}


		/**
		 * Saves the settings for all instances of the widget class.
		 *
		 * @since 2.8.0
		 *
		 * @param array $settings Multi-dimensional array of widget instance settings.
		 */
		public function save_settings( $settings ) {
		}


		/**
		 * Retrieves the settings for all instances of the widget class.
		 *
		 * @since 2.8.0
		 *
		 * @return array Multi-dimensional array of widget instance settings.
		 */
		public function get_settings() {
		}
	}
}
