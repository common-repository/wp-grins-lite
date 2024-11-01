<?php

// WP Grins Lite
//
// Copyright (c) 2004-2007 Alex King
// http://alexking.org/projects/wordpress
//
// Lite version created on June 20, 2008 by Ronald Huereca
//
// This is an add-on for WordPress
// http://wordpress.org/
//
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
// *****************************************************************

/*
Plugin Name: WP Grins Lite
Plugin URI: http://www.ronalfy.com/2009/10/26/wp-grins-lite/
Description: A Clickable Smilies hack for WordPress.
Version: 1.1
Author: Alex King and Ronald Huereca
Author URI: http://www.ronalfy.com
Props:  Original author, Alex King
*/ 
if (!class_exists('WPGrins')) {
    class WPGrins	{
		var $adminOptionsName = "wpgrinslite";
		/**
		* PHP 4 Compatible Constructor
		*/
		function WPGrins(){$this->__construct();}
		
		/**
		* PHP 5 Constructor
		*/		
		function __construct(){
			//Scripts
			add_action('admin_print_scripts-post.php', array(&$this,'add_scripts'),1000); 
			add_action('admin_print_scripts-post-new.php', array(&$this,'add_scripts'),1000); 
			add_action('admin_print_scripts-page.php', array(&$this,'add_scripts'),1000); 
			add_action('admin_print_scripts-page-new.php', array(&$this,'add_scripts'),1000); 
			add_action('admin_print_scripts-comment.php', array(&$this,'add_scripts'),1000); 
			add_action('wp_print_scripts', array(&$this,'add_scripts_frontend'),1000);
			//Styles
			add_action('admin_print_styles-post.php', array(&$this,'add_styles'),1000); 
			add_action('admin_print_styles-post-new.php', array(&$this,'add_styles'),1000); 
			add_action('admin_print_styles-page.php', array(&$this,'add_styles'),1000); 
			add_action('admin_print_styles-page-new.php', array(&$this,'add_styles'),1000); 
			add_action('admin_print_styles-comment.php', array(&$this,'add_styles'),1000);
			add_action('wp_print_styles', array(&$this,'add_styles_frontend'));
			
			//Ajax
			add_action('wp_ajax_grins', array(&$this,'ajax_print_grins'));
			add_action('wp_ajax_nopriv_grins', array(&$this,'ajax_print_grins')); 
			
			//Admin options
			add_action('admin_menu', array(&$this,'add_admin_pages'));
			$this->adminOptions = $this->get_admin_options();
		}
		function ajax_print_grins() {
			echo $this->wp_grins();
			exit;
		}
		function wp_grins() {
				global $wpsmiliestrans;
				$grins = '';
				$smiled = array();
				foreach ($wpsmiliestrans as $tag => $grin) {
					if (!in_array($grin, $smiled)) {
						$smiled[] = $grin;
						$tag = esc_attr(str_replace(' ', '', $tag));
						$src = esc_url(site_url("wp-includes/images/smilies/{$grin}"));
						$grins .= "<img src='$src' alt='$tag' onclick='jQuery.wpgrins.grin(\"$tag\");' />";
					}
				}
				return $grins;
		} //end function wp_grins
		
		function add_styles() {
			wp_enqueue_style('wp-grins', plugins_url('wp-grins-lite/grins.css'));
			wp_enqueue_style('wp-grins-ie', plugins_url('wp-grins-lite/grins-ie.css'));
			global $wp_styles;
			$wp_styles->add_data( 'wp-grins-ie', 'conditional', 'IE' );
		}
		function add_styles_frontend() {
			if (!is_admin()) {
				if ((!is_single() && !is_page()) || 'closed' == $post->comment_status) {
					return;
				} 
				$this->add_styles();
			}
		}
		function add_scripts(){
			wp_enqueue_script('wp_grins_lite', plugins_url('wp-grins-lite/js/wp-grins.js'), array("jquery"), 1.0); 
			wp_localize_script( 'wp_grins_lite', 'wpgrinslite', $this->get_js_vars());
		}
		function add_scripts_frontend() {
			//Make sure the scripts are included only on the front-end
			if (!is_admin()) {
				if ((!is_single() && !is_page()) || 'closed' == $post->comment_status) {
					return;
				} 
				$this->add_scripts();
			}
		}
		//Returns various JavaScript vars needed for the scripts
		function get_js_vars() {
			if (is_admin()) {
				return array(
					'Ajax_Url' => admin_url('admin-ajax.php'),
					'LOCATION' => 'admin',
					'MANUAL' => 'false'
				);
			}
			return array(
					'Ajax_Url' => admin_url('admin-ajax.php'),
					'LOCATION' => 'post',
					'MANUAL' => esc_js($this->adminOptions['manualinsert'])
			);
		} //end get_js_vars
		//Returns an array of admin options
		function get_admin_options() {
			if (empty($this->adminOptions)) {
				$adminOptions = array(
					'manualinsert' => 'false'
				);
				$options = get_option($this->adminOptionsName);
				if (!empty($options)) {
					foreach ($options as $key => $option) {
						if (array_key_exists($key, $adminOptions)) {
							$adminOptions[$key] = $option;
						}
					}
				}
				$this->adminOptions = $adminOptions;
				$this->save_admin_options();								
			}
			return $this->adminOptions;
		}
		//Saves for admin 
		function save_admin_options(){
			if (!empty($this->adminOptions)) {
				update_option($this->adminOptionsName, $this->adminOptions);
			}
		}
		function add_admin_pages(){
					add_options_page('WP Grins Lite', 'WP Grins Lite', 9, basename(__FILE__), array(&$this, 'print_admin_page'));
			}
		//Provides the interface for the admin pages
		function print_admin_page() {
			include dirname(__FILE__) . '/admin-panel.php';
		}
		
		/*END UTILITY FUNCTIONS*/
    }
}
//instantiate the class
if (class_exists('WPGrins')) {
	$GrinsLite = new WPGrins();
}
// left in for legacy reasons
if (!function_exists('wp_grins')) {
	function wp_grins() { 
		print('');
	}
}
if (!function_exists('wp_print_grins')) {
	function wp_print_grins() {
		global $GrinsLite;
		if (isset($GrinsLite)) {
			return $GrinsLite->wp_grins();
		}
	}
}
?>