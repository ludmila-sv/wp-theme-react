<?php
/**
 * Version 1.0
 *      <?php wp_nav_menu( [
 *          'theme_location'  => 'primary',
 *          'container'       => 'nav',
 *          'container_class' => 'header-menu',
 *          'menu_class'      => 'menu',
 *          'walker'          => new Clean_Walker(),
 *          'tab_space'       => 3 // number of tabs to initially indent menu
 *      ] ); ?>
 */
class Clean_Walker extends Walker_Nav_Menu {

	/**
	 * Id of submenu so submenu togglers will be aware of what menu to toggle.
	 *
	 * @var string
	 */
	public $submenu_id = '';

	/**
	 * Aria label of submenu for screen readers.
	 *
	 * @var string
	 */
	public $aria_submenu_label = '';

	/**
	 * Starts the list before the elements are added.
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::start_lvl()
	 *
	 * @param string         $output Used to append additional content (passed by reference).
	 * @param int            $depth  Depth of menu item. Used for padding.
	 * @param stdClass|array $args   An object of wp_nav_menu() arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		if ( isset( $args->tab_space ) && $args->tab_space > 0 ) {
			$depth = $depth + intval( $args->tab_space );
		}
		$depth ++;
		$indent = str_repeat( $t, $depth );

		// Default class.
		// $classes = array( 'sub-menu','collapse' );
		$classes = array( 'sub-menu' );

		/**
		 * Filters the CSS class(es) applied to a menu list element.
		 *
		 * @since 4.8.0
		 *
		 * @param array    $classes The CSS classes that are applied to the menu `<ul>` element.
		 * @param stdClass $args    An object of `wp_nav_menu()` arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		$class_names = join( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$output .= "{$n}{$indent}" . '<ul id="' . $this->submenu_id . '" ' . $class_names . ' aria-label="' . $this->aria_submenu_label . '">' . "{$n}";
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::end_lvl()
	 *
	 * @param string         $output Used to append additional content (passed by reference).
	 * @param int            $depth  Depth of menu item. Used for padding.
	 * @param stdClass|array $args   An object of wp_nav_menu() arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		if ( isset( $args->tab_space ) && $args->tab_space > 0 ) {
			$depth = $depth + intval( $args->tab_space );
		}
		$depth++;

		$indent  = str_repeat( $t, $depth );
		$output .= "$indent</ul>{$n}";
	}

	/**
	 * Starts the element output.
	 *
	 * @since 3.0.0
	 * @since 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
	 *
	 * @see Walker::start_el()
	 *
	 * @param string         $output Used to append additional content (passed by reference).
	 * @param WP_Post        $item   Menu item data object.
	 * @param int            $depth  Depth of menu item. Used for padding.
	 * @param stdClass|array $args   An object of wp_nav_menu() arguments.
	 * @param int            $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		// to shift LI inside submenu.
		if ( $depth > 0 ) {
			$depth ++;
		}
		// to add starting space.
		if ( isset( $args->tab_space ) && $args->tab_space > 0 ) {
			$depth = $depth + intval( $args->tab_space );
		}

		$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		// $classes[] = 'menu-item-' . $item->ID;
		// $classes[] = 'nav-item';

		// if(false !== array_search('current-menu-item', $classes) ){
		// $classes[] = 'active';
		// }

		$has_children = ( false !== array_search( 'menu-item-has-children', $classes, true ) );

		/**
		 * Filters the arguments for a single nav menu item.
		 *
		 * @since 4.4.0
		 *
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param WP_Post  $item  Menu item data object.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

		// lets remove standard probably unnecessary classes.

		$classes = array_filter(
			$classes,
			function( $class_name ) {

				if ( 0 === strpos( $class_name, 'menu-item-type-' ) ) {
					return false;
				}
				if ( 0 === strpos( $class_name, 'menu-item-object-' ) ) {
					return false;
				}

				return true;

			}
		);
		/**
		 * Filters the CSS class(es) applied to a menu item's list item element.
		 *
		 * @since 3.0.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array    $classes The CSS classes that are applied to the menu item's `<li>` element.
		 * @param WP_Post  $item    The current menu item.
		 * @param stdClass $args    An object of wp_nav_menu() arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );

		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		/**
		 * Filters the ID applied to a menu item's list item element.
		 *
		 * @since 3.0.1
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string   $menu_id The ID that is applied to the menu item's `<li>` element.
		 * @param WP_Post  $item    The current menu item.
		 * @param stdClass $args    An object of wp_nav_menu() arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		// $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
		// $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$id      = '';
		$output .= $n . $indent . '<li' . $id . $class_names . '>';

		$atts = array();
		// commented out title to solve safari bug.
//		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target ) ? $item->target : '';
		if ( '_blank' === $item->target && empty( $item->xfn ) ) {
			$atts['rel'] = 'noopener noreferrer';
		} else {
			$atts['rel'] = $item->xfn;
		}
		$atts['href'] = ! empty( $item->url ) ? $item->url : '';

		/**
		 * Filters the HTML attributes applied to a menu item's anchor element.
		 *
		 * @since 3.6.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 *     @type string $title  Title attribute.
		 *     @type string $target Target attribute.
		 *     @type string $rel    The rel attribute.
		 *     @type string $href   The href attribute.
		 * }
		 * @param WP_Post  $item  The current menu item.
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		// $atts['role'] = 'menuitem';

		/** This filter is documented in wp-includes/post-template.php */
		$title = apply_filters( 'the_title', $item->title, $item->ID );

