<?php
/**
* Download Brochure form in a Sidebar
*
* @package JacuzziDirect
* @since JacuzziDirect 1.0
*/
$custom = get_post_meta($post->ID,'_progo');
$direct = $custom[0];

?>

<form action="http://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" method="post" id="leadForm" class="pform quo">

    <?php avala_hidden_fields( 19, 9, 12 ); ?>

    <h3 id="rh"><?php echo nl2br(esc_html($direct[rightheadline])); ?></h3>
    <span class="errors" style="display:none"><?php
        if(count($errors) > 0) {
        foreach( $errors as $err ) {
        echo "$err<br />";
        }
        }
        ?>
    </span>
    <table width="276">
        <tr>
            <td width="144">
                <?php avala_field('first_name', 'txt', true, NULL, array( 'size' => 14) ); ?>
            </td>
            <td width="132" colspan="2">
                <?php avala_field('last_name', 'txt', true, NULL, array( 'size' => 15) ); ?>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <?php avala_field('address', 'txt full', false, NULL, array( 'size' => 30) ); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php avala_field('city', 'txt', false, NULL, array( 'size' => 20) ); ?>
            </td>
            <td width="66">
                <?php avala_field('state', 'brochure state', true, NULL, array( 'style' => 'width:52px') ); ?>
            </td>
            <td width="66">
                <?php avala_field('postal_code', 'txt zip', true, NULL, array( 'size' => 7) ); ?>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <?php avala_field('country', 'country', false, NULL, array( 'style' => 'width:273px') ); ?>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <?php avala_field('phone', 'txt full', true, NULL, array('size' => 12)); ?>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <?php avala_field('email', 'txt full email', true, NULL, array('size' => 20)); ?>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <em>* Indicates required fields.</em><br />
                <em>We will never share your information with anyone.</em>
                <input type="submit" value="<?php esc_attr_e($direct['button']); ?>" class="sbtn" />
            </td>
        </tr>
    </table>
</form>

<script type="text/javascript"> if (!window.mstag) mstag = {loadTag : function(){},time : (new Date()).getTime()};</script> <script id="mstag_tops" type="text/javascript" src="//flex.atdmt.com/mstag/site/2007fee5-1f40-4bc4-b858-08ac4cb4c99b/mstag.js"></script> <script type="text/javascript"> mstag.loadTag("analytics", {dedup:"1",domainId:"1183768",type:"1",revenue:"250",actionid:"28615"})</script> <noscript> <iframe src="//flex.atdmt.com/mstag/tag/2007fee5-1f40-4bc4-b858-08ac4cb4c99b/analytics.html?dedup=1&domainId=1183768&type=1&revenue=250&actionid=28615" frameborder="0" scrolling="no" width="1" height="1" style="visibility:hidden;display:none"> </iframe> </noscript>
