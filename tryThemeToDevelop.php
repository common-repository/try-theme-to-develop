<?php
/*
Plugin Name: Try theme to develop
Plugin URI: http://jorge.delcasar.net/plugins/try-theme-to-develop/
Description: This plugin detect if current user have the capacity of "edit_themes" and then he can change the template to develop it.
Author: Jorge del Casar
Version: 0.2
Author URI: http://jorge.delcasar.net/
*/ 
class TryThemeToDevelop{
	var $templateToTry;
	var $isAdmin;
	var $capacity = "edit_themes";
	var $fileName = "tryThemeToDevelop-option";
	function TryThemeToDevelop(){	
		$this->isAdmin = false;
		$templateToTry = get_template();
		if(get_option('templateToTry')==false)
		    add_option('templateToTry',$templateToTry);
		$this->add_actions(); 
		$this->add_filters();
	}
	function add_actions(){
		add_action('plugins_loaded',array(&$this,'detectUser'));
    	add_action('admin_menu', array(&$this,'tryThemeToDevelopAdminMenu'));
	}
	function add_filters(){
		add_filter('template',array(&$this,'get_template'));
		add_filter('stylesheet',array(&$this,'get_stylesheet'));
	}
	function detectUser(){
		global $userdata;
		get_currentuserinfo();
		$this->isAdmin = $userdata->user_level == 10;
	}
	function tryThemeToDevelopAdminMenu(){
    	if ( function_exists('add_submenu_page') ) {
    	    add_submenu_page('themes.php', __('Try Theme'), __('Try Theme'), $this->capacity, $this->fileName ,array(&$this,'tryThemeToDevelopPluginOption'));
    	}
	}
	function tryThemeToDevelopPluginOption(){
    	if ( isset($_POST['submit']) ) {
            if ( function_exists('current_user_can') && !current_user_can($this->capacity) ){
                die(__('Cheatin&#8217; uh?'));
            }
            update_option('templateToTry', $_POST['templateToTry']);
    	}
        include_once($this->fileName.'.php');
	}
	function get_template($template) {
		if ($this->isAdmin) $template = get_option('templateToTry');
		return $template;
	}
	function get_stylesheet($stylesheet) {
		if ($this->isAdmin) $stylesheet = get_option('templateToTry');
		return $stylesheet;
	}
}
$wp_pda = new TryThemeToDevelop();