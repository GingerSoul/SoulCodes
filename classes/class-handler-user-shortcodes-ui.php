<?php

use GingerSoul\SoulCodes\Handler;
use GingerSoul\SoulCodes\Query_Builder_Interface;
use GingerSoul\SoulCodes\Template_Interface;

/**
 * Handler class.
 *
 * @package SoulCodes
 */
class Handler_User_Shortcodes_Ui extends Handler {

	/**
	 * @since [*next-version*]
	 */
	protected function hook() {
		add_action(
			'admin_menu',
			function () {
				$this->register_pages();
			}
		);
	}

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

    protected function get_list_page_output()
    {
        $query = $this->get_shortcodes()->get();
        $total = $query->found_posts;
        $count = $query->post_count;
        $shortcodes = $query->get_posts();

        $list = $this->create_template_block($this->get_template('user_shortcodes_list'), [
            'shortcodes'            => $shortcodes,
            'total'                 => $total,
            'count'                 => $count,
        ]);
        $page = $this->create_template_block($this->get_template('user_shortcodes_list_page'), [
            'list'          => $list,
        ]);

        return $page;
    }

    /**
     * @return Query_Builder_Interface
     */
    protected function get_shortcodes() {
	    $builder = $this->get_config('user_shortcodes_query_builder');
        assert($builder instanceof Query_Builder_Interface);

        return $builder;
    }
}
