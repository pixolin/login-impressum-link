<?php
/**
 * Plugin Name:     Login Impressum Link
 * Plugin URI:      https://github.com/pixolin/login-impressum-link
 * Description:     Fügt den Link zu deinem Impressum auf der Anmeldeseite hinzu.
 * Author:          Bego Mario Garde <pixolin@pixolin.de>
 * Author URI:      https://pixolin.de
 * License:         GPLv2 or later
 * Version:         0.1.0
 *
 * @package         Login_Impressum_Link
 */

// Your code starts here.

namespace Pixolin;

add_filter( 'the_privacy_policy_link', 'Pixolin\add_login_impressum' );
/**
 * Adds the login impressum link to the provided link.
 *
 * @param mixed $link The original link to append the impressum link to.
 * @return mixed The updated link with the impressum link appended.
 */
function add_login_impressum( $link ) {

	$impressum = my_get_impressum();
	if ( empty( $impressum ) ) {
		return; }

	$link = '<a href="' . get_permalink( $impressum ) . '">Impressum</a> ' . $link;

	return $link;
}

/**
 * Retrieves the ID of the 'Impressum' page.
 *
 * @return int|null The ID of the 'Impressum' page if found, null otherwise.
 */
function my_get_impressum() {
	$posts = get_posts(
		array(
			'post_type'              => 'page',
			'title'                  => 'Impressum',
			'post_status'            => 'publish',
			'numberposts'            => 1,
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
			'orderby'                => 'post_date ID',
			'order'                  => 'ASC',
		)
	);

	$page_got_by_title = null;

	if ( ! empty( $posts ) ) {
		$page_got_by_title = $posts[0];
		return $page_got_by_title->ID;
	}

	return null;
}
