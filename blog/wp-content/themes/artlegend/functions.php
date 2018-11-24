<?php
if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'name' => 'Left Sidebar',
        'before_widget' => '<li>',
		
        'after_widget' => '</li>',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
    ));
	if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'name' => 'Right Sidebar',
        'before_widget' => '<li>',
        'after_widget' => '</li>',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
    ));
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size('my_thumb',224,98,true);// enable featured image in dashboard
	//include('admin_option.php');
	register_nav_menus(array('header_menu'=>'Header','footer_menu'=>'Footer'));
	if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'slider', 266, 568 ); //300 pixels wide (and unlimited height)
	add_image_size( 'thumb', 60, 128, true ); //(cropped)
}
	 // to call this thumbnail, put this in template:-> the_post_thumbnail('my_thumb'); 
?>