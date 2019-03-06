<?php

use GingerSoul\SoulCodes\Handler;
use GingerSoul\SoulCodes\Query_Builder_Interface;

/**
 * Handler class.
 *
 * @since [*next-version*]
 *
 * @package SoulCodes
 */
class Handler_User_Shortcodes_Ui extends Handler {

    const PARAM_ACTION = 'action';
    const PARAM_NONCE = 'nonce';
    const PARAM_ID = 'id';
    const PARAM_OBJECT = 'object';
    const OBJECT_SHORTCODE = 'shortcode';
    const ACTION_TRASH = 'trash';
    const ACTION_ADD = 'add';

	/**
     * {@inheritdoc}
     *
	 * @since [*next-version*]
	 */
	protected function hook() {
	    add_action(
	        'admin_init',
            function () {
	            global $pagenow;

	            // Only for our page
	            if (!$pagenow === 'admin.php') {
	                return;
                }

                $string_filter_options = FILTER_FLAG_STRIP_BACKTICK
                    | FILTER_FLAG_STRIP_HIGH
                    | FILTER_FLAG_STRIP_LOW;
                $page = filter_input(
                    INPUT_GET,
                    'page',
                    FILTER_SANITIZE_STRING,
                    $string_filter_options
                );
                $object = filter_input(
                    INPUT_GET,
                    static::PARAM_OBJECT,
                    FILTER_SANITIZE_STRING,
                    $string_filter_options
                );
                $action = filter_input(
                    INPUT_GET,
                    self::PARAM_ACTION,
                    FILTER_SANITIZE_STRING,
                    $string_filter_options
                );

                if (is_null($action)) {
                    return;
                }

                $is_handled = $this->handle_action($page, $action, $object);
                if ($is_handled) {
                    wp_redirect(admin_url(vsprintf('%1$s?page=%2$s', [$pagenow, $page])));
                    exit();
                }
            }
        );

		add_action(
			'admin_menu',
			function () {
				$this->register_pages();
			}
		);
	}

    /**
     * Handles an action of a page.
     *
     * Useful for things like CRUD operations.
     * Requires a nonce to be passed as part of the URL.
     *
     * @since [*next-version*]
     *
     * @param string $page The key of the page to handle.
     * @param string $action The key of the action to handle.
     */
	protected function handle_action($page, $action, $object)
    {
        if (!$page === $this->get_config('user_shortcodes_list_page_name')) {
            return false;
        }

        $nonce = filter_input(
            INPUT_GET,
            static::PARAM_NONCE,
            FILTER_SANITIZE_STRING,
            FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK
            );

        // Require valid nonce.
        if (!$this->validate_nonce($nonce, $object)) {
            wp_die(
                wpautop($this->__('You are not authorized to perform this action.
Possibly the page which dispatched the action has timed out.
Please go back, refresh the page, and try again.')),
                $this->__('Action Interrupted'),
                [
                    'back_link' => true,
                ]);
        }

        switch ($object) {
            case static::OBJECT_SHORTCODE:
                return $this->handle_shortcode_action($action);

                break;
        }

        return false;
    }

    /**
     * Handles an action of a shortcode.
     *
     * @since [*next-version*]
     *
     * @param string $action The key of the list page action to handle.
     */
    protected function handle_shortcode_action($action) {
        switch ($action) {
            case static::ACTION_TRASH:
                $id = abs(filter_input(
                    INPUT_GET,
                    static::PARAM_ID,
                    FILTER_SANITIZE_NUMBER_INT
                ));
                $is_success = $this->delete_shortcode($id);

                return true;

                break;

            case static::ACTION_ADD:
                $is_success = $this->add_shortcode($this->get_config('user_shortcode_default_name'), '');

                return true;

                break;
        }

        return false;
    }

    protected function add_shortcode($name, $template) {
        return (bool) wp_insert_post([
            'post_name'     => $name,
            'post_content'  => $template,
            'post_type'     => $this->get_config('user_shortcodes_post_type'),
            'post_status'   => 'publish'
        ]);
    }

    /**
     * Deletes a shortcode by ID.
     *
     * @since [*next-version*]
     *
     * @param int $id The ID of the shortcode to delete.
     *
     * @return bool True if the post was deleted successfully; false otherwise.
     */
    protected function delete_shortcode($id) {
	    return (bool) wp_delete_post($id);
    }

    /**
     * Registers admin menus and their pages.
     *
     * @since [*next-version*]
     */
	protected function register_pages()
    {
        $menu_slug = $this->get_config('user_shortcodes_list_page_name');
        $capability = $this->get_config('user_shortcodes_list_page_cap');
        add_menu_page(
            $this->__('SoulCodes'),
            $this->__('SoulCodes'),
            $capability,
            $menu_slug,
            function () {
                echo $this->get_list_page_output();
            }
        );
    }

    /**
     * Retrieves the output of the list page.
     *
     * @since [*next-version*]
     *
     * @return string Something that can be cast to string, which represents page output.
     */
    protected function get_list_page_output()
    {
        $query = $this->get_shortcodes()->get();
        $total = $query->found_posts;
        $count = $query->post_count;
        $shortcodes = $query->get_posts();
        $object = static::OBJECT_SHORTCODE;
        $action_trash = static::ACTION_TRASH;
        $action_add = static::ACTION_ADD;
        $trash_url_template = add_query_arg([
            self::PARAM_OBJECT        => $object,
            self::PARAM_ACTION        => $action_trash,
            self::PARAM_NONCE         => '%1$s',
            self::PARAM_ID            => '%2$s',
        ]);
        $add_url_template = add_query_arg([
            self::PARAM_OBJECT        => $object,
            self::PARAM_ACTION        => $action_add,
            self::PARAM_NONCE         => '%1$s',
        ]);
        $nonce = $this->create_nonce($object);

        $list = $this->create_template_block($this->get_template('user_shortcodes_list'), [
            'shortcodes'            => $shortcodes,
            'total'                 => $total,
            'count'                 => $count,
            'nonce'                 => $nonce,
            'trash_url_template'    => $trash_url_template,
            'add_url_template'      => $add_url_template,
        ]);
        $page = $this->create_template_block($this->get_template('user_shortcodes_list_page'), [
            'list'          => $list,
        ]);


        return $page;
    }

    /**
     * Retrieves a query builder for shortcode queries.
     *
     * @since [*next-version*]
     *
     * @return Query_Builder_Interface The shortcode query builder.
     */
    protected function get_shortcodes() {
	    $builder = $this->get_config('user_shortcodes_query_builder');
        assert($builder instanceof Query_Builder_Interface);

        return $builder;
    }

    /**
     * Creates a nonce for the specified key.
     *
     * @since [*next-version*]
     *
     * @param string $key The key to create the nonce for.
     *
     * @return string A string or stringable object that represents a nonce.
     */
    protected function create_nonce($key) {
        return wp_create_nonce($key);
    }

    /**
     * Determines whether a nonce is valid.
     *
     * @since [*next-version*]
     *
     * @param string $nonce A string or stringable value that represents a nonce to validate.
     * @param string $key The key to validate the nonce for.
     *
     * @return false|int A positive integer if the nonce is valid. False otheriwse.
     * See {@see wp_verify_nonce()}.
     */
    protected function validate_nonce($nonce, $key) {
        return wp_verify_nonce($nonce, $key);
    }
}
