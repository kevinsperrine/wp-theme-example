<?php

/**
* Acts as a master facade class for WordPress to allow me to isolate and test
* functionality without bootstrapping all of WordPress
*
* @uses
*
* @category Category
* @package  Package
* @author    <>
* @license
* @link
*/
class C3_Support_Facade_WordPress
{
    /**
     * Magic __call method that creates a facade for globalwordpress functions.
     *
     * @param string $method    The WordPress function you want to call.
     * @param mixed  $arguments The arguments passed to the function
     *
     * @access public
     *
     * @return mixed The returns value from the WP function
     */
    public function __call($method, $arguments)
    {
        if (function_exists($method)) {
            return call_user_func_array($method, $arguments);
        }

        throw new Exception(sprintf('The function, "%s", does not exist.', $method));
    }

    /**
     * Facade method for returning the current $post object.
     *
     * @access public
     *
     * @return Object The WordPress global $post object
     */
    public function post()
    {
        global $post;

        return $post;
    }

    /**
     * Returns the global $wpdb object
     *
     * @access public
     *
     * @return Wpdb WordPress's global $wpdb object
     */
    public function wpdb()
    {
        global $wpdb;

        return $wpdb;
    }

    /**
     * Facade method for creating new WP_Query objects
     *
     * @param mixed Either a string or array of arguments passed to WP_Query
     *
     * @access public
     *
     * @return WP_Query
     */
    public function newQuery($args)
    {
        return new WP_Query($args);
    }

    /**
     * Returns the current global WP_Query object
     *
     * @access public
     *
     * @return WP_Query
     */
    public function wpQuery()
    {
        global $wp_query;

        return $wp_query;
    }

    /**
     * Returns WordPress's global $wp object.
     *
     * @access public
     *
     * @return WP Object
     */
    public function wp()
    {
        global $wp;

        return $wp;
    }

    public function typenow()
    {
        global $typenow;

        return $typenow;
    }
}
