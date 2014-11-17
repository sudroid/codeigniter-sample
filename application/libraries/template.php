<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/** 
 * 
 *  This template library can be used to automatically build 
 *    views with a header and footer 
 * 
 * 
 *    Usage: $this->template->show('view', $args); 
 *    Note: make sure to include in autoload.php 
 * 
 * 
 */ 
class Template 
{ 
    function show($view, $args = NULL) 
    { 
        $CI =& get_instance(); 
         
        $CI->load->view('header'); 
        $CI->load->view($view, $args); 
        $CI->load->view('footer'); 
    } 
}