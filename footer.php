<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package JHT
 * @subpackage JHT
 * @since JHT 1.0
 */

global $post;
$ppcopts = get_post_meta($post->ID,'jht_newppc_options', true);
$ppcoptsheadline = '';
if ( is_array( $ppcopts ) ) {
	if ( isset( $ppcopts['headline'] ) ) {
		$ppcoptsheadline = $ppcopts['headline'];
	}
}
if ( $ppcoptsheadline === '' ) {
	$ppcoptsheadline = '&nbsp;';
}
$menuopts = get_post_meta($post->ID,'jht_menuoption', true);
if ( !is_array( $menuopts ) ) {
	$menuopts = array();
}

wp_reset_query();

// IF not front page and not Backyard Designer -> CTA buttons at bottom
if ( !is_front_page() && !jht_is_backyard() && !jht_is_convpage() ) {
    get_sidebar('bottomBlocksCTA');
}
// ELSE IF backyard designer -> non-CTA bottom blocks
else if ( jht_is_backyard() ) {
    get_sidebar('bottomBlocks');
}
else {} ?>
        </div><!-- /wrap -->
    </div><!-- /bd -->

    <?php /* Top Navigation Items */ ?>
    <div class="hd">
        <div class="wrap">
            <a href="<?php echo jht_homeurl_tfix(); ?>" class="logo">Jacuzzi</a>
            <?php
            // top black navigation bar
						$showtop = true;
						if ( isset( $menuopts['top'] ) ) {
            	$showtop = ( $menuopts['top'] !== 'No' );
						}
						if ( $showtop ) {
              get_sidebar('topNav');
            }
            // main navigation flop menu
						$showmain = true;
						if ( isset( $menuopts['main'] ) ) {
            	$showmain = ( $menuopts['main'] !== 'No' );
						}
						if ( $showmain ) {
              get_sidebar('mainNav');
            } else {
                // top keyword header in place of menu
							print '<div id="ppc-headline">';
							echo $ppcoptsheadline;
							print '</div>';
            }
            ?>
        </div>
    </div>

    <?php /* Footer navigation / water mark / social icons */ ?>
    <?php
		$showfoot = true;
		if ( isset( $menuopts['foot'] ) ) {
			$showfoot = ( $menuopts['foot'] !== 'No' );
		}
		if ( $showfoot ) { ?>
    <div class="wrap">
        <div class="ft">
            <span class="icon watermark"></span>
            <?php jht_socialmenu(true);
            wp_nav_menu( array( 'container' => 'false', 'menu_class' => 'footerMenuTop', 'theme_location' => 'ftline1' ) );
            wp_nav_menu( array( 'container' => 'false', 'menu_class' => 'footerMenuBottom', 'theme_location' => 'ftline2' ) );
            wp_nav_menu( array( 'container' => 'false', 'menu_class' => 'footerMenuBottom', 'menu_id' => 'resourceMenu', 'theme_location' => 'ftres' ) );
            ?>
        </div>
    </div>
    <?php } ?>

    <?php /* Bottom black nav bar */ ?>
    <?php
		$showfbar = true;
		if ( isset( $menuopts['black'] ) ) {
			$showfbar = ( $menuopts['black'] !== 'No' );
		}
		if ( $showfbar ) { ?>
        <div id="fbar">
            <div class="inside">
                <a href="#" class="prar"></a>
                <?php dynamic_sidebar('fbar-promo'); ?>
                <div class="loc">
                    <form name="countryZipForm" method="post" action="<?php echo trailingslashit(get_bloginfo('url')) ?>dealer-locator/cities/">
                        <input type="hidden" value="1" name="zipcodeSearch" />
                        <input type="hidden" value="1" name="data[Dealer][country_id]" />
                        <a href="<?php bloginfo('url'); ?>/dealer-locator/">Locate a Dealer</a>
                        <input type="text" class="text zip" value="Zip" onfocus="if(jQuery(this).val() == 'Zip') jQuery(this).val('')" onblur="if(jQuery(this).val() == '') jQuery(this).val('Zip')" name="zip" />
                        <input type="image" value="submit" src="<?php bloginfo('template_url') ?>/images/icons/topsub.png" class="sub" />
                    </form>
                </div>
                <a href="<?php bloginfo('url'); ?>/hot-tubs/" class="bbtn">Explore Models</a>
                <a href="<?php echo get_permalink(3743) ?>" class="bbtn">Get a Quote</a>
                <a href="<?php echo get_permalink(3745) ?>" class="bbtn">Free Brochure</a>
                <?php jht_socialmenu(); ?>
                <div class="sites">
                    <a href="http://www.jacuzzi.com/" class="bbtn" target="_blank">Jacuzzi Websites</a>
                </div>
            </div>
        </div>
    <?php } ?>

    <script type="text/javascript">
      (function() {
        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
        po.src = 'https://apis.google.com/js/plusone.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
      })();
    </script>
    <?php

    /* Always have wp_footer() just before the closing </body>
     * tag of your theme, or you will break many plugins, which
     * generally use this hook to reference JavaScript files.
     */

    wp_footer();
?>

</body>
</html>
