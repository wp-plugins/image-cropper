=== Plugin Name ===
Tags: image, cropper, api
Requires at least: 3.0
Tested up to: 3.2.1
Stable tag: 0.3.0

Image cropper gives you an API for cropping images inside WordPress.

== Description ==

For cropping a post thumbnail image to 200x300 pixels:

	<?php
		the_post();
		img(200, 300);
	?>

This will verify the existence of post thumbnail, crop the image, save it in uploads folder, and generate an image tag.

To verify the existence of a post thumbnail, you can use <code>has_img()</code>

	<?php if (has_img()): ?>
	<figure>
		<?php img(200, 300) ?>
		<figcaption>Some text</figcaption>
	</figure>
	<?php endif ?>
	
	
To crop images that are not post thumbnails, you can use <code>crop($url, $size)</code>
	
	<?php
		$cropped_url= crop( get_bloginfo('url') . '/wp-content/uploads/image.jpg', array(200, 300) );
	?>
	<img src="<?php echo $cropped_url ?>">
	
	
== Installation ==

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Done :) Use the new template tags on your theme, eg `<?php the_post(); img(200, 300); ?>`

== Frequently Asked Questions ==

= When using img(), where does the image come from? =
The img() template tag gets the image from your post thumbnail.



== Changelog ==

= 0.3.0 =
* First public version.