<?php
/*
Plugin Name: Hotel Special Offer Widget
Description: Show block with hotel special offer for user
Version: 0.1
Author: Yury Dyumkin
License: GPL2

	Copyright 2017 Yury Dyumkin

	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License,
	version 2, as published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
*/

/**
 * Register widget on init
 */
function register_hotel_special_offer_widget() {
	register_widget( 'Hotel_Special_Offer_Widget' );
}

add_action( 'widgets_init', 'register_hotel_special_offer_widget' );

/**
 * Class Hotel_Special_Offer_Widget
 */
class Hotel_Special_Offer_Widget extends WP_Widget {

	protected $slug = 'hotel-special-offer';

	public function __construct() {
		$widgetOptions  = array( 'classname' => $this->slug, 'description' => __( 'Showcase a hotel special offer', $this->slug ) );

		parent::__construct( 'hotel_special_offer', __( 'Hotel Special Offer', $this->slug ), $widgetOptions);

		$this->registerAssets();
		$this->registerAjaxCallback();
	}

	/**
	 * Register widget-specific files
	 */
	private function registerAssets() {
		// Register admin styles and scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'registerAdminScripts' ) );

		// Register site styles and scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'registerWidgetStyles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'registerWidgetScripts' ) );
	}

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */
	public function registerAdminScripts() {
		wp_enqueue_media();
		wp_enqueue_script( $this->slug.'-admin-script', plugins_url(
			'assets/js/admin.js', __FILE__ ), array('jquery') );
	}

	/**
	 * Registers and enqueues widget-specific styles.
	 */
	public function registerWidgetStyles() {
		wp_enqueue_style( $this->slug . '-widget-styles', plugins_url( 'assets/css/widget.css', __FILE__ ) );
	}

	/**
	 * Registers and enqueues widget-specific scripts.
	 */
	public function registerWidgetScripts() {
		wp_enqueue_script( $this->slug . '-class', plugins_url( 'assets/js/offer.js', __FILE__ ), array( 'jquery' ) );
		wp_enqueue_script( $this->slug . '-script', plugins_url( 'assets/js/widget.js', __FILE__ ),	array( 'jquery', $this->slug . '-class' ) );
		wp_localize_script( $this->slug . '-class', 'offer_config', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	}

	/**
	 * Registers AJAX support
	 */
	private function registerAjaxCallback() {
		add_action( 'wp_ajax_offer_get_data', array( $this, 'getOffer' ) );
		add_action( 'wp_ajax_nopriv_offer_get_data', array( $this, 'getOffer' ) );
	}

	/**
	 * AJAX response
	 */
	public function getOffer() {
		$number = filter_input( INPUT_GET, 'number', FILTER_VALIDATE_INT );

		if ( ! $number ) {
			$this->errorResponse();
		}

		$offers = get_option( $this->option_name );

		if ( ! $offers[ $number ] ) {
			$this->errorResponse();
		}

		echo json_encode( $this->prepareOffer( $offers[ $number ] ) );

		wp_die();
	}

	/**
	 * Set Bad Request status and die
	 */
	private function errorResponse() {
		status_header( 400 );
		wp_send_json_error();
	}


	/**
	 * Preparation of the offer data before sending
	 *
	 * @param array $offer
	 * @return array
	 */
	private function prepareOffer(array $offer) {

		$arrival = DateTime::createFromFormat('Y-m-d', $offer['arrival_date']);
		$departure = DateTime::createFromFormat('Y-m-d', $offer['departure_date']);

		$offer['arrival_month'] = __($arrival->format('F'));
		$offer['arrival_day'] = $arrival->format('d');
		$offer['departure_month'] = __($departure->format('F'));
		$offer['departure_day'] = $departure->format('d');

		$offer['cost_rate'] = '$' . $offer['cost'] . __(' usd/night') . ' | ' . $offer['rate_name'] . __(' rate');

		return $offer;
	}

	/**
	 * @inheritdoc
	 */
	public function form($instance) {

		// Define default values for variables.
		$instance = wp_parse_args( (array) $instance, $this->getDefaultFormFields() );

		include( plugin_dir_path( __FILE__ ) . 'views/form.php' );
	}

	/**
	 * Render an array of default values for admin form.
	 *
	 * @return array default values
	 */
	private function getDefaultFormFields() {
		$defaults = array(
			'image_url' => '',
			'image_alt' => '',
			'hotel_name' => '',
			'room_name' => '',
			'rate_name' => '',
			'cost' => 0,
			'arrival_date' => '',
			'departure_date' => '',
		);

		return apply_filters( 'hotel_so_option_defaults', $defaults );
	}

	/**
	 * @inheritdoc
	 */
	public function update( $newInstance, $oldInstance ) {
		$instance = $oldInstance;

		$instance['image_url']      = strip_tags( $newInstance['image_url'] );
		$instance['image_alt']      = strip_tags( $newInstance['image_alt'] );
		$instance['hotel_name']     = strip_tags( $newInstance['hotel_name'] );
		$instance['room_name']      = strip_tags( $newInstance['room_name'] );
		$instance['rate_name']      = strip_tags( $newInstance['rate_name'] );
		$instance['cost']           = (float) $newInstance['cost'];
		$instance['arrival_date']   = $newInstance['arrival_date'];
		$instance['departure_date'] = $newInstance['departure_date'];

		return $instance;
	}

	/**
	 * @inheritdoc
	 */
	public function widget( $args, $instance ) {
		include( plugin_dir_path( __FILE__ ) . 'views/widget.php' );
	}

	/**
	 * @param $instance
	 * @return bool
	 */
	private function hasImage($instance) {
		return !empty($instance['image_url']);
	}
}