<?php
class HmdMobileMenu extends Walker_Nav_Menu {
    function start_lvl( &$output, $depth = 0, $args = null ) {
        $submenu_class = $depth == 0 ? 'pl-4 bg-gray-50' : 'pl-4 bg-gray-100';
        $output .= "\n<div class='submenu $submenu_class'>\n";
    }

    function end_lvl( &$output, $depth = 0, $args = null ) {
        $output .= "</div>\n";
    }

    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        $class_names = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item';

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = ' class="' . esc_attr( $class_names ) . '"';

        $output .= $indent . '<div' . $class_names . '>';

        if ( $depth == 0 && !empty($args->has_children) ) {
            $output .= '<a href="' . esc_url( $item->url ) . '" class="w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100">';
            $output .= esc_html( $item->title );
            $output .= '</a>';
            $output .= '<button class="float-right px-4">&#9660;</button>';
        } else if ( !empty($args->has_children) ) {
            $output .= '<a href="' . esc_url( $item->url ) . '" class="w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100">';
            $output .= esc_html( $item->title );
            $output .= '</a>';
            $output .= '<button class="float-right px-4">&#9660;</button>';
        } else {
            $output .= '<a href="' . esc_url( $item->url ) . '" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">';
            $output .= esc_html( $item->title );
            $output .= '</a>';
        }
    }

    function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= "</div>\n";
    }

    function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
        $element->has_children = !empty( $children_elements[ $element->ID ] );
        $args[0]->has_children = $element->has_children;

        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
}





