== Documentation ==

The built in template can be overridden by files within your template.

= Default vs. Custom Templates =

The Image Widget comes with a default template for the widget output. If you would like to alter the widget display code, create a new folder called "hotel-special-offer" in your template directory and copy over the "views/widget.php" file.

Edit the new file to your hearts content. Please do not edit the one in the plugin folder as that will cause conflicts when you update the plugin to the latest release.

You may now also use the "sp_template_hotel_so_widget.php" filter to override the default template behavior for .php template files. Eg: if you wanted widget.php to reside in a folder called my-custom-templates/ and wanted it to be called my-custom-name.php:

`add_filter('sp_template_image-widget_widget.php', 'my_template_filter');
function my_template_filter($template) {
	return get_template_directory() . '/my-custom-templates/my-custom-name.php';
}`