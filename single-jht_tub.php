<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package JHT
 * @subpackage JHT
 * @since JHT 1.0
 */
get_header();
while ( have_posts() ) : the_post();

global $post;
/*
$custom = get_post_meta($post->ID,'jht_quickinfo');
$jht_tub_quickinfo = $custom[0];
echo '<pre style="display:none" title="quickinfo">'. print_r($jht_tub_quickinfo,true) .'</pre>';
*/
$custom = get_post_meta($post->ID,'jht_info');
$jht_info = $custom[0];
$custom = get_post_meta($post->ID,'jht_colors');
$jht_colors = $custom[0];
// array(66,68,70...) -> so process it
$o = array();

$args = array( 'numberposts' => -1, 'post_type'=>'jht_color', 'include' => $jht_colors, 'orderby' => 'menu_order', 'order' => 'ASC' );
$thesecolors = get_posts($args);

foreach ( $thesecolors as $c ) {
	$o[$c->ID] = $c->post_title;
}

$jht_colors = $o;

$custom = get_post_meta($post->ID,'jht_cabs');
$jht_cabs = $custom[0];
// array(66,68,70...) -> so process it
$o = array();

$args = array( 'numberposts' => -1, 'post_type'=>'jht_cabinetry', 'include' => $jht_cabs, 'orderby' => 'menu_order', 'order' => 'ASC' );
$thesecolors = get_posts($args);

foreach ( $thesecolors as $c ) {
	$o[$c->ID] = $c->post_title;
}
$jht_cabs = $o;

$custom = get_post_meta($post->ID,'jht_specs');
$jht_specs = $custom[0];
$custom = get_post_meta($post->ID,'jht_feats');
$jht_feats = $custom[0];
$custom = get_post_meta($post->ID,'jht_wars');
$jht_wars = $custom[0];
if ( $jht_wars == '' ) $jht_wars = array();
if ( count($jht_wars) > 0 ) {
	$args = array( 'numberposts' => -1, 'post_type'=>'jht_warranty', 'include' => $jht_wars, 'orderby' => 'menu_order', 'order' => 'ASC' );
	$jht_wars = get_posts($args);
}
$custom = get_post_meta($post->ID,'jht_jets');
$jht_jets = $custom[0];
$jetcount = 0;
foreach ( $jht_jets as $v ) $jetcount += $v;

// transient for jht_alljets
if ( false === ( $special_query_results = get_transient( 'jht_alljets' ) ) ) {
	// It wasn't there, so regenerate the data and save the transient
	$special_query_results = get_posts(array('numberposts'=>-1,'post_type'=>'jht_jet','orderby'=>'menu_order','order'=>'ASC'));
	set_transient( 'jht_alljets', $special_query_results, 60*60*12 );
}
// Use the data like you would have normally...
$alljets = get_transient( 'jht_alljets' );
?>
<div class="hero"<?php
if (class_exists('MultiPostThumbnails')) {
	$img_id = MultiPostThumbnails::get_post_thumbnail_id('jht_tub', 'background-image', $post->ID);
	if ( $img_id ) {
		$img = get_post($img_id);
		echo ' style="background: #000 url('. $img->guid .') 50% 0 no-repeat"';
	}
}
?>>
    	<div class="wrap">
            <div class="inner"<?php
			if (class_exists('MultiPostThumbnails')) {
				$img_id = MultiPostThumbnails::get_post_thumbnail_id('jht_tub', 'overhead-large', $post->ID);
				if ( $img_id ) {
					$imgsrc = wp_get_attachment_image_src($img_id, 'overhead');
					echo ' style="background: url('. $imgsrc[0] .') 0 65% no-repeat"';
				}
			}
