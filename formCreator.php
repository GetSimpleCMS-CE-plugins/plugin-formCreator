<?php

i18n_merge('formCreator') || i18n_merge('formCreator','en_US');

# get correct id for plugin
$thisfile = basename(__FILE__, ".php");

# register plugin
register_plugin(
	$thisfile, //Plugin id
	'formCreator', 	//Plugin name
	'2.0', 		//Plugin version
	'Multicolor',  //Plugin author
	'https://ko-fi.com/multicolorplugins', //author website
	'Create own form!', //Plugin description
	'pages', //page type - on which admin tab to display
	'formList'  //main function (administration)
);



# add a link in the admin tab 'theme'
add_action('pages-sidebar', 'createSideMenu', array($thisfile, 'Form Creator List 💌'));



include(GSPLUGINPATH . 'formCreator/class/backend.class.php');
include(GSPLUGINPATH . 'formCreator/class/frontend.class.php');


function formList()
{

	
	global $SITEURL;
	global $GSADMIN;

	echo '<link href="' . $SITEURL . 'plugins/formCreator/css/w3.css' . '"  rel="stylesheet">';



	$formClass = new backendFormCreator();


	if (isset($_GET['addnewform']) || isset($_GET['editform'])) {
		include(GSPLUGINPATH . 'formCreator/edit.php');
	} elseif (isset($_GET['settings'])) {
		include(GSPLUGINPATH . 'formCreator/settings.php');
	} else {
		include(GSPLUGINPATH . 'formCreator/list.php');
	}

	echo "
	<div style='text-decoration:none !important;margin-top:20px;display:flex;align-items:center;justify-content:space-between' class='w3-border w3-padding w3-light-gray'>
	<p style='margin:0 auto'>".i18n_r('formCreator/COFFE')."</p>
<a href='https://ko-fi.com/I3I2RHQZS' target='_blank'><img height='36' style='border:0px;height:36px;' src='https://storage.ko-fi.com/cdn/kofi3.png?v=3' border='0' alt='Buy Me a Coffee at ko-fi.com' /></a> 
</div>";


	//delete form

	if (isset($_GET['delete'])) {

		$formClass->deleteForm($_GET['delete']);
	}


	echo '<script src="' . $SITEURL . 'plugins/formCreator/js/w3.js' . '"></script>';
}




function showFormCreator($val)
{
	$formClassFront = new frontendFormCreator();
$formClassFront->show($val);
}
