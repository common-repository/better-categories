<?php
/*
	Plugin Name: Better Categories
	Version: 1.2
	Description: Packs the categories hierarchy on post edit page.
	Author: CMS Expert
	Author URI: https://profiles.wordpress.org/cmsexpert
	Plugin URI: 
*/

define( 'BC_OS', '1.1' );

if ( ! defined( 'WP_CONTENT_URL' ) )
      define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
if ( ! defined( 'WP_PLUGIN_URL' ) )
      define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );

function load_custom_wp_admin_style() {
        wp_register_style( 'bc_os_style', WP_PLUGIN_URL . '/better-categories/css/bc-os-style.css', false, BC_OS );
        wp_enqueue_style( 'bc_os_style' );
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );

// Print my js
function bc_os_print_scripts(){
	?>
	<script type='text/javascript'>
	jQuery(document).ready(function(){
		/* for post add/edit screen*/
		if(jQuery('.categorychecklist').length > 0){
			jQuery( '.categorychecklist > li' ).children( '.children' ).hide();

			jQuery( '.categorychecklist > li' ).each( function(){
				if(jQuery(this).children("ul").length) {
					/*console.log('here');*/
				} else {
					/*console.log('here2');*/
					jQuery( this ).css('margin-left', '21px');
				}
			});

			jQuery( '.categorychecklist > li ul li' ).each( function(){
				if(jQuery(this).children("ul").length) {
					/*console.log('here');*/
				} else {
					/*console.log('here2');*/
					jQuery( this ).css('margin-left', '21px');
				}
			});
			
			jQuery( '.categorychecklist > li' ).children( 'ul' ).each( function(){
				var id = jQuery(this).parent().attr('id');
				if ( jQuery( this ).hasClass('children') ){
					jQuery( this ).parent().prepend( '<a href="#" class="toggle-child-cats"><img src="<?php echo WP_PLUGIN_URL; ?>/better-categories/arrows.gif" height="8" /></span>' );
					jQuery( this ).parent().children( 'ul' ).css( 'padding-left', '0px').addClass(id);
				} else {
					jQuery( this ).parent().prepend( "<span style='width:1px;padding-left:16px;'></span>" );
					jQuery( this ).parent().css('margin-left', '16px');
				}
			});

			jQuery( '.categorychecklist > li ul li' ).children( 'ul' ).each( function(){
				var id = jQuery(this).parent().attr('id');
				if ( jQuery( this ).hasClass('children') ){
					jQuery( this ).parent().prepend( '<a href="#" class="toggle-child-cats"><img src="<?php echo WP_PLUGIN_URL; ?>/better-categories/arrows.gif" height="8" /></span>' );
					jQuery( this ).parent().children( 'ul' ).css( 'padding-left', '0px' ).addClass(id).toggle();
				} else {
					jQuery( this ).parent().prepend( "<span style='width:1px;padding-left:16px;'></span>" );
					jQuery( this ).parent().css('margin-left', '16px');
				}
			});
			
			jQuery( '.categorychecklist > li' ).find( '.toggle-child-cats' ).click( function() {
				var id = jQuery(this).parent().attr('id');
				jQuery( this ).parent().find( ".children."+id).toggle();
				return false;
			});
		}

		/* for post quick edit screen*/
		if(jQuery('.cat-checklist').length > 0){
			jQuery( '.cat-checklist > li' ).children( '.children' ).hide();

			jQuery( '.cat-checklist > li' ).each( function(){
				if(jQuery(this).children("ul").length) {
					/*console.log('here');*/
				} else {
					/*console.log('here2');*/
					jQuery( this ).css('margin-left', '21px');
				}
			});

			jQuery( '.cat-checklist > li ul li' ).each( function(){
				if(jQuery(this).children("ul").length) {
					/*console.log('here');*/
				} else {
					/*console.log('here2');*/
					jQuery( this ).css('margin-left', '21px');
				}
			});
			
			jQuery( '.cat-checklist > li' ).children( 'ul' ).each( function(){
				var id = jQuery(this).parent().attr('id');
				if ( jQuery( this ).hasClass('children') ){
					jQuery( this ).parent().prepend( '<a href="#" class="toggle-child-cats"><img src="<?php echo WP_PLUGIN_URL; ?>/better-categories/arrows.gif" height="8" /></span>' );
					jQuery( this ).parent().children( 'ul' ).css( 'padding-left', '0px').addClass(id);
				} else {
					jQuery( this ).parent().prepend( "<span style='width:1px;padding-left:16px;'></span>" );
					jQuery( this ).parent().css('margin-left', '16px');
				}
			});

			jQuery( '.cat-checklist > li ul li' ).children( 'ul' ).each( function(){
				var id = jQuery(this).parent().attr('id');
				if ( jQuery( this ).hasClass('children') ){
					jQuery( this ).parent().prepend( '<a href="#" class="toggle-child-cats"><img src="<?php echo WP_PLUGIN_URL; ?>/better-categories/arrows.gif" height="8" /></span>' );
					jQuery( this ).parent().children( 'ul' ).css( 'padding-left', '0px' ).addClass(id).toggle();
				} else {
					jQuery( this ).parent().prepend( "<span style='width:1px;padding-left:16px;'></span>" );
					jQuery( this ).parent().css('margin-left', '16px');
				}
			});
			
			jQuery( '.cat-checklist > li' ).find( '.toggle-child-cats' ).click( function() {
				var id = jQuery(this).parent().attr('id');
				jQuery( this ).parent().find( ".children."+id).toggle();
				return false;
			});
		}

		/* for payment box*/
		if(jQuery("#amount").length != 0){
			jQuery("#pay-form #amount").keyup(function(){
				jQuery("#xx").prop("disabled", false);
				var amount = jQuery(this).val();
				jQuery("#baseamt").val(amount);
			});
		}
	});
	</script>
	<?php
}

