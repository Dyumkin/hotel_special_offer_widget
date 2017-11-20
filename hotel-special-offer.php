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
		$actualOffer = wp_parse_args( $offer, self::getDefaultFormFields() );

		$actualOffer['image_url']      = apply_filters( 'hotel_so_image_url', esc_url( $offer['image_url'] ), $offer );
		$actualOffer['image_alt']      = apply_filters( 'hotel_so_image_alt', esc_attr( $offer['image_alt'] ), $offer );
		$actualOffer['hotel_name']     = apply_filters( 'hotel_so_hotel_name', $offer['hotel_name'], $offer );
		$actualOffer['room_name']      = apply_filters( 'hotel_so_room_name', $offer['room_name'], $offer );
		$actualOffer['rate_name']      = apply_filters( 'hotel_so_rate_name', $offer['rate_name'], $offer );
		$actualOffer['cost']           = apply_filters( 'hotel_so_cost', $offer['cost'], $offer );
		$actualOffer['arrival_date']   = apply_filters( 'hotel_so_arrival_date', $offer['arrival_date'], $offer );
		$actualOffer['departure_date'] = apply_filters( 'hotel_so_departure_date', $offer['departure_date'], $offer );

		$arrival = DateTime::createFromFormat('Y-m-d', $actualOffer['arrival_date']);
		$departure = DateTime::createFromFormat('Y-m-d', $actualOffer['departure_date']);

		$actualOffer['arrival_month'] = __($arrival->format('F'));
		$actualOffer['arrival_day'] = $arrival->format('d');
		$actualOffer['departure_month'] = __($departure->format('F'));
		$actualOffer['departure_day'] = $departure->format('d');

		$actualOffer['cost_rate'] = '$' . $actualOffer['cost'] . __(' usd/night') . ' | ' . $actualOffer['rate_name'] . __(' rate');

		return $actualOffer;
	}

	/**
	 * @inheritdoc
	 */
	public function form( $instance ) {

		// Define default values for variables.
		$instance = wp_parse_args( (array) $instance, $this->getDefaultFormFields() );

		include( $this->getTemplateHierarchy( 'form' ) );
	}

	/**
	 * Render an array of default values for admin form.
	 *
	 * @return array default values
	 */
	private static function getDefaultFormFields() {
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
		include( $this->getTemplateHierarchy( 'widget' ) );
	}

	/**
	 * Loads theme files in appropriate hierarchy: 1) child theme,
	 * 2) parent template, 3) plugin resources. will look in the hotel-special-offer widget/
	 * directory in a theme and the views/ directory in the plugin
	 *
	 * @param string $template template file to search for
	 * @return string template path
	 */

	public function getTemplateHierarchy( $template ) {
		$template_slug = rtrim( $template, '.php' );
		$template      = $template_slug . '.php';

		if ( $theme_file = locate_template( array( $this->slug . '/' . $template ) ) ) {
			$file = $theme_file;
		} else {
			$file = 'views/' . $template;
		}

		return apply_filters( 'sp_template_hotel_so_' . $template, $file );
	}

	/**
	 * @param $instance
	 * @return bool
	 */
	private function hasImage($instance) {
		return !empty($instance['image_url']);
	}
}