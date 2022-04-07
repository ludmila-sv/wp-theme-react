<?php
/**
 * Include React into the theme.
 *
 * @package pressfoundry
 */

/**
 * Enqueue Theme JS w React Dependency
 *
 * @package pressfoundry
 */
function pf_enqueue_react_js() {
	wp_enqueue_script(
		'pf-react',
		get_stylesheet_directory_uri() . '/build/react.js',
		array( 'wp-element' ),
		time(), // Change this to wp_get_theme()->get('Version') for production.
		true
	);
}
add_action( 'wp_enqueue_scripts', 'pf_enqueue_react_js' );

/**
 * Pass some data to react.js
 */
function pf_archive_data() {
	$page_title = '';
	$query_parameters = '';
	$category         = '';
	$tag              = '';
	$blog_url         = get_post_type_archive_link( 'post' ) . '/';
	$posts_per_page   = get_option( 'posts_per_page' ) ? get_option( 'posts_per_page' ) : 12;
	$search           = get_search_query() ? get_search_query() : null;
//	$count_posts = wp_count_posts();
//	$total_posts = $count_posts->publish;

	if ( is_home() ) {
		$page_title = 'Blog';
	} elseif ( is_archive() ) {
		$page_title = wp_strip_all_tags( get_the_archive_title() );
	} elseif ( is_search() ) {
		$page_title = 'Search results for: ' . get_search_query();
	}

	if ( is_category() ) { // .
		$query_parameters = 'categories=' . get_queried_object()->term_id;
		$blog_url        .= 'category/' . get_queried_object()->slug . '/';
		$category         = get_queried_object()->term_id;
	} elseif ( is_tag() ) {
		$query_parameters = 'tags=' . get_queried_object()->term_id;
		$blog_url        .= 'tag/' . get_queried_object()->slug . '/';
		$tag              = get_queried_object()->term_id;
	}

	$current_page     = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	$query_parameters = $query_parameters ? $query_parameters . '&per_page=' . $posts_per_page : 'per_page=' . $posts_per_page;
	$query_parameters = $query_parameters ? $query_parameters . '&page=' . $current_page : 'page=' . $current_page;

	$data = array(
		'page_title'       => $page_title,
		'current_page'     => $current_page,
		'posts_per_page'   => $posts_per_page,
		'query_parameters' => $query_parameters,
		'blog_url'         => $blog_url,
		'category'         => $category,
		'tag'              => $tag,
		'search'           => $search,
	);
	wp_localize_script( 'pf-react', 'archive_data', $data );
}
add_action( 'wp_enqueue_scripts', 'pf_archive_data' );

/**
 * Add archive headers to header of the rest api request.
 *
 * @param WP_REST_Response $result Current rest response.
 * @param WP_REST_Server   $server Server object.
 * @param WP_REST_Request  $request Current rest request.
 *
 * @return mixed
 */
function pf_archive_header( $result, $server, $request ) {
	$title = 'Blog';
	if ( ! empty( $request['tags'] ) ) {
		$title = 'Tag: ' . get_term( $request['tags'][0] )->name;
	}
	if ( ! empty( $request['categories'] ) ) {
		$title = 'Category: ' . get_cat_name( $request['categories'][0] );
	}
	if ( ! empty( $request['search'] ) ) {
		$title = 'Search Results for: ' . $request['search'];
	}

	$result->header( 'X-WP-Archive-Header', wp_strip_all_tags( $title ) );
	return $result;
}

add_filter( 'rest_post_dispatch', 'pf_archive_header', 10, 3 );

/* GraphQL */

// Don't know what for, but pagination does not work without this.
add_filter(
	'graphql_post_object_connection_query_args',
	function( $args ) {
		$args['no_found_rows'] = false;
		return $args;
	}
);

// Add total number of posts to page_info.
add_action(
	'graphql_register_types',
	function() {

		register_graphql_field(
			'WPPageInfo',
			'total',
			array(
				'type' => 'Int',
			)
		);

	}
);
add_filter(
	'graphql_connection_page_info',
	function( $page_info, $connection ) {
		$page_info['total'] = null;
		if ( $connection->get_query() instanceof \WP_Query ) {
			if ( isset( $connection->get_query()->found_posts ) ) {
				$page_info['total'] = (int) $connection->get_query()->found_posts;
			}
		}
		return $page_info;
	},
	10,
	2
);

// Add archive title to page_info.
add_action(
	'graphql_register_types',
	function() {

		register_graphql_field(
			'WPPageInfo',
			'pageTitle',
			array(
				'type' => 'String',
			)
		);

	}
);
add_filter(
	'graphql_connection_page_info',
	function( $page_info, $connection ) {
		$page_info['pageTitle'] = null;
		$page_title             = '';
		if ( $connection->get_query() instanceof \WP_Query ) {
			if ( ! empty( $connection->get_query()->is_home ) ) {
				$page_title = 'Blog';
			} elseif ( ! empty( $connection->get_query()->is_category ) ) {
				$page_title = 'Category: ' . $connection->get_query()->get_queried_object()->name;
			} elseif ( ! empty( $connection->get_query()->is_tag ) ) {
				$page_title = 'Tag: ' . $connection->get_query()->get_queried_object()->name;
			} elseif ( ! empty( $connection->get_query()->is_search ) ) {
				$page_title = 'Search Results for: ' . $connection->get_query()->s;
			}
		}
		$page_info['pageTitle'] = $page_title;
		return $page_info;
	},
	10,
	2
);