add_action( 'admin_print_footer_scripts', 'bc_os_print_scripts' );

function bc_os_admin_paybox_cookie(){
	/* set cookie if link clicked */
	if($_GET['removepay'] == "yes"){
		$cookie_name = "paybox";
		$cookie_value = "remove";
		setcookie($cookie_name, $cookie_value, time() + (86400 * 30 * 30));
	}
}
add_action( 'admin_init', 'bc_os_admin_paybox_cookie' ); 

function bc_os_admin_notice(){
	/* show payment box once in a month is cookie is set */
	if(empty($_COOKIE['paybox']) || $_COOKIE['paybox'] != "remove") {
	?>
	   	<div class="notice is-dismissible">
	   		<h3>Did you liked Better Categories? Please make a donation to help me improve the plugin.</h3>
	   		<p>Enter amount below and click on Make a Donation</p>
	        <form id="pay-form" action="https://www.paypal.com/cgi-bin/webscr" method="post" onsubmit="this.target = 'paypal'; return ReadForm (this);">
				<input type="hidden" name="cmd" value="_xclick" />
				<input type="hidden" name="add" value="1" />
				<input type="hidden" name="business" value="info@timata.org" />
				<input type="hidden" name="item_name" id="item-name" value="Better Categories Donation" />
				<span id="dollar">$</span> <input type="text" name="amount" id="amount" value="" />
				<input type="hidden" name="currency_code" value="USD" />
				<input type="hidden" name="baseamt" id="baseamt" value="" />
				<input type="hidden" name="basedes" value="Better Categories Donation" />
				<input type="hidden" name="return" value="">
				<input disabled="disabled" type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but21.gif" id="xx" value="Make Payment" border="0" name="submit" class="pay-button" alt="PayPal - The safer, easier way to pay online!">
				<img alt="" border="0" src="https://www.paypalobjects.com/WEBSCR-640-20110306-1/en_US/i/scr/pixel.gif" width="1" height="1">
			</form>
			<a class="remove-pay-notice" href="?removepay=yes">Click to remove this box completely.</a>
	    </div>
   	<?php
	}
}
add_action('admin_notices', 'bc_os_admin_notice');
?>