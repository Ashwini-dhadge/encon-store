<?php 

function init_header($data='')
{
	$CI = & get_instance();
	$CI = & get_instance();

    $data = array();
     
	

	$CI->load->view(ADMIN.INC.'head', $data);
	$CI->load->view(ADMIN.INC.'top_bar', $data);
	//$data1['access_CURD']=$access;
	$CI->load->view(ADMIN.INC.'side_bar', $data);
}

function init_footer($data='')
{
	$CI = & get_instance();

	$CI->load->view(ADMIN.INC.'footer', $data);
}
function init_header_vendor($data='')
{
        $CI = & get_instance();
        $data = array();
        $CI->load->view(VENDOR.INC.'head', $data);
        $CI->load->view(VENDOR.INC.'top_bar', $data);
        //$data1['access_CURD']=$access;
        $CI->load->view(VENDOR.INC.'side_bar', $data);
}

function init_footer_vendor($data='')
{
        $CI = & get_instance();
        $CI->load->view(VENDOR.INC.'footer', $data);
}
function init_header_customer($data='')
{
        $CI = & get_instance();
        $data = array();
        $CI->load->view(CUST.INC.'head', $data);
        $CI->load->view(CUST.INC.'top_bar', $data);
        //$data1['access_CURD']=$access;
        $CI->load->view(CUST.INC.'side_bar', $data);
}

function init_footer_customer($data='')
{
        $CI = & get_instance();
        $CI->load->view(CUST.INC.'footer', $data);
}

function init_header_print(){
    $CI = & get_instance();
        $data = array();
        $CI->load->view(ADMIN.INC.'head', $data);
       
}
 ?>