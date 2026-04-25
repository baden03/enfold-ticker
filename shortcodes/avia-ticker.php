<?php
/**
 * ALB Ticker shortcode (loaded via avia_load_shortcodes path).
 *
 * @package enfold-ticker
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Enfold_Ticker_Element' ) ) {
	class Enfold_Ticker_Element extends aviaShortcodeTemplate {

		/**
		 * @param \AviaBuilder|object $builder AviaBuilder instance (required by Enfold’s parent class).
		 */
		public function __construct( $builder = null ) {
			parent::__construct( $builder );
		}

		public function shortcode_insert_button() {
			$this->config['version']         = '1.0';
			$this->config['self_closing']    = 'no';
			$this->config['name']            = __( 'Ticker', 'enfold-ticker' );
			// Use Enfold’s own tab string so the button groups with default Content Elements (tab-2), not a new column.
			$this->config['tab']  = __( 'Content Elements', 'avia_framework' );
			// `sc-announcement.png` is not present in all Enfold builds; we resolve a file that exists or a bundled icon.
			$this->config['icon'] = function_exists( 'enfold_ticker_get_alb_icon_url' ) ? enfold_ticker_get_alb_icon_url() : AviaBuilder::$path['imagesURL'] . 'sc-announcement.png';
			$this->config['order']          = 10;
			$this->config['target']         = 'avia-target-insert';
			$this->config['tinyMCE']        = array( 'disable' => true );
			$this->config['shortcode']      = 'av_ticker';
			$this->config['tooltip']        = __( 'Add a scrolling news ticker', 'enfold-ticker' );
			$this->config['preview']         = 'large';
			$this->config['id_name']        = 'id';
			$this->config['id_show']         = 'yes';
		}

		public function popup_elements() {
			$this->elements = array(

				array(
					'type'          => 'tab_container',
					'nodescription' => true,
				),

				array(
					'type'          => 'tab',
					'name'          => __( 'Content', 'enfold-ticker' ),
					'nodescription' => true,
				),
				array(
					'type'  => 'textarea',
					'name'  => __( 'Ticker Content', 'enfold-ticker' ),
					'desc'  => __( 'Enter the text to display in the ticker.', 'enfold-ticker' ),
					'id'    => 'content',
					'std'   => __( 'Your ticker text goes here', 'enfold-ticker' ),
				),
				array(
					'type' => 'tab_close',
				),

				array(
					'type'          => 'tab',
					'name'          => __( 'Styling', 'enfold-ticker' ),
					'nodescription' => true,
				),
				array(
					'type'  => 'input',
					'name'  => __( 'Font Size', 'enfold-ticker' ),
					'desc'  => __( 'Ticker font size, e.g. 16px or 1rem.', 'enfold-ticker' ),
					'id'    => 'font_size',
					'std'   => '16px',
				),
				array(
					'type' => 'input',
					'name' => __( 'Scroll duration', 'enfold-ticker' ),
					'desc' => __( 'Duration in seconds for one full loop (5-300). Lower is faster, higher is slower.', 'enfold-ticker' ),
					'id'   => 'scroll_duration',
					'std'  => '20',
				),
				array(
					'type'    => 'select',
					'name'    => __( 'Scroll Direction', 'enfold-ticker' ),
					'desc'    => __( 'Direction the ticker text scrolls.', 'enfold-ticker' ),
					'id'      => 'direction',
					'std'     => 'rtl',
					'subtype' => array(
						__( 'Right to Left (default)', 'enfold-ticker' ) => 'rtl',
						__( 'Left to Right',            'enfold-ticker' ) => 'ltr',
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

		/**
		 * How the element appears in the ALB editor canvas.
		 *
		 * @param array $params Builder layout params.
		 * @return array
		 */
		public function editor_element( $params ) {
			$label = esc_html__( 'Ticker', 'enfold-ticker' );
			$params['class']     = 'enfold_ticker el_before_title';
			$params['innerHtml'] = '<div class="avia_textblock" data-update_with="content" style="padding:12px 0;text-align:center"><strong>' . $label . '</strong></div>';

			return $params;
		}

		public function shortcode_handler( $atts, $content = '', $shortcodename = '', $meta = '' ) {
			$defaults = array(
				'font_size'        => '16px',
				'scroll_duration'  => '20',
				'speed'            => '',
				'direction'        => 'rtl',
			);
			$atts     = shortcode_atts( $defaults, $atts, $shortcodename );
			$duration = $this->enfold_ticker_get_duration( $atts );

			wp_enqueue_style( 'enfold-ticker' );

			$direction = in_array( $atts['direction'], array( 'rtl', 'ltr' ), true ) ? $atts['direction'] : 'rtl';
			$font_size = esc_attr( $atts['font_size'] );
			$content   = wp_kses_post( $content );

			$inline_style = sprintf(
				'style="--enfold-ticker-duration:%s; font-size:%s;"',
				esc_attr( $duration ),
				esc_attr( $font_size )
			);

			// Wrapper helps Avia color sections / flex cells stretch the ticker to full content width.
			$output  = '<div class="enfold-ticker-wrap" ' . $inline_style . '>';
			$output .= '<div class="enfold-ticker">';
			$output .= '<div class="enfold-ticker-track enfold-ticker-track--' . esc_attr( $direction ) . '">';
			// Two segments, each at least the ticker width, so short text still wraps seamlessly (the duplicate enters as the first leaves).
			$output .= '<div class="enfold-ticker-seg"><span class="enfold-ticker-content">' . $content . '</span></div>';
			$output .= '<div class="enfold-ticker-seg" aria-hidden="true"><span class="enfold-ticker-content">' . $content . '</span></div>';
			$output .= '</div>';
			$output .= '</div>';
			$output .= '</div>';

			return $output;
		}

		/**
		 * Return CSS duration string from atts (scroll_duration in seconds) or legacy speed presets.
		 *
		 * @param array $atts Merged atts.
		 * @return string e.g. "24s"
		 */
		protected function enfold_ticker_get_duration( array $atts ) {
			$raw = isset( $atts['scroll_duration'] ) ? $atts['scroll_duration'] : '20';
			if ( ( is_string( $raw ) || is_int( $raw ) || is_float( $raw ) ) && $raw !== '' && is_numeric( $raw ) ) {
				$sec = (int) $raw;
			} elseif ( ! empty( $atts['speed'] ) && in_array( $atts['speed'], array( 'slow', 'medium', 'fast' ), true ) ) {
				$legacy = array(
					'slow'   => 40,
					'medium' => 20,
					'fast'   => 10,
				);
				$sec = (int) $legacy[ $atts['speed'] ];
			} else {
				$sec = 20;
			}
			$sec = min( 300, max( 5, $sec ) );

			return (string) $sec . 's';
		}
	}

	// Instantiated in AviaBuilder::load_shortcode_library() method scope, so $this is the builder.
	// In CLI test, ENFOLD_TICKER_STANDALONE_TEST is set and a stub AviaBuilder is used.
	$enfold_ticker_builder = ( defined( 'ENFOLD_TICKER_STANDALONE_TEST' ) && ENFOLD_TICKER_STANDALONE_TEST )
		? new AviaBuilder()
		: ( isset( $this ) ? $this : null );
	if ( $enfold_ticker_builder ) {
		new Enfold_Ticker_Element( $enfold_ticker_builder );
	}
}
