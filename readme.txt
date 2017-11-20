== Description ==

Hotel Special Offer is a simple plugin that uses to show special offer information for customers.

== Installation ==

Getting started with Hotel Special Offer Widget!

1. Download and install the Hotel Special Offer Widget plugin
2. From your WordPress admin screen, select Plugins from the menu
3. Activate the Hotel Special Offer Widget plugin
4. Go to Appearance > Widget to place the widget in your sidebar in the Design

== Documentation ==

The built in template can be overridden by files within your template.

= Default vs. Custom Templates =

The Hotel Special Offer comes with a default template for the widget output. If you would like to alter the widget display code, create a new folder called "hotel-special-offer" in your template directory and copy over the "views/widget.php" file.

Edit the new file to your hearts content. Please do not edit the one in the plugin folder as that will cause conflicts when you update the plugin to the latest release.

You may now also use the "sp_template_hotel_so_widget.php" filter to override the default template behavior for .php template files. Eg: if you wanted widget.php to reside in a folder called my-custom-templates/ and wanted it to be called my-custom-name.php:

`add_filter('sp_template_hotel_so_widget.php', 'my_template_filter');
function my_template_filter($template) {
	return get_template_directory() . '/my-custom-templates/my-custom-name.php';
}`

= Filters =

There are a number of filters in the code that will allow you to override data as you see fit. The best way to learn what filters are available is always by simply searching the code for 'apply_filters'. But all the same, here are a few of the more essential filters:

*hotel_so_image_url*

Filters the url of the image displayed in the widget.
Accepts additional $offer arguments.

*hotel_so_image_alt*

Filters the alt text of the image.
Accepts additional $offer arguments.

*hotel_so_hotel_name*

Filters the hotel name in the offer.
Accepts additional $offer arguments.

*hotel_so_room_name*

Filters the room name in the offer.
Accepts additional $offer arguments.

*hotel_so_rate_name*

Filters the rate name in the offer.
Accepts additional $offer arguments.

*hotel_so_cost*

Filters the offer cost.
Accepts additional $offer arguments.

*hotel_so_arrival_date*

Filters arrival date in the offer.
Accepts additional $offer arguments.

*hotel_so_departure_date*

Filters departure date in the offer.
Accepts additional $offer arguments.

*hotel_so_option_defaults*

Filters the default fields in the widget.

