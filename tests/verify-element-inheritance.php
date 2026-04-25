<?php
/**
 * CLI check: child class must be loadable and override shortcode_handler with Enfold’s signature.
 *
 * Run from plugin root: php tests/verify-element-inheritance.php
 */
define( 'ABSPATH', __DIR__ . '/../' );

if ( ! defined( 'ENFOLD_TICKER_STANDALONE_TEST' ) ) {
	define( 'ENFOLD_TICKER_STANDALONE_TEST', true );
}

// Minimal stubs for the element file (mirrors what Enfold provides when ALB runs).
if ( ! function_exists( '__' ) ) {
	function __( $text, $domain = 'default' ) {
		return $text;
	}
}
class AviaBuilder {
	public static $path = array( 'imagesURL' => 'https://example.test/' );
}
class aviaShortcodeTemplate {
	public $config  = array();
	public $elements = array();

	public function __construct( $builder = null ) {
		if ( is_callable( array( $this, 'shortcode_insert_button' ) ) ) {
			$this->shortcode_insert_button();
		}
		if ( is_callable( array( $this, 'popup_elements' ) ) ) {
			$this->popup_elements();
		}
	}

	public function editor_element( $params ) {
		return $params;
	}
	public function shortcode_handler( $atts, $content = '', $shortcodename = '', $meta = '' ) {
		return '';
	}
}

require __DIR__ . '/../shortcodes/avia-ticker.php';
// The element file also runs `new Enfold_Ticker_Element();` on load; class must parse with public shortcode_handler.

$rc = new ReflectionClass( 'Enfold_Ticker_Element' );
$m  = $rc->getMethod( 'shortcode_handler' );
if ( ! $m->isPublic() ) {
	fwrite( STDERR, "FAIL: shortcode_handler must be public (PHP requires match with aviaShortcodeTemplate).\n" );
	exit( 1 );
}
$parent_m = ( new ReflectionClass( 'aviaShortcodeTemplate' ) )->getMethod( 'shortcode_handler' );
if ( $m->getNumberOfParameters() !== $parent_m->getNumberOfParameters() ) {
	fwrite( STDERR, "FAIL: shortcode_handler must declare the same parameters as aviaShortcodeTemplate.\n" );
	exit( 1 );
}
echo "OK: class loads; shortcode_handler is public and signature matches parent.\n";
exit( 0 );
