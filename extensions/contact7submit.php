<?php 

/*

	The code below extends functionality of Contact Form 7's submit module

*/

if (function_exists('wpcf7_add_shortcode')) wpcf7_add_shortcode( 'submit_chrome', 'wpcf7_submit_chrome_shortcode_handler' );

function wpcf7_submit_chrome_shortcode_handler( $tag ) {
	if ( ! is_array( $tag ) )
		return '';

	$options = (array) $tag['options'];
	$values = (array) $tag['values'];

	$atts = '';
	$id_att = '';
	$class_att = '';
	$tabindex_att = '';

	$class_att .= ' wpcf7-submit';

	foreach ( $options as $option ) {
		if ( preg_match( '%^id:([-0-9a-zA-Z_]+)$%', $option, $matches ) ) {
			$id_att = $matches[1];

		} elseif ( preg_match( '%^class:([-0-9a-zA-Z_]+)$%', $option, $matches ) ) {
			$class_att .= ' ' . $matches[1];

		} elseif ( preg_match( '%^tabindex:(\d+)$%', $option, $matches ) ) {
			$tabindex_att = (int) $matches[1];

		}
	}

	if ( $id_att )
		$atts .= ' id="' . trim( $id_att ) . '"';

	if ( $class_att )
		$atts .= ' class="' . trim( $class_att ) . '"';

	if ( '' !== $tabindex_att )
		$atts .= sprintf( ' tabindex="%d"', $tabindex_att );

	$value = isset( $values[0] ) ? $values[0] : '';
	if ( empty( $value ) )
		$value = __( 'Send', 'wpcf7' );

	$html = '<button ' . $atts . '><span><span>'.esc_attr( $value ).'</span></span></button>';

	if ( wpcf7_script_is() ) {
		$src = apply_filters( 'wpcf7_ajax_loader', wpcf7_plugin_url( 'images/ajax-loader.gif' ) );
		$html .= '<img class="ajax-loader" style="visibility: hidden;" alt="' . esc_attr( __( 'Sending ...', 'wpcf7' ) ) . '" src="' . esc_url_raw( $src ) . '" />';
	}

	return $html;
}



?>