<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'aviaShortcodeTemplate' ) ) {
	return;
}

class Enfold_Ticker_Element extends aviaShortcodeTemplate {

	protected function shortcode_insert_button() {
		$this->config['name']      = __( 'Ticker', 'enfold-ticker' );
		$this->config['tab']       = __( 'Content Elements', 'enfold-ticker' );
		$this->config['icon']      = AviaBuilder::$path['imagesURL'] . 'sc-announcement.png';
		$this->config['order']     = 10;
		$this->config['target']    = 'avia-target-insert';
		$this->config['tinyMCE']   = array( 'disable' => 'true' );
		$this->config['shortcode'] = 'av_ticker';
		$this->config['tooltip']   = __( 'Add a scrolling news ticker', 'enfold-ticker' );
	}

	protected function popup_elements() {
		$this->elements = array(

			array(
				'type'           => 'tab_container',
				'nodescription'  => true,
			),

			// Content tab
			array(
				'type'          => 'tab',
				'name'          => __( 'Content', 'enfold-ticker' ),
				'nodescription' => true,
			),
			array(
				'type' => 'textarea',
				'name' => __( 'Ticker Content', 'enfold-ticker' ),
				'desc' => __( 'Enter the text to display in the ticker.', 'enfold-ticker' ),
				'id'   => 'content',
				'std'  => __( 'Your ticker text goes here', 'enfold-ticker' ),
			),
			array(
				'type' => 'tab_close',
			),

			// Styling tab
			array(
				'type'          => 'tab',
				'name'          => __( 'Styling', 'enfold-ticker' ),
				'nodescription' => true,
			),
			array(
				'type' => 'input',
				'name' => __( 'Font Size', 'enfold-ticker' ),
				'desc' => __( 'Ticker font size, e.g. 16px or 1rem.', 'enfold-ticker' ),
				'id'   => 'font_size',
				'std'  => '16px',
			),
			array(
				'type'    => 'select',
				'name'    => __( 'Scroll Speed', 'enfold-ticker' ),
				'desc'    => __( 'How fast the ticker scrolls.', 'enfold-ticker' ),
				'id'      => 'speed',
				'std'     => 'medium',
				'subtype' => array(
					__( 'Slow',   'enfold-ticker' ) => 'slow',
					__( 'Medium', 'enfold-ticker' ) => 'medium',
					__( 'Fast',   'enfold-ticker' ) => 'fast',
				),
			),
			array(
				'type'    => 'select',
				'name'    => __( 'Scroll Direction', 'enfold-ticker' ),
				'desc'    => __( 'Direction the ticker text scrolls.', 'enfold-ticker' ),
				'id'      => 'direction',
				'std'     => 'rtl',
				'subtype' => array(
					__( 'Right to Left (default)', 'enfold-ticker' ) => 'rtl',
					__( 'Left to Right',           'enfold-ticker' ) => 'ltr',
				),
			),
			array(
				'type' => 'tab_close',
			),

			array(
				'type'          => 'tab_container_close',
				'nodescription' => true,
			),
		);
	}

	public function shortcode_handler( $atts, $content = '', $shortcode_tag = '' ) {
		$atts = shortcode_atts(
			array(
				'font_size' => '16px',
				'speed'     => 'medium',
				'direction' => 'rtl',
			),
			$atts,
			$shortcode_tag
		);

		wp_enqueue_style( 'enfold-ticker' );

		$speed_map = array(
			'slow'   => '40s',
			'medium' => '20s',
			'fast'   => '10s',
		);
		$duration  = isset( $speed_map[ $atts['speed'] ] ) ? $speed_map[ $atts['speed'] ] : '20s';
		$direction = in_array( $atts['direction'], array( 'rtl', 'ltr' ), true ) ? $atts['direction'] : 'rtl';
		$font_size = esc_attr( $atts['font_size'] );
		$content   = wp_kses_post( $content );

		$inline_style = sprintf(
			'style="--enfold-ticker-duration:%s; font-size:%s;"',
			esc_attr( $duration ),
			esc_attr( $font_size )
		);

		$output  = '<div class="enfold-ticker" ' . $inline_style . '>';
		$output .= '<div class="enfold-ticker-track enfold-ticker-track--' . esc_attr( $direction ) . '">';
		// Content is duplicated to create a seamless loop via CSS animation.
		$output .= '<span class="enfold-ticker-content">' . $content . '</span>';
		$output .= '<span class="enfold-ticker-content" aria-hidden="true">' . $content . '</span>';
		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}
}

new Enfold_Ticker_Element();
