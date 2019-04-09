<?php

namespace GingerSoul\SoulCodes;

use WP_Query;

class Post_Query_Builder implements Query_Builder_Interface {

	const ORDER_ASCENDING  = 'ASC';
	const ORDER_DESCENDING = 'DESC';

	/** @var int|null */
	protected $limit;

	/** @var int */
	protected $offset;

	/** @var array[] */
	protected $order;

	/** @var array */
	protected $defaults;

	/** @var callable */
	protected $query_factory;

	public function __construct( $query_factory, $defaults = [] ) {
		$this->defaults      = $defaults;
		$this->order         = [];
		$this->offset        = 0;
		$this->query_factory = $query_factory;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @since [*next-version*]
	 */
	public function get() {
		$args  = $this->get_args( $this->defaults );
		$query = $this->create_wp_query( $args );

		return $query;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @since [*next-version*]
	 */
	public function withLimit( $limit ) {
		if ( ! is_null( $limit ) ) {
			$limit = (int) $limit;
		}

		$builder        = clone $this;
		$builder->limit = $limit;

		return $builder;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @since [*next-version*]
	 */
	public function withOffset( $offset ) {
		$builder         = clone $this;
		$builder->offset = (int) $offset;

		return $builder;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @since [*next-version*]
	 */
	public function withAddedOrder( $field, $is_ascending ) {
		$builder                  = clone $this;
		$builder->order[ $field ] = $is_ascending;

		return $builder;
	}

	protected function get_args( $defaults ) {
		$args = $defaults;

		if ( ! isset( $args['orderby'] ) ) {
			$args['orderby'] = [];
		}

		foreach ( $this->order as $key => $value ) {
			$args['orderby'][ $key ] = $value
				? static::ORDER_ASCENDING
				: static::ORDER_DESCENDING;
		}

		$args['posts_per_page'] = is_null( $this->limit )
			? -1
			: (int) $this->limit;

		$args['offset'] = (int) $this->offset;

		return $args;
	}

	/**
	 * Creates a new WP query object.
	 *
	 * @param array $args The args for the new query.
	 *
	 * @return WP_Query The new query object.
	 */
	protected function create_wp_query( $args ) {
		return ( $this->query_factory )( $args );
	}
}
