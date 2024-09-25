<?php


if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title'    => 'Theme General Settings',
		'menu_title'    => 'Theme Settings',
		'menu_slug'     => 'theme-general-settings',
		'capability'    => 'edit_posts',
		'redirect'      => false
  ));

  acf_add_options_sub_page(array(
		'page_title'    => 'Social Networks Settings',
		'menu_title'    => 'Social Networks',
		'parent_slug'   => 'theme-general-settings',
  ));

  acf_add_options_sub_page(array(
	'page_title'    => 'Contacts Settings',
	'menu_title'    => 'Contacts',
	'parent_slug'   => 'theme-general-settings',
));

acf_add_options_sub_page(array(
	'page_title'    => 'Packages Settings',
	'menu_title'    => 'Packages',
	'parent_slug'   => 'theme-general-settings',
));

}