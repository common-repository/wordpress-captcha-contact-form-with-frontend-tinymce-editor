<?php


/*
Plugin Name: WordPress captcha contact form with frontend TinyMCE editor
Plugin URI: http://donicaptcha.donimedia-servicetique.net/?p=75
Description: With this widget , you can display a customizable captcha contact form with a frontend TinyMCE editor , on your Wordpress website . <a href="http://donicaptcha.donimedia-servicetique.net/?page_id=9" title="Be well informed about our latest creations or updates">Newsletter</a> | <a href="http://donicaptcha.donimedia-servicetique.net/?page_id=17" title="DoniCaptcha Support Forum">Support Forum</a>
Version: 1.0.0
Author: David DONISA
Author URI: http://donicaptcha.donimedia-servicetique.net/
*/


/** Make sure that the WordPress bootstrap has run before continuing. */
require( $_SERVER["DOCUMENT_ROOT"].'/wp-load.php' );






	//  error_reporting(E_ALL);  //  For DEBUG purpose
	add_action("widgets_init", array('captcha_contact_form_tinymce_wccfwte', 'register'));
	register_activation_hook( __FILE__, array('captcha_contact_form_tinymce_wccfwte', 'activate'));
	register_deactivation_hook( __FILE__, array('captcha_contact_form_tinymce_wccfwte', 'deactivate'));



	global $data, $wp_captcha_contact_form_tinymce_wccfwte_plugin_dir, $max_upload_size, $wp_captcha_contact_form_tinymce_wccfwte_plugin_dir_url, $error_message, $email_sent, $submission_counter;


	if ( isset($_REQUEST['submission_counter']) )  {

		$submission_counter += intval($_REQUEST['submission_counter']); 

	};




	$wp_captcha_contact_form_tinymce_wccfwte_plugin_dir = $_SERVER["DOCUMENT_ROOT"].'/wp-content/plugins/captcha_contact_form_tinymce_wccfwte/'; 
	$wp_captcha_contact_form_tinymce_wccfwte_plugin_dir_url = plugin_dir_url(__FILE__);  // With ending slash


	$plugin_prefix = 'wp_captcha_contact_form_tinymce_wccfwte';


	function wp_captcha_contact_form_tinymce_wccfwte_upload_css (){


		global $data;

		$data = get_option('wp_captcha_contact_form_tinymce_wccfwte_name');


		$css_to_display = "<style type='text/css'>
			
			.wp_captcha_contact_form_tinymce_wccfwte_box_container{

				position: relative;

				z-index: 0;	/* important to get captcha string position on top of background container */

				width : 100%;
				height: 20px;

				overflow:hidden; /* hide overflowing content */  

				margin-top: 5px;
				margin-left: 0px;
		
				background: #".$data['wp_captcha_contact_form_tinymce_wccfwte_captcha_background_hexadecimal_color'].";  
				color: #".$data['wp_captcha_contact_form_tinymce_wccfwte_captcha_hexadecimal_text_color'].";  

				text-align: center;
			}
  

			.wp_captcha_contact_form_tinymce_wccfwte_box_image{  

				position: absolute; /* important to get image position on top of text */

				z-index: 2;		 /* important to get image position on top of text */

				left: 0px;

				width : 100%;
				height: 20px;
			}  


			.wp_captcha_contact_form_tinymce_wccfwte_captcha_string{  	/* Do not indent characters ( text-ident ) to avoid that the user believes it is necessary to add spaces */

				position: relative;

				z-index: 1;	 /* important to get captcha string position on top of background container */

				font-size: ".$data['wp_captcha_contact_form_tinymce_wccfwte_font_size']."pt;
				font-weight: bold;

				width : 100%;
				height: 20px;

			}  



			.wp_captcha_contact_form_tinymce_wccfwte_captcha_user{  

				position: relative;

				margin-left: 0px; 
				margin-top: 5px; 

				width: 100%;
			} 


			.wp_captcha_contact_form_tinymce_wccfwte_error_message{  

				position: relative;

				margin-left: 0px; 
				margin-top: 10px; 

				color: #ff0000;
				text-align: center;


				font-size: 8pt;
				font-weight: bold;
			} 


			.wp_captcha_contact_form_tinymce_wccfwte_email_field{  

				position: relative; 

				font-size: ".$data['wp_captcha_contact_form_tinymce_wccfwte_font_size']."pt; 

				margin-left: 0px; 
				margin-top: 5px; 

				width: 100%;

				display: block;

			}


			.wp_captcha_contact_form_tinymce_wccfwte_subject_field{  

				position: relative; 

				font-size: ".$data['wp_captcha_contact_form_tinymce_wccfwte_font_size']."pt; 

				margin-left: 0px; 
				margin-top: 5px; 

				width: 100%;

				display: block;

			} 


			.wp_captcha_contact_form_tinymce_wccfwte_uploaded_file{  

				position: relative; 

				margin-left: 0px; 
				margin-top: 5px;

				width: 100%;

			} 


			.wp_captcha_contact_form_tinymce_wccfwte_uploaded_file_limits{  

				position: relative; 

				margin-left: 0px; 
				margin-top: 0px; 

				font-size: 7pt; 

				display: block;

			} 


			.wp_captcha_contact_form_tinymce_wccfwte_captcha_code_instructions{  

				position: relative; 

				margin-left: 0px; 
				margin-top: 0px; 

				font-size: 7pt; 

				display: block;

			} 


			.wp_captcha_contact_form_tinymce_wccfwte_editor_textarea{  

				position: relative; 

				width: 100%;

			}


			.wp_captcha_contact_form_tinymce_wccfwte_credits_link{  

				position: relative; 

				width: 100%;

				text-align: center;  

				color: #ff0000; 

				font-size: 7pt; 
				font-weight: bold;

				margin-top: 5px; 
				margin-bottom: 20px; 

			}




			.wp_captcha_contact_form_tinymce_wccfwte_submit_button{  

				position: relative; 

				margin-left: 0px; 
				margin-top: 5px;
				margin-bottom: 10px; 

			}

		</style>";

		echo $css_to_display;



	};  //  function wp_captcha_contact_form_tinymce_wccfwte_upload_css () End



	function wp_captcha_contact_form_tinymce_wccfwte_upload_jquery (){

		global $data;

		$data = get_option('wp_captcha_contact_form_tinymce_wccfwte_name');



		//  Skins handling :

		switch ( $data['wp_captcha_contact_form_tinymce_wccfwte_editor_skin'] ) {


			case "o2k7":

				$skin = "

					skin : 'o2k7',
				";

				break;

			case "o2k7_black":

				$skin = "

					skin : 'o2k7',
					skin_variant : 'black',
				";

				break;

			case "o2k7_silver":

				$skin = "

					skin : 'o2k7',
					skin_variant : 'silver',
				";


				break;


		
		}  //  switch End







		$jquery_to_display = "<script  type='text/javascript' src='http://ajax.microsoft.com/ajax/jquery/jquery-1.4.4.min.js'></script><script type='text/javascript'>
			
					  /*  Captcha foreground image handling */

					  jQuery(document).ready(function() {

					  	jQuery('.wp_captcha_contact_form_tinymce_wccfwte_box_container').hover(function(){	/*  On mouse over */

            							var width = jQuery(this).outerWidth();

            							jQuery(this).find('.wp_captcha_contact_form_tinymce_wccfwte_box_image').animate({ left : width },{queue:false,duration:300});


        						}, function(){	/*  On mouse out */

            							jQuery(this).find('.wp_captcha_contact_form_tinymce_wccfwte_box_image').animate({ left : '0px' },{queue:false,duration:300});

        						}


					);  /*   jQuery('.wp_captcha_contact_form_tinymce_wccfwte_box_container').hover(function() End  */




					/* Disabling paste function */
	
					jQuery('#wp_captcha_contact_form_tinymce_wccfwte_captcha_user').live('cut copy paste',function(e) { e.preventDefault(); });






  				});

		</script>



		<script type='text/javascript' src='".$wp_captcha_contact_form_tinymce_wccfwte_plugin_dir_url."wp-content/plugins/captcha_contact_form_tinymce_wccfwte/scripts/tinymce/jscripts/tiny_mce/tiny_mce.js'></script>

		<script type='text/javascript'>
	
			tinyMCE.init({

				// General options
				mode : 'exact',
				elements : 'wp_captcha_contact_form_tinymce_wccfwte_editor_textarea',

				theme : 'advanced',
				".$skin."

				constrain_menus : false,
	
				plugins : 'autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave',

				// Theme options
				theme_advanced_buttons1 : '".$data['wp_captcha_contact_form_tinymce_wccfwte_editor_buttons_line1']."',
				theme_advanced_buttons2 : '".$data['wp_captcha_contact_form_tinymce_wccfwte_editor_buttons_line2']."',
				theme_advanced_buttons3 : '".$data['wp_captcha_contact_form_tinymce_wccfwte_editor_buttons_line3']."',
				theme_advanced_buttons4 : '".$data['wp_captcha_contact_form_tinymce_wccfwte_editor_buttons_line4']."',
				theme_advanced_toolbar_location : '".$data['wp_captcha_contact_form_tinymce_wccfwte_toolbar_location']."',
				theme_advanced_toolbar_align : '".$data['wp_captcha_contact_form_tinymce_wccfwte_toolbar_align']."',
				theme_advanced_statusbar_location : '".$data['wp_captcha_contact_form_tinymce_wccfwte_statusbar_location']."',
				theme_advanced_resizing : ".$data['wp_captcha_contact_form_tinymce_wccfwte_textarea_resizing'].",

				// Example word content CSS (should be your site CSS) this one removes paragraph margins
				content_css : 'css/word.css',

				// Drop lists for link/image/media/template dialogs
				template_external_list_url : 'lists/template_list.js',
				external_link_list_url : 'lists/link_list.js',
				external_image_list_url : 'lists/image_list.js',
				media_external_list_url : 'lists/media_list.js',
		
				// Replace values for the template plugin
				template_replace_values : {
				username : 'wp_captcha_contact_form_tinymce_wccfwte',
				staffid : 'wp_captcha_contact_form_tinymce_wccfwte'


				}
			});
	</script>
	<!-- /TinyMCE -->


	";


		echo $jquery_to_display;



	};  //  function wp_captcha_contact_form_tinymce_wccfwte_upload_jquery () End


	add_action("wp_head", 'wp_captcha_contact_form_tinymce_wccfwte_upload_css');
	add_action("wp_head", 'wp_captcha_contact_form_tinymce_wccfwte_upload_jquery');







