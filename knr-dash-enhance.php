<?php
/*
Plugin Name: KNR Dash Enhance
Version: 0.1
Author: k_nitin_r
Description: Enhances the WordPress Dashboard by displaying a drafts link of draft posts or pages exist. More features on the way.
*/


/* BEGIN - Draft page/post menus */

add_action('admin_menu', 'draft_wpmenu');

function have_draft_posts() {
	return (count(get_posts(array(
		'numberposts' => 1,
		'post_type' => 'post',
		'post_status' => 'draft'
	)))>0);
}

function have_draft_pages() {
	return (count(get_posts(array(
		'numberposts' => 1,
		'post_type' => 'page',
		'post_status' => 'draft'
	)))>0);
}

function draft_wpmenu() {
	if (have_draft_posts()) {
		$post_hook_suffix = add_posts_page('Drafts', 'Drafts', 'edit_posts', 'edit-draft-posts', 'draft_post_redirect');	
		add_action('load-'.$post_hook_suffix, 'draft_post_load');
	}
	
	if (have_draft_pages()) {
		$page_hook_suffix = add_pages_page('Drafts', 'Drafts', 'edit_posts', 'edit-draft-pages', 'draft_page_redirect');	
		add_action('load-'.$page_hook_suffix, 'draft_page_load');
	}
}

function draft_post_load() {
	if (!current_user_can('edit_posts')) return;
	wp_redirect('edit.php?post_status=draft&post_type=post');
	exit();
}

function draft_page_load() {
	if (!current_user_can('edit_posts')) return;
	wp_redirect('edit.php?post_status=draft&post_type=page');
	exit();
}

function draft_post_redirect() {
	if (!current_user_can('edit_posts'))
		wp_die('You do not have privileges to edit posts.');
	else {
		echo '<p>You should not be seeing this page. If you are report this as a problem.</p>';
		echo '<p><a href="edit.php?post_status=draft&post_type=post">Draft Posts</a></p>';;
	}
}

function draft_page_redirect() {
	if (!current_user_can('edit_posts'))
		wp_die('You do not have privileges to edit posts.');
	else {
		echo '<p>You should not be seeing this page. If you are report this as a problem.</p>';
		echo '<p><a href="edit.php?post_status=draft&post_type=page">Draft Pages</a></p>';
	}
}

/* END - Draft page/post menus */

?>