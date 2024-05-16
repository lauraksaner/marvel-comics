<?php
/**
* Plugin Name: Marvel Comics Aggregator
* Plugin URI:  https://laurasaner.com
* Description: Reaches out to Marvel's API to retrieve comics.
* Version: 1.0
* Author: Laura Saner
* Author URI: https://laurasaner.com
**/

function marvel_styles() {
    wp_enqueue_style( 'style',  plugin_dir_url( __FILE__ ) . "/style.css");
}
add_action( 'wp_enqueue_scripts', 'marvel_styles' );



function comics_shortcode() {
	// Contact Marvel with character ID, startYear, api key, and hash
	$marvel_query = file_get_contents('https://gateway.marvel.com/v1/public/characters/1009610/comics?startYear=2022&limit=8&ts=1&apikey=b006bbfe50199178bde13fe3dd509f04&hash=e571abee317ab06351183b69d6b4f91c');
	// Convert response to array
	$marvel_array = json_decode($marvel_query, TRUE);
	// Loop all results and build display
	$output = "<section id='marvel-data'>";
	foreach ($marvel_array['data']['results'] as $comic){
		$output .= "<div class='comic-wrap'>";
			$output .=  "<img src='" . $comic['thumbnail']['path'] . "/portrait_uncanny." . $comic['thumbnail']['extension'] ."'/><br />";
			$output .= $comic["title"] . "<br />";
		$output .= "</div>";
	}
	$output .= "</div>";
	return $output;
}
add_shortcode( 'get_comics', 'comics_shortcode' );