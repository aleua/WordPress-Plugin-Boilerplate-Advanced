<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link http://example.com
 *
 * @package Plugin_Name
 * @subpackage Plugin_Name/includes
 * @since 1.0.0
 */

/**
 * Registers all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @since 1.0.0
 */
class Plugin_Name_Loader {

	/**
	 * The array of actions registered with WordPress.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var array $actions The actions registered with WordPress to fire when the plugin loads.
	 */
	protected $actions;

	/**
	 * The array of filters registered with WordPress.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var array $filters The filters registered with WordPress to fire when the plugin loads.
	 */
	protected $filters;

	/**
	 * The array of filters registered with WordPress.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var array $shortcodes The shortcodes registered with WordPress to fire when the plugin loads.
	 */
	protected $shortcodes;

	/**
	 * Initializes the collections used to maintain the actions, filters and shortcodes.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->actions    = array();
		$this->filters    = array();
		$this->shortcodes = array();
	}

	/**
	 * Adds a new action to the collection to be registered with WordPress.
	 *
	 * @since 1.0.0
	 *
	 * @param string $hook The name of the WordPress action that is being registered.
	 * @param object $component A reference to the instance of the object on which the action is defined.
	 * @param string $callback The name of the function definition on the $component.
	 * @param int $priority Optional. The priority at which the function should be fired. Default is 10.
	 * @param int $accepted_args Optional. The number of arguments that should be passed to the $callback. Default is 1.
	 */
	public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * Adds a new filter to the collection to be registered with WordPress.
	 *
	 * @since 1.0.0
	 *
	 * @param string $hook The name of the WordPress filter that is being registered.
	 * @param object $component A reference to the instance of the object on which the filter is defined.
	 * @param string $callback The name of the function definition on the $component.
	 * @param int $priority Optional. The priority at which the function should be fired. Default is 10.
	 * @param int $accepted_args Optional. The number of arguments that should be passed to the $callback. Default is 1
	 */
	public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * Adds a new shortcode to the collection to be registered with WordPress.
	 *
	 * @since 1.0.0
	 *
	 * @param string $tag The tag of the shortcode that is being registered.
	 * @param object $component A reference to the instance of the object on which the filter is defined.
	 * @param string $callback The name of the function definition on the $component.
	 */
	public function add_shortcode( $tag, $component, $callback ) {
		$this->shortcodes = $this->add( $this->shortcodes, $tag, $component, $callback );
	}

	/**
	 * A utility function that is used to register the actions, hooks and shortcodes into a single
	 * collection.
	 *
	 * @since 1.0.0
	 * @access private
	 *
	 * @param array $hooks The collection of hooks that is being registered (that is, actions or filters).
	 * @param string $hook The name of the WordPress filter that is being registered.
	 * @param object $component A reference to the instance of the object on which the filter is defined.
	 * @param string $callback The name of the function definition on the $component.
	 * @param int $priority Optional. The priority at which the function should be fired. Default is null.
	 * @param int $accepted_args Optional. The number of arguments that should be passed to the $callback. Default is null.
	 *
	 * @return   array The collection of actions and filters registered with WordPress.
	 */
	private function add( $hooks, $hook, $component, $callback, $priority = null, $accepted_args = null ) {
		$hooks[] = array(
			'hook'          => $hook,
			'component'     => $component,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args
		);

		return $hooks;
	}

	/**
	 * Registers the filters, actions and shortcodes with WordPress.
	 *
	 * @since 1.0.0
	 */
	public function run() {
		foreach ( $this->filters as $hook ) {
			add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'],
				$hook['accepted_args'] );
		}

		foreach ( $this->actions as $hook ) {
			add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'],
				$hook['accepted_args'] );
		}

		foreach ( $this->shortcodes as $hook ) {
			add_shortcode( $hook['hook'], array( $hook['component'], $hook['callback'] ) );
		}
	}

}