class captcha_contact_form_tinymce_wccfwte {

  function activate(){


	global $data, $wp_captcha_contact_form_tinymce_wccfwte_error_message, $email_sent, $submission_counter;

	$email_sent = false;
	$submission_counter = 0;

    	$data = array( 	//  Options initialization :

				'wp_captcha_contact_form_tinymce_wccfwte_title' => 'Your widget title',
				'wp_captcha_contact_form_tinymce_wccfwte_email_label' => 'Your e-mail address',
				'wp_captcha_contact_form_tinymce_wccfwte_email_subject_label' => 'Your e-mail subject',
				'wp_captcha_contact_form_tinymce_wccfwte_email_extensions_limits_label' => '( jpg , png , pdf . size < 2 Mo )',
				'wp_captcha_contact_form_tinymce_wccfwte_captcha_instructions_label' => '( Cross over image then reproduce )',

				'wp_captcha_contact_form_tinymce_wccfwte_attachment_size_error_message' => 'Attachment size is not valid !' ,
				'wp_captcha_contact_form_tinymce_wccfwte_attachment_extension_error_message' => 'Attachment extension is not valid !' ,
				'wp_captcha_contact_form_tinymce_wccfwte_mail_not_sent_error_message' => 'Mail could not be sent !' ,
				'wp_captcha_contact_form_tinymce_wccfwte_captcha_not_valid_error_message' => 'Captcha value entered by user is not valid !' ,
				'wp_captcha_contact_form_tinymce_wccfwte_email_not_valid_error_message' => 'E-mail address is not valid !' ,

				'wp_captcha_contact_form_tinymce_wccfwte_email_reply' => 'Your E-mail address !' ,
				'wp_captcha_contact_form_tinymce_wccfwte_font_size' => '10' ,
				'is_wp_captcha_contact_form_tinymce_wccfwte_captcha_display_first_load' => 'yes',
				'wp_captcha_contact_form_tinymce_wccfwte_captcha_display' => 'yes',
				'is_wp_captcha_contact_form_tinymce_wccfwte_upload_button_display_first_load' => 'yes',
				'wp_captcha_contact_form_tinymce_wccfwte_upload_button_display' => 'yes',

				'wp_captcha_contact_form_tinymce_wccfwte_captcha_background_hexadecimal_color' => '000000' ,
				'wp_captcha_contact_form_tinymce_wccfwte_captcha_hexadecimal_text_color' => 'ffffff' ,
				'wp_captcha_contact_form_tinymce_wccfwte_captcha_code_length' => '6' ,

				'is_wp_captcha_contact_form_tinymce_wccfwte_credit_link_first_load' => 'yes',
				'wp_captcha_contact_form_tinymce_wccfwte_credit_link' => 'yes',

				'wp_captcha_contact_form_tinymce_wccfwte_editor_buttons_line1' => '',
				'wp_captcha_contact_form_tinymce_wccfwte_editor_buttons_line2' => '',
				'wp_captcha_contact_form_tinymce_wccfwte_editor_buttons_line3' => '',
				'wp_captcha_contact_form_tinymce_wccfwte_editor_buttons_line4' => '',

				'wp_captcha_contact_form_tinymce_wccfwte_toolbar_location' => 'top',
				'is_wp_captcha_contact_form_tinymce_wccfwte_toolbar_location_first_load' => 'yes',
				'wp_captcha_contact_form_tinymce_wccfwte_toolbar_align' => 'center',
				'is_wp_captcha_contact_form_tinymce_wccfwte_toolbar_align_first_load' => 'yes',
				'wp_captcha_contact_form_tinymce_wccfwte_statusbar_location' => 'bottom',
				'is_wp_captcha_contact_form_tinymce_wccfwte_statusbar_location_first_load' => 'yes',
				'wp_captcha_contact_form_tinymce_wccfwte_textarea_resizing' => 'true',
				'is_wp_captcha_contact_form_tinymce_wccfwte_textarea_resizing_first_load' => 'yes',
				'wp_captcha_contact_form_tinymce_wccfwte_editor_skin' => 'o2k7_silver',
				'is_wp_captcha_contact_form_tinymce_wccfwte_editor_skin_first_load' => 'yes'


	);

    	if ( ! get_option('wp_captcha_contact_form_tinymce_wccfwte_name')){
     	add_option('wp_captcha_contact_form_tinymce_wccfwte_name' , $data);
    	} else {
     	update_option('wp_captcha_contact_form_tinymce_wccfwte_name' , $data);
    	}
  }

