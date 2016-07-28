<?php
// don't load directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

if(!class_exists('Kidix_Google_Map')) {
    class Kidix_Google_Map {
        function __construct() {
            add_shortcode('kidix_google_map', array($this, 'shortcode'));
        }

        function shortcode($atts) {
	        $output = '';

	        extract( shortcode_atts( array(
                'title'     => '',
                'latitude'  => '',
                'longitude' => '',
                'zoom'      => 12,
            ), $atts ) );

			$output .= '<div id="wpgmza_map"></div>';
			ob_start(); ?>
<script>
var map;

function initialize() {
	var myLatlng = new google.maps.LatLng(<?php echo esc_html( $latitude ); ?>, <?php echo esc_html( $longitude ); ?>);
	var mapOptions = {
		zoom: <?php echo intval( $zoom ); ?>,
		center: myLatlng,
		scrollwheel: false,
		styles: [{"stylers":[{"saturation":-100},{"gamma":0.8},{"lightness":4},{"visibility":"on"}]},{"featureType":"landscape.natural","stylers":[{"visibility":"on"},{"color":"#5dff00"},{"gamma":4.97},{"lightness":-5},{"saturation":100}]}],
	};
	
	map = new google.maps.Map(document.getElementById('wpgmza_map'), mapOptions);
	
	var marker = new google.maps.Marker({
		position: myLatlng,
		map: map,
		title: '<?php echo esc_html( $title ); ?>'
	});
}

if( typeof google != 'undefined' ) {
	google.maps.event.addDomListener(window, 'load', initialize);
}
</script>
<?php
			$output .= ob_get_clean();

            return $output;
        }
    }
    new Kidix_Google_Map;
}