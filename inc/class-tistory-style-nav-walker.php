<?php
/**
 * Renders wp_nav_menu() output in the exact markup the skin's CSS targets:
 *   <ul class="category_list">
 *     <li><a class="link_item">Label</a>
 *       <ul class="sub_category_list">
 *         <li><a class="link_sub_item">Child</a></li>
 *       </ul>
 *     </li>
 *   </ul>
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class Tistory_Style_Nav_Walker extends Walker_Nav_Menu {

	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '<ul class="sub_category_list">';
	}

	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '</ul>';
	}

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		if ( in_array( 'current-menu-item', $classes, true ) || in_array( 'current-menu-ancestor', $classes, true ) ) {
			$classes[] = 'selected';
		}

		$has_new = false;
		$cat_id  = 0;
		if ( ( 'taxonomy' === $item->type && 'category' === $item->object ) || 'category' === $item->object ) {
			$cat_id = (int) $item->object_id;
		} elseif ( ! empty( $item->url ) ) {
			$cat_path = trim( (string) wp_parse_url( $item->url, PHP_URL_PATH ), '/' );
			if ( preg_match( '#category/([^/]+)#', $cat_path, $matches ) ) {
				$cat_obj = get_category_by_slug( $matches[1] );
				if ( $cat_obj && ! is_wp_error( $cat_obj ) ) {
					$cat_id = (int) $cat_obj->term_id;
				}
			}
		}

		if ( $cat_id && function_exists( 'wisdom_desk_category_has_new_post' ) ) {
			$has_new = wisdom_desk_category_has_new_post( $cat_id );
		}

		if ( $has_new ) {
			$classes[] = 'has-new-post';
		}

		$class_names = implode( ' ', array_filter( $classes ) );
		$link_class  = ( 0 === $depth ) ? 'link_item' : 'link_sub_item';

		$output .= '<li' . ( $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '' ) . '>';
		$output .= '<a href="' . esc_url( $item->url ) . '" class="' . esc_attr( $link_class ) . '">';
		$output .= esc_html( $item->title );
		if ( $has_new ) {
			$output .= '<span class="nav-new-dot" aria-label="' . esc_attr__( '새 글', 'tistory-style' ) . '" title="' . esc_attr__( '새 글', 'tistory-style' ) . '"></span>';
		}
		$output .= '</a>';
	}

	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		$output .= '</li>';
	}
}