  function dewp_captcha_contact_form_tinymce_wccfwte_activate(){

    	delete_option('wp_captcha_contact_form_tinymce_wccfwte_name');

  }


function control(){

	global $data, $wp_captcha_contact_form_tinymce_wccfwte_error_message;

	$data = get_option('wp_captcha_contact_form_tinymce_wccfwte_name');


  ?>



	<h3>Captcha Contact Form <br />Labels Translations</h3>
  	<p><label>Title <b>:</b> <br /> <input name="wp_captcha_contact_form_tinymce_wccfwte_title" type="text" size="30" value="<?php echo $data['wp_captcha_contact_form_tinymce_wccfwte_title']; ?>" /></label></p>
  	<p><label>"E-mail" label <b>:</b> <br /> <input name="wp_captcha_contact_form_tinymce_wccfwte_email_label" type="text" size="30" value="<?php echo $data['wp_captcha_contact_form_tinymce_wccfwte_email_label']; ?>" /></label></p>
  	<p><label>"E-mail subject" label <b>:</b> <br /> <input name="wp_captcha_contact_form_tinymce_wccfwte_email_subject_label" type="text" size="30" value="<?php echo $data['wp_captcha_contact_form_tinymce_wccfwte_email_subject_label']; ?>" /></label></p>
  	<p><label>"Attachment extensions limits" label <b>:</b> <br /> <input name="wp_captcha_contact_form_tinymce_wccfwte_email_extensions_limits_label" type="text" size="30" value="<?php echo $data['wp_captcha_contact_form_tinymce_wccfwte_email_extensions_limits_label']; ?>" /></label></p>
  	<p><label>"Captcha Instructions" label <b>:</b> <br /> <input name="wp_captcha_contact_form_tinymce_wccfwte_captcha_instructions_label" type="text" size="30" value="<?php echo $data['wp_captcha_contact_form_tinymce_wccfwte_captcha_instructions_label']; ?>" /></label></p>


	<h3>Error Messages Translations</h3>
  	<p><label>"Attachment size" error message <b>:</b> <br /> <input name="wp_captcha_contact_form_tinymce_wccfwte_attachment_size_error_message" type="text" size="30" value="<?php echo $data['wp_captcha_contact_form_tinymce_wccfwte_attachment_size_error_message']; ?>" /></label></p>
  	<p><label>"Attachment extension" error message <b>:</b> <br /> <input name="wp_captcha_contact_form_tinymce_wccfwte_attachment_extension_error_message" type="text" size="30" value="<?php echo $data['wp_captcha_contact_form_tinymce_wccfwte_attachment_extension_error_message']; ?>" /></label></p>
  	<p><label>"Mail not sent" error message <b>:</b> <br /> <input name="wp_captcha_contact_form_tinymce_wccfwte_mail_not_sent_error_message" type="text" size="30" value="<?php echo $data['wp_captcha_contact_form_tinymce_wccfwte_mail_not_sent_error_message']; ?>" /></label></p>
  	<p><label>"Captcha not valid" error message <b>:</b> <br /> <input name="wp_captcha_contact_form_tinymce_wccfwte_captcha_not_valid_error_message" type="text" size="30" value="<?php echo $data['wp_captcha_contact_form_tinymce_wccfwte_captcha_not_valid_error_message']; ?>" /></label></p>
  	<p><label>"Email not valid" error message <b>:</b> <br /> <input name="wp_captcha_contact_form_tinymce_wccfwte_email_not_valid_error_message" type="text" size="30" value="<?php echo $data['wp_captcha_contact_form_tinymce_wccfwte_email_not_valid_error_message']; ?>" /></label></p>


	<h3>General Settings</h3>
  	<p><label style="color: #ff0000; font-weight: bold;" >Contact Form E-mail Reply ( required ) :</label> <br /> <input name="wp_captcha_contact_form_tinymce_wccfwte_email_reply" type="text" size="30" value="<?php echo $data['wp_captcha_contact_form_tinymce_wccfwte_email_reply']; ?>" /></p>
  	<p><label>Font Size ( in pt ) <b>:</b> <br /> <input name="wp_captcha_contact_form_tinymce_wccfwte_font_size" type="text" size="3" value="<?php echo $data['wp_captcha_contact_form_tinymce_wccfwte_font_size']; ?>" /></label></p>
  	<p><label>Captcha background hexadecimal color <br />( without # ) <b>:</b> <br /> <input name="wp_captcha_contact_form_tinymce_wccfwte_captcha_background_hexadecimal_color" type="text" size="3" value="<?php echo $data['wp_captcha_contact_form_tinymce_wccfwte_captcha_background_hexadecimal_color']; ?>" /></label></p>
  	<p><label>Captcha hexadecimal text color <br />( without # ) <b>:</b> <br /> <input name="wp_captcha_contact_form_tinymce_wccfwte_captcha_hexadecimal_text_color" type="text" size="3" value="<?php echo $data['wp_captcha_contact_form_tinymce_wccfwte_captcha_hexadecimal_text_color']; ?>" /></label></p>
  	<p><label>Captcha code length  ( default : 6 ) <b>:</b> <br /> <input name="wp_captcha_contact_form_tinymce_wccfwte_captcha_code_length" type="text" size="3" value="<?php echo $data['wp_captcha_contact_form_tinymce_wccfwte_captcha_code_length']; ?>" /></label></p>



  <?php

	//  Upload button display handling :

	if ( $data['is_wp_captcha_contact_form_tinymce_wccfwte_upload_button_display_first_load'] == 'yes' ) {

	  	echo '<p><label>Upload button display <b>:</b> <br /> Yes <input name="wp_captcha_contact_form_tinymce_wccfwte_upload_button_display" type="radio" value="yes" checked/>';
	  	echo ' No <input name="wp_captcha_contact_form_tinymce_wccfwte_upload_button_display" type="radio" value="no" /></label></p>';

		$data['is_wp_captcha_contact_form_tinymce_wccfwte_upload_button_display_first_load'] = 'no';

	} else {

		if ( $data['wp_captcha_contact_form_tinymce_wccfwte_upload_button_display'] == 'yes' ) {

		  	echo '<p><label>Upload button display <b>:</b> <br /> Yes <input name="wp_captcha_contact_form_tinymce_wccfwte_upload_button_display" type="radio" value="yes" checked/>';
		  	echo ' No <input name="wp_captcha_contact_form_tinymce_wccfwte_upload_button_display" type="radio" value="no" /></label></p>';

		} else {

		  	echo '<p><label>Upload button display <b>:</b> <br /> Yes <input name="wp_captcha_contact_form_tinymce_wccfwte_upload_button_display" type="radio" value="yes" />';
		  	echo ' No <input name="wp_captcha_contact_form_tinymce_wccfwte_upload_button_display" type="radio" value="no" checked/></label></p>';

		};
	};





	//  Captcha display handling :

	if ( $data['is_wp_captcha_contact_form_tinymce_wccfwte_captcha_display_first_load'] == 'yes' ) {

	  	echo '<p><label>Captcha display <b>:</b> <br /> Yes <input name="wp_captcha_contact_form_tinymce_wccfwte_captcha_display" type="radio" value="yes" checked/>';
	  	echo ' No <input name="wp_captcha_contact_form_tinymce_wccfwte_captcha_display" type="radio" value="no" /></label></p>';

		$data['is_wp_captcha_contact_form_tinymce_wccfwte_captcha_display_first_load'] = 'no';

	} else {

		if ( $data['wp_captcha_contact_form_tinymce_wccfwte_captcha_display'] == 'yes' ) {

		  	echo '<p><label>Captcha display <b>:</b> <br /> Yes <input name="wp_captcha_contact_form_tinymce_wccfwte_captcha_display" type="radio" value="yes" checked/>';
		  	echo ' No <input name="wp_captcha_contact_form_tinymce_wccfwte_captcha_display" type="radio" value="no" /></label></p>';

		} else {

		  	echo '<p><label>Captcha display <b>:</b> <br /> Yes <input name="wp_captcha_contact_form_tinymce_wccfwte_captcha_display" type="radio" value="yes" />';
		  	echo ' No <input name="wp_captcha_contact_form_tinymce_wccfwte_captcha_display" type="radio" value="no" checked/></label></p>';

		};
	};


?>





	<h3>TinyMCE Editor Settings</h3>
	
	<p style="text-align: center; border-width:2px;	border-style: dotted solid;"><a href="http://donicaptcha.donimedia-servicetique.net/?p=85" target="_blank" title="List of TinyMCE editor buttons available with DoniCaptcha plugins">Editor buttons list</a>
	<br /><a href="http://donicaptcha.donimedia-servicetique.net/?p=174" target="_blank" title="How to customize toolbars of WordPress captcha contact form with frontend TinyMCE editor">Toolbars customization tutorial</a>
	<br /><a href="http://donicaptcha.donimedia-servicetique.net/?p=49" target="_blank" title="WordPress captcha contact form with frontend TinyMCE editor documentation">Documentation</a></p>

  	<p><label>Editor buttons line 1 <b>:</b> <br /> <input name="wp_captcha_contact_form_tinymce_wccfwte_editor_buttons_line1" type="text" size="30" value="<?php echo $data['wp_captcha_contact_form_tinymce_wccfwte_editor_buttons_line1']; ?>" /></label></p>
  	<p><label>Editor buttons line 2 <b>:</b> <br /> <input name="wp_captcha_contact_form_tinymce_wccfwte_editor_buttons_line2" type="text" size="30" value="<?php echo $data['wp_captcha_contact_form_tinymce_wccfwte_editor_buttons_line2']; ?>" /></label></p>
  	<p><label>Editor buttons line 3 <b>:</b> <br /> <input name="wp_captcha_contact_form_tinymce_wccfwte_editor_buttons_line3" type="text" size="30" value="<?php echo $data['wp_captcha_contact_form_tinymce_wccfwte_editor_buttons_line3']; ?>" /></label></p>
  	<p><label>Editor buttons line 4 <b>:</b> <br /> <input name="wp_captcha_contact_form_tinymce_wccfwte_editor_buttons_line4" type="text" size="30" value="<?php echo $data['wp_captcha_contact_form_tinymce_wccfwte_editor_buttons_line4']; ?>" /></label></p>

	

  <?php


	// Toolbar location display control :

	if ( $data['is_wp_captcha_contact_form_tinymce_wccfwte_toolbar_location_first_load'] == 'yes' ) {

	  	echo '
			<p><label>Toolbar location <b>:</b></label>

				<select name="wp_captcha_contact_form_tinymce_wccfwte_toolbar_location" >

					<option value="bottom">Bottom</option>
					<option value="top" selected>Top</option>


				</select>
	  		</p>
		';

		$data['is_wp_captcha_contact_form_tinymce_wccfwte_toolbar_location_first_load'] = 'no';

	} else {

		if ( $data['wp_captcha_contact_form_tinymce_wccfwte_toolbar_location'] == 'top' ) {

	  	echo '
			<p><label>Toolbar location <b>:</b></label>

				<select name="wp_captcha_contact_form_tinymce_wccfwte_toolbar_location" >

					<option value="bottom">Bottom</option>
					<option value="top" selected>Top</option>

				</select>
	  		</p>
		';

		} elseif ( $data['wp_captcha_contact_form_tinymce_wccfwte_toolbar_location'] == 'bottom' ) {

	  	echo '
			<p><label>Toolbar location <b>:</b></label>

				<select name="wp_captcha_contact_form_tinymce_wccfwte_toolbar_location" >

					<option value="bottom" selected>Bottom</option>
					<option value="top">Top</option>

				</select>
	  		</p>
		';
		};
	};





	// Toolbar align display control :

	if ( $data['is_wp_captcha_contact_form_tinymce_wccfwte_toolbar_align_first_load'] == 'yes' ) {

	  	echo '
			<p><label>Toolbar align <b>:</b></label>

				<select name="wp_captcha_contact_form_tinymce_wccfwte_toolbar_align" >

					<option value="center" selected>Center</option>
					<option value="left">Left</option>
					<option value="right">Right</option>

				</select>
	  		</p>
		';

		$data['is_wp_captcha_contact_form_tinymce_wccfwte_toolbar_align_first_load'] = 'no';

	} else {

		if ( $data['wp_captcha_contact_form_tinymce_wccfwte_toolbar_align'] == 'center' ) {

	  	echo '
			<p><label>Toolbar align <b>:</b></label>

				<select name="wp_captcha_contact_form_tinymce_wccfwte_toolbar_align" >

					<option value="center" selected>Center</option>
					<option value="left">Left</option>
					<option value="right">Right</option>

				</select>
	  		</p>
		';

		} elseif ( $data['wp_captcha_contact_form_tinymce_wccfwte_toolbar_align'] == 'left' ) {

		  	echo '
			<p><label>Toolbar align <b>:</b></label>

				<select name="wp_captcha_contact_form_tinymce_wccfwte_toolbar_align" >

					<option value="center" selected>Center</option>
					<option value="left" selected>Left</option>
					<option value="right">Right</option>

				</select>
	  		</p>
		';

		} elseif ( $data['wp_captcha_contact_form_tinymce_wccfwte_toolbar_align'] == 'right' ) {

	  	echo '
			<p><label>Toolbar align <b>:</b></label>

				<select name="wp_captcha_contact_form_tinymce_wccfwte_toolbar_align" >

					<option value="center" selected>Center</option>
					<option value="left">Left</option>
					<option value="right" selected>Right</option>

				</select>
	  		</p>
		';
		};
	};






	// Statusbar location display control :

	if ( $data['is_wp_captcha_contact_form_tinymce_wccfwte_statusbar_location_first_load'] == 'yes' ) {

	  	echo '
			<p><label>Statusbar location <b>:</b></label>

				<select name="wp_captcha_contact_form_tinymce_wccfwte_statusbar_location" >

					<option value="bottom" selected>Bottom</option>
					<option value="none">None</option>
					<option value="top">Top</option>


				</select>
	  		</p>
		';

		$data['is_wp_captcha_contact_form_tinymce_wccfwte_statusbar_location_first_load'] = 'no';

	} else {

		if ( $data['wp_captcha_contact_form_tinymce_wccfwte_statusbar_location'] == 'bottom' ) {

	  	echo '
			<p><label>Statusbar location <b>:</b></label>

				<select name="wp_captcha_contact_form_tinymce_wccfwte_statusbar_location" >

					<option value="bottom" selected>Bottom</option>
					<option value="none">None</option>
					<option value="top">Top</option>

				</select>
	  		</p>
		';

		} elseif ( $data['wp_captcha_contact_form_tinymce_wccfwte_statusbar_location'] == 'none' ) {

	  	echo '
			<p><label>Statusbar location <b>:</b></label>

				<select name="wp_captcha_contact_form_tinymce_wccfwte_statusbar_location" >

					<option value="bottom">Bottom</option>
					<option value="none" selected>None</option>
					<option value="top">Top</option>

				</select>
	  		</p>
		';
		} elseif ( $data['wp_captcha_contact_form_tinymce_wccfwte_statusbar_location'] == 'top' ) {

	  	echo '
			<p><label>Statusbar location <b>:</b></label>

				<select name="wp_captcha_contact_form_tinymce_wccfwte_statusbar_location" >

					<option value="bottom">Bottom</option>
					<option value="none">None</option>
					<option value="top" selected>Top</option>

				</select>
	  		</p>
		';
		};

	};





	// Textarea resizing display control :

	if ( $data['is_wp_captcha_contact_form_tinymce_wccfwte_textarea_resizing_first_load'] == 'yes' ) {

	  	echo '
			<p><label>Textarea resizing <b>:</b></label>

				<select name="wp_captcha_contact_form_tinymce_wccfwte_textarea_resizing" >

					<option value="false">False</option>
					<option value="true" selected>True</option>

				</select>
	  		</p>
		';

		$data['is_wp_captcha_contact_form_tinymce_wccfwte_textarea_resizing_first_load'] = 'no';

	} else {

		if ( $data['wp_captcha_contact_form_tinymce_wccfwte_textarea_resizing'] == 'true' ) {

	  	echo '
			<p><label>Textarea resizing <b>:</b></label>

				<select name="wp_captcha_contact_form_tinymce_wccfwte_textarea_resizing" >

					<option value="false">False</option>
					<option value="true" selected>True</option>

				</select>
	  		</p>
		';

		} elseif ( $data['wp_captcha_contact_form_tinymce_wccfwte_textarea_resizing'] == 'false' ) {

	  	echo '
			<p><label>Textarea resizing <b>:</b></label>

				<select name="wp_captcha_contact_form_tinymce_wccfwte_textarea_resizing" >

					<option value="false" selected>False</option>
					<option value="true">True</option>

				</select>
	  		</p>
	  		</p>
		';
		};
	};




	// Editor skin control :

	if ( $data['is_wp_captcha_contact_form_tinymce_wccfwte_editor_skin_first_load'] == 'yes' ) {

	  	echo '
			<p><label>Editor skin <b>:</b></label>

				<select name="wp_captcha_contact_form_tinymce_wccfwte_editor_skin" >

					<option value="o2k7">o2k7</option>
					<option value="o2k7_black">o2k7 variant Black</option>
					<option value="o2k7_silver" selected>o2k7 variant Silver</option>

				</select>
	  		</p>
		';

		$data['is_wp_captcha_contact_form_tinymce_wccfwte_editor_skin_first_load'] = 'no';

	} else {

		if ( $data['wp_captcha_contact_form_tinymce_wccfwte_editor_skin'] == 'o2k7' ) {

	  	echo '
			<p><label>Editor skin <b>:</b></label>

				<select name="wp_captcha_contact_form_tinymce_wccfwte_editor_skin" >

					<option value="o2k7" selected>o2k7</option>
					<option value="o2k7_black">o2k7 variant Black</option>
					<option value="o2k7_silver">o2k7 variant Silver</option>

				</select>
	  		</p>
		';

		} elseif ( $data['wp_captcha_contact_form_tinymce_wccfwte_editor_skin'] == 'o2k7_black' ) {

	  	echo '
			<p><label>Editor skin <b>:</b></label>

				<select name="wp_captcha_contact_form_tinymce_wccfwte_editor_skin" >

					<option value="o2k7">o2k7</option>
					<option value="o2k7_black" selected>o2k7 variant Black</option>
					<option value="o2k7_silver">o2k7 variant Silver</option>

				</select>
	  		</p>
		';
		} elseif ( $data['wp_captcha_contact_form_tinymce_wccfwte_editor_skin'] == 'o2k7_silver' ) {

	  	echo '
			<p><label>Editor skin <b>:</b></label>

				<select name="wp_captcha_contact_form_tinymce_wccfwte_editor_skin" >

					<option value="o2k7">o2k7</option>
					<option value="o2k7_black">o2k7 variant Black</option>
					<option value="o2k7_silver" selected>o2k7 variant Silver</option>

				</select>
	  		</p>
		';
		};

	};










	echo '<h3>Credit link for DoniCaptcha</h3>';
	

	if ( $data['is_wp_captcha_contact_form_tinymce_wccfwte_credit_link_first_load'] == 'yes' ) {

	  	echo '<p><label>Display DoniCaptcha credit link , please <b>:</b> <br /> Yes <input name="wp_captcha_contact_form_tinymce_wccfwte_credit_link" type="radio" value="yes" checked/>';
	  	echo ' No <input name="wp_captcha_contact_form_tinymce_wccfwte_credit_link" type="radio" value="no" /></label></p>';

		$data['is_wp_captcha_contact_form_tinymce_wccfwte_credit_link_first_load'] = 'no';

	} else {

		if ( $data['wp_captcha_contact_form_tinymce_wccfwte_credit_link'] == 'yes' ) {

		  	echo '<p><label>Display DoniCaptcha credit link , please <b>:</b> <br /> Yes <input name="wp_captcha_contact_form_tinymce_wccfwte_credit_link" type="radio" value="yes" checked/>';
		  	echo ' No <input name="wp_captcha_contact_form_tinymce_wccfwte_credit_link" type="radio" value="no" /></label></p>';

		} else {

		  	echo '<p><label>Display DoniCaptcha credit link , please <b>:</b> <br /> Yes <input name="wp_captcha_contact_form_tinymce_wccfwte_credit_link" type="radio" value="yes" />';
		  	echo ' No <input name="wp_captcha_contact_form_tinymce_wccfwte_credit_link" type="radio" value="no" checked/></label></p>';

		};
	};





   if (isset($_POST['wp_captcha_contact_form_tinymce_wccfwte_title'])){

    	$data['wp_captcha_contact_form_tinymce_wccfwte_title'] = attribute_escape($_POST['wp_captcha_contact_form_tinymce_wccfwte_title']);
    	$data['wp_captcha_contact_form_tinymce_wccfwte_email_label'] = attribute_escape($_POST['wp_captcha_contact_form_tinymce_wccfwte_email_label']);
    	$data['wp_captcha_contact_form_tinymce_wccfwte_email_subject_label'] = attribute_escape($_POST['wp_captcha_contact_form_tinymce_wccfwte_email_subject_label']);
    	$data['wp_captcha_contact_form_tinymce_wccfwte_email_extensions_limits_label'] = attribute_escape($_POST['wp_captcha_contact_form_tinymce_wccfwte_email_extensions_limits_label']);
    	$data['wp_captcha_contact_form_tinymce_wccfwte_captcha_instructions_label'] = attribute_escape($_POST['wp_captcha_contact_form_tinymce_wccfwte_captcha_instructions_label']);

    	$data['wp_captcha_contact_form_tinymce_wccfwte_attachment_size_error_message'] = attribute_escape($_POST['wp_captcha_contact_form_tinymce_wccfwte_attachment_size_error_message']);
    	$data['wp_captcha_contact_form_tinymce_wccfwte_attachment_extension_error_message'] = attribute_escape($_POST['wp_captcha_contact_form_tinymce_wccfwte_attachment_extension_error_message']);
    	$data['wp_captcha_contact_form_tinymce_wccfwte_mail_not_sent_error_message'] = attribute_escape($_POST['wp_captcha_contact_form_tinymce_wccfwte_mail_not_sent_error_message']);
    	$data['wp_captcha_contact_form_tinymce_wccfwte_captcha_not_valid_error_message'] = attribute_escape($_POST['wp_captcha_contact_form_tinymce_wccfwte_captcha_not_valid_error_message']);
    	$data['wp_captcha_contact_form_tinymce_wccfwte_email_not_valid_error_message'] = attribute_escape($_POST['wp_captcha_contact_form_tinymce_wccfwte_email_not_valid_error_message']);

    	$data['wp_captcha_contact_form_tinymce_wccfwte_email_reply'] = attribute_escape($_POST['wp_captcha_contact_form_tinymce_wccfwte_email_reply']);
    	$data['wp_captcha_contact_form_tinymce_wccfwte_font_size'] = attribute_escape($_POST['wp_captcha_contact_form_tinymce_wccfwte_font_size']);
    	$data['wp_captcha_contact_form_tinymce_wccfwte_captcha_display'] = attribute_escape($_POST['wp_captcha_contact_form_tinymce_wccfwte_captcha_display']);
    	$data['wp_captcha_contact_form_tinymce_wccfwte_upload_button_display'] = attribute_escape($_POST['wp_captcha_contact_form_tinymce_wccfwte_upload_button_display']);

    	$data['wp_captcha_contact_form_tinymce_wccfwte_captcha_background_hexadecimal_color'] = attribute_escape($_POST['wp_captcha_contact_form_tinymce_wccfwte_captcha_background_hexadecimal_color']);
    	$data['wp_captcha_contact_form_tinymce_wccfwte_captcha_hexadecimal_text_color'] = attribute_escape($_POST['wp_captcha_contact_form_tinymce_wccfwte_captcha_hexadecimal_text_color']);
    	$data['wp_captcha_contact_form_tinymce_wccfwte_captcha_code_length'] = attribute_escape($_POST['wp_captcha_contact_form_tinymce_wccfwte_captcha_code_length']);

    	$data['wp_captcha_contact_form_tinymce_wccfwte_editor_buttons_line1'] = attribute_escape($_POST['wp_captcha_contact_form_tinymce_wccfwte_editor_buttons_line1']);
    	$data['wp_captcha_contact_form_tinymce_wccfwte_editor_buttons_line2'] = attribute_escape($_POST['wp_captcha_contact_form_tinymce_wccfwte_editor_buttons_line2']);
    	$data['wp_captcha_contact_form_tinymce_wccfwte_editor_buttons_line3'] = attribute_escape($_POST['wp_captcha_contact_form_tinymce_wccfwte_editor_buttons_line3']);
    	$data['wp_captcha_contact_form_tinymce_wccfwte_editor_buttons_line4'] = attribute_escape($_POST['wp_captcha_contact_form_tinymce_wccfwte_editor_buttons_line4']);

    	$data['wp_captcha_contact_form_tinymce_wccfwte_toolbar_location'] = attribute_escape($_POST['wp_captcha_contact_form_tinymce_wccfwte_toolbar_location']);
    	$data['wp_captcha_contact_form_tinymce_wccfwte_toolbar_align'] = attribute_escape($_POST['wp_captcha_contact_form_tinymce_wccfwte_toolbar_align']);
    	$data['wp_captcha_contact_form_tinymce_wccfwte_statusbar_location'] = attribute_escape($_POST['wp_captcha_contact_form_tinymce_wccfwte_statusbar_location']);
    	$data['wp_captcha_contact_form_tinymce_wccfwte_textarea_resizing'] = attribute_escape($_POST['wp_captcha_contact_form_tinymce_wccfwte_textarea_resizing']);
    	$data['wp_captcha_contact_form_tinymce_wccfwte_editor_skin'] = attribute_escape($_POST['wp_captcha_contact_form_tinymce_wccfwte_editor_skin']);

   	$data['wp_captcha_contact_form_tinymce_wccfwte_credit_link'] = attribute_escape($_POST['wp_captcha_contact_form_tinymce_wccfwte_credit_link']);
    	update_option('wp_captcha_contact_form_tinymce_wccfwte_name', $data);


  }
}








  function widget($args){


	/** Make sure that the WordPress bootstrap has run before continuing. */
	require( $_SERVER["DOCUMENT_ROOT"].'/wp-load.php' );





	//  The function below allows to remove accents from a given sentence :

	function wp_captcha_contact_form_tinymce_wccfwte_delete_accents($sentence) { 

		$charset='utf-8';
    		$sentence = htmlentities($sentence, ENT_NOQUOTES, $charset); 
     
	    	$sentence = preg_replace('#\&([A-za-z])(?:acute|cedil|circ|grave|ring|tilde|uml)\;#', '\1', $sentence);
    		$sentence = preg_replace('#\&([A-za-z]{2})(?:lig)\;#', '\1', $sentence);
	    	$sentence = preg_replace('#\&[^;]+\;#', '', $sentence);
		$sentence = preg_replace( '/\s+/', '_', $sentence);     

	    	return $sentence;

	}  //  function wp_captcha_contact_form_tinymce_wccfwte_delete_accents End




	//  The function below generates a random Captcha string :

	function wp_captcha_contact_form_tinymce_wccfwte_generate_captcha($_string_length) { //  Alphanumeric string generator with a given length .

		global $wp_captcha_contact_form_tinymce_wccfwte_error_message;

    			$validCharacters = "0123456789abcdefghijklmnopqrstuxyvwzABCDEFGHIJKLMNOPQRSTUXYVWZ+-*#&@!?";
    			$validCharNumber = strlen($validCharacters);
 
    			$result = "";
 
    			for ($i = 0; $i < $_string_length; $i++) {

        			$index = mt_rand(0, $validCharNumber - 1);
        			$result .= $validCharacters[$index];

    			};
 
    			return $result;

	}  //  function wp_captcha_contact_form_tinymce_wccfwte_delete_accents End




	function display_captcha_contact_form($error_msg) {


		global $wp_captcha_contact_form_tinymce_wccfwte_plugin_dir_url,$data;

		$data = get_option('wp_captcha_contact_form_tinymce_wccfwte_name');



		//  Error messages handling :

		switch ( $error_msg ) {


			case "attachment_size":

				$wp_captcha_contact_form_tinymce_wccfwte_error_message = '<p class="wp_captcha_contact_form_tinymce_wccfwte_error_message">'.$data["wp_captcha_contact_form_tinymce_wccfwte_attachment_size_error_message"].'</p>'; 

				break;

			case "attachment_extension":

				$wp_captcha_contact_form_tinymce_wccfwte_error_message = '<p class="wp_captcha_contact_form_tinymce_wccfwte_error_message">'.$data["wp_captcha_contact_form_tinymce_wccfwte_attachment_extension_error_message"].'</p>'; 

				break;

			case "mail_not_sent":

				$wp_captcha_contact_form_tinymce_wccfwte_error_message = '<p class="wp_captcha_contact_form_tinymce_wccfwte_error_message">'.$data["wp_captcha_contact_form_tinymce_wccfwte_mail_not_sent_error_message"].'</p>'; 

				break;

			case "captcha_not_valid":

				$wp_captcha_contact_form_tinymce_wccfwte_error_message = '<p class="wp_captcha_contact_form_tinymce_wccfwte_error_message">'.$data["wp_captcha_contact_form_tinymce_wccfwte_captcha_not_valid_error_message"].'</p>'; 

				break;

			case "email_not_valid":

				$wp_captcha_contact_form_tinymce_wccfwte_error_message = '<p class="wp_captcha_contact_form_tinymce_wccfwte_error_message">'.$data["wp_captcha_contact_form_tinymce_wccfwte_email_not_valid_error_message"].'</p>'; 

				break;

			default:

				$wp_captcha_contact_form_tinymce_wccfwte_error_message = ''; 

				break;


		
		}  //  switch End



		



		$wp_captcha_contact_form_tinymce_wccfwte_captcha_string = wp_captcha_contact_form_tinymce_wccfwte_generate_captcha($data['wp_captcha_contact_form_tinymce_wccfwte_captcha_code_length']);
		$wp_captcha_contact_form_tinymce_wccfwte_captcha_display = '';
		$wp_captcha_contact_form_tinymce_wccfwte_upload_button_display = ''; 


		if ( $data['wp_captcha_contact_form_tinymce_wccfwte_captcha_display'] == 'yes' ) {

			$wp_captcha_contact_form_tinymce_wccfwte_captcha_display = "<div class='wp_captcha_contact_form_tinymce_wccfwte_box_container'>
									<img class='wp_captcha_contact_form_tinymce_wccfwte_box_image' src='".$wp_captcha_contact_form_tinymce_wccfwte_plugin_dir_url."images/background_1_130_30.png' />
        								<span class='wp_captcha_contact_form_tinymce_wccfwte_captcha_string'>".$wp_captcha_contact_form_tinymce_wccfwte_captcha_string ."</span>
	   							</div>

								<input type='text' name='wp_captcha_contact_form_tinymce_wccfwte_captcha_user' id='wp_captcha_contact_form_tinymce_wccfwte_captcha_user' size='30' class='wp_captcha_contact_form_tinymce_wccfwte_captcha_user' />
								<span class='wp_captcha_contact_form_tinymce_wccfwte_captcha_code_instructions' title='Paste function is disabled'>".$data['wp_captcha_contact_form_tinymce_wccfwte_captcha_instructions_label']."</span>
								<input type='hidden' name='generated_captcha' value='".$wp_captcha_contact_form_tinymce_wccfwte_captcha_string."'>
							";

		};


		if ( $data['wp_captcha_contact_form_tinymce_wccfwte_upload_button_display'] == 'yes' ) {

			$wp_captcha_contact_form_tinymce_wccfwte_upload_button_display = "<div>
									<input type='file' name='wp_captcha_contact_form_tinymce_wccfwte_uploaded_file' id='wp_captcha_contact_form_tinymce_wccfwte_uploaded_file' class='wp_captcha_contact_form_tinymce_wccfwte_uploaded_file' />
									<span class='wp_captcha_contact_form_tinymce_wccfwte_uploaded_file_limits'>".$data['wp_captcha_contact_form_tinymce_wccfwte_email_extensions_limits_label']."</span>
								     </div>
							";

		};





	
	  	$form_to_display = "	<textarea id='wp_captcha_contact_form_tinymce_wccfwte_editor_textarea' name='wp_captcha_contact_form_tinymce_wccfwte_editor_textarea' class='wp_captcha_contact_form_tinymce_wccfwte_editor_textarea' rows='15' cols='80' >
				&lt;p&gt;This is the first paragraph.&lt;/p&gt;
				&lt;p&gt;This is the second paragraph.&lt;/p&gt;
				&lt;p&gt;This is the third paragraph.&lt;/p&gt;
			</textarea>".$wp_captcha_contact_form_tinymce_wccfwte_error_message."

			<input name='wp_captcha_contact_form_tinymce_wccfwte_email_label' type='text' size='30' class='wp_captcha_contact_form_tinymce_wccfwte_email_field' value='".$data['wp_captcha_contact_form_tinymce_wccfwte_email_label']."' />
  			<input name='wp_captcha_contact_form_tinymce_wccfwte_email_subject_label' type='text' size='30' class='wp_captcha_contact_form_tinymce_wccfwte_subject_field' value='".$data['wp_captcha_contact_form_tinymce_wccfwte_email_subject_label']."' />

  			<input name='submission_counter' type='hidden' value='1' />
			

		".$wp_captcha_contact_form_tinymce_wccfwte_captcha_display.$wp_captcha_contact_form_tinymce_wccfwte_upload_button_display;



		echo $form_to_display;


	}  //  function display_captcha_contact_form() End




	global $data, $wp_captcha_contact_form_tinymce_wccfwte_plugin_dir, $max_upload_size, $wp_captcha_contact_form_tinymce_wccfwte_plugin_dir_url, $wp_captcha_contact_form_tinymce_wccfwte_error_message, $email_sent, $submission_counter;

	$data = get_option('wp_captcha_contact_form_tinymce_wccfwte_name');
	$max_upload_size = 2000000;

    	echo $args['before_widget'];
	echo $args['before_title'] .$data['wp_captcha_contact_form_tinymce_wccfwte_title']. $args['after_title'];



	echo "<form method='post' name='captcha_form' id='captcha_form' action='".$_SERVER['PHP_SELF']."' enctype='multipart/form-data' >";



	if ( !( $_REQUEST['action'] == 'reset' ) ) {

	if (filter_var($_REQUEST['wp_captcha_contact_form_tinymce_wccfwte_email_label'], FILTER_VALIDATE_EMAIL)) { 	//  if "email" field is filled out AND is valid then send email



	
			
			
	     		//  Variables declarations :
			//  ------------------------
			
			$recipient_email = $data['wp_captcha_contact_form_tinymce_wccfwte_email_reply'];
     			$sender_email = $_REQUEST['wp_captcha_contact_form_tinymce_wccfwte_email_label'];
     			$sender_name = $_REQUEST['wp_captcha_contact_form_tinymce_wccfwte_email_label'];  //  'client_name';
			
			
     			$email_reply = $data['wp_captcha_contact_form_tinymce_wccfwte_email_reply'];
			$subject = $_REQUEST['wp_captcha_contact_form_tinymce_wccfwte_email_subject_label']; //  'E-mail subject';

     			//  $text_message = 'Bonjour,'."\n\n".'Voici un message au format texte'; 
     			$html_message = '<html>
     			<head>
     				<title>'.$subject.'</title> 
     			</head> 
     			<body>'.stripslashes($_REQUEST["wp_captcha_contact_form_tinymce_wccfwte_editor_textarea"]).'</body> 
     			</html>'; //  stripslashes() is required to remove slashes in $_REQUEST["wp_captcha_contact_form_tinymce_wccfwte_editor_textarea"]



	     		//  Boundary between text message , html message or attachment :
			//  ------------------------------------------------------------ 

     			$boundary = '-----=' . md5(uniqid(mt_rand()));
			
			
			//  Mail headers :
     			//  -------------- 

     			$headers = 'From: '.$sender_name.' <'.$sender_email.'>'."\n"; 
     			$headers .= 'Return-Path: <'.$email_reply.'>'."\n"; 
     			$headers .= 'MIME-Version: 1.0'."\n"; 
     			$headers .= 'Content-Type: multipart/mixed; boundary="'.$boundary.'"'; 




     			//  Text message :
     			//  -------------- 

     			$message = 'Multi-part message in MIME format.'."\n\n"; 

     			$message .= '--'.$boundary."\n"; 
     			$message .= 'Content-Type: text/plain; charset="iso-8859-1"'."\n"; 
     			$message .= 'Content-Transfer-Encoding: 8bit'."\n\n"; 
     			$message .= $text_message."\n\n"; 



     			//  Html message :
     			//  -------------- 

     			$message .= '--'.$boundary."\n";
     			$message .= 'Content-Type: text/html; charset="iso-8859-1"'."\n"; 
     			$message .= 'Content-Transfer-Encoding: 8bit'."\n\n"; 
     			$message .= $html_message."\n\n"; 

     			$message .= '--'.$boundary."\n"; 



     			//  Attachment :
     			//  ------------ 

			$tmp_name = $_FILES['wp_captcha_contact_form_tinymce_wccfwte_uploaded_file']['tmp_name'];
			$tmp_name_parts = pathinfo($tmp_name);

			if ( is_uploaded_file($tmp_name) ) { 	//  if an attachment is uploaded


				if ( (($_FILES["wp_captcha_contact_form_tinymce_wccfwte_uploaded_file"]["type"] == "image/jpeg")
					|| ($_FILES["wp_captcha_contact_form_tinymce_wccfwte_uploaded_file"]["type"] == "image/jpg")
					|| ($_FILES["wp_captcha_contact_form_tinymce_wccfwte_uploaded_file"]["type"] == "image/pjpeg")
					|| ($_FILES["wp_captcha_contact_form_tinymce_wccfwte_uploaded_file"]["type"] == "image/png")
					|| ($_FILES["wp_captcha_contact_form_tinymce_wccfwte_uploaded_file"]["type"] == "application/pdf")) ) { 	//  if attachment extension is valid


					if ( $_FILES["wp_captcha_contact_form_tinymce_wccfwte_uploaded_file"]["size"] <= $max_upload_size ) { 	//  if attachment size is valid

		

						if ($_FILES["wp_captcha_contact_form_tinymce_wccfwte_uploaded_file"]["error"] > 0) {

							echo '<p><strong>Return Code : '.$_FILES["wp_captcha_contact_form_tinymce_wccfwte_uploaded_file"]["error"].'<br /></strong></p>';

							die;

    						};




						$old = umask(0);  // Necessary to change the chmod of the newly created directories . Otherwise directories images won't display ( even though they really are in those directories 

						//  Upload directory creation :
					
						if ( !(is_dir( $wp_captcha_contact_form_tinymce_wccfwte_plugin_dir.'wp_captcha_contact_form_tinymce_wccfwte_uploaded_file/' )) ) {

							mkdir($wp_captcha_contact_form_tinymce_wccfwte_plugin_dir.'wp_captcha_contact_form_tinymce_wccfwte_uploaded_file/', 0755, true);
				
							chmod($wp_captcha_contact_form_tinymce_wccfwte_plugin_dir.'wp_captcha_contact_form_tinymce_wccfwte_uploaded_file/', 0755);
		
							umask($old);

							// Verification :

							if ($old != umask()) {

						    		die('An error occured while changing back the umask');
	
							}

						};


    						$expurgated_wp_captcha_contact_form_tinymce_wccfwte_uploaded_file_name = wp_captcha_contact_form_tinymce_wccfwte_delete_accents($_FILES['wp_captcha_contact_form_tinymce_wccfwte_uploaded_file']['name']);

						move_uploaded_file($_FILES["wp_captcha_contact_form_tinymce_wccfwte_uploaded_file"]["tmp_name"],$wp_captcha_contact_form_tinymce_wccfwte_plugin_dir.'wp_captcha_contact_form_tinymce_wccfwte_uploaded_file/'.$expurgated_wp_captcha_contact_form_tinymce_wccfwte_uploaded_file_name);



						$wp_captcha_contact_form_tinymce_wccfwte_uploaded_file = $wp_captcha_contact_form_tinymce_wccfwte_plugin_dir.'wp_captcha_contact_form_tinymce_wccfwte_uploaded_file/'.$expurgated_wp_captcha_contact_form_tinymce_wccfwte_uploaded_file_name;
						$wp_captcha_contact_form_tinymce_wccfwte_uploaded_file_path_parts = pathinfo($wp_captcha_contact_form_tinymce_wccfwte_uploaded_file);


						switch ( $wp_captcha_contact_form_tinymce_wccfwte_uploaded_file_path_parts["extension"] ) {

							case "jpg":

								$message .= 'Content-Type: image/jpeg; name="'.$wp_captcha_contact_form_tinymce_wccfwte_uploaded_file.'"'."\n"; 
   			  					$message .= 'Content-Transfer-Encoding: base64'."\n"; 
     								$message .= 'Content-Disposition:attachement; filename="'.$wp_captcha_contact_form_tinymce_wccfwte_uploaded_file_path_parts['basename'].'"'."\n\n"; 
	
   	  							$message .= chunk_split(base64_encode(file_get_contents($wp_captcha_contact_form_tinymce_wccfwte_uploaded_file)))."\n";

								break;


							case "jpeg":

								$message .= 'Content-Type: image/jpeg; name="'.$wp_captcha_contact_form_tinymce_wccfwte_uploaded_file.'"'."\n"; 
   			  					$message .= 'Content-Transfer-Encoding: base64'."\n"; 
     								$message .= 'Content-Disposition:attachement; filename="'.$wp_captcha_contact_form_tinymce_wccfwte_uploaded_file_path_parts['basename'].'"'."\n\n"; 
	
   	  							$message .= chunk_split(base64_encode(file_get_contents($wp_captcha_contact_form_tinymce_wccfwte_uploaded_file)))."\n";

								break;


							case "pjpeg":

								$message .= 'Content-Type: image/jpeg; name="'.$wp_captcha_contact_form_tinymce_wccfwte_uploaded_file.'"'."\n"; 
   			  					$message .= 'Content-Transfer-Encoding: base64'."\n"; 
     								$message .= 'Content-Disposition:attachement; filename="'.$wp_captcha_contact_form_tinymce_wccfwte_uploaded_file_path_parts['basename'].'"'."\n\n"; 
	
   	  							$message .= chunk_split(base64_encode(file_get_contents($wp_captcha_contact_form_tinymce_wccfwte_uploaded_file)))."\n";

								break;


							case "png":	

								$message .= 'Content-Type: image/png; name="'.$wp_captcha_contact_form_tinymce_wccfwte_uploaded_file.'"'."\n"; 
     								$message .= 'Content-Transfer-Encoding: base64'."\n"; 
     								$message .= 'Content-Disposition:attachement; filename="'.$wp_captcha_contact_form_tinymce_wccfwte_uploaded_file_path_parts['basename'].'"'."\n\n"; 
	
		     						$message .= chunk_split(base64_encode(file_get_contents($wp_captcha_contact_form_tinymce_wccfwte_uploaded_file)))."\n";

								break;

	
							case "pdf":

								$message .= 'Content-Type: application/pdf; name="'.$wp_captcha_contact_form_tinymce_wccfwte_uploaded_file.'"'."\n"; 
     								$message .= 'Content-Transfer-Encoding: base64'."\n"; 
     								$message .= 'Content-Disposition:attachement; filename="'.$wp_captcha_contact_form_tinymce_wccfwte_uploaded_file_path_parts['basename'].'"'."\n\n"; 
	
     								$message .= chunk_split(base64_encode(file_get_contents($wp_captcha_contact_form_tinymce_wccfwte_uploaded_file)))."\n";
	
								break;

		
							}  //  switch End



						} else { //  if attachment size is not valid

							$wp_captcha_contact_form_tinymce_wccfwte_error_message = 'attachment_size';                               

							display_captcha_contact_form($wp_captcha_contact_form_tinymce_wccfwte_error_message);

     						}

					}   else { //  if attachment extension is not valid	

							$wp_captcha_contact_form_tinymce_wccfwte_error_message = 'attachment_extension';

							display_captcha_contact_form($wp_captcha_contact_form_tinymce_wccfwte_error_message);

     					}


				}  // if ( is_wp_captcha_contact_form_tinymce_wccfwte_uploaded_file($tmp_name) )  End





     				if(mail($recipient_email,$subject,$message,$headers) && !$email_sent) { 

				
					$email_sent = true;


					//  display_captcha_contact_form($wp_captcha_contact_form_tinymce_wccfwte_error_message);

					//  wp_redirect($_SERVER['PHP_SELF'].'?action=reset');



				echo "<script  type='text/javascript'>

						function redirection(page){

							window.location=page;

						}

						setTimeout(\"redirection('".$_SERVER['PHP_SELF']."?action=reset')\",1000);

					</script>";





     				} else { 

					$wp_captcha_contact_form_tinymce_wccfwte_error_message = 'mail_not_sent';  //  mail could not be sent

					display_captcha_contact_form($wp_captcha_contact_form_tinymce_wccfwte_error_message);					

     				} 

  		} else { 

				if ( $submission_counter < 1 )  {

					$wp_captcha_contact_form_tinymce_wccfwte_error_message = '';  //  if it's page first load , don't display error .
					display_captcha_contact_form($wp_captcha_contact_form_tinymce_wccfwte_error_message);

				} else { 

					$wp_captcha_contact_form_tinymce_wccfwte_error_message = 'email_not_valid';  //  if "email" field value is not valid then send email
					display_captcha_contact_form($wp_captcha_contact_form_tinymce_wccfwte_error_message);

  				};

		 }
  		} else { 

			$wp_captcha_contact_form_tinymce_wccfwte_error_message = '';   //   if ( !( $_REQUEST['action'] == 'reset' ) )

			echo "<p style='font-size: 8pt; font-weight: bold; text-align: center;' >Thank you for using our contact form !</p>";

			display_captcha_contact_form($wp_captcha_contact_form_tinymce_wccfwte_error_message);

  		}




		echo "<input type='submit' class='wp_captcha_contact_form_tinymce_wccfwte_submit_button'/></form>";






		if ( $data['wp_captcha_contact_form_tinymce_wccfwte_credit_link'] == 'yes' ) {

			$donicaptcha_wp_captcha_contact_form_tinymce_wccfwte_credits_link = "<div class='wp_captcha_contact_form_tinymce_wccfwte_credits_link'>

						<a href='http://donicaptcha.donimedia-servicetique.net' title='Wordpress Captcha Contact Form by DoniCaptcha'>By DoniCaptcha</a>

					   </div>

			";
			
			echo $donicaptcha_wp_captcha_contact_form_tinymce_wccfwte_credits_link;
		};






     		echo $args['after_widget'];


  }


  function register(){

		function wp_captcha_contact_form_tinymce_wccfwte_my_enqueue_scripts() {

			wp_register_style('wp_captcha_contact_form_tinymce_wccfwte_pluginStylesheet', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css',false,null);
			wp_enqueue_style('wp_captcha_contact_form_tinymce_wccfwte_pluginStylesheet');
		
			wp_deregister_script('jquery');
			wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js',false,null);
			wp_enqueue_script('jquery');
		
			wp_deregister_script('jquery-ui-core');
			wp_register_script('jquery-ui-core', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js',false,null);
			wp_enqueue_script('jquery-ui-core');
		
			$file_dir=get_bloginfo('url')."/wp-content/plugins/captcha_contact_form_tinymce_wccfwte";
			//  wp_enqueue_style("wp_captcha_contact_form_tinymce_wccfwte_pluginStylesheet", $file_dir."/styles/styles.css", false, "1.0", "all");
			wp_enqueue_script("wp_captcha_contact_form_tinymce_wccfwte_pluginJQueryScript", $file_dir."/scripts/script.js", array('jquery'),null);
		
		}
 
		add_action('init', 'wp_captcha_contact_form_tinymce_wccfwte_my_enqueue_scripts');
		//  add_action('admin_init', 'wp_captcha_contact_form_tinymce_wccfwte_my_enqueue_scripts');

    	register_sidebar_widget('Captcha Contact Form TinyMCE editor', array('captcha_contact_form_tinymce_wccfwte', 'widget'));
    	register_widget_control('Captcha Contact Form TinyMCE editor', array('captcha_contact_form_tinymce_wccfwte', 'control'));
  	}
}






?>