?>>
                <h1><?php the_title(); ?></h1>
                <h2><?php esc_attr_e($jht_info['topheadline']); ?></h2>
            </div>
        </div>
    </div>
    <div class="goldBar8">
        <div class="the-tab-buttons">
            <a id="pricing-tab-link" href="<?php bloginfo('url'); ?>/get-a-quote/"><b>Get</b> Pricing</a>
            <a id="brochure-tab-link" href="<?php bloginfo('url'); ?>/request-brochure/"><b>Free</b> Brochure</a>
        </div>
    </div>
    <div class="bd">
    	<div class="wrap">
            <div class="twoCol">
                <div class="side">
                	<div class="specifications">
                    	<h4>Specifications</h4>
                        <p><strong>Seats:</strong> <?php esc_attr_e($jht_specs['seats']); ?></p>
                        <p><strong>PowerPro Jets:</strong> <?php echo absint($jetcount); ?></p>
                        <p><strong>Dimensions:</strong> <?php esc_attr_e($jht_specs['dim_us']); ?></p>
                        <p><strong>Spa Volume:</strong> <?php esc_attr_e($jht_specs['vol_us']); ?></p>
                    </div>
                    <div class="energy">
                    	<h2 class="green"><strong>Energy Efficiency</strong><span class="icon e"></span></h2>
                        <table cellpadding="0">
                        	<tr>
                            	<td><p><strong>Monthly Cost<br /> 60&deg;F / 15&deg;C:</strong></p></td>
                                <td><p class="green">$<?php esc_attr_e($jht_specs['emoc']); ?></p></td>
                            </tr>
                        </table>
                    </div>
                	<div class="tub-brochure-pricing">
                        <div class="">
                            <a class="gold-button-208" href="<?php bloginfo('url'); ?>/get-a-quote/"><span class="the-content">Get Pricing<span>></span></span></a>
                        </div>
                        <p><i>Take a minute &amp; get a free quote</i><br />&nbsp;</p>
                    </div>
                    <?php
					get_sidebar('freeBrochure');
					//get_sidebar('requestQuote');
                    //get_sidebar('tradeIn');
					?>
                    <div class="share">
                        <div class="share-bar">
                            <?php if(function_exists('sharethis_button')) sharethis_button(); ?>
                        </div>
                    </div>
                </div>
                <div class="main">
					<?php the_content();
					if (class_exists('MultiPostThumbnails')) {
						MultiPostThumbnails::the_post_thumbnail('jht_tub', 'three-quarter', $post->ID, 'three-quarter', array('class'=>'threequarters'));
					}
					?>
                    <div class="options">
                        <h3>Color Options</h3>
                        <ul>
                            <?php foreach ( $jht_colors as $i => $t ) {
                                echo '<li class="has-img-tooltip"><a title="'. $t .'">'. get_the_post_thumbnail( $i, 'options-small-thumbs') . '</a>';
                                echo '<div class="tooltip-img" style="display:none;"><div>' . get_the_post_thumbnail($i) . '<p style="padding-top: 6px;">' . $t . '</p></div></div>';
                                echo '</li>';
                            } ?>
                        </ul>
                        <h3>Cabinetry Options</h3>
                        <ul>
                            <?php foreach ( $jht_cabs as $i => $t ) {
                                echo '<li class="has-img-tooltip"><a title="'. $t .'">'. get_the_post_thumbnail( $i, 'options-small-thumbs') . '</a>';
                                echo '<div class="tooltip-img" style="display:none;"><div>' . get_the_post_thumbnail($i) . '<p style="padding-top: 6px;">' . $t . '</p></div></div>';
                                echo '</li>';
                            } ?>
                        </ul>
                    </div>
                    <?php /*
					// not right now
                    <div class="buy-now">
                    	<h3>Call to Order: 844.411.5228 <!--span class="icon close"></span--></h3>
                        <p class="inner">
                        	<a href="#" class="btn gold">Request a Quote</a><a class="btn black" href="#">Buy</a>
                        </p>
                    </div>
					*/ ?>
                </div>
            </div>
            
            <div class="container">
                <ul class="tabs" id="tubtabs"><li class="current"><a href="#features-options">Features &amp; Options</a></li><li><a href="#jets">Jets</a></li><li><a href="#specs">Specifications</a></li><li><a href="#warranty">Warranty</a></li></ul>
                	<div class="twoCol">
                    	<div class="main">
                    	
                        <div id="features-options">
                        	<h2 class="tabtitle">Features &amp; Options</h2>
                            <p><?php esc_attr_e($jht_info['featureblurb']); ?></p>
                            <div class="features">
                            	<?php
								foreach ( $jht_feats as $fid ) {
									$feat = get_post($fid);
									?>
                                <div class="feature withimage">
                                	<?php echo get_the_post_thumbnail($fid, 'feature-option'); ?>
                                    <h2><?php esc_attr_e($feat->post_title); ?></h2>
                                    <?php echo apply_filters('the_content', $feat->post_content); ?>
                                </div>
								<?php } ?>
                            </div>
                            <?php /*
                            
                            <div class="gallery">
                            	<h1>Gallery &amp; Videos</h1>
                                <div class="gallery-wrap">
                                	<span class="icon prev"></span><span class="icon next"></span>
                                	<div class="main-image"></div>
                                    <ul class="image-list"><li><img src="<?php bloginfo('template_url'); ?>/images/hot-tub-details/gallery/thumb1.jpg" /></li><li><img src="<?php bloginfo('template_url'); ?>/images/hot-tub-details/gallery/thumb2.jpg" /></li><li><img src="<?php bloginfo('template_url'); ?>/images/hot-tub-details/gallery/thumb3.jpg" /></li><li><img src="<?php bloginfo('template_url'); ?>/images/hot-tub-details/gallery/thumb4.jpg" /></li><li><img src="<?php bloginfo('template_url'); ?>/images/hot-tub-details/gallery/thumb5.jpg" /></li><li><img src="<?php bloginfo('template_url'); ?>/images/hot-tub-details/gallery/thumb6.jpg" /></li></ul>
                                </div>
                            </div>
							*/ ?>
                        </div>
                            
                        <div id="jets" style="display:none">
                            <?php /*<div class="pro-power-jets">
                                <h1>New ProPower jets</h1>
                                <h2>with advanced power and capabilities</h2>
                            </div> */?>
                            <div class="half">
                                <div class="description">
                                	<div class="inner">
                                        <h2>Get more jet satisfaction</h2>
                                        <p>High-volume, low-pressure pumps support the exclusive PowerPro jet system in delivering a bold hydromassage. A Patented process creates a 50/50 air-to-water mixture that introduces air from all around the jets for a soothing, yet effective, professional-quality massage. To test the jets in a hot tub, contact your local dealer.</p>
                                    	<!--div class="arrow-right"><a href="#">Roll Over Plus Signs for more Jet Info</a></div-->
                                    </div>
                                </div>
                                <div class="rollover">
                                <?php /*
                                    <div class="arrow arrow1"></div>
                                    <div class="arrow arrow1"></div>
                                    <div class="arrow arrow1"></div>
                                    <div class="arrow arrow1"></div>
                                    <div class="arrow arrow1"></div>
                                    <?php
									*/
                                    if (class_exists('MultiPostThumbnails')) {
                                    	MultiPostThumbnails::the_post_thumbnail('jht_tub', 'overhead-large', $post->ID, 'overhead');
                                    }
								?>
                                </div>
                            </div>
                            <div class="jet-details">
                            <?php
							$i = 0;
							foreach( $jht_jets as $j => $c ) {
								if ( absint($c) > 0 ) { ?>
                                <div class="jet-detail">
                                    <?php echo get_the_post_thumbnail( $j, 'jet', array('class'=>'alignleft')); ?>
                                    <h2><?php esc_attr_e($alljets[$i]->post_title); ?> Jets <span class="count">(<?php echo absint($c); ?>)</span></h2>
                                    <?php echo apply_filters('the_content', $alljets[$i]->post_content); ?>
                                    <br class="clear" />
                                </div>
                                <?php
								}
								$i++;
							}?>
                            </div>
                        </div>
                            
                        <div id="specs" class="specifications" style="display:none">
                        	<h3>Overview</h3>
                            <table cellspacing="0">
                            	<tr class="line1">
                                	<td>Seating Capacity</td>
                                    <td><?php esc_attr_e($jht_specs['seats']); ?></td>
                                </tr>
                                <tr>
                                	<td>Dimensions</td>
                                    <td><?php echo esc_attr($jht_specs['dim_us']) .(($jht_specs['dim_us'] . $jht_specs['dim_int']) != '' ? ' / ' : ''). esc_attr($jht_specs['dim_int']); ?></td>
                                </tr>
                                <tr>
                                	<td>Average Spa Volume</td>
                                    <td><?php echo esc_attr($jht_specs['vol_us']) .(($jht_specs['vol_us'] . $jht_specs['vol_int']) != '' ? ' / ' : ''). esc_attr($jht_specs['vol_int']); ?></td>
                                </tr>
                                <tr>
                                	<td>Dry Weight</td>
                                    <td><?php esc_attr_e($jht_specs['dry_weight']); ?></td>
                                </tr>
                                <tr>
                                	<td>Total Filled Weight</td>
                                    <td><?php esc_attr_e($jht_specs['filled']); ?></td>
                                </tr>
                                <?php
								for ( $i = 1; $i < 4; $i++ ) {
								if ( isset($jht_specs['pump'.$i]) ) if ( $jht_specs['pump'. $i] != '' ) { ?>
                                <tr>
                                	<td>Pump <?php echo $i ?></td>
                                    <td><?php echo nl2br(esc_attr($jht_specs['pump'. $i])); ?></td>
                                </tr>
                                <?php
								}
								}
								?>
                                <tr>
                                	<td>Circulation Pump</td>
                                    <td><?php esc_attr_e($jht_specs['circulation']); ?></td>
                                </tr>
                                <tr>
                                	<td>Diverter Valves</td>
                                    <td><?php echo absint($jht_specs['diverter']); ?></td>
                                </tr>
                                <?php
								if ( !isset($jht_specs['wps']) ) $jht_specs['wps'] = 'CLEAR<strong>RAY</strong>&trade;'; // hax
								if ( isset($jht_specs['wps']) ) if ( $jht_specs['wps'] != '' ) { ?>
                                <tr>
                                	<td>Water Purification System</td>
                                    <td><?php echo $jht_specs['wps']; ?></td>
                                </tr>
                                <?php } ?>
                                <?php if ( isset($jht_specs['filtration']) ) if ( $jht_specs['filtration'] != '' ) { ?>
                                <tr>
                                	<td>Filtration</td>
                                    <td><?php esc_attr_e($jht_specs['filtration']); ?></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                	<td>Filters</td>
                                    <td><?php echo nl2br(esc_attr($jht_specs['filters'])); ?></td>
                                </tr>
                                <tr>
                                	<td>Electrical North America</td>
                                    <td><?php esc_attr_e($jht_specs['elec_na']); ?></td>
                                </tr>
                                <tr>
                                	<td>Electrical International</td>
                                    <td><?php esc_attr_e($jht_specs['elec_int']); ?></td>
                                </tr>
                            </table>
                        	<h3>Colors &amp; Cabinetry</h3>
                            <table cellspacing="0">
                                <tr class="line1">
                                	<td>Cabinetry</td>
                                    <td><?php echo implode(', ', $jht_cabs); ?></td>
                                </tr>
                                <tr>
                                	<td>Shell Colors**</td>
                                    <td><?php echo implode(', ', $jht_colors); ?></td>
                                </tr>
                            </table>
                            <h3>Jets</h3>
                            <table cellspacing="0">
                            	<tr class="line1">
                                	<td>Total Jets</td>
                                    <td><?php echo absint($jetcount); ?></td>
                                </tr>
                                <?php
								$i = 0;
								foreach ( $jht_jets as $j => $c ) {
									$c = absint($c);
									if ( $c > 0 ) {
									?>
                            	<tr>
                                	<td><?php esc_attr_e($alljets[$i]->post_title); ?></td>
                                    <td><?php echo $c; ?></td>
                                </tr><?php
									}
									$i++;
								}
								?>
                            </table>
                            <p class="note"><small><strong>NOTE:</strong> Spa Volume is based on average fill.<br /><br />
                                Jacuzzi Hot Tubs may make product modifications and enhancements. Specifications may change without notice. International products may be configured differently to meet local electrical requirements. Dimensions are approximate. Spa volume is based on average fill. Manufactured under one or more United States patent numbers. Other patents may apply.<br /><br />
                                Estimated monthly cost is based on CEC test protocol for standby power consumption only. Test results measured in a controlled environment based on a kilowatt rate per hour of $0.10. Local and future energy rates, local conditions and individual use will alter these estimated monthly costs.For complete CEC test protocol and results visit http://www.energy.ca.gov<br /><br />
                                * Pump input or brake horsepower (bhp) is the actual horsepower delivered to the pump shaft. Source: ITT Goulds Pumps, Centrifugal Pump Fundamentals.<br />
                                ** Selection may vary by dealer</small></p>
                        </div>
                		<div id="warranty" style="display:none">
                        	<h2 class="tabtitle">Available Warranties</h2>
                            <h2>Warranty Info: <?php the_title(); ?></h2>
                            <div class="warranties">
                            	<?php foreach ( $jht_wars as $p ) { ?>
                            	<div class="warranty">
                                	<p><?php echo get_the_post_thumbnail($p->ID, 'warranty', array('class'=>'alignleft')); ?><?php echo esc_attr($p->post_title) .' - '. esc_attr($p->post_content); ?></p>
                                </div>
                                <?php } ?>
                            </div>
                            <p class="note">For complete warranty information, please visit our <a href="<?php echo get_permalink(4169) ?>">warranty page</a></p>
                        </div>
                                                
                    </div>
                    <div class="side">
                        <h2>Acrylic Shell Colors</h2>
                        <p>The Jacuzzi TriFusion&trade; System produces a durable acrylic spa shell that is eight times stronger than conventional fiberglass shells and rich in color and texture.</p>
                            <div class="options">
                                <ul class="colors">
                                	<?php
									foreach ( $jht_colors as $i => $t ) {
										echo '<li><span>'. get_the_post_thumbnail( $i, 'right-thumbs') .'</span>';
										echo $t;
										echo '</li>';
									}
									?>
                                </ul>
                                <h2>Cabinetry</h2>
                                <p>Our cabinetry is durable and UV-resistant.</p>
                                <ul class="cabinetry">
                                	<?php
									foreach ( $jht_cabs as $i => $t ) {
										echo '<li><span>'. get_the_post_thumbnail( $i, 'right-thumbs') .'</span>';
										echo $t;
										echo '</li>';
									}
									?>
                                </ul>
                        </div>
                        <div class="scall bro"><a href="<?php echo get_permalink(3745); ?>"><strong>Free</strong> Brochure</a></div>
                        <div class="scall quo"><a href="<?php echo get_permalink(3743); ?>"><strong>Request</strong> a Quote</a></div>
                        <div class="scall quo"><a href="<?php echo get_permalink(7759); ?>"><strong>Trade-In</strong> Value</a></div>
                        <?php /*
                        <div class="request-appointment">
                            <h2><a href="<?php echo get_permalink(4414); ?>"><strong>Request Appointment</strong><br />Call Today: 877.411.5228</a></h2>
                        </div>
						*/ ?>
                    </div>
                </div>
                <h3 class="to-top"><a href="#top"><span class="icon upArrow"></span>Back to Top</a></h3>
            </div><br /><br />
            <?php /* not yet...
            <div class="container similar">
            	<h1 class="title">Other Similar Hot Tubs</h1>
                <div class="slider">
                	<span class="icon prev"></span><span class="icon next"></span>
                    <ul class="grid3"><li class="cell j495">
                    		<div class="inner">
                                <h1>J-495</h1>
                                <p>Seats: 7-8 Adults</p>
                                <p>Jets: 48</p>
                                <p><a href="#">View Full Details</a></p>
                            </div>
                        </li><li class="cell j470">
                        	<div class="inner">
                                <h1>J-470</h1>
                                <p>Seats: 6-7 Adults</p>
                                <p>Jets: 39</p>
                                <p><a href="#">View Full Details</a></p>
                            </div>
                        </li><li class="cell j365">
                        	<div class="inner">
                                <h1>J-365</h1>
                                <p>Seats: 6-7 Adults</p>
                                <p>Jets: 32</p>
                                <p><a href="#">View Full Details</a></p>
                            </div>
                        </li><li class="cell j280">
                        	<div class="inner">
                                <h1>J-280</h1>
                                <p>Seats: 6-7 Adults</p>
                                <p>Jets: 48</p>
                                <p><a href="#">View Full Details</a></p>
                            </div>
                        </li><li class="cell j280">
                        	<div class="inner">
                                <h1>J-280</h1>
                                <p>Seats: 6-7 Adults</p>
                                <p>Jets: 48</p>
                                <p><a href="#">View Full Details</a></p>
                            </div>
                        </li><li class="cell j280">
                        	<div class="inner">
                                <h1>J-280</h1>
                                <p>Seats: 6-7 Adults</p>
                                <p>Jets: 48</p>
                                <p><a href="#">View Full Details</a></p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
<?php
*/
endwhile;
get_footer(); ?>
