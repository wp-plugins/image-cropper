<?php

/*
Plugin Name: Image Cropper
Plugin URI: https://github.com/julioprotzek/ImageCropper
Description: Image cropper gives you an API for cropping images inside WordPress
Author: Julio Protzek
Version: 0.3.0
Author URI: http://beehivestudio.com.br
*/


require_once 'phpthumb/ThumbLib.inc.php';

function img($w, $h) {
	$size[]= $w;
	$size[]= $h;
	global $post;
	$img= wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large');
	if ($img) {
		$url= crop($img[0], $size);
		echo "<img src=\"$url\" width=\"{$size[0]}\" height=\"{$size[1]}\">";
	}
}

function has_img() {
	global $post;
	return get_post_thumbnail_id($post->ID) ? true : false;
}

function crop($url, $size) {
	$offline_file= cached_filename($url, $size[0], $size[1], 'offline');
	$online_file= cached_filename($url, $size[0], $size[1], 'online');

	if (file_exists($offline_file)) {
		return $online_file;
	} else {
		try {
			$thumb= PhpThumbFactory::create($url);
			$thumb->adaptiveResize($size[0], $size[1]);
			$thumb->save($offline_file);
			return $online_file;
		} catch (Exception $e) {
			if (WP_DEBUG) { echo $e; }
			return $url;
		}
	}
}

function file_from($url) {
	return basename($url, extension_from($url));
}

function extension_from($url) {
	$info= pathinfo($url);
	return ".{$info['extension']}";
}

function get_cache_dir($mode) {
	$uploads= wp_upload_dir();

	if ($mode == 'offline')
		$dir= "{$uploads['basedir']}/cache";
	else
		$dir= "{$uploads['baseurl']}/cache";

	if(!file_exists($dir)) { mkdir($dir); }
	return $dir;
}

function cached_filename($url, $w, $h, $mode) {
	$cache_dir= get_cache_dir($mode);
	$file= file_from($url);
	$extension= extension_from($url);
	return "{$cache_dir}/{$file}-{$w}x{$h}{$extension}";
}