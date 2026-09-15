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
		$class_names = implode( ' ', array_filter( $classes ) );

		$link_class = ( 0 === $depth ) ? 'link_item' : 'link_sub_item';

		$output .= '<li' . ( $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '' ) . '>';
		$output .= '<a href="' . esc_url( $item->url ) . '" class="' . esc_attr( $link_class ) . '">';
		$output .= esc_html( $item->title );
		$output .= '</a>';
	}

	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		$output .= '</li>';
	}
}