		/**
		 * Filters a menu item's title.
		 *
		 * @since 4.4.0
		 *
		 * @param string   $title The menu item's title.
		 * @param WP_Post  $item  The current menu item.
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

		// Here we handle mixed case when our link has children but on it's own it is a `#` empty hash link
		// so it will become a subnavbar toggle on it's own.
		if ( $has_children ) {

			$this->aria_submenu_label = esc_attr( $title );
			$this->submenu_id         = esc_attr( is_numeric( $item->post_name ) ? ( 'menu-' . $item->post_name ) : $item->post_name );

			if ( empty( $atts['href'] ) || ( '#' === $atts['href'] ) ) {

				// we are setting here WAI-ARIA attributes for link to be toggler on it's own.
				$atts['href'] = '#' . $this->submenu_id;
				// $atts['aria-expanded'] = 'false';
				// $atts['aria-haspopup'] = 'true';
				$atts['aria-label'] = 'Toggle ' . $this->aria_submenu_label;
			}
		}

		// combine link's attributes into  single string.
		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$item_output  = $n;
		$item_output .= $indent . $t;
		$item_output .= $args->before;
		$item_output .= '<a class="nav-link"' . $attributes . '>';
		$item_output .= $args->link_before . $title . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;
		$item_output .= $n;

		if ( $has_children ) {
			$item_output .= $indent . $t;
			$item_output .= '<a class="subnavbar-toggler" href="#' . $this->submenu_id . '"  aria-label="Toggle ' . $this->aria_submenu_label . ' "></a>';

		}

		/**
		 * Filters a menu item's starting output.
		 *
		 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
		 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
		 * no filter for modifying the opening and closing `<li>` for a menu item.
		 *
		 * @since 3.0.0
		 *
		 * @param string   $item_output The menu item's starting HTML output.
		 * @param WP_Post  $item        Menu item data object.
		 * @param int      $depth       Depth of menu item. Used for padding.
		 * @param stdClass $args        An object of wp_nav_menu() arguments.
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::end_el()
	 *
	 * @param string         $output Used to append additional content (passed by reference).
	 * @param WP_Post        $item   Page data object. Not used.
	 * @param int            $depth  Depth of page. Not Used.
	 * @param stdClass|array $args   An object of wp_nav_menu() arguments.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$initial_depth = $depth;
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		// to shift LI in Submenu.
		if ( $depth > 0 ) {
			$depth ++;
		}
		// to add starting space.
		if ( isset( $args->tab_space ) && $args->tab_space > 0 ) {
			$depth = $depth + intval( $args->tab_space );
		}
		$indent = str_repeat( $t, $depth );

		$output .= $indent;
		$output .= "</li>{$n}";
		if ( $initial_depth < 1 ) {
			if ( $depth > 0 ) {
				$depth--;
			}
			$output .= str_repeat( $t, $depth );
		}

	}

} // Clean_Walker
