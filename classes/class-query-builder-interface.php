<?php

namespace GingerSoul\SoulCodes;

use WP_Query;

/**
 * Interface Post_Query_Builder_Interface
 *
 * @package GingerSoul\SoulCodes
 */
interface Query_Builder_Interface {

	/**
	 * Retrieves the query for the parameters.
	 *
	 * @since [*next-version*]
	 *
	 * @return WP_Query
	 */
	public function get();

	/**
	 * Sets a limit on the amount of records retreived.
	 *
	 * @since [*next-version*]
	 *
	 * @param int|null $limit
	 * @return self
	 */
	public function withLimit( $limit);

	/**
	 * Sets the offset for the returned records.
	 *
	 * @since [*next-version*]
	 *
	 * @param int $offset
	 * @return self
	 */
	public function withOffset( $offset);

	/**
	 * Adds ordering to the returned records.
	 *
	 * @since [*next-version*]
	 *
	 * @param string $field Name of the field to order by.
	 * @param bool   $isAscending If true, records will be sorted in ascending order;
	 *   descending order otherwise.
	 *
	 * @return self
	 */
	public function withAddedOrder( $field, $isAscending);
}
