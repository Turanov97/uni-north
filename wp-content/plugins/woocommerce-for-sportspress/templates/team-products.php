<?php
/**
 * Team Product Thumbnail
 *
 * @author    WordPay
 * @package   WooCommerce_SportsPress
 * @version   1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$html5 = current_theme_supports( 'html5', 'gallery' );
$defaults = array(
	'id' => get_the_ID(),
	'title' => false,
	'number' => -1,
	'orderby' => 'default',
	'itemtag' => 'dl',
	'icontag' => 'dt',
	'captiontag' => 'dd',
	'columns' => 3,
	'size' => 'sportspress-crop-medium',
);

extract( $defaults, EXTR_SKIP );

// Determine number of teams to display
if ( -1 === $number ):
	$number = (int) get_post_meta( $id, 'sp_number', true );
	if ( $number <= 0 ) $number = -1;
endif;

$itemtag = tag_escape( $itemtag );
$captiontag = tag_escape( $captiontag );
$icontag = tag_escape( $icontag );
$valid_tags = wp_kses_allowed_html( 'post' );
if ( ! isset( $valid_tags[ $itemtag ] ) )
	$itemtag = 'dl';
if ( ! isset( $valid_tags[ $captiontag ] ) )
	$captiontag = 'dd';
if ( ! isset( $valid_tags[ $icontag ] ) )
	$icontag = 'dt';

$columns = intval( $columns );
$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
$size = $size;
$float = is_rtl() ? 'right' : 'left';

$selector = 'sp-team-products-' . $id;

if ( $title )
	echo '<h4 class="sp-table-caption">' . $title . '</h4>';

$gallery_style = $gallery_div = '';
if ( apply_filters( 'use_default_gallery_style', ! $html5 ) )
	$gallery_style = "
	<style type='text/css'>
		#{$selector} {
			margin: auto;
		}
		#{$selector} .gallery-item {
			float: {$float};
			margin-top: 10px;
			text-align: center;
			width: {$itemwidth}%;
		}
		#{$selector} img {
			border: 2px solid #cfcfcf;
		}
		#{$selector} .gallery-caption {
			margin-left: 0;
		}
		/* see gallery_shortcode() in wp-includes/media.php */
	</style>";
$size_class = sanitize_html_class( $size );
$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
echo apply_filters( 'gallery_style', $gallery_style . "\n\t\t" );

echo $gallery_div;

if ( intval( $number ) > 0 )
	$limit = $number;

$i = 0;

$gallery = '';

$args = array(
	'post_type' => 'product',
	'numberposts' => $number,
	'posts_per_page' => $number,
	'meta_query' => array(
		array(
			'key' => 'sp_team',
			'value' => $id,
		),
	),
);

$loop = new WP_Query( $args );

while ( $loop->have_posts() ) : $loop->the_post(); 
	if ( isset( $limit ) && $i >= $limit ) continue;

	global $product;

	$gallery.= "<{$itemtag} class='gallery-item'>";
	$gallery.= "
		<{$icontag} class='gallery-icon portrait'>"
			. '<a href="' . get_permalink() . '">' . woocommerce_get_product_thumbnail( $size ) . '</a>'
		. "</{$icontag}>";
	$gallery.= '<a href="' . get_permalink() . '"><' . $captiontag . ' class="wp-caption-text gallery-caption small-' . $columns . ' columns">' . get_the_title() . '</' . $captiontag . '></a>';
	$gallery.= "</{$itemtag}>";
endwhile;

wp_reset_query();

echo '<div class="sp-template sp-template-team-products sp-template-gallery">';

echo '<div class="sp-team-products-wrapper sp-gallery-wrapper">';

echo $gallery;

if ( ! $html5 && $columns > 0 && ++$i % $columns == 0 ) {
	echo '<br style="clear: both" />';
}

echo '</div>';

echo '</div>';

if ( ! $html5 && $columns > 0 && ++$i % $columns == 0 ) {
	echo '<br style="clear: both" />';
}
	
echo "</div>\n";
