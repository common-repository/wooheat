<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class WooHeat {


	function __construct() {
		add_action( 'woocommerce_product_options_general_product_data', array($this, 'wc_woo_heat_field'));
		add_action( 'save_post',array($this, 'woo_heat_save_product'));
		add_filter( 'woocommerce_get_catalog_ordering_args', array($this, 'woo_heat_add_postmeta_ordering_args'));
		add_filter( 'woocommerce_default_catalog_orderby_options', array($this, 'woo_heat_add_new_postmeta_orderby'));
		add_filter( 'woocommerce_catalog_orderby', array($this, 'woo_heat_add_new_postmeta_orderby'));
		add_shortcode( 'wooheat', array($this, 'woo_heat_shortcodes'));
	}


	function wc_woo_heat_field() {

		for ($i=1; $i <= 15; $i++) { 
			$options[$i] = __( $i, 'woocommerce' );
		}

		woocommerce_wp_select(
			array( 
				'id'          => 'woo_heat', 
				'label'       => __( 'Heat Rating', 'woocommerce' ), 
				'description' => __( 'Choose a Rating.', 'woocommerce' ),
				'options' => $options
				)
			);

		woocommerce_wp_text_input(
			array(
				'id'			=> 'woo_heat_scoville',
				'label'			=> __( 'Scoville Rating', 'woocommerce'),
				'description'	=> __('Scoville Heat Units, eg 1000000', 'woocommerce')
				)
			);
	}


	function woo_heat_shortcodes( $atts ) {

		global $product;

		if(isset($product) && is_product() && isset($atts[0])) {

			switch($atts[0]) {

				case 'rating':
					return get_post_meta($product->get_id(), 'woo_heat', true );
					break;

				case 'scoville':
					return get_post_meta($product->get_id(), 'woo_heat_scoville', true );
					break;
			}

		}

	}


	function woo_heat_save_product( $product_id ) {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;

		if ( isset( $_POST['woo_heat'] ) ) {
			if ( is_numeric( $_POST['woo_heat'] ) )
				update_post_meta( $product_id, 'woo_heat', $_POST['woo_heat'] );
			else
				update_post_meta( $product_id, 'woo_heat', 1 );
		} else update_post_meta( $product_id, 'woo_heat', 1 );

		if ( isset( $_POST['woo_heat_scoville'] ) ) {
			if ( is_numeric( $_POST['woo_heat_scoville'] ) )
				update_post_meta( $product_id, 'woo_heat_scoville', $_POST['woo_heat_scoville'] );
			else
				update_post_meta( $product_id, 'woo_heat_scoville', 0 );
		} else update_post_meta( $product_id, 'woo_heat_scoville', 0 );
	}


	function woo_heat_add_postmeta_ordering_args( $sort_args ) {
			
		$orderby_value = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );

		$orderby_meta = get_option('woo_heat_orderby', 'woo_heat');
		if(!in_array($orderby_meta, array('woo_heat', 'woo_heat_scoville'))) {
			$orderby_meta = 'woo_heat';
		}
		
		switch( $orderby_value ) {		
			case 'woo_heat_low':
				$sort_args['orderby']  = 'meta_value';
				$sort_args['order']    = 'asc';
				$sort_args['meta_key'] = $orderby_meta;
				break;
			case 'woo_heat_high':
				$sort_args['orderby']  = 'meta_value';
				$sort_args['order']    = 'dsc';
				$sort_args['meta_key'] = $orderby_meta;
				break;
		}
		
		return $sort_args;
	}


	function woo_heat_add_new_postmeta_orderby( $sortby ) {
		
		$sortby['woo_heat_high'] = __( 'Sort by heat: hot to mild', 'woocommerce' );
		$sortby['woo_heat_low'] = __( 'Sort by heat: mild to hot', 'woocommerce' );
	    
		return $sortby;
	}

}

?>